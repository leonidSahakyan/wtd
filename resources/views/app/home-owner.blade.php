@extends('app.layouts.app')
@section('content')
    <!-- Contact One -->
    <section class="contact-one">
        <div class="container">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="contact-one__form-box">

                        <h2 class="contact-one__title-two">{{trans('app.order_service')}}</h2>
                        <!-- Contact Form -->
                        <div class="contact-form">
                            <!-- Contact Form -->
                            <form class="contact-form owner-form">
                                @csrf
                                <input type="hidden" id='gallery_id' name="gallery_id" value="0"/>
                                <div class="row clearfix">
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                        <input type="text" id="first_name" name="first_name" placeholder="First Name">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                        <input type="text" id="last_name" name="last_name" placeholder="Last Name">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                        <input type="text" id="address" name="address" placeholder="Address">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                        <input type="email" id="email" name="email" placeholder="Email Address">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                        <input type="text" id="phone" name="phone" placeholder="Phone">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                        <select id="find_us" name="find_us">
                                            <option value="" disabled selected>- Where you find us -</option>
                                            <option value="facebook">Facebook</option>
                                            <option value="google">Google</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                        <select id="location_type" name="location_type">
                                            <option value="0" disabled selected>- Location type -</option>
                                            <option value="residential">Residential</option>
                                            <option value="commercial">Commercial</option>
                                        </select>
                                    </div>
                                    <div class="row clearfix"></div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                    @if (count($services) > 0)
                                    <select id="service" name="service">
                                            <option value="" disabled selected>- Select service -</option>
                                            @foreach ($services as $service)
                                            <option residential_price="{{ $service->residential_price }}" title="{{ $service->title }}" commercial_price="{{ $service->commercial_price }}" value="{{ $service->id }}">{{ $service->title }}</option>
                                            @endforeach
                                        </select>
                                        @endif
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                        @if (count($serviceTypes) > 0)
                                        @foreach ($services as $service)
                                        <div class="service_type_container" style="display: none;" id="service_type_container_{{$service->id}}">
                                            <select class="service_type" id="service_type_{{$service->id}}" name="service_type_{{$service->id}}">
                                                <option value="" disabled selected>- Select type -</option>
                                                @foreach ($serviceTypes as $serviceType)
                                                @if($serviceType->parent_id == $service->id)
                                                <option value="{{ $serviceType->id }}">{{ $serviceType->title }}</option>
                                                @endif
                                                @endforeach
                                                <option value="-1">Other</option>
                                            </select>
                                            </div>
                                        @endforeach 
                                        @endif
                                        
                                        <input type="text" style="display:none;"  id="service_other_type" name="service_other_type" placeholder="Choose other">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                        @if (count($serviceReplacementices) > 0)
                                            @foreach ($services as $service)
                                                <div class="service_replacementices_container" style="display: none;"  id="service_replacementices_container_{{$service->id}}">
                                                        @foreach ($serviceReplacementices as $serviceReplacement)
                                                                @if($serviceReplacement->parent_id == $service->id)
                                                                <div class="form-check">
                                                                    <input class="form-check-input replacmentCheckbox" type="checkbox" value="{{ $serviceReplacement->id }}" name="service_replacement_{{$serviceReplacement->id}}" item_id="{{$serviceReplacement->id}}" id="replacment_{{$serviceReplacement->id}}">
                                                                    <label class="form-check-label" for="replacment_{{$serviceReplacement->id}}">
                                                                        {{ $serviceReplacement->title }}
                                                                        @if($serviceReplacement->price > 0)
                                                                                - Qty: <input type="number" min="1" value="1" item_price="{{$serviceReplacement->price}}" name="service_replacement_qty_{{$serviceReplacement->id}}" item_id="{{$serviceReplacement->id}}" id="replacement_qty_{{$serviceReplacement->id}}" class="replacement_qty"> + 
                                                                                <span  id="replacement_totle_{{$serviceReplacement->id}}">{{$serviceReplacement->price}}</span> $
                                                                        @endif
                                                                    </label>
                                                                </div>
                                                            @endif
                                                        @endforeach     
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <clear></clear>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12" style="display:inline-flex;">
                                        <div class="col-lg-6">
                                            <input type="text" id="order_date" name="order_date" placeholder="Date">
                                        </div>
                                        <div class="col-lg-6" style="margin-left: 5px;">
                                            <select  id="order_time" name="order_time">
                                                <option value="" disabled selected>- Time -</option>
                                                <option value="am">AM (8:00 - 12:00)</option>
                                                <option value="pm">PM (12:00 - 18:00)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <textarea name="comment" id="comment" placeholder="Notes"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label style="font-size:18px;">Upload images</label>
                                        <div id="gallery-container"></div>
                                    </div>
                                    <div class="form-group" style="text-align:right">
                                        <input type="hidden" id="total_price_input" name="total_price">
                                        <span style="font-size: 20px;">Total</span> <span style="font-size: 20px;" id="total_price">0</span> $
                                    </div>
                                    <div class="form-group" style="text-align:right">
                                        <button type="submit" class="theme-btn btn-style-two"><span class="txt">Order
                                            </span></button>
                                    </div>
                                </div>
                            </form>
                            <!-- End Contact Form -->
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Contact One -->
    @push('css')
    <link href="{!! asset('assets/vendors/dropzone/css/dropzone.css') !!}" media="all" rel="stylesheet" type="text/css" />
    <!-- <link href="{!! asset('assets/vendors/simple-ajax-uploader/SimpleAjaxUploader.css') !!}" media="all" rel="stylesheet" type="text/css" /> -->
    <link href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" rel="stylesheet" crossorigin="anonymous" />
    @endpush
    @push('script')
    <script src="{!! asset('assets/vendors/dropzone/dropzone.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('assets/js/gallery.js?8') !!}" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js" crossorigin="anonymous"></script>
    <!-- <script src="{!! asset('assets/vendors/simple-ajax-uploader/SimpleAjaxUploader.js') !!}" type="text/javascript"></script> -->
    <!-- <script src="{!! asset('assets/js/upload.js') !!}" type="text/javascript"></script> -->
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
            $(function() {
                $('#order_date').daterangepicker({
                    singleDatePicker: true,
                    defaultDate: null,
                    placeholder:'Select a range',
                    autoApply: true,
                    minDate: moment(moment(), "YYYY-MM-DD").add('<?=$miniday; ?>', 'days'),
                    locale: {
                        format: 'YYYY-MM-DD'
                    }
                });

                $('#order_date').val('');
                $('#order_date').attr("placeholder","Date");
            });
            // $(document).ready(function() {
            //     $(".alert").delay(5000).slideUp(300);
            // });
            var gallery = new Gallery;
            gallery.init({
                gallery_id:'{{$galleryId}}',
                _token: '<?=csrf_token(); ?>',
                container: '#gallery-container',
            })
            window.gallery = gallery;
            gallery.load(false);
            function calcTotal(){
                    location_type = $('#location_type').val();
                    if(location_type == 0){
                        return true;
                    }
                    serviceId = $('#service').children('option:selected').val();
                    servicePrice = $('#service').children('option:selected').attr(location_type+'_price');
                    
                    replacementPrice = 0;
                    $('#service_replacementices_container_'+serviceId+' input:checked').each(function() {
                        replacmentId = $(this).attr('item_id')
                        qty = $('#replacement_qty_'+replacmentId).val()
                        price = $('#replacement_qty_'+replacmentId).attr('item_price')

                        subtotal = 0
                        if(price > 0){
                            subtotal = parseInt(qty) * parseInt(price);
                        }
                
                        replacementPrice = parseInt(replacementPrice) + parseInt(subtotal)  
                    });
                    if(replacementPrice > 0){
                        total_price = parseInt(servicePrice) + parseInt(replacementPrice)
                    }else{
                        total_price = servicePrice
                    }
                    $('#total_price').html(total_price);
                    $('#total_price_input').val(parseInt(total_price));
            }
            function checkOther(){
                selectedServiceId = $('#service').children('option:selected').val();
                selectedServiceType = $('#service_type_'+selectedServiceId).val()
                if(selectedServiceType == '-1'){ // other selected
                    $('#service_other_type').show();
                }else{
                    $('#service_other_type').hide();
                }
            }
            $('.replacmentCheckbox').change(function() {
                calcTotal();    
            });
            checkOther();
            $('.service_type').change(function() {
                checkOther();
            });
            $('#service').change(function() {
                let id = $(this).children('option:selected').val();
                $(".service_type_container").hide();
                $("#service_type_container_"+id).show();
                $(".service_replacementices_container").hide();
                $("#service_replacementices_container_"+id).show();
                checkOther();
                calcTotal();
            });
            $('#location_type').change(function() {
                let location_type = $(this).children('option:selected').val();
                $("#service > option").each(function() {
                    if($(this).val() > 0){  
                        title = $(this).attr('title');
                        price = $(this).attr(location_type+"_price");
                        $(this).html(title +" - "+ price +" $")
                    }
                });
                calcTotal();
            });
            $('.replacement_qty').bind('keyup mouseup', function () {
				id = $(this).attr("item_id")
				price = $(this).attr("item_price")
				qty = $(this).val()
                if(qty == 0){
                    qty = 1;
                    $(this).val(1)
                }
                total = price * qty;
                $('#replacement_totle_'+id).html(total)
                calcTotal();
		    });
        });
        $('.owner-form').submit(function(event) {
            event.preventDefault();
            var formData = new FormData(this);
            $('.owner-form .error').remove();

            $.ajax({
                type: 'POST',
                url: "{{ url('/owner-request') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if(response.status == 1){
                        let hash = response.hash;
                        var loc = window.location;
                        window.location = loc.protocol + "//" + loc.hostname + "/checkout/" + hash;
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
    </script>
@endpush    
@endsection
