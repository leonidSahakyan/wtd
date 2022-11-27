@extends('app.layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 text-center">
            <h2 class="title font-weight-bolder mb-1">Checkout</h2>
        </div>
    </div>
    <form action="#" method="post" class="row checkout__form">
        @csrf
        <div class="col-lg-4">
            <div class="checkout__step mb-0">
                <div class="checkout__step_title">1. GOLD DELIVERY</div>
                <div class="checkout__step_body bg-gray">
                    <div class="form-group">
                        <label>Please enter your ingame username (RSN)*</label>
                        <input type="text" name="rsn" value="@if($card && isset($card['rsn'])){{$card['rsn']}}@endif"  class="form-control">
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="customCheck1">
                        <label class="custom-control-label" for="customCheck1">I confirm that my in-game name is correct.</label>
                    </div>
                </div>
            </div>
            <div class="notify notify-warning">
                We will NEVER message you ingame for any reason.
                We ONLY speak through our livechat for gold deliveries.
                Please ignore any direct PMs ingame as these are likely to be an imposter & a scam.
            </div>
            @if(!Auth::check())
            <div class="checkout__step">
                <div class="checkout__step_title">2. USER INFORMATION</div>
                <div class="checkout__step_body bg-gray">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>First Name*</label>
                                <input type="text" name="first_name" value="@if($card && isset($card['first_name'])){{$card['first_name']}}@endif" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Last Name*</label>
                                <input type="text" name="last_name" value="@if($card && isset($card['last_name'])){{$card['last_name']}}@endif" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <label>Email Address*</label>
                        <input type="email" name="email" value="@if($card && isset($card['email'])){{$card['email']}}@endif" class="form-control">
                    </div>
                </div>
            </div>
            @endif
        </div>
        <div class="col-lg-4">
            <div class="checkout__step">
                <div class="checkout__step_title">{{Auth::check() ? '2.' : '3.'}} PAYMENT METHOD</div>
                <div class="checkout__step_body bg-gray">
                    <label>Please select payment method</label>
                    <div class="form-group">
                        <input type="radio" name="payment" @if($card && isset($card['payment'])) @if($card['payment'] == 'g2a') checked @endif @else checked @endif id="g2a" value="g2a" class="payment__radio">
                        <label for="g2a" class="payment__wrap">
                            <span class="payment__wrap_title">
                                <img src="img/payment/G2A-Pay.svg" width="174" alt="">
                            </span>
                            <span class="payment__wrap_body">
                                <img src="img/payment/Paysafecard.svg" class="payment__wrap_img" alt="">
                                <img src="img/payment/Discover.svg" class="payment__wrap_img" alt="">
                                <img src="img/payment/Bitcoin.svg" class="payment__wrap_img" alt="">
                                <img src="img/payment/Mastercard-cc.svg" class="payment__wrap_img" alt="">
                                <img src="img/payment/Skrill.svg" class="payment__wrap_img" alt="">
                                <img src="img/payment/iDeal.svg" class="payment__wrap_img" alt="">
                                <img src="img/payment/Neteller.svg" class="payment__wrap_img" alt="">
                                <img src="img/payment/Visa.svg" class="payment__wrap_img" alt="">
                                <img src="img/payment/American-Express.svg" class="payment__wrap_img" alt="">
                            </span>
                        </label>
                    </div>
                    <div class="form-group mb-0">
                        <input type="radio" name="payment" @if($card && isset($card['payment'])) @if($card['payment'] == 'coinbase') checked @endif @endif id="coinbase" value="coinbase" class="payment__radio">
                        <label for="coinbase" class="payment__wrap mb-0">
                            <span class="payment__wrap_title">
                                <img src="img/payment/Coinbase.svg" width="164" alt="">
                            </span>
                            <span class="payment__wrap_body">
                                <img src="img/payment/Bitcoin.svg" class="payment__wrap_img" alt="">
                                <img src="img/payment/Ethereum.svg" class="payment__wrap_img" alt="">
                            </span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="checkout__step">
                <div class="checkout__step_title">YOUR CART</div>
                <div class="checkout__step_body bg-blue">
                    <div class="form-group checkout__group">
                        <div class="checkout__group_title">Cart item
                            <a href="{{ route('clearCard') }}" class="color-red checkout__group_link">Clear Cart</a>
                            <span class="checkout__group_price">Price</span>
                        </div>
                        @if($card)
                            <div class="checkout__group_item" >
                                <?php /* <a href="#" onclick="return Card.remove('{{$item["game"]}}');" class="checkout__group_remove"><img src="img/svg/remove.svg" alt=""></a> --> */ ?>
                                <span class="color-green">{{ $card['game'] == "rune_scape_old" ? "RuneScape Old OSRS Gold" : "RuneScape OSRS Gold" }} - {{$card['amount']}}M</span>
                                <span class="checkout__group_price">{{$card['price']}} {{$card['currency_code']}}</span>
                            </div>
                        @endif
                    </div>
                    <div class="form-group checkout__group">
                        <div class="checkout__group_title">Have a Coupon code?</div>
                        <div class="row">
                            <div class="col-md-9">
                                <input type="text" id="coupon" class="form-control bg-blue-2" placeholder="Discord code here">
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-block btn-light">Apply</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group checkout__group">
                        <div class="checkout__group_title">Order Summary</div>
                        <div class="checkout__group_item">
                            <span class="text-white">Subtotal:</span>
                            <span class="checkout__group_price">@if($card){{$card['price']}} {{$card['currency_code']}}@else 0 @endif</span>
                        </div>
                        <div class="checkout__group_item">
                            <span class="text-white">Discount: (10OFF)</span>
                            <span class="checkout__group_price">0</span>
                        </div>
                        <div class="checkout__group_item">
                            <span class="text-white font-weight-bold">Total:</span>
                            <span class="checkout__group_price">@if($card){{$card['price']}} {{$card['currency_code']}}@else 0 @endif</span>
                        </div>
                    </div>
                    <div class="form-group custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input dark-input"  id="agree">
                        <label class="custom-control-label text-white" for="agree">I ACCEPT TERMS OF SERVICE & REFUND
                            POLICY.</label>
                    </div>
                    <button onclick="order(); return false;" type="button" id="submitOrder" class="btn-game btn-green btn-block">complete purchase</button>
                </div>
            </div>
        </div>
    </form>

</div>
<div class="payment">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="payment__method">
                    <img src="img/payment/American-Express.svg" alt="" class="payment__logo">
                    <img src="img/payment/Paysafecard.svg" alt="" class="payment__logo">
                    <img src="img/payment/Mastercard-cc.svg" alt="" class="payment__logo">
                    <img src="img/payment/G2A-Pay.svg" alt="" class="payment__logo">
                    <img src="img/payment/Neteller.svg" alt="" class="payment__logo">
                    <img src="img/payment/Skrill.svg" alt="" class="payment__logo">
                    <img src="img/payment/PayPal.svg" alt="" class="payment__logo">
                    <img src="img/payment/Discover.svg" alt="" class="payment__logo">
                    <img src="img/payment/Visa.svg" alt="" class="payment__logo">
                    <img src="img/payment/Bitcoin.svg" alt="" class="payment__logo">
                    <img src="img/payment/Ethereum.svg" alt="" class="payment__logo">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="games">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-6 text-white">
                <h2 class="title font-weight-bold">Buy & Sell RuneScape Gold</h2>
                <p class="title__sub">Purchasing RuneScape Gold allows you to skip straight to the fun part of the
                    game.</p>
            </div>
            <div class="col-md-12 col-lg-6">
                <div class="row">
                    <div class="col-md-6 col-xl-5">
                        <div class="games__item">
                            <div class="games__item_wrap">
                                <img src="img/OSRS-Logo.png" class="games__item_logo" alt="">
                            </div>
                            <a href="#" class="btn-game btn-red">BUY OSRS GOLD</a>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-5">
                        <div class="games__item">
                            <div class="games__item_wrap">
                                <img src="img/RS3-Logo.png" class="games__item_logo" alt="">
                            </div>
                            <a href="#" class="btn-game btn-yellow">BUY rs3 GOLD</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection