@extends('authio::layout')

@section('body')
    <form class="form w-100 pt-20" action="">
        <div id="form-auth" class="form-data active">
            <div class="text-right mb-20">
                <h1 class="text-dark fw-bolder mb-3">{{ trans('authio::base.page.auth.title') }}</h1>
                <div class="text-gray-500 fw-semibold fs-6">{{ trans('authio::base.page.auth.description') }}</div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="d-flex justify-content-between align-items-center mb-5">
                        <span class="fs-4 fw-semibold">{{ trans('authio::base.page.auth.login_by') }}</span>
                        <div class="nav-group nav-group-outline">
                            <button class="form-auth-change-data btn btn-color-gray-600 btn-active btn-active-secondary fs-6 px-4 py-1 me-2 active" onclick="authio.pages.auth.changeType(this, event)" data-type="mobile">{{ trans('authio::base.page.auth.mobile') }}</button>
                            <button class="form-auth-change-data btn btn-color-gray-600 btn-active btn-active-secondary fs-6 px-4 py-1" onclick="authio.pages.auth.changeType(this, event)" data-type="email">{{ trans('authio::base.page.auth.email') }}</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row fv-row mb-8">
                <div class="col">
                    <div id="form-auth-mobile" class="form-auth-data-mode active">
                        <div class="row">
                            <div class="col-8">
                                <input type="number" id="mobile" autocomplete="off" class="form-control form-control-solid me-3 flex-grow-1" min="0" placeholder="{{ trans('authio::base.page.auth.mobile_placeholder') }}" onkeydown="authio.pages.auth.enterKey(event)"/>
                            </div>
                            <div class="col-4">
                                <select id="mobile-prefix" class="form-control form-control-solid btn-light fw-bold flex-shrink-0">
                                    @foreach($countries as $country)
                                        <option value="{{ $country->mobile_prefix }}">{{ $country->mobile_prefix }} ({{ $country->name }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <span class="text-danger fs-7 form-error" id="error-mobile"></span>
                            </div>
                        </div>
                    </div>
                    <div id="form-auth-email" class="form-auth-data-mode">
                        <input type="email" id="email" autocomplete="off" class="form-control form-control-solid" placeholder="{{ trans('authio::base.page.auth.email_placeholder') }}" onkeydown="authio.pages.auth.enterKey(event)"/>
                        <span class="text-danger fs-7 form-error" id="error-email"></span>
                    </div>
                </div>
            </div>
            <div class="row mb-10">
                <div class="col-12">
                    <div class="d-grid">
                        <button class="btn btn-primary" onclick="authio.pages.auth.send(event)">
                            <span class="indicator-label">{{ trans('authio::base.page.buttons.next') }}</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="separator separator-content my-14 mt-20">
                <span class="w-250px text-gray-500 fw-semibold fs-7">{{ trans('authio::base.page.auth.social_login') }}</span>
            </div>
            <div class="d-flex flex-wrap flex-center">
                <a href="javascript:void(0)" class="btn btn-icon btn-light-facebook me-5">
                    <i class="fab fa-facebook-f fs-4"></i>
                </a>
                <a href="javascript:void(0)" class="btn btn-icon btn-light-google me-5">
                    <i class="fab fa-google fs-4"></i>
                </a>
                <a href="javascript:void(0)" class="btn btn-icon btn-light-twitter me-5">
                    <i class="fab fa-twitter fs-4"></i>
                </a>
                <a href="javascript:void(0)" class="btn btn-icon btn-light-linkedin me-5">
                    <i class="fab fa-linkedin fs-4"></i>
                </a>
                <a href="javascript:void(0)" class="btn btn-icon btn-light-facebook">
                    <i class="fab fa-github fs-4"></i>
                </a>
            </div>
        </div>

        <div id="form-code" class="form-data">
            <div class="d-flex justify-content-between">
                <div class="text-right mb-20">
                    <h1 class="text-dark fw-bolder mb-3">{{ trans('authio::base.page.code.title') }}</h1>
                    <div class="text-gray-500 fw-semibold fs-6">
                        <span>{{ trans('authio::base.page.code.description') }}</span>
                    </div>
                </div>
                <a href="javascript:void(0)" onclick="authio.pages.auth.backTo(event)" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="{{ trans('authio::base.page.buttons.change') }}">
                    <i class="ki-duotone ki-pencil fs-2x">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </a>
            </div>
            <div class="row fv-row mb-8 flex-row-reverse">
                <div class="col">
                    <input type="number" id="code-1" autocomplete="off" class="form-control form-control-solid text-center" onkeydown="authio.pages.code.fill(this, event)" data-code-number="1"/>
                </div>
                <div class="col">
                    <input type="number" id="code-2" autocomplete="off" class="form-control form-control-solid text-center" onkeydown="authio.pages.code.fill(this, event)" data-code-number="2"/>
                </div>
                <div class="col">
                    <input type="number" id="code-3" autocomplete="off" class="form-control form-control-solid text-center" onkeydown="authio.pages.code.fill(this, event)" data-code-number="3"/>
                </div>
                <div class="col">
                    <input type="number" id="code-4" autocomplete="off" class="form-control form-control-solid text-center" onkeydown="authio.pages.code.fill(this, event)" data-code-number="4"/>
                </div>
                <div class="col">
                    <input type="number" id="code-5" autocomplete="off" class="form-control form-control-solid text-center" onkeydown="authio.pages.code.fill(this, event)" data-code-number="5"/>
                </div>
            </div>
            <div class="d-flex justify-content-between mb-7">
                <div>
                    <a href="javascript:void(0)" class="text-primary fw-semibold fs-6" onclick="authio.pages.password.show()">{{ trans('authio::base.page.buttons.login_password') }}</a>
                </div>
                <div>
                    <span id="timer" class="text-primary fw-semibold fs-6 active"></span>
                    <a href="javascript:void(0)" onclick="authio.pages.code.resend()">{{ trans('authio::base.page.buttons.resend') }}</a>
                </div>
            </div>
            <div class="row mb-10">
                <div class="col-12">
                    <div class="d-grid">
                        <button id="btn-code" class="btn btn-primary">
                            <span class="indicator-label">{{ trans('authio::base.page.buttons.login') }}</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="register-data">
                <div class="separator my-14 mt-20"></div>
                <div class="d-flex flex-wrap flex-center">
                    <p class="text-gray-500 fw-semibold fs-7">{{ trans('authio::base.page.code.rules') }}</p>
                </div>
            </div>
        </div>

        <div id="form-password" class="form-data">
            <div class="d-flex justify-content-between">
                <div class="text-right mb-20">
                    <h1 class="text-dark fw-bolder mb-3">{{ trans('authio::base.page.password.title') }}</h1>
                    <div class="text-gray-500 fw-semibold fs-6">
                        <span>{{ trans('authio::base.page.password.description') }}</span>
                    </div>
                </div>
                <a href="javascript:void(0)" onclick="authio.pages.auth.backTo(event)" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="{{ trans('authio::base.page.buttons.change') }}">
                    <i class="ki-duotone ki-pencil fs-2x">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </a>
            </div>
            <div class="row fv-row mb-8 flex-row-reverse">
                <div class="col position-relative">
                    <input type="password" id="password" onkeyup="authio.pages.password.changeType.toggle(this)" autocomplete="off" class="form-control form-control-solid text-center"/>
                    <div onclick="authio.pages.password.changeType.action(this)">
                        <i class="ki-duotone ki-eye fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between mb-7">
                <div>
                    <a href="javascript:void(0)" class="text-primary fw-semibold fs-6" onclick="authio.pages.code.show()">{{ trans('authio::base.page.buttons.login_code') }}</a>
                </div>
            </div>
            <div class="row mb-10">
                <div class="col-12">
                    <div class="d-grid">
                        <button class="btn btn-primary" onclick="authio.pages.password.send(event)">
                            <span class="indicator-label">{{ trans('authio::base.page.buttons.login') }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div id="form-authenticator" class="form-data">
            <div class="d-flex justify-content-between">
                <div class="text-right mb-20">
                    <h1 class="text-dark fw-bolder mb-3">{{ trans('authio::base.page.authenticator.title') }}</h1>
                    <div class="text-gray-500 fw-semibold fs-6">
                        <span>{{ trans('authio::base.page.authenticator.description') }}</span>
                    </div>
                </div>
                <a href="javascript:void(0)" onclick="authio.pages.auth.backTo(event)" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="{{ trans('authio::base.page.buttons.change') }}">
                    <i class="ki-duotone ki-pencil fs-2x">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </a>
            </div>
            <div class="row fv-row mb-8 flex-row-reverse">
                <div class="col">
                    <input type="number" id="auth-code" maxlength="6" autocomplete="off" class="form-control form-control-solid text-center"/>
                </div>
            </div>
            <div class="d-flex justify-content-between mb-7">
                <div>
                    <a href="javascript:void(0)" class="text-primary fw-semibold fs-6" onclick="authio.pages.code.show()">{{ trans('authio::base.page.buttons.login_code') }}</a>
                </div>
            </div>
            <div class="row mb-10">
                <div class="col-12">
                    <div class="d-grid">
                        <button id="btn-authenticator" class="btn btn-primary">
                            <span class="indicator-label">{{ trans('authio::base.page.buttons.login') }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div id="form-selection" class="form-data">
            <div class="d-flex justify-content-between">
                <div class="text-right mb-20">
                    <h1 class="text-dark fw-bolder mb-3">{{ trans('authio::base.page.selection.title') }}</h1>
                    <div class="text-gray-500 fw-semibold fs-6">
                        <span>{{ trans('authio::base.page.selection.description') }}</span>
                    </div>
                </div>
                <a href="javascript:void(0)" onclick="authio.pages.auth.backTo(event)" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" title="{{ trans('authio::base.page.buttons.change') }}">
                    <i class="ki-duotone ki-pencil fs-2x">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </a>
            </div>
            <div class="row fv-row mb-8">
                <div class="col">
                    <input type="radio" class="btn-check" name="selection-method" value="authenticator" id="select-authenticator"/>
                    <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-5 d-flex align-items-center mb-5" for="select-authenticator" onclick="authio.pages.selection.select('authenticator')">
                        <div class="col-3">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 2481.9 2481.9" width="30px">
                                <g transform="translate(-27 -27)">
                                    <circle fill="#616161" cx="1268" cy="1268" r="1241"/>
                                    <path fill="#9E9E9E" d="M1268,2057.7c-436.2,0-789.7-353.5-789.7-789.7c0-436.2,353.5-789.7,789.7-789.7c218,0,415.4,88.4,558.4,231.3 l319.1-319.1C1920.9,165.9,1610.6,27,1268,27C582.6,27,27,582.6,27,1268s555.6,1241,1241,1241c342.7,0,652.9-138.9,877.6-363.4 l-319.1-319.1C1683.4,1969.3,1486,2057.7,1268,2057.7z"/>
                                    <path fill="#424242" d="M2057.7,1268h-394.9c0-218-176.8-394.9-394.9-394.9S873.1,1049.9,873.1,1268c0,106.2,42,202.5,110.3,273.6 l-0.3,0.3l488.9,488.9l0.1,0.1C1809.3,1940.9,2057.7,1633.5,2057.7,1268L2057.7,1268z"/>
                                    <path fill="#616161" d="M2508.9,1268h-451.3c0,365.5-248.5,672.9-585.5,762.9l348.5,348.5C2228.6,2176.1,2508.9,1754.8,2508.9,1268z"/>
                                    <g transform="translate(236.455 236.455)">
                                        <path fill="#9E9E9E" d="M2046.9,918.7H1031.5c-62.3,0-112.8,50.5-112.8,112.8c0,62.3,50.5,112.8,112.8,112.8h1015.3 c62.3,0,112.8-50.5,112.8-112.8C2159.7,969.2,2109.2,918.7,2046.9,918.7z"/>
                                        <path fill="#BDBDBD" opacity="0.5" d="M2046.9,918.7H1031.5c-62.3,0-112.8,50.5-112.8,112.8c0,62.3,50.5,112.8,112.8,112.8h1015.3 c62.3,0,112.8-50.5,112.8-112.8C2159.7,969.2,2109.2,918.7,2046.9,918.7z"/>
                                    </g>
                                    <g fill="#BDBDBD">
                                        <circle cx="1268" cy="252.6" r="84.6"/>
                                        <circle cx="548.8" cy="550" r="84.6"/>
                                        <circle cx="252.6" cy="1268" r="84.6"/>
                                        <circle cx="548.8" cy="1987.2" r="84.6"/>
                                        <circle cx="1268" cy="2283.3" r="84.6"/>
                                    </g>
                                    <circle fill="#757575" cx="1987.2" cy="1987.2" r="84.6"/>
                                </g>
                            </svg>
                        </div>
                        <div class="col">
                            <span class="d-block fw-semibold text-start">
                                <span class="text-gray-900 fw-bold d-block fs-3">{{ trans('authio::base.page.selection.authenticator') }}</span>
                            </span>
                        </div>
                    </label>
                    <input type="radio" class="btn-check" name="selection-method" value="sms" id="select-sms"/>
                    <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-5 d-flex align-items-center mb-5" for="select-sms" onclick="authio.pages.selection.select('code')">
                        <div class="col-3">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="100 85 315 315" width="30px" fill="#000">
                                <path fill="#FFD05B" d="M408.2,360.4V189.5H96.8v170.9c0,20.2,16.3,36.5,36.5,36.5h238.4 C391.9,396.9,408.2,380.6,408.2,360.4z"/>
                                <path fill="#FFD05B" d="M408.2,189.5v170.9c0,10.4-4.4,19.8-11.3,26.4c-6.6,6.3-15.4,10.1-25.2,10.1H133.3 c-9.8,0-18.7-3.8-25.2-10.1c-7-6.7-11.3-16-11.3-26.4V189.5H408.2z"/>
                                <path fill="#FF7058" d="M231.6,95.4L96.8,189.5l155.7,108.7l155.6-108.7L273.4,95.4C260.8,86.6,244.1,86.6,231.6,95.4z"/>
                                <path fill="#FF7058" d="M408.1,189.5l-40.1,28l-115.5,80.7l-115.7-80.7l-40-28l40-28l56.4-39.4l38.4-26.8 c12.5-8.8,29.2-8.8,41.8,0l38.4,26.8l56.4,39.4L408.1,189.5z"/>
                                <path fill="#FFFFFF" d="M368.1,137.9v79.6l-115.6,80.7l-115.7-80.7V138c0-8.7,7.1-15.8,15.8-15.8h199.7 C361,122.2,368.1,129.2,368.1,137.9z"/>
                                <path fill="#F9B54C" d="M396.9,386.8c-6.6,6.3-15.4,10.1-25.2,10.1H133.3c-9.8,0-18.7-3.8-25.2-10.1l120-107.6 c13.9-12.4,34.8-12.4,48.7,0L396.9,386.8z"/>
                                <path fill="#4CDBC4" d="M194.5,175.6c-1,0.8-1.5,1.9-1.5,3.3c0,1.4,0.6,2.5,1.9,3.3c1.2,0.8,4.1,1.8,8.6,2.9 c4.5,1.1,7.9,2.8,10.4,5s3.7,5.4,3.7,9.6c0,4.2-1.6,7.7-4.8,10.3s-7.3,3.9-12.5,3.9c-7.5,0-14.2-2.8-20.2-8.3l6.3-7.7 c5.1,4.4,9.8,6.7,14.1,6.7c1.9,0,3.4-0.4,4.6-1.2c1.1-0.8,1.7-2,1.7-3.4s-0.6-2.5-1.8-3.4c-1.2-0.8-3.5-1.7-6.9-2.5 c-5.5-1.3-9.5-3-12-5.1s-3.8-5.4-3.8-9.8c0-4.5,1.6-7.9,4.8-10.4c3.2-2.4,7.2-3.6,12-3.6c3.1,0,6.3,0.5,9.4,1.6 c3.1,1.1,5.9,2.6,8.2,4.6l-5.3,7.7c-4.1-3.1-8.3-4.7-12.7-4.7C196.9,174.3,195.5,174.8,194.5,175.6z"/>
                                <path fill="#4CDBC4" d="M268.7,183.7L256,209.5h-6.3L237,183.7v29.7h-10.5v-47.1h14.2l12.1,25.9l12.2-25.9h14.2v47.1h-10.5 V183.7z"/>
                                <path fill="#4CDBC4" d="M301.8,175.6c-1,0.8-1.5,1.9-1.5,3.3c0,1.4,0.6,2.5,1.9,3.3c1.2,0.8,4.1,1.8,8.6,2.9 c4.5,1.1,7.9,2.8,10.4,5s3.7,5.4,3.7,9.6c0,4.2-1.6,7.7-4.8,10.3c-3.2,2.6-7.3,3.9-12.5,3.9c-7.5,0-14.2-2.8-20.2-8.3l6.3-7.7 c5.1,4.4,9.8,6.7,14.1,6.7c1.9,0,3.4-0.4,4.6-1.2c1.1-0.8,1.7-2,1.7-3.4s-0.6-2.5-1.8-3.4c-1.2-0.8-3.5-1.7-6.9-2.5 c-5.5-1.3-9.5-3-12-5.1s-3.8-5.4-3.8-9.8c0-4.5,1.6-7.9,4.8-10.4c3.2-2.4,7.2-3.6,12-3.6c3.1,0,6.3,0.5,9.4,1.6s5.9,2.6,8.2,4.6 l-5.3,7.7c-4.1-3.1-8.3-4.7-12.7-4.7C304.2,174.3,302.8,174.8,301.8,175.6z"/>
                            </svg>
                        </div>
                        <div class="col">
                            <span class="d-block fw-semibold text-start">
                                <span class="text-gray-900 fw-bold d-block fs-3">{{ trans('authio::base.page.selection.sms') }}</span>
                            </span>
                        </div>
                    </label>
                    <input type="radio" class="btn-check" name="selection-method" value="email" id="select-email"/>
                    <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-5 d-flex align-items-center mb-5" for="select-email" onclick="authio.pages.selection.select('email')">
                        <div class="col-3">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="30px" fill="#000000">
                                <polygon fill="#C0874A" points="511.401,173.663 502.513,179.269 458.244,207.066 268.606,326.073 266.213,327.652 265.699,327.968 256.043,334.048 255.701,334.207 247.753,329.232 246.299,328.284 66.659,215.516 54.439,207.856 0.598,174.057 0,173.663 54.439,139.469 249.548,16.988 261.854,16.988 458.244,140.258 464.74,144.365"/>
                                <path fill="#69B25F" d="M467.859,16.065v383.862c0,8.807-7.88,15.985-17.641,15.985H62.29 c-9.671,0-17.551-7.178-17.551-15.985V16.065C44.739,7.176,52.619,0,62.29,0h387.928C459.978,0,467.859,7.176,467.859,16.065z"/>
                                <rect x="110.787" y="75.101"  fill="#A2CC86" width="190.508" height="25.378"/>
                                <rect x="110.787" y="71.093"  fill="#53A654" width="190.508" height="25.378"/>
                                <rect x="110.787" y="214.682" fill="#A2CC86" width="289.501" height="25.378"/>
                                <rect x="110.787" y="210.675" fill="#53A654" width="289.501" height="25.378"/>
                                <rect x="110.787" y="284.473" fill="#A2CC86" width="289.501" height="25.378"/>
                                <rect x="110.787" y="280.466" fill="#53A654" width="289.501" height="25.378"/>
                                <rect x="110.787" y="144.891" fill="#A2CC86" width="289.501" height="25.378"/>
                                <rect x="110.787" y="140.884" fill="#53A654" width="289.501" height="25.378"/>
                                <polygon fill="#F0BA7D" points="256.299,322.118 253.308,323.881 195.45,357.662 188.356,361.847 12.392,464.583 0.598,471.413 0.598,172.824 71.446,214.169 246.642,316.464 248.009,317.272 256.043,321.971"/>
                                <path fill="#E5A864" d="M510.236,167.293c0.97-0.567,1.764-0.111,1.764,1.013v294.576c0,1.124-0.019,2.027-0.043,2.006 s-0.139-0.103-0.257-0.184c-0.118-0.081-0.291-0.197-0.385-0.257c-0.094-0.061-0.19-0.11-0.214-0.11 c-0.024,0-0.837-0.464-1.807-1.03L265.498,320.993c-0.97-0.566-2.556-1.497-3.524-2.068l-0.839-0.495 c-0.968-0.571-2.452-1.451-3.298-1.956c-0.846-0.505-0.743-1.379,0.229-1.944l6.209-3.604c0.972-0.564,1.825-1.059,1.895-1.099 c0.071-0.04,0.186-0.107,0.257-0.147c0.071-0.04,0.923-0.535,1.895-1.1l5.44-3.161c0.972-0.564,2.56-1.49,3.531-2.057 L510.236,167.293z"/>
                                <circle fill="#EEF3CA" opacity="0.68" cx="377.142" cy="75.101" r="38.186"/>
                                <path fill="#C0874A" d="M512,425.251v45.808h-0.513l-7.35,0.342H27.689l-0.341-7.094 c8.632-5.896,20.082-13.845,27.518-18.887l1.025-0.684l24.956-17.178l38.97-26.92l11.28-7.777l118.365-81.615l7.947-5.556 c1.88-1.195,4.017-2.222,6.324-2.904c2.735-0.941,5.726-1.539,8.717-1.795c1.025-0.086,1.965-0.171,2.991-0.086 c1.025-0.171,2.052-0.171,3.077-0.171c2.735-0.085,5.385,0.171,7.948,0.683c2.734,0.513,5.213,1.369,7.435,2.564l89.735,49.91 l44.354,24.697l11.538,6.41l41.79,23.245l27.518,15.298c0.77,0.428,1.624,0.855,2.479,1.368 C511.487,424.995,511.743,425.166,512,425.251z"/>
                                <path fill="#ECB168" d="M512,441.404v29.997H0.598v-29.997c8.974-5.471,20.768-12.905,28.459-17.52l1.025-0.684 l25.724-15.98l40.252-24.955l11.623-7.264l122.125-75.805l8.204-5.127c4.273-2.564,9.828-3.846,15.298-3.932 c1.025-0.086,1.965-0.086,2.991,0c1.026-0.086,2.051-0.086,3.077,0c2.393,0,4.701,0.257,6.923,0.769 c3.077,0.599,5.896,1.71,8.29,3.163l11.879,7.349l75.377,46.834l43.073,26.75l11.196,7.007l40.68,25.212l26.748,16.665 c0.77,0.428,1.539,0.854,2.393,1.367c5.47,3.505,12.477,7.864,19.058,11.88C507.385,438.669,509.778,440.122,512,441.404z"/>
                                <path fill="#BADB9E" opacity="0.2" d="M467.816,16.066v4.273c0-8.887-7.863-16.066-17.605-16.066H62.301 c-9.656,0-17.604,7.178-17.604,16.066v-4.273C44.696,7.178,52.645,0,62.301,0h387.911C459.953,0,467.816,7.178,467.816,16.066z"/>
                            </svg>
                        </div>
                        <div class="col">
                            <span class="d-block fw-semibold text-start">
                                <span class="text-gray-900 fw-bold d-block fs-3">{{ trans('authio::base.page.selection.email') }}</span>
                            </span>
                        </div>
                    </label>
                </div>
            </div>
        </div>
    </form>
@endsection
