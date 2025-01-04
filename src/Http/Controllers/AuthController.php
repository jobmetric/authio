<?php

namespace JobMetric\Authio\Http\Controllers;

use Illuminate\Contracts\View\View;
use JobMetric\Authio\Facades\Authio;
use JobMetric\Authio\Http\Requests\AuthRequestRequest;
use JobMetric\Authio\Http\Requests\ResendOtpRequest;
use JobMetric\Authio\Http\Resources\RequestResource;
use JobMetric\Authio\Http\Resources\ResendResource;
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

    /**
     * Request data
     *
     * @param AuthRequestRequest $request
     *
     * @return RequestResource
     * @throws Throwable
     */
    public function request(AuthRequestRequest $request): RequestResource
    {
        return Authio::request($request->validated());
    }

    public function loginOtp()
    {
    }

    /**
     * resend otp
     *
     * @param ResendOtpRequest $request
     *
     * @return ResendResource
     * @throws Throwable
     */
    public function resendOtp(ResendOtpRequest $request): ResendResource
    {
        return Authio::resend($request->validated());
    }

    public function loginPassword()
    {
    }
}
