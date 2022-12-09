<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Solapa Solar & Power HTML-5 Template | Homepage 01</title>

    <!-- Stylesheets -->
    <link href="{!! asset('assets/vendors/bootstrap/css/bootstrap.css') !!}" rel="stylesheet">
    <link href="{!! asset('assets/vendors/fontawesome/css/font-awesome.css') !!}" rel="stylesheet">
    <link href="{!! asset('assets/vendors/flaticons/flaticon.css') !!}" rel="stylesheet">
    <link href="{!! asset('assets/vendors/animate/css/animate.css') !!}" rel="stylesheet">
    <link href="{!! asset('assets/vendors/owl-slider/css/owl.css') !!}" rel="stylesheet">
    <link href="{!! asset('assets/vendors/icomoon-fonts/css/style.css') !!}" rel="stylesheet">
    <link href="{!! asset('assets/vendors/jquery-ui/css/jquery-ui.css') !!}" rel="stylesheet">
    <link href="{!! asset('assets/vendors/animate/css/custom-animate.css') !!}" rel="stylesheet">
    <!-- <link href="{!! asset('assets/vendors/fancybox/css/jquery.fancybox.min.css') !!}" rel="stylesheet"> -->
    <link href="{!! asset('assets/vendors/swiper/swiper.min.css') !!}" rel="stylesheet">

    <!-- Catamaran Font -->
    <link href="https://fonts.googleapis.com/css2?family=Catamaran:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Smooch Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Smooch+Sans:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Favicons Icons -->
    <link rel="apple-touch-icon" sizes="180x180" href="{!! asset('assets/images/favicons/apple-touch-icon.png') !!}" />
    <link rel="icon" type="image/png" sizes="32x32" href="{!! asset('assets/images/favicons/favicon-32x32.png') !!}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{!! asset('assets/images/favicons/favicon-16x16.png') !!}" />
    <link rel="manifest" href="{!! asset('assets/images/favicons/site.webmanifest') !!}" />

    <!-- Responsive -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <!-- todo include in page -->
    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css"
        rel="stylesheet">
    <link href="{!! asset('assets/css/solapa.css') !!}" rel="stylesheet">
    <link href="{!! asset('assets/css/solapa-responsive.css') !!}" rel="stylesheet">
    <link href="{!! asset('assets/css/custom.css') !!}" rel="stylesheet">


    <!--[if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script><![endif]-->
    <!--[if lt IE 9]><script src="js/respond.js"></script><![endif]-->
    @stack('css')
</head>

<body>

    <div class="page-wrapper">

        <!-- Preloader -->
        <div class="preloader">
            <span></span>
        </div>
        <!-- End Preloader -->

        <!-- Header Style One -->
        <header class="main-header">

            <!-- Header Top -->
            <div class="main-header__top">
                <div class="container clearfix">

                    <div class="pull-left">
                        <ul class="main-header__info">
                            <li><a href="contact.html"><span class="icon icon-location"></span> @if (isset($site_settings->address))
								{{ $site_settings->address }}
							@endif</a></li>
                            <li><a href="mailto:helpus24@gmail.com"><span class="icon icon-email"></span>
                                    @if (isset($site_settings->email))
                                        {{ $site_settings->email }}
                                    @endif
                                </a></li>
                        </ul>
                    </div>

                    <div class="pull-right clearfix">
                        <div class="main-header__top-text">@lang('app.header_right_text')</div>
                        <div class="main-header__top-estimate"><a
                                href="{{ route('requestQuote') }}">{{ trans('app.request_quote') }}</a></div>

                        <!-- Language DropDown -->
                        <!-- <div class="main-header__language-dropdown dropdown">
       <button class="dropdown-toggle" type="button" id="dropdownMenuButton1"
        data-bs-toggle="dropdown" aria-expanded="false">
        <span class="header-top__flag-icon"><img src="{!! asset('assets/images/icons/flag.png') !!}"
          alt="" /></span> English
       </button>
       <ul class="main-header__language-list dropdown-menu" aria-labelledby="dropdownMenuButton1">
        <li><a href="#">English</a></li>
        <li><a href="#">German</a></li>
        <li><a href="#">Arabic</a></li>
        <li><a href="#">Hindi</a></li>
       </ul>
      </div> -->

                        <!-- Cart Box -->
                        <!-- <div class="main-header__cart-box">
       <div class="dropdown">
        <button class="dropdown-toggle" type="button" id="dropdownMenuButton2"
         data-bs-toggle="dropdown" aria-expanded="false"><span
          class="icon-shopping-cart"></span><span
          class="main-header__total-cart">2</span></button>
        <div class="dropdown-menu main-header__cart-panel"
         aria-labelledby="dropdownMenuButton2">
         <div class="main-header__cart-product">
          <div class="inner">
           <div class="main-header__cross-icon"><span class="icon fa fa-remove"></span>
           </div>
           <div class="main-header__cart-image"><img
             src="assets/images/resource/post-thumb-1.jpg" alt="" /></div>
           <h3 class="main-header__cart-title"><a href="shoping-cart.html">Product
             01</a></h3>
           <div class="main-header__quantity-text">Quantity 1</div>
           <div class="main-header__cart-price">$99.00</div>
          </div>
         </div>
         <div class="main-header__cart-product">
          <div class="inner">
           <div class="main-header__cross-icon"><span class="icon fa fa-remove"></span>
           </div>
           <div class="main-header__cart-image"><img
             src="assets/images/resource/post-thumb-2.jpg" alt="" /></div>
           <h3 class="main-header__cart-title"><a href="shoping-cart.html">Product
             02</a></h3>
           <div class="main-header__quantity-text">Quantity 1</div>
           <div class="main-header__cart-price">$99.00</div>
          </div>
         </div>
         <div class="main-header__cart-total">Sub Total: <span>$198</span></div>
         <ul class="main-header__cart-btns">
          <li><a href="shoping-cart.html">View Cart</a></li>
          <li><a href="checkout.html">CheckOut</a></li>
         </ul>
        </div>
       </div>
      </div> -->
                        <!-- End Cart Box -->

                    </div>

                </div>
            </div>

            <!-- Header Lower -->
            <div class="main-header__lower">
                <div class="container">
                    <div class="main-header__lower__inner clearfix">
                        <!-- Logo Box -->
                        <div class="main-header__logo-box">
                            <div class="main-header__logo"><a href="{{ route('homepage') }}"><img
                                        src="{{ asset('assets/images/logo1.jpg') }}" style="left:28px" alt=""
                                        title=""></a></div>
                        </div>

                        <!-- Nav Outer -->
                        <div class="nav-outer clearfix">
                            <!-- Mobile Navigation Toggler -->
                            <div class="mobile-nav-toggler"><span class="icon fas fa-bars"></span></div>
                            <!-- Main Menu -->
                            <nav class="main-menu__menu-box navbar-expand-md">
                                <div class="navbar-header">
                                    <!-- Toggle Button -->
                                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                        aria-expanded="false" aria-label="Toggle navigation">
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>
                                </div>

                                <div class="navbar-collapse collapse clearfix" id="navbarSupportedContent">
                                    <ul class="main-menu__navigation">
                                        <li @if (isset($menu) && $menu == 'home') class="current" @endif><a href="{{ route('homepage') }}">{{ trans('app.home') }}</a></li>
                                        <li @if (isset($menu) && $menu == 'services') class="current" @endif><a href="{{ route('services') }}">{{ trans('app.services') }}</a></li>
                                        <li @if (isset($menu) && $menu == 'homeowner') class="current" @endif><a href="{{ route('homeOwner') }}">{{ trans('app.homeowner') }}</a></li>
                                        <li @if (isset($menu) && $menu == 'business') class="current" @endif><a href="{{ route('homeOwner') }}">{{ trans('app.business') }}</a></li>
                                        <li @if (isset($menu) && $menu == 'maintenance') class="current" @endif><a href="{{ route('maintenance') }}">{{ trans('app.maintenance') }}</a></li>
                                        <li @if (isset($menu) && $menu == 'contact') class="current" @endif><a href="{{ route('contact') }}">{{ trans('app.contact') }}</a></li>

                                    </ul>
                                </div>
                            </nav>
                        </div>
                        <!-- Main Menu End-->
                        <div class="outer-box clearfix">
                            <!-- Phone Box -->
                            <div class="main-header__phone-box">
                                <div class="main-header__phone-inner">
                                    <span class="main-header__phone-icon icon-phone"></span>
                                    Phone Number<br>
                                    <a class="main-header__phone-number" href="tel:+88-5700-24-51">(88) 5700-24-51
                                        Call</a>
                                </div>
                            </div>
                            <!-- End Phone Box -->
                            <div class="main-header__button-box">
                                @if (!Auth::user())
                                    <a href="{{ route('user-auth') }}" class="theme-btn btn-style-one"><span
                                            class="txt">Signin
                                        </span></a>
                                @else
                                    <a href="{{ url('/auth') }}" class="theme-btn btn-style-one"><span
                                            class="txt">Profile
                                        </span></a>
                                @endif

                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <!-- End Header Lower -->

            <!-- Sticky Header  -->
            <div class="sticky-header">
                <div class="container clearfix">
                    <!-- Logo -->
                    <div class="sticky-header__logo pull-left">
                        <a href="{{ route('homepage') }}" title=""><img src="{{ asset('assets/images/logo1.jpg') }}"
                                alt="" title=""></a>
                    </div>
                    <!--Right Col-->
                    <div class="pull-right">

                        <!-- Main Menu -->
                        <nav class="main-menu__navigation">
                            <!--Keep This Empty / Menu will come through Javascript-->
                        </nav>
                        <!-- Main Menu End-->

                        <!-- Mobile Navigation Toggler -->
                        <div class="mobile-nav-toggler"><span class="icon fas fa-bars"></span></div>

                    </div>
                </div>
            </div><!-- End Sticky Menu -->

            <!-- Mobile Menu  -->
            <div class="mobile-menu">
                <div class="menu-backdrop"></div>
                <div class="close-btn"><span class="icon fas fa-times"></span></div>

                <nav class="mobile-menu__box">
                    <!-- assets/images/resource/logo-2.png -->
                    <div class="mobile-menu__logo"><a href="{{ route('homepage') }}"><img
                                src="{{ asset('assets/images/logo1.jpg') }}" alt="" title=""></a>
                    </div>
                    <div class="mobile-menu__outer">
                        <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
                    </div>

                    <!-- Contact List -->
                    <ul class="mobile-menu__contact-list">
                        <li><span class="icon fa fa-envelope"></span><a
                                href="mailto:solapaemail@gmail.com">solapaemail@gmail.com</a></li>
                        <li><span class="icon fa fa-phone"></span><a href="tel:+88-01682648101">+88 01682648101</a>
                        </li>
                    </ul>

                    <!-- Social Box -->
                    <ul class="mobile-menu__social">
                        <li><a href="https://www.instagram.com/" class="fa fa-instagram"></a></li>
                        <li><a href="https://www.facebook.com/" class="fa fa-facebook-f"></a></li>
                        <li><a href="https://www.twitter.com/" class="fa fa-twitter"></a></li>
                        <li><a href="https://www.pinterest.com/" class="fa fa-pinterest-p"></a></li>
                    </ul>

                </nav>

            </div>
            <!-- End Mobile Menu -->

        </header>
        <!-- End Main Header -->

        @yield('content')

        <!-- Site Footer Start -->
        <footer class="site-footer">
            <div class="site-footer__shape-one"
                style="background-image: url(assets/images/shapes/footer-shape-1.png)">
            </div>
            <div class="site-footer__shape-two"
                style="background-image: url(assets/images/shapes/footer-shape-1.png)">
            </div>
            <div class="container">
                <!-- Site Footer Middle -->
                <div class="site-footer__middle">
                    <div class="row clearfix">

                        <!-- Footer Widget Column -->
                        <div class="footer-widget__column col-lg-4 col-md-6 col-sm-12">
                            <h3 class="footer-widget__title">About</h3>
                            <div class="site-footer__about-text">@lang('app.footer_about_text')</div>
                            <ul class="footer-contact__list">
                                <li><span class="icon icon-location"></span>@if (isset($site_settings->address))
									{{ $site_settings->address }}
								@endif</li>
                                <li><span class="icon icon-email"></span>@if (isset($site_settings->email))
									{{ $site_settings->email }}
								@endif</li>
                            </ul>
                        </div>

                        <div class="footer-widget__column col-lg-2 col-md-6 col-sm-12">
                            <h3 class="footer-widget__title">Explore Link</h3>
                            <ul class="footer-widget__links-list">
                                <li><a href="{{ route('services') }}">{{ trans('app.services') }}</a></li>
                                <li><a href="{{ route('homeOwner') }}">{{ trans('app.homeowner') }}</a></li>
                                <li><a href="{{ route('homeOwner') }}">Business</a></li>
                                <li><a href="{{ route('maintenance') }}">Maintenance</a></li>
                                <li><a href="{{ route('requestQuote') }}">{{ trans('app.request_quote') }}</a></li>
                            </ul>
                        </div>

                        <div class="footer-widget__column col-lg-2 col-md-6 col-sm-12">
                            <h3 class="footer-widget__title">Support</h3>
                            <ul class="footer-widget__links-list">
                                <li><a href="{{ route('homepage') }}#faq" >Help & FAQ</a></li>
                                <li><a href="{{ route('contact') }}">Contact Us</a></li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Site Footer Bottom -->
            <div class="site-footer__bottom">
                <div class="container">
                    <div class="row clearfix">
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <!-- Logo Box -->
                            <div class="site-footer__bottom-logo">
                                <a href="{{ route('homepage') }}"><img
                                    src="{{ asset('assets/images/logo1.jpg') }}"
                                        alt="" title=""></a>
                            </div>
                        </div>
                        <!-- Column -->
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <div class="site-footer__copyright">&copy; 2022 Solapa. All Rights Reserved</div>
                        </div>
                        <!-- Column -->
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <ul class="site-footer__social-nav">
								@if (isset($site_settings->facebook))
									<li><a href="{{ $site_settings->facebook }}">fb</a></li>
								@endif
								@if (isset($site_settings->twitter))
									<li><a href="{{ $site_settings->twitter }}">tw</a></li>
								@endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </footer>

    </div>
    <!-- End PageWrapper -->

    <!-- Scroll To Top -->
    <div class="scroll-to-top scroll-to-target" data-target="html"><span class="fa fa-arrow-up"></span></div>


    <script src="{{ asset('assets/vendors/jquery/jquery-v3.6.0.js') }}"></script>
    <script src="{{ asset('assets/vendors/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/bootstrap/js/bootstrap.min.js') }}"></script>

    <!-- <script src="{{ asset('assets/vendors/fancybox/js/jquery.fancybox.js') }}"></script> -->
    <script src="{{ asset('assets/vendors/jquery-appear/appear.js') }}"></script>
    <script src="{{ asset('assets/vendors/animate/js/parallax.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/animate/js/tilt.jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/animate/js/jquery.paroller.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/owl-slider/js/owl.js') }}"></script>
    <script src="{{ asset('assets/vendors/wow/js/wow.js') }}"></script>
    <script src="{{ asset('assets/vendors/validate/js/validate.js') }}"></script>
    <script src="{{ asset('assets/vendors/nav-tools/js/nav-tool.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery-ui/js/jquery-ui.js') }}"></script>
    <script src="{{ asset('assets/vendors/swiper/swiper.min.js') }}"></script>

    <!-- Template Js -->
    <script src="{{ asset('assets/js/solapa-script.js') }}"></script>
    <script src="{!! asset('backend/vendor/popup.js') !!}" type="text/javascript"></script>
    @stack('script')


</body>
<div id="modal-container"></div>

</html>
