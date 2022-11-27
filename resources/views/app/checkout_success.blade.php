@extends('app.layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if($order)
                <h2 class="title text-center font-weight-bolder">Payment success</h2>
                <h3 style="text-align:center; min-height: 310px;">
                    Your order successfully submitted, order link
                    <a href="{{ route('order', ['hash'=>$order->hash])}}">{{$order->sku}}</a>,</br>
                    you will give email about order datails.
                </h3>
            @else
                <h2 class="title text-center font-weight-bolder">Order not found</h2>
            @endif
        </div>
    </div>
</div>
@endsection