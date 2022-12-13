@extends('app.layouts.app')
@section('content')
<div class="container content-faq text-center  margin_bottom_150 margin_top_100 container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="title-faq title-font">Some problem with payment</h1>
            <p style="font-size: 18px;">
            Pls connect with administrator manual,<br> Your payment is done but with problems, pls DO NOT re-pay it, your order SKU: <a href="{{ route('order', ['hash'=>$order->hash])}}">{{$order->sku}}</a>
            </p>
        </div>
    </div>
</div>
@endsection