<?php

namespace JobMetric\Authio\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use JobMetric\Authio\Http\Requests\AuthRequestRequest;
use JobMetric\Domi\Facades\Domi;
use JobMetric\Location\Facades\LocationCountry;
use JobMetric\Panelio\Http\Controllers\Controller;
use Throwable;

class AuthController extends Controller
{
    /**
     * Display a listing of the taxonomy.
     *
     * @return View
     * @throws Throwable
     */
    public function index(): View
    {
        $template = Domi::template();

        if (trans('templates/' . Domi::template() . '/auth.title') == 'templates/' . Domi::template() . '/auth.title') {
            $data['title'] = trans('authio::base.title');
        } else {
            $data['title'] = trans('templates/' . Domi::template() . '/auth.title');
        }

        if (trans('templates/' . Domi::template() . '/auth.description') == 'templates/' . Domi::template() . '/auth.description') {
            $data['description'] = trans('authio::base.description');
        } else {
            $data['description'] = trans('templates/' . Domi::template() . '/auth.description');
        }

        if (trans('templates/' . Domi::template() . '/auth.keywords') == 'templates/' . Domi::template() . '/auth.keywords') {
            $keywords = trans('authio::base.keywords');
        } else {
            $keywords = trans('templates/' . Domi::template() . '/auth.keywords');
        }

        $data['countries'] = LocationCountry::all();

        DomiTitle($data['title']);
        DomiDescription($data['description']);
        DomiKeywords($keywords);

        DomiLocalize('auth', [
            'route' => [
                'request' => route('auth.request'),
                'otp' => route('auth.otp'),
                'resend' => route('auth.resend'),
                'password' => route('auth.password'),
            ],
        ]);

        if (trans('domi::base.direction') == 'rtl') {
            if (file_exists(public_path('templates/' . $template . '/assets/css/page/auth-rtl.css'))) {
                DomiStyle('templates/' . $template . '/assets/css/page/auth-rtl.css');
            } else {
                DomiStyle('assets/vendor/authio/css/auth-rtl.css');
            }
        } else {
            if (file_exists(public_path('templates/' . $template . '/assets/css/page/auth.css'))) {
                DomiStyle('templates/' . $template . '/assets/css/page/auth.css');
            } else {
                DomiStyle('assets/vendor/authio/css/auth.css');
            }
        }

        if (file_exists(public_path('templates/' . $template . '/assets/js/page/auth.js'))) {
            DomiScript('templates/' . $template . '/assets/js/page/auth.js');
        } else {
            DomiPlugins('jquery.form');
            DomiScript('assets/vendor/authio/js/auth.js');
        }

        if (view()->exists('templates.' . Domi::template() . '.auth')) {
            return view('templates.' . Domi::template() . '.auth', $data);
        } else {
            return view('authio::auth', $data);
        }
    }

    public function request(AuthRequestRequest $request)
    {
        $input = $request->validated();

        $data = [];
        if($input['type'] == 'mobile') {
            $mobile_prefix = $input['mobile_prefix'];
            $mobile = $input['mobile'];

            $user = User::ofMobile($mobile_prefix, $mobile, true)->first();

            if($user) {
                $data['type'] = 'login';
            } else {
                $data['type'] = 'register';

                // add user
                $user = User::create([
                    'mobile_prefix' => $mobile_prefix,
                    'mobile' => $mobile,
                ]);

                // register auth code and send
                // send secret
            }
        } else {
            $email = $input['email'];

            $user = User::ofEmail($email, true)->first();

            if($user) {
                $data['type'] = 'login';
            } else {
                $data['type'] = 'register';

                // add user
                $user = User::create([
                    'email' => $email,
                ]);

                // register auth code and send
                // send secret
            }
        }

        return response()->json($data);
    }

    public function loginOtp()
    {
    }

    public function resendOtp()
    {
    }

    public function loginPassword()
    {
    }
}
