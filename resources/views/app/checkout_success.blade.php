@extends('app.layouts.app')
@section('content')
<div class="container content-faq text-center  margin_bottom_150 margin_top_100 container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="title-faq title-font">Payment success</h1>
            <p style="font-size: 18px;">
                Your order successfully payed, order link
                <a href="{{ route('order', ['hash'=>$order->hash])}}">{{$order->sku}}</a>,</br>
                you will give email about order datails.
            </p>
        </div>
    </div>
</div>
@endsection