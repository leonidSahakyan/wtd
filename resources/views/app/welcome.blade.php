@extends('app.layouts.app')
@section('content')
    <!--Main Slider Start-->
    <section class="main-slider clearfix">
        <div class="swiper-container thm-swiper__slider"
            data-swiper-options='{"slidesPerView": 1, "loop": true,
			"effect": "fade",
			"pagination": {
			"el": "#main-slider-pagination",
			"type": "bullets",
			"clickable": true
			},
			"navigation": {
			"nextEl": "#main-slider__swiper-button-next",
			"prevEl": "#main-slider__swiper-button-prev"
			},
			"autoplay": {
			"delay": 5000
			}}'>
            <div class="swiper-wrapper" id="slider_z1">
                @foreach ($slider as $item)
                    <div class="swiper-slide">
                        <div class="image-layer" style="background-image: url('{{asset('images/homeslider/'.$item->image_file_name)}}"></div>
                        <div class="container">
                            <div class="main-slider__inner">
                                <div class="row">
                                    <div class="col-xl-7 col-lg-7">
                                        <div class="main-slider__content-right">
                                            <div class="main-slider__sub-title-box">
                                                <div class="main-slider__sub-title-icon">
                                                    <img src="assets/images/icons/icon-1.png" alt="">
                                                </div>
                                                <p class="main-slider__sub-title">{{ $item->title }}</p>
                                            </div>
                                            <h3 class="main-slider__title">{{ $item->description }}</h3>
                                            <div class="main-slider__btn-box">
                                                <a href="{{ $item->link }}" class="theme-btn btn-style-two"
                                                    @if ($item->linktype == 0) target="_blank" @else @endif><span
                                                        class="txt">{{ $item->namebutton }}</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- If we need navigation buttons -->
            <div class="main-slider__nav">
                <div class="swiper-button-prev" id="main-slider__swiper-button-next">
                    <i class="icon-left-arrow-2"></i>
                </div>
                <div class="swiper-button-next" id="main-slider__swiper-button-prev">
                    <i class="icon-right-arrow-2"></i>
                </div>
            </div>

        </div>
    </section>
    <!--Main Slider End-->
    <!-- News One -->
    <section class="news-one">
        <div class="container">
            <!-- Section Title -->
            @if (count($services) >0)
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
                                <!-- <h3 class="service-three__text text-services">{{ $service->title }}</h3> -->
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="form-group" style="text-align:right">
                    <a href="{{ url('all-services') }}" class="theme-btn btn-style-two"><span class="txt">View All
                        </span></a>
                </div>
            </div>
            @endif
        </div>
    </section>
    <!-- End News One -->

    <!-- Faq One -->
    <section class="faq-one" id="faq">
        <div class="container">
            <div class="faq-one__inner-container">
                <div class="row clearfix">

                    <!-- Faq One Image Column -->
                    <div class="faq-one__image-column col-lg-6 col-md-12 col-sm-12">
                        <div class="faq-one__image wow slideInLeft" data-wow-delay="100ms" data-wow-duration="2500ms">
                            <img src="assets/images/resource/faq.jpg" alt="" />
                        </div>
                    </div>

                    <!-- Faq One Accordion Column -->
                    <div class="faq-one__accordion-column col-lg-6 col-md-12 col-sm-12">
                        <div class="faq-one__accordion-column-inner">
                            <!-- Section Title -->
                            <div class="section-title">
                                <h2 class="section-title__title">Have Any Questions?</h2>
                            </div>

                            <ul class="faq-one__accordion">

                                <!-- Block -->
                                @for ($i = 0; $i < count($faq); $i++)
                                    @if ($i == 0)
                                        <li class="faq-accordion__toggle faq-one__block active-block">
                                            <div class="faq-one__acc-btn active">
                                                {{ $faq[$i]->question }}
                                                <div class="faq-one__icon icon-add"></div>
                                                <div class="faq-one__icon-two icon-remove"></div>
                                            </div>
                                            <div class="faq-one-acc__content current">
                                                <div class="faq-one__content">
                                                    <div class="faq-one__text">
                                                        {{ $faq[$i]->answer }}
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                    @if ($i != 0)
                                        <li class="faq-accordion__toggle faq-one__block">
                                            <div class="faq-one__acc-btn">
                                                {{ $faq[$i]->question }}
                                                <div class="faq-one__icon icon-add"></div>
                                                <div class="faq-one__icon-two icon-remove"></div>
                                            </div>
                                            <div class="faq-one-acc__content">
                                                <div class="faq-one__content">
                                                    <div class="faq-one__text">
                                                        {{ $faq[$i]->answer }}
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                @endfor

                            </ul>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- End Faq One -->
@endsection
