@if(@$feed)
	@foreach ($feed as $product)
		@include('app.product-list-item', [$product])
	@endforeach
	@include('app.pagination',['paginator'=>$feed])
@endif