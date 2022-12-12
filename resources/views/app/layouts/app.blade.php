<!DOCTYPE html>
<html>
<head>
    <title>WTD1</title>
	<meta name="format-detection" content="telephone=no">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="icon" href="{!! asset('asset/img/favicon.png') !!}" type="image/x-icon"/>
    <!-- jquery ui -->
	<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
    <!--  -->
	<link rel="stylesheet" type="text/css" href="{!! asset('asset/css/bootstrap.min.css') !!}">
	<link rel="stylesheet" type="text/css" href="{!! asset('') !!}asset/css/bootstrap-theme.min.css">
	<link rel="stylesheet" type="text/css" href="{!! asset('asset/css/themify-icons.css') !!}">
	<link rel="stylesheet" type="text/css" href="{!! asset('asset/css/zoa-font.css') !!}">
	<link rel="stylesheet" type="text/css" href="{!! asset('asset/css/font-awesome.min.css') !!}">
	<link rel="stylesheet" type="text/css" href="{!! asset('asset/css/font-family.css') !!}">
	<link rel="stylesheet" type="text/css" href="{!! asset('asset/css/slick.css') !!}">
	<link rel="stylesheet" type="text/css" href="{!! asset('asset/css/slick-theme.css') !!}">
	<link rel="stylesheet" type="text/css" href="{!! asset('asset/css/style-main.css') !!}">
	<link rel="stylesheet" type="text/css" href="{!! asset('asset/css/responsive.css') !!}">
	<link rel="stylesheet" type="text/css" href="{!! asset('asset/css/jquery.fancybox.min.css') !!}">
	<link rel="stylesheet" type="text/css" href="{!! asset('asset/css/custom.css') !!}">
</head>
<body>
	<!-- push menu-->
    <div class="pushmenu menu-home5">
        <div class="menu-push">
            <span class="close-left js-close"><i class="ti-close"></i></span>
            <div class="clearfix"></div>
            <ul class="nav-home5 js-menubar clear-space menu-font">
                <li class="level1 {{$menu == 'home' ? 'active' : ''}}">
                    <a href="{{route('homepage')}}"  class="uppercase">Home</a>
                </li>
                <li class="level1 {{$menu == 'shop' ? 'active' : ''}}">
                    <a href="{{route('shop')}}" class="uppercase">Shop</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- end push menu-->
    <header @if($menu == 'home')class="full-width fixed header-home2"@endif>
        <div class="container space_top_bot_55 delay03" id="menu-header">
            <div class="row flex">
                <div class="col-lg-1 col-md-2 col-sm-6 col-xs-5">
                    <a href="{{route('homepage')}}"><img src="{{ asset('asset/img/logo.png') }}" alt=""></a>
                </div>
                <div class="col-lg-8 col-md-7 hidden-sm hidden-xs">
                    <ul class="nav navbar-nav menu-font menu-main menu-home2">
                        <li class="relative">
                            <a href="{{route('homepage')}}" class="link-menu delay03 uppercase">HOME</a>
                            <figure class="line {{$menu == 'home' ? 'active_line' : ''}} absolute delay03"></figure>
                        </li>
                        <li class="relative">
                            <a href="{{route('shop')}}" class="link-menu delay03 uppercase">SHOP</a>
                            <figure class="line {{$menu == 'shop' ? 'active_line' : ''}} absolute delay03"></figure>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-7 text-right icon-main">
                    <a href="#" class="link-menu delay03 container_20 relative inline-block text-center" id="btn-cart">
                        <i class="ti-bag"></i>
                        <figure class="absolute label-cart number-font">{{$cartCount}}</figure>
                    </a>
                    <a href="#" class="link-menu delay03 inline-block hidden-md hidden-lg space_left_10 btn-push-menu">
                        <svg width="26" height="16" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 66 41" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve">
                        <g>
                            <line class="st0" x1="1.5" y1="1.5" x2="64.5" y2="1.5"></line>
                            <line class="st0" x1="1.5" y1="20.5" x2="64.5" y2="20.5"></line>
                            <line class="st0" x1="1.5" y1="39.5" x2="64.5" y2="39.5"></line>
                        </g>
                    </svg>
                    </a>
                </div>
            </div>
        </div>
        @stack('css')
    </header>
<main>
    @yield('content')
</main>
<footer>
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 space_bot_40 logo-footer-home2">

				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-left logo-footer clear-space-left">
					<a href="#" class="inline-block"><img src="{{ asset('asset/img/logo.png') }}" class="img-responsive" alt=""></a>
				</div>
                @if(isset($site_settings->email))
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right newsletter clear-space-right">
					<a href="mailto:{{$site_settings->email}}" class="des-font delay03 inline-block"><span>{{$site_settings->email}}</span> <i class="ti-email delay03"></i></a>
				</div>
				@endif
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 space_bot_40 copy-footer-home2">

				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-left copy clear-space">
					<p class="des-font copy-text space_top_40">{{trans('app.copyright')}}</p>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right social-footer clear-space">
					<div class="social-home2 space_top_40">
                        @if(isset($site_settings->facebook))
                            <a href="{{$site_settings->facebook}}" target="_blank" class="delay03 inline-block space_left_40"><i class="ti-facebook delay03"></i></a>
                        @endif
                        @if(isset($site_settings->instagram))
                            <a href="{{$site_settings->instagram}}" target="_blank" class="delay03 inline-block space_left_40"><i class="ti-instagram delay03"></i></a>
                        @endif
					</div>
				</div>
				
			</div>
		</div>
	</div>
	
</footer>
<div class="overlay"></div>
	<div class="gotop text-center fade"><i class="ti-angle-up"></i></div>
	<div class="form-search delay03 text-center">
						
                        	<i class="ti-close" id="close-search"></i>
                            <h3 class="text-center title-font">what are<br>your looking for ?</h3>
                            <form method="get" action="/search" role="search">
                              <input type="text" class="form-control control-search des-font" value="" autocomplete="off" placeholder="Enter Search ..." aria-label="SEARCH" name="q">
                              <button class="button_search title-font" type="submit">search</button>
                            </form>
                        
	</div>
	<!-- <div class="form-cart delay03">
		<i class="ti-close" id="close-cart"></i>
		<h3 class="title-font capital">my cart</h3>
		<div class="empty-cart">
			<p class="des-font">No products in the cart.</p>
			<a href="#" class="capital des-font">start shopping</a>
		</div>
		
	</div> -->
</body>
<script src="{{ asset('asset/js/jquery-3.3.1.min.js') }}" defer=""></script>
<script src="{{ asset('asset/js/bootstrap.min.js') }}" defer=""></script>
<script src="{{ asset('asset/js/slick.min.js') }}" defer=""></script>
<script src="{{ asset('asset/js/function-main.js') }}" defer=""></script>
<script src="{{ asset('asset/js/jquery.fancybox.min.js') }}" defer=""></script>
<script src="{{ asset('asset/js/function-select-custom.js') }}" defer=""></script>
<script src="{{ asset('asset/js/function-input-number.js') }}" defer=""></script>
<script src="{{ asset('asset/js/custom.js') }}" defer=""></script>
@stack('script')
</body>
</html>