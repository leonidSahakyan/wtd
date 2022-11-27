@extends('app.layouts.app')
@section('content')

    @if (!Auth::user())
        <div class="row  col-lg-12">
            <div class="form-group col-lg-1"></div>
            <div class="form-group col-lg-4">
                <div class="contact-one__form-box">
                    <h2 class="contact-one__title-two reg-form-text">Signin</h2>
                    <div class="contact-one__text-two">
                    </div>
                    <div class="contact-form">
                        <!-- Contact Form -->
                        <form class="contact-form login-form-data">
                            @csrf
                            <div class="row clearfix">
                                <div class="form-group">
                                    <input type="email" id="email-login" name="email" placeholder="Email Address">
                                    <label for="name" id="emailLogMsg" class="error"></label>
                                </div>
                                <div class="form-group">
                                    <input type="password" id="password-login" name="password" placeholder="Password">
                                    <label for="name" id="passLogMsg" class="error"></label>
                                </div>
                                <?php /* 
                                <div  class="form-group">
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div> */ ?>
                                <div class="form-group text-right">
                                    <button type="submit" class="theme-btn btn-style-two"><span class="txt">Sign in
                                        </span></button>
                                </div>
                            </div>
                        </form>
                        <!-- End Contact Form -->
                    </div>

                </div>
            </div>
            <div class="form-group col-lg-6 ">
                <div class="contact-one__form-box">
                    <h2 class="contact-one__title-two reg-form-text">Signup</h2>
                    <div class="contact-one__text-two">
                    </div>
                    <div class="contact-form">
                        <!-- Contact Form -->
                        <form class="contact-form register-form">
                            @csrf
                            <div class="row clearfix">
                                <div class="form-group col-lg-6 col-md-6">
                                    <input type="text" id="first_name" name="first_name" placeholder="First Name">
                                    <label for="name" id="firstnameMsg" class="error"></label>

                                </div>
                                <div class="form-group col-lg-6 col-md-6 ">
                                    <input type="text" id="last_name" name="last_name" placeholder="Last Name">
                                    <label for="name" id="lastnameMsg" class="error"></label>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 ">
                                    <input type="text" id="address" name="address" placeholder="Address">
                                    <label for="name" id="addressMsg" class="error"></label>

                                </div>
                                <div class="form-group col-lg-6 col-md-6 ">
                                    <input type="email" id="email" name="email" placeholder="Email Address">
                                    <label for="name" id="emailMsg" class="error"></label>
                                </div>

                                <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                    <input type="tel" id="phone" name="phone" placeholder="Phone">
                                    <label for="name" id="phoneMsg" class="error"></label>
                                </div>

                                <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                    <input type="text" id="company" name="company" placeholder="Company Name">
                                    <label for="name" id="companyMsg" class="error"></label>
                                </div>

                                <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                    <input type="password" id="password" name="password" placeholder="Password">
                                    <label for="name" id="passwordMsg" class="error"></label>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                    <input type="number" id="licanece_number" name="licanece_number"
                                        placeholder="Licanece Number">
                                    <label for="name" id="licaneceMsg" class="error"></label>
                                </div>
                                <div class="form-group text-right">
                                    <button type="submit" class="theme-btn btn-style-two"><span class="txt">Sign up
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </form>
                        <!-- End Contact Form -->
                    </div>

                </div>
            </div>
        </div>
    @else
        <section class="service-detail">
            <div class="container">
                <div class="row clearfix">
                    @include('components.menu-profile')
                    <div class="col-lg-8 col-md-12 col-sm-12">
                        <h2 class="service-detail__title">Personal Information</h2>
                        <div class="service-detail__text">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <div class="contact-form">
                                    @if (Session::has('success'))
                                        <div class="alert alert-success text-center">
                                            <p>{{ Session::get('success') }}</p>
                                        </div>
                                    @endif
                                    <!-- Contact Form -->
                                    <form class="contact-form " method="POST" action="{{ route('saveProfile') }}">
                                        @csrf
                                        <div class="row clearfix">
                                            <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                                <input type="text" id="first_name" name="first_name"
                                                    value="{{ Auth::user()->first_name }}" placeholder="First Name">
                                                <label for="name" id="firstnameMsg" class="error"></label>
                                            </div>
                                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                                <input type="text" id="last_name" name="last_name"
                                                    value="{{ Auth::user()->last_name }}" placeholder="Last Name">
                                                <label for="name" id="lastnameMsg" class="error"></label>
                                            </div>
                                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                                <input type="text" id="address"
                                                    name="address"value="{{ Auth::user()->address }}"
                                                    placeholder="Address">
                                                <label for="name" id="addressMsg" class="error"></label>

                                            </div>
                                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                                <input type="email" id="email"
                                                    name="email"value="{{ Auth::user()->email }}"
                                                    placeholder="Email Address">
                                                <label for="name" id="emailMsg" class="error"></label>
                                            </div>
                                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                                <input type="tel" id="phone" name="phone" placeholder="Phone"
                                                    value="{{ Auth::user()->phone }}">
                                                <label for="name" id="phoneMsg" class="error"></label>
                                            </div>
                                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                                <input type="text" id="company"
                                                    name="company"value="{{ Auth::user()->company }}"
                                                    placeholder="Company Name">
                                                <label for="name" id="companyMsg" class="error"></label>
                                            </div>
                                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                                <input type="number" id="licanece_number"
                                                    name="licanece_number"value="{{ Auth::user()->licanece_number }}"
                                                    placeholder="Licanece Number">
                                                <label for="name" id="licaneceMsg" class="error"></label>
                                            </div>
                                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                                <button type="submit" class="theme-btn btn-style-two"><span
                                                        class="txt">Save
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- End Contact Form -->
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Service Detail -->
    @endif
    @push('script')
    <script>
        $(document).ready(function(e) {
            $('.register-form').submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                let email = $('#email').val();
                let password = $('#password').val();
                let last_name = $('#last_name').val();
                let first_name = $('#first_name').val();
                let phone = $('#phone').val();
                let company = $('#company').val();
                let licanece_number = $('#licanece_number').val();
                let address = $('#address').val();

                formData.append('email', email);
                formData.append('last_name', last_name);
                formData.append('first_name', first_name);
                formData.append('phone', phone);
                formData.append('password', password);
                formData.append('company', company);
                formData.append('licanece_number', licanece_number);
                formData.append('address', address);
                $('#email').keypress(function(e) {
                    $('#emailMsg').hide();
                });
                $('#password').keypress(function(e) {
                    $('#passwordMsg').hide();
                });
                $('#phone').keypress(function(e) {
                    $('#phoneMsg').hide();
                });
                $('#last_name').keypress(function(e) {
                    $('#lastnameMsg').hide();
                });
                $('#first_name').keypress(function(e) {
                    $('#firstnameMsg').hide();
                });
                $('#address').keypress(function(e) {
                    $('#addressMsg').hide();
                });
                $('#company').keypress(function(e) {
                    $('#companyMsg').hide();
                });
                $('#licanece_number').keypress(function(e) {
                    $('#licaneceMsg').hide();
                });

                $.ajax({
                    type: 'POST',
                    url: "{{ url('signup') }}",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        location.reload();
                    },
                    error: function(response) {
                        $('#emailMsg').text(response.responseJSON.errors.email);
                        $('#passwordMsg').text(response.responseJSON.errors.password);
                        $('#phoneMsg').text(response.responseJSON.errors.phone);
                        $('#lastnameMsg').text(response.responseJSON.errors.last_name);
                        $('#firstnameMsg').text(response.responseJSON.errors.first_name);
                        $('#addressMsg').text(response.responseJSON.errors.address);
                        $('#companyMsg').text(response.responseJSON.errors.company);
                        $('#licaneceMsg').text(response.responseJSON.errors.licanece_number);
                    }
                });

            });
        });
        $('.login-form-data').submit(function(event) {
            event.preventDefault();
            var formData = new FormData(this);
            let email = $('#email-login').val();
            let password = $('#password-login').val();
            formData.append('email', email);
            formData.append('password', password);
            $.ajax({
                type: 'POST',
                url: "{{ url('signin') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    location.reload();
                },
                error: function(response) {
                    console.log(response.responseJSON.errors);
                    $('#emailLogMsg').text(response.responseJSON.errors.email);
                    $('#passLogMsg').text(response.responseJSON.errors.password);
                }
            });
        });
    </script>
    @endpush
@endsection
