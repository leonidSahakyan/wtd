@extends('app.layouts.app')
@section('content')
    <section class="page-title" style="background-image: url(assets/images/background/2.jpg)">
        <div class="container">
            <h1 class="page-main__title">Contact</h1>
            <ul class="page__breadcrumb">
                <li><a href="index.html">home</a></li>
                <li>Contact</li>
            </ul>
        </div>
    </section>
	<div class="contact-one__form-box" id="thank-you">
		<h2 class="contact-one__title-two">{{trans('app.thank_you_title')}}</h2>
		<div class="contact-one__text-two">Request thank you text</div>
	</div>
    <!-- Contact One -->
	<div class="contact-one__form-box" id="request-html">
    <section class="contact-one">
        <div class="container">
            <div class="row clearfix">
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <h2 class="contact-one__title">Feel free to ask questions or share your message with us.</h2>
                    <div class="contact-one__text">You can also reach out to us by phone or email are many
                        variations</div>
                    <ul class="contact-one__info">
                        <li>
                            <span class="icon icon-location"></span>
                            Address
                            <p>Boat House 2/21 City Road <br> Hoxton, N1 6NG, UK</p>
                        </li>
                        <li>
                            <span class="icon icon-phone"></span>
                            Phone
                            <p>+8801682648101 <br> Fax : 02 9292162</p>
                        </li>
                        <li>
                            <span class="icon icon-email"></span>
                            Email Address
                            <p>Info24@gmail.com <br> Support24@gmail.com</p>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-8 col-md-12 col-sm-12">
                    <div class="contact-one__form-box">
                        <h2 class="contact-one__title-two">Send Us Message</h2>
                        <div class="contact-one__text-two">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            Ut <br> blandit arcu in pretium ratione voluptatem sequi</div>
                        <!-- Contact Form -->
                        <div class="contact-form">
                            <!-- Contact Form -->
                            <form method="post"  id="contact-form" >
								@csrf
                                <div class="row clearfix">
                                    <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                        <input type="text" require name="name" placeholder="Full Name">
                                    </div>

                                    <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                        <input type="email" name="email" placeholder="Email Address">
                                    </div>

                                    <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                        <input type="text" name="phone" placeholder="Phone">
                                    </div>

                                    <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                        <input type="text" name="subject" placeholder="Subject">
                                    </div>

                                    <div class="form-group">
                                        <textarea name="message" placeholder="Your Message Here"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="theme-btn btn-style-two"><span class="txt">Send
                                                Message</span></button>
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
	</div>
    <!-- End Contact One -->

    <!-- Contact Map -->
    <section class="contact-map">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d805184.6331292129!2d144.49266890254142!3d-37.97123689954809!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad646b5d2ba4df7%3A0x4045675218ccd90!2sMelbourne%20VIC%2C%20Australia!5e0!3m2!1sen!2s!4v1574408946759!5m2!1sen!2s"
            allowfullscreen=""></iframe>
    </section>
    <!-- End Contact Map -->
	@push('script')
    <script>
        $('#contact-form').submit(function(event) {
            event.preventDefault();
            var formData = new FormData(this);
            $('.owner-form .error').remove();
            $.ajax({
                type: 'POST',
                url: "{{ url('/contact-request') }}",
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
                    if (response.responseJSON.errors) {
                        errors = response.responseJSON.errors
                        $.each(errors, function(key, value) {
                            if ($("#" + key).length > 0) {
                                $("#" + key).after('<label class="error">' + value +
                                '</label>');
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
