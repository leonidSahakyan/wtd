<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>WTD</title>
        <link href="{!! asset('backend/css/styles.css') !!}" media="all" rel="stylesheet" type="text/css" />
        <link href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" rel="stylesheet" crossorigin="anonymous" />
        <link rel="icon" type="image/x-icon" href="{!! asset('backend/assets/img/favicon.png') !!}" />
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
        <link href="{!! asset('backend/vendor/bootstrap-toastr/toastr.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
        <link href="{!! asset('backend/css/custom.css') !!}" media="all" rel="stylesheet" type="text/css" />
        @stack('css')
    </head>
    <body class="nav-fixed {{ Auth::guard('admin')->user()->role != 'superadmin' ? 'sidenav-toggled' : '' }}">
        <nav class="topnav navbar navbar-expand shadow justify-content-between justify-content-sm-start navbar-light bg-white" id="sidenavAccordion">
            <!-- Navbar Brand-->
            <!-- * * Tip * * You can use text or an image for your navbar brand.-->
            <!-- * * * * * * When using an image, we recommend the SVG format.-->
            <!-- * * * * * * Dimensions: Maximum height: 32px, maximum width: 240px-->
            <a class="navbar-brand" href="{{ Auth::guard('admin')->user()->role == 'superadmin' ? route('dashboard') : route('adminOrder') }}">
                WTD
                <?php /* <!-- <img src="{!! asset('backend/img/logo.png') !!}" style="height: 25px;" /> --> */ ?>
            </a>
            <!-- Sidenav Toggle Button-->
            @if(Auth::guard('admin')->user()->role == 'superadmin')
            <button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 mr-lg-2" id="sidebarToggle"><i data-feather="menu"></i></button>
            @endif
            <!-- Navbar Items-->
            <ul class="navbar-nav align-items-center ml-auto">
                <!-- User Dropdown-->
                <li class="nav-item dropdown no-caret mr-3 mr-lg-0 dropdown-user">
                    <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage" href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="img-fluid" src="/backend/assets/img/illustrations/profiles/profile-1.png" /></a>
                    <div class="dropdown-menu dropdown-menu-right border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownUserImage">
                        <h6 class="dropdown-header d-flex align-items-center">
                            <img class="dropdown-user-img" src="/backend/assets/img/illustrations/profiles/profile-1.png" />
                            <div class="dropdown-user-details">
                                <div class="dropdown-user-details-name admin_name_lbl">{{auth()->guard('admin')->user()->name}}</div>
                            </div>
                        </h6>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('adminProfile') }}">
                            <div class="dropdown-item-icon"><i data-feather="settings"></i></div>
                            Account
                        </a>
                        <a class="dropdown-item" href="{{ route('adminLogout') }}">
                            <div class="dropdown-item-icon"><i data-feather="log-out"></i></div>
                            Logout
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            @if(Auth::guard('admin')->user()->role == 'superadmin')
            <div id="layoutSidenav_nav">
                <nav class="sidenav shadow-right sidenav-light">
                    <div class="sidenav-menu">
                        <div class="nav accordion" id="accordionSidenav">

                        <?php /* <!-- Sidenav Menu Heading (Account)
                            <!-- * * Note: * * Visible only on and above the sm breakpoint-->
                            <div class="sidenav-menu-heading d-sm-none">Account</div>
                            <!-- Sidenav Link (Alerts)-->
                            <!-- * * Note: * * Visible only on and above the sm breakpoint-->
                            <a class="nav-link d-sm-none" href="#!">
                                <div class="nav-link-icon"><i data-feather="bell"></i></div>
                                Alerts
                                <span class="badge badge-warning-soft text-warning ml-auto">4 New!</span>
                            </a>
                            <!-- Sidenav Link (Messages)-->
                            <!-- * * Note: * * Visible only on and above the sm breakpoint-->
                            <a class="nav-link d-sm-none" href="#!">
                                <div class="nav-link-icon"><i data-feather="mail"></i></div>
                                Messages
                                <span class="badge badge-success-soft text-success ml-auto">2 New!</span>
                            </a> -->
                            */?>
                            <!-- Sidenav Menu Heading (Core)-->
                            <div class="sidenav-menu-heading">Main</div>
                            <!-- Sidenav Accordion (Dashboard)-->
                            <a class="nav-link @if(isset($menu) && $menu == 'dashboard') active @endif" href="{{ route('dashboard') }}">
                                <div class="nav-link-icon"><i data-feather="activity"></i></div>
                                Dashboard
                            </a>
                            <a class="nav-link @if(isset($menu) && $menu == 'orders') active @endif" href="{{ route('adminOrder') }}">
                                <div class="nav-link-icon"><i data-feather="dollar-sign"></i></div>
                                Orders
                            </a>
                            <a class="nav-link @if(isset($menu) && $menu == 'collections') active @endif" href="{{ route('adminCollections') }}">
                                <div class="nav-link-icon"><i data-feather="dollar-sign"></i></div>
                                Collections
                            </a>
                            <a class="nav-link @if(isset($menu) && $menu == 'products') active @endif" href="{{ route('products') }}">
                                <div class="nav-link-icon"><i data-feather="dollar-sign"></i></div>
                                Prodcuts
                            </a>
                            <!-- <a class="nav-link @if(isset($menu) && $menu == 'users') active @endif" href="{{ route('ausers') }}">
                               <div class="nav-link-icon"><i data-feather="users"></i></div>
                               Users
                            </a>
                            <a class="nav-link @if(isset($menu) && $menu == 'masters') active @endif" href="{{ route('adminMasters') }}">
                               <div class="nav-link-icon"><i data-feather="users"></i></div>
                               Masters
                            </a> -->

                            <?php /*
                            <a class="nav-link @if(isset($menu) && $menu == 'categories') active @endif" href="{{ route('adminCategories') }}">
                                <div class="nav-link-icon"><i data-feather="folder"></i></div>
                                Categories
                            </a> */ ?>
                            <?php $contectMenuItems = array('services','dictionary','settings','slider','faq','meta');?>
                            <a class="nav-link @if(isset($menu) && !in_array($menu,$contectMenuItems)) collapsed @endif" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseUsers" aria-expanded="true" aria-controls="collapseUsers">
                                <div class="nav-link-icon"><i data-feather="users"></i></div>
                                Content
                                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse @if(isset($menu) && in_array($menu,$contectMenuItems)) active show @endif" id="collapseUsers" data-parent="#accordionSidenav">
                                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                                    <a class="nav-link @if(isset($menu) && ($menu == 'services')) active @endif" href="{{ route('adminServices') }}">
                                        <div class="nav-link-icon"><i data-feather="tool"></i></div>
                                        Services
                                    </a>
                                    <a class="nav-link @if(isset($menu) && ($menu =='meta')) active @endif" href="{{ route('adminMeta') }}">
                                        <div class="nav-link-icon"><i data-feather="tool"></i></div>
                                        Meta
                                    </a>
                                    <a class="nav-link @if(isset($menu) && ($menu == 'dictionary')) active @endif" href="{{ route('adminDictionary') }}">
                                        <div class="nav-link-icon"><i data-feather="tool"></i></div>
                                        Dictionary
                                    </a>
                                    <a class="nav-link @if(isset($menu) && ($menu =='settings')) active @endif" href="{{ route('adminSettings') }}">
                                        <div class="nav-link-icon"><i data-feather="tool"></i></div>
                                        Settings
                                    </a>
                                    <a class="nav-link @if(isset($menu) && ($menu =='slider')) active @endif" href="{{ route('adminSlider') }}">
                                        <div class="nav-link-icon"><i data-feather="tool"></i></div>
                                        Slider
                                    </a>
                                    <a class="nav-link @if(isset($menu) && ($menu =='faq')) active @endif" href="{{ route('adminFaq') }}">
                                        <div class="nav-link-icon"><i data-feather="tool"></i></div>
                                        F.A.Q.
                                    </a>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <!-- Sidenav Footer-->
                    <div class="sidenav-footer">
                        <div class="sidenav-footer-content">
                            <div class="sidenav-footer-subtitle">Logged in as:</div>
                            <div class="sidenav-footer-title admin_name_lbl">{{auth()->guard('admin')->user()->name}}</div>
                        </div>
                    </div>
                </nav>
            </div>
            @endif
            <div id="layoutSidenav_content">
                @yield('content')
                <footer class="footer mt-auto footer-light">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6 small">Copyright &copy; WTD 2022</div>
                            <!-- <div class="col-md-6 text-md-right small">
                                <a href="#!">Privacy Policy</a>
                                &middot;
                                <a href="#!">Terms &amp; Conditions</a>
                            </div> -->
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="{!! asset('backend/vendor/bootstrap-toastr/toastr.min.js') !!}" type="text/javascript"></script>
        <script src="{!! asset('backend/vendor/bootbox/bootbox.min.js') !!}" type="text/javascript"></script>
        <script src="{!! asset('backend/vendor/popup.js') !!}" type="text/javascript"></script>
        <script src="{!! asset('backend/js/scripts.js') !!}" type="text/javascript"></script>
        <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js" crossorigin="anonymous"></script>
        @stack('script')
    </body>
    <div id="modal-container"></div>
</html>
