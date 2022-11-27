@extends('app.layouts.app')
@section('content')
<section class="contact-one">
    <div class="container">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="contact-one__form-box">
                    <h2 class="contact-one__title-two">{{trans('app.checkout')}}</h2>
                    @if ($data)
                    <input type="hidden" name="hash" id="order_hash" value="{{ $data->hash }}">
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
                                <label for="locationType">Location type</label>
                                <input type="text" style="text-transform: capitalize;"  disabled value="{{ $data->second_type }}">
                                <label>Date</label>
                                <input disabled type="text" value="{{ $data->order_date }} {{$data->order_time == 'am' ? 'AM (8:00 - 12:00)' : 'PM (12:00 - 18:00)' }}">
                                <div class="pricing_container">
                                    <label style="margin-bottom:5px;">Service</label>
                                    <div class="checkout_item"><span>{{ $data->title }}<br>Type: {{$data->service_type ? $data->service_type_title : '(other) '.$data->service_type_other }}</span> <span class="price_sub">{{ $data->service_price }}  $</span></div>
                                    <div class="hr"></div>
                                    @if(count($orderReplacement) > 0)
                                        <label style="margin-bottom:5px;">Replacment(s)</label>
                                        @foreach($orderReplacement as $replacment)
                                            @if($replacment->price > 0)
                                                <div class="checkout_item">{{ $replacment->title }} (Qty: {{ $replacment->qty }}) - {{ $replacment->price }}$ <span class="price_sub">{{ $replacment->qty * $replacment->price}} $</span></div>
                                            @else
                                                <div class="checkout_item">{{ $replacment->title }}</div>
                                            @endif
                                        @endforeach
                                        <div class="hr"></div>
                                    @endif
                                    <div class="checkout_total">Total <span class="price_sub">{{ $data->total }} $</span></div>
                                </div>
                            </div>
                            <i class="fab fa-servicestack"></i>
                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                <form action="#" id="stirpe_form" method="GET">
                                    <button class="stripe-buy-now-button" type="submit">
                                        <span>Buy now with</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="90" height="30"
                                            viewBox="5.322 20.344 440.334 180.144">
                                            <path fill="#359ad5"
                                                d="M406.487 86.49c-8.87 0-7.944 10.902-8.312 22.541h14.779c0-13.119 0-22.541-6.467-22.541zm-8.312 41.572c0 10.53 5.172 12.562 13.856 12.562 9.978 0 23.463-2.958 28.637-3.881v25.499c-4.063 1.479-16.442 4.986-28.637 4.986-21.987 0-48.78-3.51-48.78-50.438 0-41.387 21.064-51.179 43.235-51.179 22.727 0 39.17 11.64 39.17 50.809v11.642h-47.481zm-86.669-36.584c-2.03 0-6.096 1.663-8.312 2.958v47.296c1.661.557 4.618.926 5.912.926 6.098 0 9.793-5.174 9.793-26.79-.002-21.988-1.666-24.39-7.393-24.39zm4.064 75.752c-4.434 0-9.053-1.293-12.378-2.033v35.29h-35.105V67.459h28.452l5.175 6.097c5.357-4.803 12.934-7.945 20.878-7.945 14.41 0 31.408 4.064 31.408 50.254 0 50.628-25.496 51.365-38.43 51.365zM235.747 55.45c-9.791 0-17.366-7.945-17.366-17.553s7.575-17.553 17.366-17.553c9.794 0 17.369 7.945 17.369 17.553s-7.575 17.553-17.369 17.553zm-17.551 109.933V67.459h35.105v97.924h-35.105zM196.94 94.989c-5.543 0-9.793 2.218-11.641 3.326v67.068h-35.104V67.459h27.899l5.173 9.422c2.032-6.097 7.575-11.271 15.705-11.271 5.543 0 9.238 1.109 10.899 2.032v29.191c-3.51-.921-8.128-1.844-12.931-1.844zm-66.707 45.636c2.217 0 9.978-1.107 12.562-1.479v24.943c-5.356 1.292-17.182 3.141-24.941 3.141-9.978 0-28.638-1.107-28.638-28.267V89.816H76.283V67.459h12.935l4.434-22.171 30.67-7.39V67.46h18.476l-4.618 22.357h-13.857v42.865c-.002 6.649 2.03 7.943 5.91 7.943zM39.505 95.728c0 3.88 2.588 5.173 8.684 7.944l3.696 1.664c8.683 3.88 20.691 10.162 20.691 28.639 0 29.561-21.987 33.256-37.691 33.256-10.162 0-20.878-2.402-28.084-4.617V137.3c6.281 1.666 17.184 4.249 21.986 4.249 5.358 0 9.423-.737 9.423-5.542 0-3.695-2.587-5.357-8.314-7.943l-4.435-2.033c-8.313-3.881-20.139-10.53-20.139-28.453 0-26.237 20.508-31.963 37.692-31.963 12.934 0 21.433 2.955 25.866 4.619v24.573c-5.174-1.662-15.703-3.88-21.985-3.88-4.249-.002-7.39 1.105-7.39 4.801z" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                <div id="paypal-button-container"></div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@push('script')
    <script type="text/javascript" src="https://js.stripe.com/v3/"></script>
    <script src="https://www.paypal.com/sdk/js?client-id=AQmvhyfqxnYiOZLjz0y6FXi2nJyCPo3-wqhcWoiqn2rnHPDRziQr39IbKBOYU6BTRnlZvLVDUElGf0ec&currency=USD"></script>
    <script>
        let hash = $('#order_hash').val();
        // Render the PayPal button into #paypal-button-container
        paypal.Buttons({

            // Call your server to set up the transaction
            createOrder: function(data, actions) {
                return fetch('{{ route("processToCheckout") }}', {
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    method: 'post',
                    body:JSON.stringify({_token:"<?php echo csrf_token(); ?>", hash:hash,method:'paypal'}),
                }).then(function(res) {
                    console.log(res)
                    return res.json();
                }).then(function(orderData) {
                    return orderData.id;
                });
            },

            // Call your server to finalize the transaction
            onApprove: function(data, actions) {//data.orderID
                return fetch('{{ route("paypal-handler") }}', {
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    method: 'post',
                    body:JSON.stringify({_token:"<?php echo csrf_token(); ?>", orderId:data.orderID}),
                }).then(function(res) {
                    return res.json();
                }).then(function(orderData) {
                    // Three cases to handle:
                    //   (1) Recoverable INSTRUMENT_DECLINED -> call actions.restart()
                    //   (2) Other non-recoverable errors -> Show a failure message
                    //   (3) Successful transaction -> Show confirmation or thank you

                    // This example reads a v2/checkout/orders capture response, propagated from the server
                    // You could use a different API or structure for your 'orderData'
                    var errorDetail = Array.isArray(orderData.details) && orderData.details[0];

                    if (errorDetail && errorDetail.issue === 'INSTRUMENT_DECLINED') {
                        return actions.restart();
                    }

                    if (errorDetail) {
                        var msg = 'Sorry, your transaction could not be processed.';
                        if (errorDetail.description) msg += '\n\n' + errorDetail.description;
                        if (orderData.debug_id) msg += ' (' + orderData.debug_id + ')';
                        return alert(msg); // Show a failure message (try to avoid alerts in production environments)
                    }

                    // Successful capture! For demo purposes:
                    console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                    var transaction = orderData.purchase_units[0].payments.captures[0];
                    alert('Transaction '+ transaction.status + ': ' + transaction.id + '\n\nSee console for all available details');

                    // Replace the above to show a success message within this page, e.g.
                    // const element = document.getElementById('paypal-button-container');
                    // element.innerHTML = '';
                    // element.innerHTML = '<h3>Thank you for your payment!</h3>';
                    // Or go to another URL:  actions.redirect('thank_you.html');
                });
            }

        }).render('#paypal-button-container');
    </script>
    <script>
    $('#stirpe_form').submit(function(event) {
        event.preventDefault();
        var stripe = Stripe("pk_test_M0zTJ0d4Wo2OSKkqHglDQ4Pv");
        $.ajax({
            type: 'POST',
            url: "{{ route('processToCheckout') }}",
            dataType: 'JSON',
            data:{_token:"<?php echo csrf_token(); ?>", hash:hash,method:'stripe'},
            success: function(response) {
                if(response.status == 1){
                        return stripe.redirectToCheckout({ sessionId: response.redirect_url });
                }else{
                    console.log(response);
                    alert(response.message);
                }
            },
            error: function(response) {
                alert("something wrong pls try again");
            }
        });
    });
</script>
@endpush
@endsection
