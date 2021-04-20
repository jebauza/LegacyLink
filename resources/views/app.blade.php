<!DOCTYPE html>

<html lang="en">

@include('sections.head')

<body id="kt_body"
    class="header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-secondary-enabled footer-fixed page-loading">

    <div id="app">
        <!--Header Mobile-->
        @include('sections.header_mobile')

        <div class="d-flex flex-column flex-root">

            <div class="d-flex flex-row flex-column-fluid page">

                <!--begin::Aside-->
                @include('sections.aside')

                <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">

                    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

                        <!--Subheader-->
                        @include('sections.subheader')

                        <div class="d-flex flex-column-fluid">

                            <!--Content-->
                            <div class="container-fluid">

                                @yield('content')
                            </div>
                        </div>

                    </div>

                    <!--Footer-->
                    @include('sections.footer')

                </div>

            </div>
        </div>

        <!-- Quick Actions Panel-->
        @include('sections.extras.quick_actions')

        <!-- User Panel-->
        @include('sections.extras.quick_user')

        <!-- User Panel-->
        @include('sections.extras.quick_panel')

        <!-- Chat Panel-->
        @include('sections.extras.chat')

        <!-- Chat scrolltop-->
        @include('sections.extras.scrolltop')

    </div>


    <!-- Script-->
    @include('sections.script')

    @yield('script')

</body>

</html>
