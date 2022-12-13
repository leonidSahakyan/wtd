@extends('app.layouts.app')
@section('content')
<main>
<div class="container">
<div class="table-cart-bottom margin_top_20 margin_bottom_50">
<div class="row">
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="form-note login_page">
                <h3 class="title-font margin_bottom_20" style="margin-top: 0;">Order Information</h3>
                <div class="cart-text">
                    <p class="des-font">OrderID: {{$order->sku}}</p>
                    <p class="des-font">Status: <span class="capital">{{$order->status}}</span></p>
                    <p class="des-font">Created: <span class="capital">{{$order->created_at}}</span></p>
                    <div class="cart-element flex">
                        <p class="des-font">Subtotal <span id="subtotal_item_count">{{$order->qty}}</span> item(s):</p>
                        <p class="number-font right">$<span id="subtotal_price">{{$order->items_price}}</span>.00</p>
                    </div>
                    <div class="cart-element flex">
                        <p class="des-font">Shipping:</p>
                        <p class="number-font right">$<span id="shipping_price">{{$order->shipping_price}}</span>.00</p>
                    </div>
                    <div class="cart-element flex">
                        <p class="des-font">Total:</p>
                        <p class="number-font right">$<span id="total_price">{{$order->total}}</span>.00</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="form-note login_page">
                <h3 class="title-font margin_bottom_20" style="margin-top: 0;">Shipping Information</h3>
                <div class="row">
                      <div class="col-sm-6">
                        <div class="cart-text">
                            <p class="des-font">First name: {{$order->first_name}}</p>
                            <p class="des-font">Last name: {{$order->last_name}}</p>
                            <p class="des-font">Email: {{$order->email}}</p>
                            <p class="des-font">Phone: {{$order->phone}}</p>
                            @if($order->notes)
                            <label for="notes" class="des-font margin_bottom_20">Special instructions for seller</label>
                            <textarea rows="6" name="notes" name="note" disabled class="form-control note--input des-font">{{$order->notes}}</textarea>
                            @endif
                        </div>
					</div>
					<div class="col-sm-6">
                        <div class="cart-text">
                            <p class="des-font">Country: {{$country}}</p>
                            <p class="des-font">City: {{$order->city}}</p>
                            <p class="des-font">Address: {{$order->address}}</p>
                            <p class="des-font">Post code: {{$order->post_code}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="table-responsive">
    <table class="table cart-table" id="cart-page">
        <thead>
            <tr class="number-font">
                <th class="product-thumbnail uppercase">Product</th>
                <th class="product-name uppercase">Description</th>
                <th class="product-price uppercase">Price</th>
                <th class="product-quantity uppercase">Quantity</th>
                <th class="product-subtotal uppercase">Total</th>
            </tr>
        </thead>
        <tbody>
				@foreach($orderItems as $product)
                <tr class="item_cart">
                    <td class=" product-name">
                        <div class="product-img">
                            <img src="{{$product->imagePath}}" class="img-responsive" alt="">
                        </div>
                    </td>
                    <td class="product-desc">
                        <div class="product-info">
                            <a href="{{route('product',['slug'=>$product->slug])}}" class="title-font link-default">{{$product->title}}</a>
                            <p class="number-font margin_top_20">SKU: <span class="menu-child-font">{{$product->sku}}</span></p>
							@if(isset($product->color))
                            <p class="number-font margin_top_20">Color: <span class="menu-child-font capital">{{$product->color}}</span></p>
							@endif
							@if(isset($product->size))
                            <p class="number-font margin_top_20">Size: <span class="menu-child-font capital">{{$product->size}}</span></p>
							@endif
                        </div>
                    </td>
                    <td>
                        <p class="price number-font">$<span class="product_item_price">{{$product->price}}<span>.00</p>
                    </td>
                    <td class="btn-fuction">
                        <p class="price number-font">{{$product->qty}}</p>
                    </td>
                    <td class="total-price">
                        <p class="price number-font">$<span class="product_item_total">{{$product->price * $product->qty}}</span>.00</p>
                    </td>
                </tr>
				@endforeach
        </tbody>
    </table>
</div>
<!--  -->

</div>
@endsection