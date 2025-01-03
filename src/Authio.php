<?php

namespace JobMetric\Authio;

use Exception;
use Illuminate\Support\Str;
use JobMetric\Authio\Enums\LoginTypeEnum;
use JobMetric\Authio\Enums\OtpTypeEnum;
use JobMetric\Authio\Events\AfterRegisterEvent;
use JobMetric\Authio\Events\SendOtpEmailEvent;
use JobMetric\Authio\Events\SendOtpSmsEvent;
use JobMetric\Authio\Exceptions\UserDeletedException;
use JobMetric\Authio\Http\Resources\RequestResource;
use JobMetric\Authio\Models\User;
use JobMetric\Authio\Models\UserOtp;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class Authio
{
    public function request(array $params = []): RequestResource
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

        if ($has_otp) {
            $otp = $this->addOtp($type, $user, $response['secret']);

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

        return RequestResource::make($response);
    }

    public function login()
    {

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
}
