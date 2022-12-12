@extends('app.layouts.app')
@section('content')
@if($collections && count($collections) > 0)
<div class="slider-home2 container-fluid">
    @foreach($collections as $collection)
    <div class="row">
        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
            <div class="text-slider-home2">
                <p class="number-font uppercase number-year text-right delay2">{{Str::substr($collection->created,0,4)}}</p>
                <p class="number-font uppercase text-new relative text-right">
                    <span class="delay2">new</span>
                </p>
                <p class="menu-child-font uppercase text-collection text-left delay1_5">collection <span class="des-font">+</span></p>
            </div>
        </div>
        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7 relative">
            <div class="info-slider-home2 absolute">
                <div class="flex">
                    <p class="number-font number-dot delay1_5">0{{$loop->index+1}}<img src="{{asset('asset/img/line-slider-home2.jpg')}}" class="img-responsive delay1_5 hidden-xs" alt=""></p>
                </div>
                <h1 class="title-font capital title-slider-home2 delay1_5">{!!$collection->title!!}</h1>
            </div>
            <a href="{{ route('collection', ['slug'=>$collection->slug])}}"><img src="{{asset('images/slider/'.$collection->file_name.'.'.$collection->ext)}}" class="img-responsive img-slider-main delay1_5" alt=""></a>
        </div>
    </div>
    @endforeach
</div>
@endif
@if(isset($site_settings->facebook) || isset($site_settings->instagram))
<div class="flex fixed right social-fixed delay03">
    @if(isset($site_settings->facebook))
        <a href="{{$site_settings->facebook}}" target="_blank" class="delay03"><i class="ti-facebook"></i></a>
    @endif
    @if(isset($site_settings->instagram))
        <a href="{{$site_settings->instagram}}" target="_blank" class="delay03"><i class="ti-instagram"></i></a>
    @endif
</div>
@endif
@if($products && count($products) > 0)
<div class="container margin_bottom_130 section-bestseller-home1 space_top_140">
    <div class="row">
        <div class="col-md-12">
            <h1 class="title-font margin_bottom_10 title-bestseller">{{trans('app.homepage_products_title')}}</h1>
            <p class="des-font margin_bottom_50 des-bestseller">{{trans('app.homepage_products_description')}}</p>
            <div class="slick-bestseller">
                @foreach($products as $product)
                    <div class="product">
                        <div class="img-product relative">
                            <a href="{{route('product',['slug'=>$product->slug])}}"><img src="{{asset('images/productList/'.$product->file_name.'.'.$product->ext)}}" class="img-responsive" alt="{{$product->title}}"></a>
                            <!-- <div class="product-icon text-center absolute">
                                <form method="post" action="/cart/add" enctype="multipart/form-data" class="inline-block icon-addcart">
                                    @csrf
				                    <input type="hidden" name="id" value="{{$product->id}}" />
                                    <button type="submit" name="add" class="enj-add-to-cart-btn btn-default"><i class="ti-bag"></i></button>
                                </form>
                            </div> -->
                        </div>
                        <div class="info-product text-center">
                            <h4 class="des-font capital title-product space_top_20"><a href="#">{{$product->title}}</a></h4>
                            <p class="number-font price-product"><span class="price">${{$product->price}}.00</span></p>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="col-md-12 text-center discover-link margin_top_70">
                <a href="{{route('shop')}}" class="menu-font uppercase relative">{{trans('app.homepage_more_products')}}<figure class="line"></figure></a>
            </div>
        </div>
    </div>
</div>
@endif
<div class="container shipping-home4 margin_bottom_150">
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 content">
            <div class="flex">
                <img src="{!! asset('asset/images/icon_1.png') !!}" class="img-responsive" alt=""><span class="title-font title-ship space_left_30">{{trans('app.homepage_icon1_title')}}</span>
            </div>
            <p class="des-font des-ship">{{trans('app.homepage_icon1_text')}}</p>
        </div>
        <!--  -->
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 content">
            <div class="flex">
                <img src="{!! asset('asset/images/icon_2.png') !!}" class="img-responsive" alt=""><span class="title-font title-ship space_left_30">{{trans('app.homepage_icon2_title')}}</span>
            </div>
            <p class="des-font des-ship">{{trans('app.homepage_icon2_text')}}</p>
        </div>
        <!--  -->
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 content">
            <div class="flex">
                <img src="{!! asset('asset/images/icon_3.png') !!}" class="img-responsive" alt=""><span class="title-font title-ship space_left_30">{{trans('app.homepage_icon3_title')}}</span>
            </div>
            <p class="des-font des-ship">{{trans('app.homepage_icon3_text')}}</p>
        </div>
    </div>
</div>
<div class="video-home7 relative margin_bottom_150">
    <div>
        <h1 class="title-font capital text-center title-video absolute">{!!trans('app.homepage_video_title')!!}</h1>
        <img src="{!! asset('asset/images/video_bg.jpg') !!}" class="img-responsive" alt="">
        <button type="button" class="btn-video-home7 absolute" data-fancybox href="{{trans('app.homepage_video_url')}}">
            <svg role="presentation" focusable="false"><svg id="plyr-play" viewBox="0 0 0 0"><i class="ti-control-play"></i></svg></svg>
        </button>
    </div>
</div>
@endsection