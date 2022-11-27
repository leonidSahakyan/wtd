@extends('app.layouts.app')
@section('content')
<!-- Page Title -->
<!-- <section class="page-title" style="background-image: url(assets/images/background/2.jpg)">
    <div class="container">
        <h1 class="page-main__title">Contact</h1>
        <ul class="page__breadcrumb">
            <li><a href="index.html">home</a></li>
            <li>Contact</li>
        </ul>
    </div>
</section> -->
<!-- End Main Slider Section -->

<!-- Contact One -->
<section class="contact-one">
    <div class="container">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="contact-one__form-box" id="request-html">
                    <h2 class="contact-one__title-two">{{trans('app.request_quote_page_title')}}</h2>
                    <div class="contact-one__text-two">{!!trans('app.request_quote_page_description')!!}</div>
                    <!-- Contact Form -->
                    <div class="contact-form">
                        <!-- Contact Form -->
                        <form id="request-quote-form">
                            @csrf
                            <input type="hidden" id='gallery_id' name="gallery_id" value="{{$galleryId}}"/>
                            <div class="row clearfix">
                                <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                    <input type="text" name="first_name" id="first_name" placeholder="First name">
                                </div>
                                
                                <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                    <input type="text" name="last_name" id="last_name" placeholder="Last name">
                                </div>

                                <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                    <input type="email" name="email" id="email" placeholder="Email Address">
                                </div>

                                <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                    <input type="text" name="phone" id="phone" placeholder="Phone">
                                </div>
                                
                                <div class="form-group col-lg-6 col-md-6 col-sm-12 image-upload-container" id="el_bill">
                                    <label style="font-size:18px;">Electricity bill <label style="font-size:15px;">(For a more accurate representation) </label></label>
                                    <div class="image-part">
                                        <img class="thumbnail" src="" />
                                        <input type="hidden" name="el_bill" class="el_bill" value="" />
                                    </div>
                                    <div class="image-action fileNotExist">
                                        <div class="img-not-exist">
                                            <span id="uploadBtn" class="btn btn-success">Upload</span>
                                        </div>
                                        <div class="img-exist">
                                            <span class="btn btn-sm btn-info remove-image">Remove</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <textarea name="comment" id="comment" placeholder="Notes"></textarea>
                                </div>

                                <div class="form-group">
                                    <label style="font-size:18px;">Upload images</label>
                                    <div id="gallery-container"></div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="theme-btn btn-style-two float-end"><span class="txt">Send</span></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="contact-one__form-box" id="thank-you">
                    <h2 class="contact-one__title-two">{{trans('app.thank_you_title')}}</h2>
                    <div class="contact-one__text-two">{{trans('app.request_quote_thank_you_text')}}</div>
                </div>
            </div>
        </div>
    </div>
</section>
@push('css')
    <link href="{!! asset('assets/vendors/dropzone/css/dropzone.css') !!}" media="all" rel="stylesheet" type="text/css" />
    <link href="{!! asset('assets/vendors/simple-ajax-uploader/SimpleAjaxUploader.css') !!}" media="all" rel="stylesheet" type="text/css" />
@endpush
@push('script')
<script src="{!! asset('assets/vendors/dropzone/dropzone.js') !!}" type="text/javascript"></script>
<script src="{!! asset('assets/js/gallery.js?8') !!}" type="text/javascript"></script>
<script src="{!! asset('assets/vendors/simple-ajax-uploader/SimpleAjaxUploader.js') !!}" type="text/javascript"></script>
<script src="{!! asset('assets/js/upload.js') !!}" type="text/javascript"></script>
<div id="preview-template" style="display:none">
	<div class="dz-preview dz-file-preview">
		<div class="dz-details">
			<div class="dz-filename"><span data-dz-name></span></div>
			<img data-dz-thumbnail />
		</div>
		<div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
		<div class="dz-success-mark"><span>✔</span></div>
		<div class="dz-error-mark"><span>✘</span></div>
		<div class="dz-error-message"><span data-dz-errormessage></span></div>
	</div>
</div>
<script>
    $(document).ready(function(e) {
        var upload = new SUpload;
        upload.init({
            uploadContainer: 'el_bill',
            token: "<?php echo csrf_token(); ?>",
            imageIdReturnEl: ".el_bill"
        });

        var gallery = new Gallery;
		gallery.init({
            gallery_id:'{{$galleryId}}',
			_token: '<?php echo csrf_token(); ?>',
			container: '#gallery-container',
		})
		window.gallery = gallery;
		gallery.load(false);

        $('#request-quote-form').submit(function(event) {
            event.preventDefault();
            var formData = new FormData(this);
            
            $('#request-quote-form .error').remove();

            // let firstName = $('#first-name').val();
            // formData.append('email', firstName);
            
            $.ajax({
                type: 'POST',
                url: "{{ route('requestQuoteSubmit') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if(response.status == 1){
                        $('#request-html').hide();
                        $('#thank-you').show();
                        $('html, body').animate({
                            scrollTop: $("html").offset().top
                        }, 500);
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
});
</script>
@endpush
<!-- End Contact One -->
@endsection