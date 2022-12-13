@extends('app.layouts.app')
@section('content')
<div class="container content-faq text-center margin_bottom_150 margin_top_100 container">
    <div class="row">
        <div class="col-md-12">
            @if($order)
                <h1 class="title-faq title-font">Payment fail</h1>
                <p style="font-size: 18px;">
                    Something went wrong pls try again.
                </p>
            @else
                <h1 class="title-faq title-font">Order not found</h1>
            @endif
        </div>
    </div>
</div>
@endsection