@extends('domi::layout')

@section('head')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700">
    <link href="{{ asset('assets/vendor/panelio/css/base.css') }}" rel="stylesheet" type="text/css" />
    @if(trans('domi::base.direction') == 'rtl')
        <link href="{{ asset('assets/vendor/panelio/fonts/iransans/fonts.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/panelio/plugins/global/plugins.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/vendor/panelio/css/style.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/vendor/panelio/css/style.rtl.css') }}" rel="stylesheet" type="text/css" />
    @else
        <link href="{{ asset('assets/vendor/panelio/css/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/vendor/panelio/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/vendor/panelio/css/style.css') }}" rel="stylesheet" type="text/css" />
    @endif
@endsection

@section('body-attribute')
    id="kt_body" class="app-blank bgi-size-cover bgi-attachment-fixed bgi-position-center bgi-no-repeat"
@endsection

@section('content')
    <script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <style>body { background-image: url({{ asset('assets/vendor/authio/media/background/' . config('authio.background_image') . '.jpg') }}); } [data-bs-theme="dark"] body { background-image: url({{ asset('assets/vendor/authio/media/background/' . config('authio.background_image') . '-dark.jpeg') }}); }</style>
        <div class="d-flex flex-column flex-column-fluid flex-lg-row">
            <div class="d-flex flex-center w-lg-50 pt-15 pt-lg-0 px-10">
                <div class="d-flex flex-center flex-lg-start flex-column">
                    <a href="javascript:void(0)" class="mb-7">
                        <img alt="Logo" src="{{ asset('assets/vendor/panelio/media/logo/default-small.svg') }}" />
                    </a>
                    <h2 class="text-white fw-normal m-0">{{ \JobMetric\Setting\Facades\Setting::get('hero_config_site_name', trans('authio::base.title')) }}</h2>
                </div>
            </div>
            <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12 p-lg-20">
                <div class="bg-body rounded-4 w-md-550px shadow shadow-lg position-relative">
                    <div class="p-20 d-flex flex-column justify-content-between align-items-stretch flex-center h-100">
                        <div class="d-flex flex-center flex-column px-lg-5">
                            @yield('body')
                        </div>
                        <div class="d-flex flex-stack px-lg-5">
                            <div class="me-0">
                                <button class="btn btn-flex btn-link btn-color-gray-700 btn-active-color-primary rotate fs-base" data-kt-menu-trigger="click" data-kt-menu-placement="top-end" data-kt-menu-offset="0px, 0px">
                                    <img data-kt-element="current-lang-flag" class="w-20px h-20px rounded me-3" src="{{ asset('assets/vendor/language/flags/' . $languageInfo->flag) }}" alt="{{ $languageInfo->name }}" />
                                    <span data-kt-element="current-lang-name" class="me-1">{{ $languageInfo->name }}</span>
                                    <i class="ki-outline ki-down fs-5 text-muted rotate-180 m-0"></i>
                                </button>
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-4 fs-7" data-kt-menu="true" id="kt_auth_lang_menu">
                                    @foreach($languages as $language)
                                        <div class="menu-item px-3">
                                            <a href="javascript:void(0);" class="menu-link d-flex px-5 change-language" data-lang="{{ $language->locale }}">
                                                <span class="symbol symbol-20px me-4">
                                                    <img class="rounded-1" src="{{ asset('assets/vendor/language/flags/' . $language->flag) }}" alt="{{ $language->name }}" />
                                                </span>{{ $language->name }}
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="d-flex fw-semibold text-primary fs-base gap-5">
                                <a href="javascript:void(0)" target="_blank">درباره ما</a>
                                <a href="javascript:void(0)" target="_blank">پشتیبانی</a>
                            </div>
                        </div>
                    </div>
                    <div id="loading">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid" width="200" height="200">
                            <circle r="20" fill="#013ca6" cy="50" cx="30">
                                <animate begin="-0.5s" values="30;70;30" keyTimes="0;0.5;1" dur="1s" repeatCount="indefinite" attributeName="cx"/>
                            </circle>
                            <circle r="20" fill="#fff" cy="50" cx="70">
                                <animate begin="0s" values="30;70;30" keyTimes="0;0.5;1" dur="1s" repeatCount="indefinite" attributeName="cx"/>
                            </circle>
                            <circle r="20" fill="#013ca6" cy="50" cx="30">
                                <animate begin="-0.5s" values="30;70;30" keyTimes="0;0.5;1" dur="1s" repeatCount="indefinite" attributeName="cx"/>
                                <animate repeatCount="indefinite" dur="1s" keyTimes="0;0.499;0.5;1" calcMode="discrete" values="0;0;1;1" attributeName="fill-opacity"/>
                            </circle>
                        </svg>
                        <div class="text-white prevent-select">در حال بارگذاری</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/vendor/panelio/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/vendor/panelio/js/scripts.bundle.js') }}"></script>
@endsection
