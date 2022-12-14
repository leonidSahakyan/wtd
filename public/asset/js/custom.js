$( document ).on( "click", ".pagination a, .collections-menu .link-collection", function(e) {
	e.preventDefault();
	var url = $(this).attr('href');

	$.ajax({
	url: url,
	data: {},
	success: function( data ) {
		if($('#btn-list').hasClass('active')){
			data = data.replace("product_item", "product_item product-list")	
		}
		
		$('html, body').animate({
			scrollTop: $('.load_feed').offset().top -300
		}, 500, function(){
		});

		$('.load_feed').html(data).removeClass('content_loader');
		if($('.open-sidebar-left').attr('data-click-state') == 1){
			$('.open-sidebar-left').click();
		}
		window.history.pushState({urlPath:url}, "Results for `Cats`", url);
	},
	beforeSend: function() {
		$('.load_feed').addClass('content_loader');
	}
	});
});

$( document ).on( "submit", "#checkout", function(e) {
	e.preventDefault();

	$('#checkout label.error').remove();

	var formData = new FormData(this);
	total = parseInt($("#checkout #total_price").html())
	formData.append('total', total);

	$.ajax({
		type: 'POST',
		url: "/checkout",
		data: formData,
		cache: false,
		contentType: false,
		processData: false,
		dataType: 'json',
		success: function(response) {
			if(response.status == 1){
				$("#hash").val(response.hash);
				triggerCheckout('disable')
				// window.location = "/checkout/" + hash;
				
			}
		},
		error: function(response) {
			if(response.responseJSON.errors){
				errors = response.responseJSON.errors
				$.each( errors, function( key, value ) {
					if($("#"+key).length > 0){
						$( "#"+key ).after( '<label class="error">'+value+'</label>' );
					}
					if(key == 'server'){
						alert(value);
					}
				});
				$('html, body').animate({
					scrollTop: $(".login_page").offset().top-200
				}, 500);
			}else{
				alert('Something wrong, pls try again!');
			}
			return;
		}
	});
	// subTotal = 0;
	// totalQty = 0;
	// shippingPrice = 0;
	// $('#cart-page .item_cart').each(function(i, obj) {
	// 	price = parseInt($(obj).find('.product_item_price').html())
	// 	qty = parseInt($(obj).find('.newQty').val())
	// 	totalQty += qty;
	// 	productSubTotal = price * qty;
	// 	subTotal += productSubTotal;
	// 	$(obj).find('.product_item_total').html(productSubTotal)
	// });
	// country = $('#shipping_country').find(":selected");
	// total = subTotal
	// if(country.val() > 0){
	// 	shippingPrice = parseInt(country.attr('price'));
	// 	total = subTotal + shippingPrice
	// 	$('#shipping_price_desc').hide();
	// }else{
	// 	$('#shipping_price_desc').show();
	// }
	// $('#shipping_price').html(shippingPrice)
	// $('#subtotal_item_count').html(totalQty)
	// $('#subtotal_price').html(subTotal)
	// $('#total_price').html(total)
})

$( document ).on( "submit", ".addToCart", function(e) {
	e.preventDefault();
	
	$('.product-detail label.error').remove();

	var formData = new FormData(this);

	formData.append('qty', $('#qty').val());

	if($('#color').length > 0){
		formData.append('color', $('#color').val());	
	}
	if($('#size').length > 0){
		formData.append('size', $('#size').val());	
	}

	$.ajax({
		type: 'POST',
		url: "/add-to-cart",
		data: formData,
		cache: false,
		contentType: false,
		processData: false,
		dataType: 'json',
		success: function(response) {
			if(response.status == 1){
				$('#btn-cart figure').html(response.cart_count)
			}else{
				alert(response.message)
			}
		},
		error: function(response) {
			if(response.responseJSON.errors){
				errors = response.responseJSON.errors
				$.each( errors, function( key, value ) {
					if(key == 'size'){
						$( ".size-container" ).append( '<label class="error">'+value+'</label>' );
					}
					if(key == 'color'){
						$( ".color-container" ).append( '<label class="error">'+value+'</label>' );
					}
					if(key == 'qty'){
						$( ".qty-container" ).append( '<label class="error" style="position:absolute; bottom: 20px;">'+value+'</label>' );
					}
					if(key == 'server'){
						alert(value)
					}
				});
			}
			return;
		}
	});
});
$( document ).on( "click", "#cartUpdate", function(e) {
	e.preventDefault();
	
	$('.product-detail label.error').remove();

	var formData = new FormData(this);

	formData.append('qty', $('#qty').val());

	if($('#color').length > 0){
		formData.append('color', $('#color').val());	
	}
	if($('#size').length > 0){
		formData.append('size', $('#size').val());	
	}

	$.ajax({
		type: 'POST',
		url: "/add-to-cart",
		data: formData,
		cache: false,
		contentType: false,
		processData: false,
		dataType: 'json',
		success: function(response) {
			if(response.status == 1){
				$('#btn-cart figure').html(response.cart_count)
			}else{
				alert(response.message)
			}
		},
		error: function(response) {
			if(response.responseJSON.errors){
				errors = response.responseJSON.errors
				$.each( errors, function( key, value ) {
					if(key == 'size'){
						$( ".size-container" ).append( '<label class="error">'+value+'</label>' );
					}
					if(key == 'color'){
						$( ".color-container" ).append( '<label class="error">'+value+'</label>' );
					}
					if(key == 'qty'){
						$( ".qty-container" ).append( '<label class="error" style="position:absolute; bottom: 20px;">'+value+'</label>' );
					}
					if(key == 'server'){
						alert(value)
					}
				});
			}
			return;
		}
	});
});
$(document).ready(function() {
	$('#color').on('change', function() {
		sliderHtml = '<div class="slick-product-detail margin_bottom_20">';
		thumbHtml = '<div class="slick-nav-product-detail">';
		selectedColor = $('#color').val();
		if(images && images.length > 0){
			images.forEach(element => {
				if(selectedColor && selectedColor != 0){
					if((element.color == selectedColor) || !element.color){
						sliderHtml += '<div><img src="'+element.img_path+'" class="img-responsive full-width" alt=""></div>';
						thumbHtml += '<div><img src="'+element.img_thumb+'" class="img-responsive full-width" alt=""></div>';
					}	
				}else{
					if((defaultColor && element.color == defaultColor) || (!element.color)){
						sliderHtml += '<div><img src="'+element.img_path+'" class="img-responsive full-width" alt=""></div>';
						thumbHtml += '<div><img src="'+element.img_thumb+'" class="img-responsive full-width" alt=""></div>';
					}
				}
			});
		}
		sliderHtml += '</div>';
		thumbHtml += '</div>';
		$('#product_slider_container').html(sliderHtml+thumbHtml)
		$('.slick-product-detail').slick({
			dots:false,
			infinite: false,
			autoplay:false,
		   slidesToShow: 1,
		   speed: 500,
		   fade: false,
		   asNavFor: '.slick-nav-product-detail',
		 });
		 $('.slick-nav-product-detail').slick({
			dots:false,
			autoplay:false,
		   infinite: false,
		   slidesToShow: 3,
		   speed: 500,
		   focusOnSelect: true,
		   asNavFor: '.slick-product-detail',
		 });
	});

	$('#cart-page .newQty').on('change', function(el) {
		if(!window.editCart){
			return false;
		}
		newQtyEl = $(el.currentTarget)
		newQty = newQtyEl.val();
		loopIndex = newQtyEl.attr('attr_loop')
		itemData = $("#cart-page #item_data_"+loopIndex).val();
		token = $('#cart-page #token').val();
		// console.log(itemData)
		var formData = new FormData();
		formData.append('newQty', newQty);
		formData.append('itemData', itemData);
		formData.append('_token', token);

		$.ajax({
			type: 'POST',
			url: "/update-cart",
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			dataType: 'json',
			success: function(response) {
				if(response.status == 1){
					$('#btn-cart figure').html(response.cart_count)
				}
				calcTotal();
			},
			error: function(response) {
				console.log(response)
				if(response.responseJSON.error){
					alert(response.responseJSON.error);
				}else{
					alert("Something wrong, pls try again");
				}
				return;
			}
		});	
	});

	$('#btn-cart').on('click', function(e) {
		e.preventDefault();
		if(window.location.pathname == '/cart'){
			return false;
		}
		if(parseInt($('#btn-cart figure').html()) > 0){
			window.location = '/cart';	
		}
	})
	$('#cart-page .product-remove').on('click', function(e) {
		e.preventDefault();
		if(!window.editCart){
			return false;
		}
		removeEl = $(e.currentTarget)
		loopIndex = removeEl.attr('attr_loop')
		itemData = $("#cart-page #item_data_"+loopIndex).val();
		token = $('#cart-page #token').val();

		var formData = new FormData();
		formData.append('itemData', itemData);
		formData.append('_token', token);

		$.ajax({
			type: 'POST',
			url: "/remove-cart",
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			dataType: 'json',
			success: function(response) {
				if(response.status == 1){
					if(response.cart_count == 0){
						window.location = '/shop';
					}else{
						$("#cart-page #item_data_"+loopIndex).parent('.item_cart').remove();
						calcTotal();
					}
					$('#btn-cart figure').html(response.cart_count)
				}
			},
			error: function(response) {
				console.log(response)
				if(response.responseJSON.error){
					alert(response.responseJSON.error);
				}else{
					alert("Something wrong, pls try again");
				}
				return;
			}
		});	
	});

	$('#shipping_country').on('change', function(el) {
		calcTotal();
	});
});
function calcTotal(){
	subTotal = 0;
	totalQty = 0;
	shippingPrice = 0;
	$('#cart-page .item_cart').each(function(i, obj) {
		price = parseInt($(obj).find('.product_item_price').html())
		qty = parseInt($(obj).find('.newQty').val())
		totalQty += qty;
		productSubTotal = price * qty;
		subTotal += productSubTotal;
		$(obj).find('.product_item_total').html(productSubTotal)
	});
	country = $('#shipping_country').find(":selected");
	total = subTotal
	if(country.val() > 0){
		shippingPrice = parseInt(country.attr('price'));
		total = subTotal + shippingPrice
		$('#shipping_price_desc').hide();
	}else{
		$('#shipping_price_desc').show();
	}
	$('#shipping_price').html(shippingPrice)
	$('#subtotal_item_count').html(totalQty)
	$('#subtotal_price').html(subTotal)
	$('#total_price').html(total)
}
function triggerCheckout(stauts){
	if(stauts == 'disable'){
		window.editCart = false
		$('.login_page input').attr('disabled',true); 
		$('.login_page textarea').attr('disabled',true); 
		$('.login_page select').attr('disabled',true); 
		$('.newQty').attr('disabled',true); 
		$('#checkoutBtn').attr('disabled',true).hide();
		$('#paypal-button-container').show();
		$('#continueBtn').attr('disabled',false).show();
	}
	if(stauts == 'enable'){
		window.editCart = true
		$('.login_page input').attr('disabled',false); 
		$('.login_page textarea').attr('disabled',false); 
		$('.login_page select').attr('disabled',false); 
		$('.newQty').attr('disabled',false); 
		$('#paypal-button-container').hide();
		$('#checkoutBtn').attr('disabled',false).show();
		$('#continueBtn').attr('disabled',true).hide();
	}
}