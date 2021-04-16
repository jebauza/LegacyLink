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

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Page Custom Styles(used by this page)-->
    <link href="{{ asset('assets/css/pages/login/classic/login-6.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Page Custom Styles-->
    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Theme Styles-->
    <!--begin::Layout Themes(used by all pages)-->
    <!--end::Layout Themes-->
    <link rel="shortcut icon" href="{{ asset('media/logos/logo-albia-rgb.jpg') }}" />
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body"
    class="header-mobile-fixed subheader-enabled aside-enabled aside-fixed aside-secondary-enabled page-loading">
    <!--begin::Main-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Login-->
        <div class="login login-6 login-signin-on login-signin-on d-flex flex-column-fluid" id="kt_login">
            <div class="d-flex flex-column flex-lg-row flex-row-fluid text-center"
                style="background-image: url(assets/media/bg/bg-3.jpg);">
                <!--begin:Aside-->
                <div class="d-flex w-100 flex-center p-15">
                    <div class="login-wrapper">
                        <!--begin:Aside Content-->
                        <div class="text-dark-75">
                            <a href="#">
                                <img src="{{ asset('media/logos/logotipo-horizontal-pantones.png') }}"
                                    class="max-h-75px" alt="" />
                            </a>
                            <h3 class="mb-8 mt-10 font-weight-bold">Su cuenta ha sido verificada exitosamente</h3>
                            {{--  <p class="mb-15 text-muted font-weight-bold">The ultimate Bootstrap &amp; Angular 6 admin
                                theme framework for next generation web apps.</p>
                            <button type="button" id="kt_login_signup"
                                class="btn btn-outline-primary btn-pill py-4 px-9 font-weight-bold">Get An
                                Account</button>  --}}
                        </div>
                        <!--end:Aside Content-->
                    </div>
                </div>
                <!--end:Aside-->
            </div>
        </div>
        <!--end::Login-->
    </div>
    <!--end::Main-->
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
    <!--begin::Page Scripts(used by this page)-->
    <script src="assets/js/pages/custom/login/login-general.js"></script>
    <!--end::Page Scripts-->
</body>
<!--end::Body-->

</html>
