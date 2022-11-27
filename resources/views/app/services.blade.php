@extends('app.layouts.app')
@section('content')
    <!-- Service Three -->
    @if ($services)
    <section class="news-one">
        <div class="container">
            <!-- Section Title -->
            <div class="section-title centered">
                <h2 class="section-title__title">Services</h2>
                <div class="section-title__text">@lang('app.services_description')</div>
            </div>
            <div class="row clearfix">
                <!-- News One Single -->
                @foreach ($services as $service)
                    <div class="news-one__single col-lg-4 col-md-6 col-sm-12">
                        <div class="news-one__single-inner wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms">
                            <div class="news-one__img">
                                <img src="{{asset('images/services/'.$service->image_file_name)}}" alt="">
                            </div>
                            <div class="news-one__content">
                                <h2>{{ $service->title }}</h2>
                                <h3 class="service-three__text text-services">{{ $service->description }}</h3>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
    <!-- End News One -->
    <!-- End Service Three -->
@endsection
