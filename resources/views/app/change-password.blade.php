@extends('app.layouts.app')
@section('content')
    <section class="service-detail">
        <div class="container">
            <div class="row clearfix">
                @include('components.menu-profile')
                <div class="col-lg-8 col-md-12 col-sm-12">
                    <h2 class="service-detail__title">Change Password</h2>
                    <div class="service-detail__text">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                            <div class="contact-form">
                                @if (Session::has('success'))
                                    <div class="alert alert-success text-center">
                                        <p>{{ Session::get('success') }}</p>
                                    </div>
                                @endif
                                <!-- Contact Form -->
                                <form class="contact-form " method="POST" action="{{ route('changepassword') }}">
                                    @csrf
                                    <div class="row clearfix">
                                        <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                            <input type="password" name="old_password" class="form-control font-cl"
                                                placeholder="Old Password"
                                                @if ($old = old('old_password')) value="{{ $old }}" @endif>
                                            @error('old_password')
                                                <p style="color: red">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                            <input type="password" name="new_password" class="form-control font-cl"
                                                placeholder="New Password"
                                                @if ($old = old('new_password')) value="{{ $old }}" @endif>
                                            @error('new_password')
                                                <p style="color: red">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                            <input type="password" name="confirm_password" class="form-control font-cl"
                                                placeholder="Confirm Password"
                                                @if ($old = old('confirm_password')) value="{{ $old }}" @endif>
                                            @error('confirm_password')
                                                <p style="color: red">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                            <button type="submit" class="theme-btn btn-style-two"><span class="txt">Save
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
@endsection
