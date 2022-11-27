<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FIFA, Buy RuneScape Gold at the best prices</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{!! asset('css/bootstrap.css') !!}">
    <link rel="stylesheet" href="{!! asset('css/style.css') !!}">
    <link rel="stylesheet" href="{!! asset('css/custom.css') !!}">
    <script src="https://js.stripe.com/v3/"></script>
    @if(isset($RSO_rate) && isset($RS_rate))
        <script>
            let $RSO_rate = <?= $RSO_rate;?>; 
            let $RS_rate = <?= $RS_rate;?> ;
        </script>
    @endif
    <script>
        var isAuth = {{ Auth::check() ? 1 : 0 }};
    </script>
</head>
<body>
<div class="header">
    <nav class="navbar navbar-light">
        <div class="container">
            <a class="navbar-brand logo__link" href="{{ route('homepage') }}">
                <img src="{!! asset('img/logo.png') !!}" alt="" width="95" height="95" class="d-inline-block align-top logo__img">
                <span class="site__name color-green font-weight-bolder">PEPE</span><span class="color-gold font-weight-bolder">GOLD</span>
            </a>
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link @if(isset($menu) && $menu == 'home') active @endif" href="{{ route('homepage') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(isset($menu) && $menu == 'rso') active @endif" href="{{ route('runeScapeOld') }}">OSRS Gold</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(isset($menu) && $menu == 'rs') active @endif" href="{{ route('runeScape') }}">RS3 Gold</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(isset($menu) && $menu == 'contact') active @endif" href="{{ route('contact') }}">Contact Us</a>
                </li>
            </ul>
        </div>
    </nav>
</div>
<div class="header__sub">
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="ml-0 discord__link" target="_blank" href="{{$discord_link}}"><img src="{!! asset('img/svg/Discord.svg') !!}" width="18" height="20" alt=""> Join us
                on
                Discord</a>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ml-auto">
                    @if(!Auth::check())
                        <a class="nav-link" data-toggle="modal" data-target="#authModal" href="#">Login or Register</a>
                    @else
                        <a class="nav-link"  data-toggle="modal" data-target="#profileModal" href="#">Profile</a>
                        <a class="nav-link"  href="{{route('orders')}}">Orders</a>
                        <a class="nav-link"  href="{{route('logout')}}">Logout</a>
                    @endif
                    <div class="dropdown">
                        <button class="btn btn-dropdown dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="img/flag/USD.png" width="25" height="17" alt=""> USD
                        <?php /* <!-- @switch(currency()->getUserCurrency())
                            @case('USD')
                                @break

                            @case('CHF')
                                <img src="img/flag/CHF.png" width="25" height="17" alt=""> CHF
                                @break
                            @case('CAD')
                                <img src="img/flag/CAD.png" width="25" height="17" alt=""> CAD
                                @break
                            @case('GBP')
                                <img src="img/flag/GBP.png" width="25" height="17" alt=""> GBP
                                @break
                            @case('SEK')
                                <img src="img/flag/SEK.png" width="25" height="17" alt=""> SEK
                                @break
                            @case('NOK')
                                <img src="img/flag/NOK.png" width="25" height="17" alt=""> NOK
                                @break
                            @case('DKK')
                                <img src="img/flag/DKK.png" width="25" height="17" alt=""> DKK
                                @break                  
                            @default
                                <img src="img/flag/USD.png" width="25" height="17" alt=""> USD
                        @endswitch --> */ ?>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{ url('/?currency=usd') }}">
                                <img src="img/flag/USD.png" width="25" height="17" alt=""> USD
                            </a>
                            <!-- <a class="dropdown-item" href="{{ url('/?currency=eur') }}">
                                <img src="img/flag/EUR.png" width="25" height="17" alt=""> EUR
                            </a>
                            <a class="dropdown-item" href="{{ url('/?currency=cad') }}">
                                <img src="img/flag/CAD.png" width="25" height="17" alt=""> CAD
                            </a>
                            <a class="dropdown-item" href="{{ url('/?currency=gbp') }}">
                                <img src="img/flag/GBP.png" width="25" height="17" alt=""> GBP
                            </a>
                            <a class="dropdown-item" href="{{ url('/?currency=sek') }}">
                                <img src="img/flag/SEK.png" width="25" height="17" alt=""> SEK
                            </a>
                            <a class="dropdown-item" href="{{ url('/?currency=nok') }}">
                                <img src="img/flag/NOK.png" width="25" height="17" alt=""> NOK
                            </a>
                            <a class="dropdown-item" href="{{ url('/?currency=dkk') }}">
                                <img src="img/flag/DKK.png" width="25" height="17" alt=""> DKK
                            </a>
                            <a class="dropdown-item" href="{{ url('/?currency=chf') }}">
                                <img src="img/flag/CHF.png" width="25" height="17" alt=""> CHF
                            </a> -->
                        </div>
                    </div>
                    <a class="nav-link" href="{{ route('checkout') }}"><img src="img/svg/Cart.svg" width="22" height="20" alt=""> @if($card)1 @else 0 @endif items</a>
                    <a class="nav-link checkout" href="{{ route('checkout') }}">Checkout</a>
                </div>
            </div>
        </div>
    </nav>
</div>
@yield('content')

@if(!Auth::check())
<!-- Modal -->
<div class="modal fade" id="authModal" tabindex="-1" role="dialog" aria-labelledby="authModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content border-0">
        <div class="authModal__step bg-gray">
            <div class="authModal__step_title">Sign Up</div>
                <div class="authModal__step_body">
                    <div class="auth_content_signup">
                        <form action="{{ route('signup') }}" method="post" class="row">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" placeholder="First Name" name="first_name" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" placeholder="Last Name" name="last_name" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" placeholder="Email" name="email" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" placeholder="Password" name="password"class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" placeholder="Confirm Password" name="password_confirmation"class="form-control">
                                    </div>
                                    <div class="error_message"></div>
                                    <div class="form-group auth-btn">
                                        <button type="button" onclick="Auth.signUp()" class="btn-game btn-yellow btn-block">Sing up</button>
                                    </div>
                                    <label>Already have an account? <a  onclick="Auth.changeMode('signin')" class="text-link" href="#">Log in</a></label>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="auth_content_signin">
                        <form action="{{ route('signin') }}" method="post" class="row">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" placeholder="Email" name="email" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" placeholder="Password" name="password"class="form-control">
                                    </div>
                                    <div class="error_message"></div>
                                    <div class="form-group auth-btn">
                                        <button type="button" onclick="Auth.signIn()" class="btn-game btn-yellow btn-block">Sing up</button>
                                    </div>
                                    <label>Already have an account? <a onclick="Auth.changeMode('signup')" class="text-link" href="#">Sign up</a></label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div> 
        </div>  
    </div>
  </div>
</div>
@else
<div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content border-0">
        <div class="authModal__step bg-gray">
            <div class="profileModal__step_title">Profile</div>
                <div class="profileModal__step_body">
                    <div class="auth_content_edit_profile">
                        <form action="{{ route('signup') }}" method="post" class="row">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" placeholder="First Name" value="{{auth()->user()->first_name}}" name="first_name" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" placeholder="Last Name" name="last_name" value="{{auth()->user()->last_name}}" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" placeholder="Email" name="email" value="{{auth()->user()->email}}" class="form-control">
                                    </div>
                                    <div class="error_message"></div>
                                    <div class="form-group auth-btn">
                                        <button type="button" onclick="Auth.saveProfile()" class="btn-game btn-yellow btn-block">Save</button>
                                    </div>
                                    <label><a  onclick="Auth.changeMode('changePassword')" class="text-link" href="#">Change password</a></label>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="auth_content_change_password">
                        <form action="{{ route('signin') }}" method="post" class="row">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="password" placeholder="Current Password" name="old_password" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" placeholder="New Password" name="password" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" placeholder="Confirm New Password" name="password_confirmation"class="form-control">
                                    </div>
                                    <div class="error_message"></div>
                                    <div class="form-group auth-btn">
                                        <button type="button" onclick="Auth.changePassword()" class="btn-game btn-yellow btn-block">Change password</button>
                                    </div>
                                    <label><a  onclick="Auth.changeMode('editProfile')" class="text-link" href="#">Edit profile</a></label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div> 
        </div>  
    </div>
  </div>
</div>
@endif
<div class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-6">
                <div class="row">
                    <div class="col-md-2">
                        <img src="img/logo.png" width="70" height="70" alt="">
                    </div>
                    <div class="col-md-10">
                        <div class="footer__title">About Us</div>
                        <div class="footer__text">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt
                            ut labore
                            et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
                            nisi ut
                            aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit
                            esse
                            cillum dolore eu fugiat.
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-6">
                <div class="row">
                    <div class="col-md-4">
                        <div class="footer__title">Navigation</div>
                        <ul class="footer__menu">
                            <li><a href="{{ route('homepage') }}">Home</a></li>
                            <li><a href="{{ route('runeScapeOld') }}">OSRS Gold</a></li>
                            <li><a href="{{ route('runeScape') }}">RS3 Gold</a></li>
                            <li><a href="{{ route('contact') }}">Contact Us</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <div class="footer__title">Our Reviews</div>
                        <ul class="footer__menu">
                            <li><a href="#">Google</a></li>
                            <li><a href="#">Trustpilot</a></li>
                            <li><a href="#">Sythe</a></li>
                            <li><a href="#">OSBot</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <div class="footer__title">Follow Us</div>
                        <ul class="footer__menu">
                            <li><a href="#">YouTube</a></li>
                            <li><a href="#">Twitter</a></li>
                            <li><a href="#">Facebook</a></li>
                            <li><a href="#">Discord</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="copyright">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                © 2021 Fifa Store. All rights reserved.
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/script.js"></script>
@stack('script')
</body>
</html>