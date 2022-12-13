@extends('app.layouts.app')
@section('content')
<div class="banner margin_bottom_150">
	<div class="container">
		<h1 class="title-font title-banner banner-product-detail">{{$product->title}}</h1>
		<ul class="breadcrumb des-font">
			<li><a href="{{route('homepage')}}">Home</a></li>
			<li><a href="{{route('shop')}}">Shop</a></li>
			<li class="active">{{$product->title}}</li>
		</ul>
	</div>
</div>
<!--  -->
	<!--  -->
<div class="container product-detail margin_bottom_150">
	<div class="row">
		@if(count($imagesArray) > 0)
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 margin_bottom_50" id="product_slider_container">
			<div class="slick-product-detail margin_bottom_20">
				@foreach($imagesArray as $image)
				@if(count($product->colors) > 0)
					@if(($defaultColor && $defaultColor != $image['color'] && $image['color']) || (!$defaultColor && $image['color']))
						@continue
					@endif
				@endif
				<div>
					<img data-color="{{$image['color']}}" src="{{$image['img_path']}}"" class="img-responsive full-width" alt="">
				</div>
				@endforeach
			</div>
			<div class="slick-nav-product-detail">
				@foreach($imagesArray as $image)
				@if(count($product->colors) > 0)
					@if(($defaultColor && $defaultColor != $image['color'] && $image['color']) || (!$defaultColor && $image['color']))
						@continue
					@endif
				@endif
				<div>
					<img data-color="{{$image['color']}}" src="{{$image['img_thumb']}}" class="img-responsive" alt="">
				</div>
				@endforeach
			</div>
		</div>
		@endif
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 info-product-detail">
			<h1 class="title-font title-product margin_bottom_30">{{$product->title}}</h1>
			<p class="number-font price margin_bottom_40">${{$product->price}}.00</p>
			<!-- <p class="product-preview margin_bottom_50">
				<i class="ti-star"></i>
				<i class="ti-star"></i>
				<i class="ti-star"></i>
				<i class="ti-star"></i>
				<i class="ti-star"></i>
				<span class="relative line-space">__</span>
				<span class="des-font">(02) Reviews</span>
			</p> -->
			
			<input type="hidden" name="id" value="{{$product->id}}" />
			@if(count($product->colors) > 0)
			<div class="margin_bottom_10 color-container" >
				<select id="color" name="color" color-attr="1" class="menu-font custom_select">
					<option class="uppercase" value="0" >Please select a color</option>
					@foreach($product->colors as $color)
						<option class="capital" {{$color == $defaultColor ? 'selected' : ''}} value="{{$color}}">{{$color}}</option>
					@endforeach
				</select>
			</div>
			@endif
			@if(count($product->sizes) > 0)
			<div class="margin_bottom_30 size-container">
				<select id="size" name="size" size-attr="1" class="menu-font custom_select">
					<option class="uppercase" value="0">Please select a size</option>
					@foreach($product->sizes as $size)
						<option class="capital" value="{{$size}}">{{$size}}</option>
					@endforeach
				</select>
			</div>
			@endif
			<div class="flex margin_bottom_50 border-bot space_bot_50 btn-function qty-container" style="position: relative;">
				<div class="input-number-group">
					<div class="relative input-number-custom">
					<div class="input-group-button absolute down-btn">
						<span class="input-number-decrement ti-angle-down"></span>
					</div>
					<input class="input-number menu-font" type="number" name="qty" id="qty" min="0" max="1000" value="1" >
					<div class="input-group-button absolute up-btn">
						<span class="input-number-increment ti-angle-up"></span>
					</div>
				</div>
			</div>
				<form method="post" action="/cart/add" enctype="multipart/form-data" class="inline-block icon-addcart addToCart">
					@csrf
					<input type="hidden" name="id" value="{{$product->id}}" />
					<button type="submit" name="add" class="enj-add-to-cart-btn btn-default menu-font uppercase">add to cart</button>
					<!-- <a href="#" class="icon-heart"><i class="ti-heart"></i></a>
					<a href="#" class="engoj_btn_quickview icon-quickview" title="quickview">
						<i class="ti-more-alt"></i>
					</a> -->
				</form>
			</div>
			<div class="inline-block border-bot">
				<div class="inline-block margin_bottom_50">
					<button class="accordion menu-font btn-tab">Description</button>
					<div class="panel">
						<p class="des-font des-tab"><br>{!!$product->description!!}</p>
					</div>
				</div>
				<div class="inline-block margin_bottom_50">
					<button class="accordion menu-font btn-tab">Shipping & returns</button>
					<div class="panel">
					<p class="des-font des-tab"><br><br>Tote bag from Mansur Gavriel in Saddle. Calf leather. Open compartment. Interior side pocket. Top 
						handles. Detachable, adjustable shoulder strap. Goldtone hardware. Embossed logo detailing at exterior. 
						Tonal patent coated interior.<br><br></p>
						<ul class="space_left_20 des-font des-tab">
							<li>Leather</li>
							<li>Made in Italy</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="info-more">
				<p class="des-font margin_bottom_30 margin_top_50"><span class="menu-font">SKU:</span> {{$product->sku}}</p>
				<p class="margin_bottom_30">
					<span class="menu-font margin_right_10">Collection:</span>
					<a href="{{ route('collection', ['slug'=>$collection->slug])}}" class="delay03 margin_right_10">{{$collection->title}}</a>
				</p>
				<!-- <p class="margin_bottom_30">
					<span class="menu-font margin_right_30">Share:</span>
					<a href="#" class="delay03 margin_right_30"><i class="ti-facebook"></i></a>
					<a href="#" class="delay03 margin_right_30"><i class="ti-twitter-alt"></i></a>
					<a href="#" class="delay03 margin_right_30"><i class="ti-pinterest"></i></a>
					<a href="#" class="delay03 margin_right_30"><i class="ti-linkedin"></i></a>
				</p> -->
			</div>
		</div>
	</div>
</div>
<?php /*
	<!--  -->
	<div class="container margin_bottom_130 section-bestseller-home1">
		<div class="row">
			<div class="col-md-12">
				<h1 class="title-font margin_bottom_10 title-bestseller">Related products</h1>
				<p class="des-font margin_bottom_50 des-bestseller">I did not even know that there were any better conditions to escape to, but I was more than willing 
					to take my chances among people fashioned after.</p>
			<div class="slick-bestseller">
				<div class="product">
					<div class="img-product relative">
						<a href="#"><img src="{!! asset('asset/img/product_1.jpg') !!}" class="img-responsive" alt=""></a>
						<figure class="absolute uppercase label-new title-font text-center">new</figure>
						<div class="product-icon text-center absolute">
							<form method="post" action="/cart/add" enctype="multipart/form-data" class="inline-block icon-addcart">
  							  <input type="hidden" name="id" value="" />
  							  <button type="submit" name="add" class="enj-add-to-cart-btn btn-default"><i class="ti-bag"></i></button>
  							</form>
  							<a href="#" class="icon-heart inline-block"><i class="ti-heart"></i></a>
  							<a href="#" class="engoj_btn_quickview icon-quickview inline-block" title="quickview">
      						  <i class="ti-more-alt"></i>
      						</a>
						</div>
					</div>
					<div class="info-product text-center">
						<h4 class="des-font capital title-product space_top_20"><a href="#">embossed backpack in brown</a></h4>
						<p class="number-font price-product"><span class="price">$123.00</span></p>
					</div>
				</div>
				<!--  -->
				<div class="product">
					<div class="img-product relative">
						<a href="#"><img src="{!! asset('asset/img/product_1.jpg') !!}" class="img-responsive" alt=""></a>
						<figure class="absolute uppercase label-sale title-font text-center">sale</figure>
						<div class="product-icon absolute text-center">
							<form method="post" action="/cart/add" enctype="multipart/form-data" class="inline-block icon-addcart">
  							  <input type="hidden" name="id" value="" />
  							  <button type="submit" name="add" class="enj-add-to-cart-btn btn-default"><i class="ti-bag"></i></button>
  							</form>
  							<a href="#" class="icon-heart inline-block"><i class="ti-heart"></i></a>
  							<a href="#" class="engoj_btn_quickview icon-quickview inline-block" title="quickview">
      						  <i class="ti-more-alt"></i>
      						</a>
						</div>
					</div>
					<div class="info-product text-center">
						<h4 class="des-font capital title-product space_top_20"><a href="#">embossed backpack in brown</a></h4>
						<p class="number-font"><span class="price">$123.00</span></p>
					</div>
				</div>
				<!--  -->
				<div class="product">
					<div class="img-product relative">
						<a href="#"><img src="{!! asset('asset/img/product_1.jpg') !!}" class="img-responsive" alt=""></a>
						<figure class="absolute uppercase label-new title-font text-center">new</figure>
						<div class="product-icon absolute text-center">
							<form method="post" action="/cart/add" enctype="multipart/form-data" class="inline-block icon-addcart">
  							  <input type="hidden" name="id" value="" />
  							  <button type="submit" name="add" class="enj-add-to-cart-btn btn-default"><i class="ti-bag"></i></button>
  							</form>
  							<a href="#" class="icon-heart inline-block"><i class="ti-heart"></i></a>
  							<a href="#" class="engoj_btn_quickview icon-quickview inline-block" title="quickview">
      						  <i class="ti-more-alt"></i>
      						</a>
						</div>
					</div>
					<div class="info-product text-center">
						<h4 class="des-font capital title-product space_top_20"><a href="#">embossed backpack in brown</a></h4>
						<p class="number-font"><span class="price">$123.00</span></p>
					</div>
				</div>
				<!--  -->
				<div class="product">
					<div class="img-product relative">
						<a href="#"><img src="{!! asset('asset/img/product_1.jpg') !!}" class="img-responsive" alt=""></a>
						<figure class="absolute uppercase label-sale title-font text-center">sale</figure>
						<div class="product-icon absolute text-center">
							<form method="post" action="/cart/add" enctype="multipart/form-data" class="inline-block icon-addcart">
  							  <input type="hidden" name="id" value="" />
  							  <button type="submit" name="add" class="enj-add-to-cart-btn btn-default"><i class="ti-bag"></i></button>
  							</form>
  							<a href="#" class="icon-heart inline-block"><i class="ti-heart"></i></a>
  							<a href="#" class="engoj_btn_quickview icon-quickview inline-block" title="quickview">
      						  <i class="ti-more-alt"></i>
      						</a>
						</div>
					</div>
					<div class="info-product text-center">
						<h4 class="des-font capital title-product space_top_20"><a href="#">embossed backpack in brown</a></h4>
						<p class="number-font"><span class="price">$123.00</span></p>
					</div>
				</div>
				<!--  -->
				<div class="product">
					<div class="img-product relative">
						<a href="#"><img src="{!! asset('asset/img/product_1.jpg') !!}" class="img-responsive" alt=""></a>
						<figure class="absolute uppercase label-sale title-font text-center">sale</figure>
						<div class="product-icon absolute text-center">
							<form method="post" action="/cart/add" enctype="multipart/form-data" class="inline-block icon-addcart">
  							  <input type="hidden" name="id" value="" />
  							  <button type="submit" name="add" class="enj-add-to-cart-btn btn-default"><i class="ti-bag"></i></button>
  							</form>
  							<a href="#" class="icon-heart inline-block"><i class="ti-heart"></i></a>
  							<a href="#" class="engoj_btn_quickview icon-quickview inline-block" title="quickview">
      						  <i class="ti-more-alt"></i>
      						</a>
						</div>
					</div>
					<div class="info-product text-center">
						<h4 class="des-font capital title-product space_top_20"><a href="#">embossed backpack in brown</a></h4>
						<p class="number-font"><span class="price">$123.00</span></p>
					</div>
				</div>
				<!--  -->
				<div class="product">
					<div class="img-product relative">
						<a href="#"><img src="{!! asset('asset/img/product_1.jpg') !!}" class="img-responsive" alt=""></a>
						<figure class="absolute uppercase label-sale title-font text-center">sale</figure>
						<div class="product-icon absolute text-center">
							<form method="post" action="/cart/add" enctype="multipart/form-data" class="inline-block icon-addcart">
  							  <input type="hidden" name="id" value="" />
  							  <button type="submit" name="add" class="enj-add-to-cart-btn btn-default"><i class="ti-bag"></i></button>
  							</form>
  							<a href="#" class="icon-heart inline-block"><i class="ti-heart"></i></a>
  							<a href="#" class="engoj_btn_quickview icon-quickview inline-block" title="quickview">
      						  <i class="ti-more-alt"></i>
      						</a>
						</div>
					</div>
					<div class="info-product text-center">
						<h4 class="des-font capital title-product space_top_20"><a href="#">embossed backpack in brown</a></h4>
						<p class="number-font"><span class="price">$123.00</span></p>
					</div>
				</div>
				<!--  -->
			</div>
			
			</div>
		</div>
	</div>
<!--  -->
*/ ?>
@push('script')
	@if(count($imagesArray) > 0)
		<script>
			let images = <?php echo json_encode($imagesArray,true); ?>;
			let defaultColor = "<?= $defaultColor ? $defaultColor : 0 ?>";
		</script>
	@endif
@endpush
@endsection