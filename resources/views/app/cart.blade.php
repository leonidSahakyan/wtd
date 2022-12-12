@extends('app.layouts.app')
@section('content')
<main>
<div class="banner margin_bottom_150">
	<div class="container">
		<h1 class="title-font title-banner">My Cart</h1>
		<ul class="breadcrumb des-font">
			<li><a href="Home1.html">Home</a></li>
			<li class="active">Cart</li>
		</ul>
	</div>
</div>
<!--  -->
<form method="POST" id="checkout">
<div class="container">
<div class="table-responsive">
    <table class="table cart-table" id="cart-page">
		<input type="hidden" name="token" id="token" value="{{ csrf_token() }}">
        <thead>
            <tr class="number-font">
                <th class="product-thumbnail uppercase">Product</th>
                <th class="product-name uppercase">Description</th>
                <th class="product-price uppercase">Price</th>
                <th class="product-quantity uppercase">Quantity</th>
                <th class="product-subtotal uppercase">Total</th>
                <th class="product-remove uppercase">Delete</th>
            </tr>
        </thead>
        <tbody>
				@foreach($products as $product)
                <tr class="item_cart">
					<input type="hidden" id="item_data_{{$loop->index+1}}" class="cart_data" name="cart_data[]" value="{{json_encode($product->cart_data)}}">
                    <td class=" product-name">
                        <div class="product-img">
                            <img src="{{$product->imagePath}}" class="img-responsive" alt="">
                        </div>
                    </td>
                    <td class="product-desc">
                        <div class="product-info">
                            <a href="{{route('product',['slug'=>$product->slug])}}" class="title-font link-default">{{$product->title}}</a>
                            <p class="number-font margin_top_20">SKU: <span class="menu-child-font">{{$product->sku}}</span></p>
							@if(isset($product->cart_data['color']))
                            <p class="number-font margin_top_20">Color: <span class="menu-child-font capital">{{$product->cart_data['color']}}</span></p>
							@endif
							@if(isset($product->cart_data['size']))
                            <p class="number-font margin_top_20">Size: <span class="menu-child-font capital">{{$product->cart_data['size']}}</span></p>
							@endif
                        </div>
                    </td>
                    <td>
                        <p class="price number-font">$<span class="product_item_price">{{$product->price}}<span>.00</p>
                    </td>
                    <td class="btn-fuction">
                        <div class="input-number-group">
                            <div class="relative input-number-custom">
                            <div class="input-group-button absolute down-btn">
                                <span class="input-number-decrement ti-angle-down"></span>
                            </div>
                              <input class="input-number menu-font newQty" id="item_newQty_{{$loop->index+1}}" attr_loop="{{$loop->index+1}}" type="number"  min="1" max="1000" value="{{$product->cart_data['qty']}}" >
                            <div class="input-group-button absolute up-btn">
                                <span class="input-number-increment ti-angle-up"></span>
                            </div>
                            </div>
                        </div>   
                    </td>
                    <td class="total-price">
						
                        <p class="price number-font">$<span class="product_item_total">{{$product->price * $product->cart_data['qty']}}</span>.00</p>
                    </td>
                    <td class="product-remove" attr_loop="{{$loop->index+1}}">
                        <a href="#" class="btn-del link-default"><i class="ti-close"></i></a>
                    </td>
                </tr>
				@endforeach
        </tbody>
    </table>
</div>
<!--  -->
<div class="table-cart-bottom margin_top_20 margin_bottom_50">
    <div class="row">
        <div class="col-md-7 col-sm-6 col-xs-12">
            <div class="form-note login_page">
                <h3 class="title-font margin_bottom_20" style="margin-top: 0;">Shipping Information</h3>
                    <div class="row">
                      <div class="col-sm-6">
					  	  <input type="text" class="form-control form-account margin_bottom_10" name="first_name" placeholder="First name*">
					  	  <input type="email" class="form-control form-account margin_bottom_10" name="email" placeholder="Email*">
							<!-- <label for="CartSpecialInstructions" class="des-font margin_bottom_20">Special instructions for seller</label> -->
							<!-- <textarea rows="6" name="note" id="CartSpecialInstructions" class="form-control note--input des-font"></textarea> -->
						  <div class="country-container ">
							  <select id="shipping_country" name="shipping_country" class="form-control custom_self_select margin_bottom_10" >
								<option  value="0" >Select country</option>
                                @if(count($countries) > 0)
                                    @foreach($countries as $country)
                                        <option class="capital" value="{{$country->id}}" price="{{$country->price}}">{{$country->title}}</option>
                                    @endforeach
                                @endif
							</select>
							<input type="text" class="form-control form-account margin_bottom_10" name="address" placeholder="Address*">
						</div>
					</div>
					<div class="col-sm-6">
						<input type="text" class="form-control form-account margin_bottom_10" name="last_name" placeholder="Last name*">
						<input type="text" class="form-control form-account margin_bottom_10" name="phone" placeholder="Phone*">
						<input type="text" class="form-control form-account margin_bottom_10" name="city" placeholder="City*">
						<input type="text" class="form-control form-account margin_bottom_10" name="post_code" placeholder="Post code">
                          <!-- <label for="CartSpecialInstructions" class="des-font margin_bottom_20">Special instructions for seller</label> -->
                          <!-- <textarea rows="6" name="note" id="CartSpecialInstructions" class="form-control note--input des-font"></textarea> -->
                      </div>
                    </div>
            </div>
        </div>
        <div class="col-md-5 col-sm-6 col-xs-12">
            <div class="cart-text">
                <div class="cart-element flex">
                    <p class="des-font">Subtotal <span id="subtotal_item_count">{{$itemsCount}}</span> item(s):</p>
                    <p class="number-font right">$<span id="subtotal_price">{{$subTotal}}</span>.00</p>
                </div>
				<div class="cart-element flex">
                    <p class="des-font">Shipping:
                    <span style="font-size: 14px;" id="shipping_price_desc"><br>Will calculate after select country*<span></p>
					<p class="number-font right">$<span id="shipping_price">0</span>.00</p>
                </div>
                <div class="cart-element flex">
                    <p class="des-font">Total:</p>
                    <p class="number-font right">$<span id="total_price">{{$subTotal}}</span>.00</p>
                </div>
            </div>
            <input type="submit" name="checkout" class="btn-nixx full-width number-font" value="Checkout">
        </div>
    </div>
</div>
</div>
</form>
@endsection