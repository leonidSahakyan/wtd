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
        
		window.history.pushState("", "", url);
      },
      beforeSend: function() {
        $('.load_feed').addClass('content_loader');
      }
    });
});
$( document ).on( "submit", ".addToCart", function(e) {
	e.preventDefault();
	
	var formData = new FormData(this);
	// $('#new-order label.error').remove();

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
				console.log('asdasd')
				// let hash = response.hash;
				// var loc = window.location;
				// window.location = loc.protocol + "//" + loc.hostname + "/checkout/" + hash;
			}else{
				alert(response.message)
			}
		},
		error: function(response) {
			if(response.responseJSON.errors){
				errors = response.responseJSON.errors
				$.each( errors, function( key, value ) {
					if($("#"+key).length > 0){
						$( "#"+key ).after( '<label class="error">'+value+'</label>' );
					}
				});
				$('html, body').animate({
					scrollTop: $("html").offset().top
				}, 500);
			}
			return;
		}
	});
});