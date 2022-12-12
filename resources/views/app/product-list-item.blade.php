<div class="product col-lg-4 col-md-4 col-sm-6 col-xs-6 margin_bottom_50 product_item">
	<div class="img-product relative">
		<a href="{{route('product',['slug'=>$product->slug])}}"><img src="{{asset('images/productList/'.$product->file_name.'.'.$product->ext)}}" class="img-responsive" alt=""></a>
		<!-- <div class="product-icon text-center absolute">
			<form method="post" action="/cart/add" enctype="multipart/form-data" class="inline-block icon-addcart addToCart">
				@csrf
				<input type="hidden" name="id" value="{{$product->id}}" />
				<button type="submit" name="add" class="enj-add-to-cart-btn btn-default"><i class="ti-bag"></i></button>
			</form>
		</div> -->
	</div>
	<div class="product-info">
	<div class="info-product text-center">
		<h4 class="des-font capital title-product space_top_20"><a href="{{route('product',['slug'=>$product->slug])}}">{{$product->title}}</a></h4>
		<p class="number-font price-product"><span class="price">${{$product->price}}.00</span></p>
		<p class="des-font des-product">{{$product->description}}</p>
	</div>
	<!-- <div class="btn-product-list">
		<form method="post" action="/cart/add" enctype="multipart/form-data" class="inline-block icon-addcart addToCart">
				@csrf
				<input type="hidden" name="id" value="{{$product->id}}" />
				<button type="submit" name="add" class="enj-add-to-cart-btn btn-default des-font uppercase">add to cart</button>
		</form>
	</div> -->
	</div>
</div>