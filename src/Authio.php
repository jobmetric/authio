<?php

namespace JobMetric\Authio;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use JobMetric\Authio\Enums\LoginTypeEnum;
use JobMetric\Authio\Enums\OtpTypeEnum;
use JobMetric\Authio\Events\AddUserTokenEvent;
use JobMetric\Authio\Events\AfterRegisterEvent;
use JobMetric\Authio\Events\LoginEvent;
use JobMetric\Authio\Events\RegisteredEvent;
use JobMetric\Authio\Events\SendOtpEmailEvent;
use JobMetric\Authio\Events\SendOtpSmsEvent;
use JobMetric\Authio\Exceptions\ExpireSecretException;
use JobMetric\Authio\Exceptions\IpNotMatchException;
use JobMetric\Authio\Exceptions\PasswordNotFoundException;
use JobMetric\Authio\Exceptions\ResendTryCountException;
use JobMetric\Authio\Exceptions\UnauthorizedException;
use JobMetric\Authio\Exceptions\UserDeletedException;
use JobMetric\Authio\Exceptions\UserNotMatchException;
use JobMetric\Authio\Http\Resources\RequestResource;
use JobMetric\Authio\Http\Resources\ResendResource;
use JobMetric\Authio\Http\Resources\TokenResource;
use JobMetric\Authio\Models\User;
use JobMetric\Authio\Models\UserOtp;
use JobMetric\Authio\Models\UserToken;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Throwable;
use Tymon\JWTAuth\Facades\JWTAuth;

class Authio
{
    /**
     * Request data
     *
     * @param array $params
     *
     * @return array
     * @throws UserDeletedException
     */
    public function request(array $params = []): array
    {
        $type = $params['type'];
        $mobile_prefix = $params['mobile_prefix'] ?? null;
        $mobile = $params['mobile'] ?? null;
        $email = $params['email'] ?? null;
        $hash = $params['hash'] ?? null;

        $response = [
            'source' => $type,
            'type' => 'register',
            'has_password' => false
        ];

        if ($type == LoginTypeEnum::MOBILE()) {
            $user = User::ofMobile($mobile_prefix, $mobile, true)->first();
        } else {
            $user = User::ofEmail($email, true)->first();
        }

        $has_otp = true;
        if ($user instanceof User) {
            if (!is_null($user->deleted_at)) {
                throw new UserDeletedException($user->name);
            }

            // login
            $response['type'] = 'login-otp';

            if ($user->password) {
                $response['type'] = 'login-password';

                $response['has_password'] = true;
                $has_otp = false;
            }
        } else {
            try {
                // register
                $user = new User;

                if ($type == LoginTypeEnum::MOBILE()) {
                    $user->mobile_prefix = $mobile_prefix;
                    $user->mobile = $mobile;
                } else {
                    $user->email = $email;
                }

                $user->save();

                event(new AfterRegisterEvent($user));
            } catch (Exception $exception) {
                throw new BadRequestException($exception->getMessage());
            }
        }

        $response['secret'] = Str::random(30);
        $otp = $this->addOtp($type, $user, $response['secret']);

        if ($has_otp) {
            if ($type == LoginTypeEnum::MOBILE()) {
                if (config('authio.enable_send_sms') || env('APP_ENV') == 'production') {
                    event(new SendOtpSmsEvent($user, $otp, $hash));
                }

                $response['code'] = $this->getCode(OtpTypeEnum::NEW, config('authio.otp.expire_reuse'));
            } else {
                if (config('authio.enable_send_email') || env('APP_ENV') == 'production') {
                    event(new SendOtpEmailEvent($user, $otp));
                }
            }
        }

        return [
            'ok' => true,
            'message' => trans('authio::base.messages.request'),
            'data' => RequestResource::make($response),
            'status' => 200
        ];
    }

    /**
     * Login Opt
     *
     * @param array $params
     *
     * @return array
     * @throws Throwable
     */
    public function loginOtp(array $params = []): array
    {
        $otp = $params['otp'];

        /**
         * @var UserOtp $user_otp
         */
        global $user_otp;

        // if otp not equal in secret record
        if ($user_otp->otp != $otp) {
            throw new UserNotMatchException;
        }

        // if token not generate
        try {
            $token = JWTAuth::fromUser($user_otp->user);
        } catch (Exception $exception) {
            throw new UnauthorizedException;
        }

        // $user_otp->user->addActivity(TableUserActivityFieldTypeEnum::LOGIN_WITH_OTP);
        $this->addToken($user_otp->user, $token, config('jwt.ttl') * 60);

        $user_otp->nowUsed();

        // if for new user
        if (is_null($user_otp->user->mobile_verified_at)) {
            $user_otp->user->nowVerifiedMobile();

            event(new RegisteredEvent($user_otp->user));
        } else {
            event(new LoginEvent($user_otp->user));
        }

        return [
            'ok' => true,
            'message' => trans('authio::base.messages.login'),
            'data' => TokenResource::make([
                'token' => $token,
                'user' => $user_otp->user,
            ]),
            'status' => 200
        ];
    }

    /**
     * Login Password
     *
     * @param array $params
     *
     * @return array
     * @throws Throwable
     */
    public function loginPassword(array $params = []): array
    {
        $password = $params['password'];

        /**
         * @var UserOtp $user_otp
         */
        global $user_otp;

        if (is_null($user_otp->user->password)) {
            throw new PasswordNotFoundException;
        }

        if (!Hash::check($password, $user_otp->user->password)) {
            throw new UserNotMatchException;
        }

        // if token not generate
        try {
            $token = JWTAuth::fromUser($user_otp->user);
        } catch (Exception $exception) {
            throw new UnauthorizedException;
        }

        //$user_otp->user->addActivity(TableUserActivityFieldTypeEnum::LOGIN_WITH_PASSWORD);
        $this->addToken($user_otp->user, $token, config('jwt.ttl') * 60);

        $user_otp->nowUsed();

        event(new LoginEvent($user_otp->user));

        return [
            'ok' => true,
            'message' => trans('authio::base.messages.login'),
            'data' => TokenResource::make([
                'token' => $token,
                'user' => $user_otp->user,
            ]),
            'status' => 200
        ];
    }

    /**
     * Resend Otp
     *
     * @param array $params
     *
     * @return array
     * @throws Throwable
     */
    public function resend(array $params = []): array
    {
        $secret = $params['secret'];
        $hash = $params['hash'] ?? null;

        /**
         * @var UserOtp $user_otp
         */
        global $user_otp;

        if (is_null($user_otp)) {
            $user_otp = UserOtp::ofSecretNotUsed($secret)->with('user')->first();
        }

        $response = [
            'source' => $user_otp->source,
            'secret' => $user_otp->secret
        ];

        // if ip not equal in secret record
        if ($user_otp->ip_address != request()->ip()) {
            throw new IpNotMatchException;
        }

        $expire_reuse = Carbon::parse($user_otp->updated_at)->diffInRealSeconds();

        // if expire reuse more than expire time config
        if ($expire_reuse > config('authio.otp.expire_time')) {
            throw new ExpireSecretException;
        }

        // if try count more than try count config
        if ($user_otp->try_count > config('authio.otp.try_count')) {
            // @todo: ban ip => config('define.otp.ban_ip') second

            throw new ResendTryCountException;
        }

        if ($expire_reuse > config('authio.otp.expire_reuse') || ($user_otp->try_count == 0 && !is_null($user_otp->user->password))) {
            $user_otp->nowTry();

            // $user_otp->user->addActivity(TableUserActivityFieldTypeEnum::RESEND_OTP);

            if ($user_otp->source == LoginTypeEnum::MOBILE()) {
                if (config('authio.enable_send_sms') || env('APP_ENV') == 'production') {
                    event(new SendOtpSmsEvent($user_otp->user, $user_otp->otp, $hash));
                }
            } else {
                if (config('authio.enable_send_email') || env('APP_ENV') == 'production') {
                    event(new SendOtpEmailEvent($user_otp->user, $user_otp->otp));
                }
            }

            $response['code'] = $this->getCode(OtpTypeEnum::UPDATE, config('authio.otp.expire_reuse'), $user_otp->try_count);

            $message = trans('authio::base.messages.resend');
        } else {
            $response['code'] = $this->getCode(OtpTypeEnum::LOCKED, config('authio.otp.expire_reuse') - $expire_reuse, $user_otp->try_count);

            $message = trans('authio::base.messages.locked', ['time' => config('authio.otp.expire_reuse') - $expire_reuse]);
        }

        return [
            'ok' => true,
            'message' => $message,
            'data' => ResendResource::make($response),
            'status' => 200
        ];
    }

    /**
     * Add Otp code
     *
     * @param string $source
     * @param User $user
     * @param string $secret
     *
     * @return int
     */
    private function addOtp(string $source, User $user, string $secret): int
    {
        if (env('APP_ENV') == 'production') {
            $otp = rand(10000, 99999);
        } else if ($source == LoginTypeEnum::MOBILE()) {
            if (config('authio.enable_send_sms')) {
                $otp = rand(10000, 99999);
            } else {
                $otp = config('authio.otp.default_value');
            }
        } else {
            if (config('authio.enable_send_email')) {
                $otp = rand(10000, 99999);
            } else {
                $otp = config('authio.otp.default_value');
            }
        }

        $user_otp = new UserOtp;

        $user_otp->user_id = $user->id;
        $user_otp->source = $source;
        $user_otp->secret = $secret;
        $user_otp->otp = $otp;
        $user_otp->ip_address = request()->ip();

        $user_otp->save();

        return $otp;
    }

    /**
     * get code
     *
     * @param OtpTypeEnum|string $type
     * @param int $timer
     * @param int $try_count
     *
     * @return array
     */
    private function getCode(OtpTypeEnum|string $type, int $timer, int $try_count = 0): array
    {
        return [
            'type' => $type,
            'timer' => $timer,
            'try_count' => $try_count,
            'max_try' => config('authio.otp.try_count'),
            'expire_time' => config('authio.otp.expire_time'),
        ];
    }

    /**
     * Add Token
     *
     * @param User $user
     * @param string $token
     * @param int|null $ttl
     *
     * @return void
     */
    private function addToken(User $user, string $token, int $ttl = null): void
    {
        $user_token = new UserToken;

        $user_token->user_id = $user->id;
        $user_token->token = $token;
        $user_token->user_agent = request()->userAgent();
        $user_token->ip_address = request()->ip();

        if ($ttl) {
            $user_token->expired_at = Carbon::parse(time())->addSeconds($ttl);
        }

        $user_token->save();

        event(new AddUserTokenEvent($user_token));
    }
}
