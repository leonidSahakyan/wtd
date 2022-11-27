@extends('app.layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if($order)
                <h2 class="title text-center font-weight-bolder">Payment fail</h2>
                <h3 style="text-align:center; min-height: 310px;">
                    Your can try 
                    <a href="{{ route('checkout', ['hash'=>$order->hash])}}">Checkout order: {{$order->sku}}</a>, again.
                </h3>
            @else
                <h2 class="title text-center font-weight-bolder">Order not found</h2>
            @endif
        </div>
    </div>
</div>
@endsection