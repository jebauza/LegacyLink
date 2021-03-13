<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <base href="/">
    <meta charset="utf-8" />
    <meta name="description" content="Login page example" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}1</title>
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Page Custom Styles(used by this page)-->
    <link href="{{ asset('assets/css/pages/login/classic/login-4.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Page Custom Styles-->
    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Theme Styles-->
    <!--begin::Layout Themes(used by all pages)-->
    <!--end::Layout Themes-->
    <link rel="shortcut icon" href="{{ asset('media/logos/favicon.ico') }}" />
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body"
    class="header-mobile-fixed subheader-enabled aside-enabled aside-fixed aside-secondary-enabled page-loading">

    @php
    $showForm = 'login-signin-on';
    $showForm = old('forgot_email') ? 'login-forgot-on' : $showForm;
    $showForm = (old('signup_email') || old('signup_password')) ? 'login-signup-on' : $showForm;
    @endphp
    <!--begin::Main-->
    <div id="app" class="d-flex flex-column flex-root">
        <!--begin::Login-->
        <div class="login login-4 {{ $showForm }} d-flex flex-row-fluid" id="kt_login">
            <div class="d-flex flex-center flex-row-fluid bgi-size-cover bgi-position-top bgi-no-repeat"
                style="background-image: url('assets/media/bg/bg-3.jpg');">
                <div class="login-form text-center p-7 position-relative overflow-hidden">
                    <!--begin::Login Header-->
                    <div class="d-flex flex-center mb-15">
                        <a href="#">
                            <img src="assets/media/logos/logo-letter-13.png" class="max-h-75px" alt="" />
                        </a>
                    </div>
                    <!--end::Login Header-->

                    @if (session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                    @endif

                    @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif

                    {{-- @if($errors->has('email'))
                    <div class="error">{{ $errors->first('email') }}
                </div>
                @endif

                @isset($errors)
                {{ dd($errors) }}
                @endisset --}}



                <!--begin::Login Sign in form-->
                <div class="login-signin">
                    <div class="mb-20">
                        <h3>Sign In To Admin</h3>
                        <div class="text-muted font-weight-bold">Enter your details to login to your account:</div>
                    </div>

                    <form class="form" id="kt_login_signin_form" method="POST" action="{{ route('admin.login') }}">
                        @csrf

                        <div class="form-group mb-5">
                            <input
                                class="form-control h-auto form-control-solid py-4 px-8  @error('email') is-invalid @enderror"
                                type="email" placeholder="{{ __('E-Mail Address') }}" name="email"
                                value="{{ old('email') }}" required autocomplete="off" autofocus />

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group mb-5">
                            <input
                                class="form-control h-auto form-control-solid py-4 px-8 @error('password') is-invalid @enderror"
                                type="password" placeholder="{{ __('Password') }}" name="password" required
                                autocomplete="current-password" />

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group d-flex flex-wrap justify-content-between align-items-center">
                            <div class="checkbox-inline">
                                <label class="checkbox m-0 text-muted">
                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} />
                                    <span></span>{{ __('Remember Me') }}</label>
                            </div>
                            <a href="javascript:;" id="kt_login_forgot" class="text-muted text-hover-primary">Forget
                                Password ?</a>
                        </div>
                        <button id="kt_login_signin_submit"
                            class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-4">Sign In</button>
                    </form>
                    <div class="mt-10">
                        <span class="opacity-70 mr-4">Don't have an account yet?</span>
                        <a href="javascript:;" id="kt_login_signup"
                            class="text-muted text-hover-primary font-weight-bold">Sign Up!</a>
                    </div>
                </div>
                <!--end::Login Sign in form-->

                <!--begin::Login Sign up form-->
                <div class="login-signup">
                    <div class="mb-20">
                        <h3>Sign Up</h3>
                        <div class="text-muted font-weight-bold">Enter your details to create your account</div>
                    </div>
                    <form class="form" id="kt_login_signup_form" method="POST" action="{{ route('admin.register') }}">
                        @csrf

                        <div class="form-group mb-5">
                            <input
                                class="form-control h-auto form-control-solid py-4 px-8 @error('name') is-invalid @enderror"
                                type="text" placeholder="{{ __('Name') }}" name="name" value="{{ old('name') }}"
                                required autocomplete="off" autofocus />

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group mb-5">
                            <input
                                class="form-control h-auto form-control-solid py-4 px-8 @error('signup_email') is-invalid @enderror"
                                type="text" placeholder="{{ __('E-Mail Address') }}" name="signup_email"
                                value="{{ old('signup_email') }}" required autocomplete="off" />

                            @error('signup_email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group mb-5">
                            <input
                                class="form-control h-auto form-control-solid py-4 px-8 @error('signup_password') is-invalid @enderror"
                                type="password" placeholder="{{ __('Password') }}" name="signup_password" required
                                autocomplete="off" />

                            @error('signup_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group mb-5">
                            <input class="form-control h-auto form-control-solid py-4 px-8" type="password"
                                placeholder="{{ __('Confirm Password') }}" name="signup_password_confirmation" required
                                autocomplete="new-password" />
                        </div>

                        {{-- <div class="form-group mb-5 text-left">
                                <div class="checkbox-inline">
                                    <label class="checkbox m-0">
                                        <input type="checkbox" name="agree" />
                                        <span></span>I Agree the
                                        <a href="#" class="font-weight-bold ml-1">terms and conditions</a>.</label>
                                </div>
                                <div class="form-text text-muted text-center"></div>
                            </div> --}}

                        <div class="form-group d-flex flex-wrap flex-center mt-10">
                            <button id="kt_login_signup_submit"
                                class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-2">Sign Up</button>
                            <button id="kt_login_signup_cancel"
                                class="btn btn-light-primary font-weight-bold px-9 py-4 my-3 mx-2">Cancel</button>
                        </div>
                    </form>
                </div>
                <!--end::Login Sign up form-->

                <!--begin::Login forgot password form-->
                <div class="login-forgot">
                    <div class="mb-20">
                        <h3>Forgotten Password ?</h3>
                        <div class="text-muted font-weight-bold">Enter your email to reset your password</div>
                    </div>
                    <form class="form" id="kt_login_forgot_form" method="POST"
                        action="{{ route('admin.forget-password') }}">
                        @csrf

                        <div class="form-group mb-10">
                            <input
                                class="form-control form-control-solid h-auto py-4 px-8 @error('email') is-invalid @enderror"
                                type="email" placeholder="Email" name="forgot_email" value="{{ old('forgot_email') }}"
                                autocomplete="off" />

                            @error('forgot_email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group d-flex flex-wrap flex-center mt-10">
                            <button id="kt_login_forgot_submit"
                                class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-2">Request</button>
                            <button id="kt_login_forgot_cancel"
                                class="btn btn-light-primary font-weight-bold px-9 py-4 my-3 mx-2">Cancel</button>
                        </div>
                    </form>
                </div>
                <!--end::Login forgot password form-->

            </div>
        </div>
    </div>
    <!--end::Login-->
    </div>
    <!--end::Main-->
    <!-- JQuery, Bootstrap, VueJS -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        var HOST_URL = "https://preview.keenthemes.com/metronic/theme/html/tools/preview";
    </script>
    <!--begin::Global Config(global config for global JS scripts)-->
    <script>
        var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#1BC5BD", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#6993FF", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#1BC5BD", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#E1E9FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };
    </script>
    <!--end::Global Config-->
    <!--begin::Global Theme Bundle(used by all pages)-->
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    <!--end::Global Theme Bundle-->

    <script>
        var KTLogin = function() {
            var _login;

            var _showForm = function(form) {
                var cls = 'login-' + form + '-on';
                var form = 'kt_login_' + form + '_form';

                _login.removeClass('login-forgot-on');
                _login.removeClass('login-signin-on');
                _login.removeClass('login-signup-on');

                _login.addClass(cls);

                KTUtil.animateClass(KTUtil.getById(form), 'animate__animated animate__backInUp');
            }

            var _handleSignInForm = function() {
                var validation;

                // Handle forgot button
                $('#kt_login_forgot').on('click', function (e) {
                    e.preventDefault();
                    _showForm('forgot');
                });

                // Handle signup
                $('#kt_login_signup').on('click', function (e) {
                    e.preventDefault();
                    _showForm('signup');
                });
            }

            var _handleSignUpForm = function(e) {
                var validation;
                var form = KTUtil.getById('kt_login_signup_form');

                // Handle cancel button
                $('#kt_login_signup_cancel').on('click', function (e) {
                    e.preventDefault();

                    _showForm('signin');
                });
            }

            var _handleForgotForm = function(e) {
                var validation;

                // Handle cancel button
                $('#kt_login_forgot_cancel').on('click', function (e) {
                    e.preventDefault();

                    _showForm('signin');
                });
            }

            // Public Functions
            return {
                // public functions
                init: function() {
                    _login = $('#kt_login');

                    _handleSignInForm();
                    _handleSignUpForm();
                    _handleForgotForm();
                }
            };
        }();

        // Class Initialization
        jQuery(document).ready(function() {
            KTLogin.init();
        });

    </script>
</body>


</html>
