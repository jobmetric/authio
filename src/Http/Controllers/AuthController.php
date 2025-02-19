<?php

namespace JobMetric\Authio\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use JobMetric\Authio\Facades\Authio;
use JobMetric\Authio\Http\Requests\AuthRequestRequest;
use JobMetric\Authio\Http\Requests\LoginOtpRequest;
use JobMetric\Authio\Http\Requests\LoginPasswordRequest;
use JobMetric\Authio\Http\Requests\ResendOtpRequest;
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
            DomiScript('assets/vendor/authio/js/authio.js');
            DomiScript('assets/vendor/authio/js/auth.js');
        }

        if (view()->exists('templates.' . Domi::template() . '.auth')) {
            return view('templates.' . Domi::template() . '.auth', $data);
        } else {
            return view('authio::auth', $data);
        }
    }

    /**
     * Request data
     *
     * @param AuthRequestRequest $request
     *
     * @return JsonResponse
     * @throws Throwable
     */
    public function request(AuthRequestRequest $request): JsonResponse
    {
        try {
            return $this->response(Authio::request($request->validated()));
        } catch (Throwable $exception) {
            return $this->response(message: $exception->getMessage(), status: $exception->getCode());
        }
    }

    /**
     * Login otp
     *
     * @param LoginOtpRequest $request
     *
     * @return JsonResponse
     * @throws Throwable
     */
    public function loginOtp(LoginOtpRequest $request): JsonResponse
    {
        try {
            return $this->response(Authio::loginOtp($request->validated()));
        } catch (Throwable $exception) {
            return $this->response(message: $exception->getMessage(), status: $exception->getCode());
        }
    }

    /**
     * resend otp
     *
     * @param ResendOtpRequest $request
     *
     * @return JsonResponse
     * @throws Throwable
     */
    public function resendOtp(ResendOtpRequest $request): JsonResponse
    {
        try {
            return $this->response(Authio::resend($request->validated()));
        } catch (Throwable $exception) {
            return $this->response(message: $exception->getMessage(), status: $exception->getCode());
        }
    }

    /**
     * Login password
     *
     * @param LoginPasswordRequest $request
     *
     * @return JsonResponse
     * @throws Throwable
     */
    public function loginPassword(LoginPasswordRequest $request): JsonResponse
    {
        try {
            return $this->response(Authio::loginPassword($request->validated()));
        } catch (Throwable $exception) {
            return $this->response(message: $exception->getMessage(), status: $exception->getCode());
        }
    }
}
