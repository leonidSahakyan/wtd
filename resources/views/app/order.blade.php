@extends('app.layouts.app')
@section('content')
<section class="contact-one">
    <div class="container">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="contact-one__form-box">
                    <h2 class="contact-one__title-two">{{trans('app.order')}}: {{$data->sku}} <label class="float-end">Status: {{$data->status}}</label></h2>
                    <div class="clearfix"></div>
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
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
