@extends('app.layouts.app')
@section('content')
<section class="contact-one">
    <div class="container">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="contact-one__form-box">
                    <h2 class="contact-one__title-two">{{trans('app.maintenance_sign_title')}}</h2>
                    @if ($data)
                    <div class="contact-form checkout-page">
                        <div class="row clearfix">
                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                <label for="fname">First Name</label>
                                <input type="text" disabled id="fname" value="{{ $data->first_name }}">
                                <label for="fname">Last Name</label>
                                <input type="text" disabled id="fname" value="{{ $data->last_name }}">
                                <label for="phone"></i>Phone</label>
                                <input type="text" disabled value="{{ $data->phone }}">
                                <label for="email"></i>Email</label>
                                <input type="text" disabled value="{{ $data->email }}">
                                <label for="city">Address</label>
                                <input type="text" disabled value="{{ $data->address }}">
                                <!-- <label for="fnotes">Notes</label>
                                <textarea name="comment" disabled id="comment" placeholder="Notes">{{ $data->comment }}</textarea> -->
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                <label for="city">System type</label>
                                <input type="text" disabled value="{{ $data->system_type }}">
                                <label for="city">Company name</label>
                                <input type="text" disabled value="{{ $data->company_name }}">
                                @if($data->website)
                                <label for="city">Website</label>
                                <input type="text" disabled value="{{ $data->website }}">
                                @endif
                                <label for="locationType">Location type</label>
                                <input type="text" style="text-transform: capitalize;"  disabled value="{{ $data->second_type }}">
                                <div class="pricing_container">
                                    <label style="margin-bottom:5px;">Service</label>
                                    <div class="checkout_item"><span>Maintenance {{ $data->price }} $  - {{ $data->years }} year(s)</span> <span class="price_sub">{{ $data->total }}  $</span></div>
                                    <div class="hr"></div>
                                    <div class="checkout_total">Total <span class="price_sub">{{ $data->total }} $</span></div>
                                </div>
                            </div>
                            <div class="hr"></div>
                            <form id="sign-form">
                                <input type="hidden" name="hash" id="maintenance_hash" value="{{ $data->hash }}">
                                @csrf
                                <div id="sign_cont" class="form-group col-lg-6 col-md-6 col-sm-12">
                                    <h2 class="contact-one__title-two" style="margin-top:20px;">{{trans('app.sign_title')}}</h2>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="agree" id="agreeChecked" >
                                        <label class="form-check-label" for="agreeChecked" style="margin-top: 0;">
                                            "I Agree" Checkboxe for Privacy Policies and Terms and Conditions Agreements
                                        </label>
                                    </div>
                                    <canvas style="border: 1px solid rgb(0, 0, 0); touch-action: none;"></canvas>
                                    <div class="clearfix float-none"></div>
                                    <span id="clear" class="float-end btn-sm btn-info" style="cursor:pointer;">Clear</span>
                                    <div class="clearfix float-none"></div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="theme-btn btn-style-two float-end"><span class="txt">Next</span></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@push('css')
    
@endpush
@push('script')
<script src="{{ asset('assets/js/signature_pad.min.js') }}"></script>
<script>
    $(document).ready(function(e) {
    const canvas = document.querySelector("canvas");
    const signaturePad = new SignaturePad(canvas);
    canvas.width = $("#sign_cont").width();
    signaturePad.clear();
    function resizeCanvas() {
        canvas.width = $("#sign_cont").width();
    }
    window.addEventListener("resize", resizeCanvas);
    resizeCanvas();
    
    // signaturePad.backgroundColor = '#fff';
    signaturePad.off();
    window.signaturePad = signaturePad;

    $('#agreeChecked').click(function() {
        if($(this).is(':checked')){
            window.signaturePad.on(); 
        }else{
            window.signaturePad.off();
        }
    });
    $('#clear').click(function() {
        window.signaturePad.clear();
    });
});
    // $(".size_large").each(function( index, element ) {
    //     new SignaturePad(element, {
    // // It's Necessary to use an opaque color when saving image as JPEG;
    // // this option can be omitted if only saving as PNG or SVG
    //     backgroundColor: 'rgb(255, 255, 255)'
    // });})

    // new SignaturePad($('#signature'), {
    // // It's Necessary to use an opaque color when saving image as JPEG;
    // // this option can be omitted if only saving as PNG or SVG
    //     backgroundColor: 'rgb(255, 255, 255)'
    // });
    // let SignaturePad = new SignaturePad($('#signature'));

    // var signature = $('#signature').signature();
    // $('#signature canvas').draggable();
    // signature.signature('disable');


    $('#sign-form').submit(function(event) {
        event.preventDefault()
        $('#sign-form .error').remove()

        let hash = $('#maintenance_hash').val()
        let agree = $('#agreeChecked').is(':checked')
        if(!agree){
            alert('Please check "I Agree" checkbox.')
            return
        }
        let isEmpty = window.signaturePad.isEmpty();
        if(isEmpty){
            alert('Please sign contract before next');
            return
        }
        console.log(window.signaturePad.toDataURL());
        return;
        alert('comming soon');
        return
        // let firstName = $('#first-name').val();
        // formData.append('email', firstName);
        
        $.ajax({
            type: 'POST',
            url: "{{ route('maintenanceSubmit') }}",
            data:{_token:"<?php echo csrf_token(); ?>", hash:hash,method:'stripe'},
            dataType: 'json',
            success: function(response) {
                if(response.status == 1){
                    let hash = response.hash;
                    var loc = window.location;
                    window.location = loc.protocol + "//" + loc.hostname + "/maintenance/sign/" + hash;
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

    $('#saveSign').click(function(e) {
        Loading.add($('#png'));
        var sign = sig.signature('toDataURL');
        $('#savePngData').val(sign);
        var data = $('#savePng').serializeFormJSON();
        console.log(data);
        $.ajax({
            type: "POST",
            url: "{{ route('signImg') }}",
            data: data,
            dataType: 'json',
            success: function(response) {
                if (response.success.status === 0) {
                    // toastr['error'](response.message, 'Error');
                    alert('Error')
                }
                if (response.success.status === 1) {
                    alert('Saved.', 'Success');
                    $('#pdfSign').val(response.success.signPath);


                }
                if(response.success.status){
                    console.log("hi")
                }

                Loading.remove($('#png'));
            }
        });
    });
</script>
@endpush
@endsection
