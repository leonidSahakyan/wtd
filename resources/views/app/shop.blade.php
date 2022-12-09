@extends('app.layouts.app')
@section('content')
<div class="banner margin_bottom_150">
	<div class="container">
		<h1 class="title-font title-banner">Shop</h1>
		<ul class="breadcrumb des-font">
			<li><a href="Home1.html">Home</a></li>
			<li class="active">Shop</li>
		</ul>
	</div>
</div>
<!--  -->
<div class="container shop-page margin_bottom_150">
	<div class="row">
		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 sidebar-left collections-menu">
            @if($collections && count($collections) > 0)
            <ul class="category margin_bottom_70">
            	<li><h1 class="title-font title">Collections</h1></li>
                @foreach($collections as $collection)
            	<li><a href="{{ route('collection', ['slug'=>$collection->slug])}}" class="des-font link-collection">{{$collection->title}} ({{$collection->items_count}})</a></li>
                @endforeach
            </ul>
            @endif
		</div>
		<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 content-shop">
			<div class="row btn-function-shop">
				<div class="col-lg-7 col-md-6 col-sm-6 col-xs-6 margin_bottom_50">
					<span class="des-font showing hidden-xs">Showing 1–9 of 50 results</span>
					<button class="active" id="btn-grid"><i class="ti-layout-grid3-alt"></i></button>
					<button id="btn-list"><i class="ti-list"></i></button>
				</div>
				<!-- <div class="col-lg-5 col-md-6 col-sm-6 col-xs-6 margin_bottom_50 text-right select-view">
					<button><i class="ti-eye"></i></button>
					<select id="select-show">
						<option>Sort by popularity</option>
                        <option>Featured</option>
                        <option>Best selling</option>
                        <option>Alphabetically, A - Z</option>
                        <option>Price, hight to low</option>
                        <option>Price, low to hight</option>
					</select>
				</div> -->
			</div>
            @if($feed)
			<div class="row load_feed">
                @foreach ($feed as $product)
                    @include('app.product-list-item', [$product,$type = 'grid'])
                @endforeach
                @include('app.pagination',['paginator'=>$feed])
			</div>
            @endif
		</div>
	</div>
</div>
@endsection