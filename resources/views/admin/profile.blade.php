@extends('admin.layouts.app')
@section('content')
<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="settings"></i></div>
                        Profile
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container mt-n10">
        <div class="card">
            <div class="card-header"></div>
            <div class="card-body">
            <div class="row">
                <div class="col-lg-6">
                    <!-- Basic Card Example -->
                    <form class="user" id="profile-form" method="post">
                        @csrf
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Personal info</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="col-md-4">First name:</label>
                                    <div class="col-md-8">
                                        <input type="text" id="admin_name" name="name" value="{{auth()->guard('admin')->user()->name}}" class="form-control">
                                    </div>
                                </div>  
                                <div class="form-group">
                                    <label class="col-md-4">Last name:</label>
                                    <div class="col-md-8">
                                        <input type="text" name="last_name" value="{{auth()->guard('admin')->user()->last_name}}" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4">Email:</label>
                                    <div class="col-md-8">
                                        <input type="email" name="email" value="{{auth()->guard('admin')->user()->email}}" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4">Phone:</label>
                                    <div class="col-md-8">
                                        <input type="text" name="phone" value="{{auth()->guard('admin')->user()->phone}}" class="form-control">
                                    </div>
                                </div>
                                <div class="my-2"></div>
                                <div class="form-group float-right">
                                    <a href="#" onclick="saveProfile()" id="saveProfile" class="btn btn-success">
                                        <span class="text">Save</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-6">
                    <!-- Basic Card Example -->
                    <form class="user" id="password-form" method="post">
                        @csrf
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Password</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="col-md-4">Current password:</label>
                                    <div class="col-md-8">
                                        <input type="password" name="current_password" value="" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4">New password:</label>
                                    <div class="col-md-8">
                                        <input type="password" name="new_password" value="" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4">Re-type new password:</label>
                                    <div class="col-md-8">
                                        <input type="password" name="new_password_re" value="" class="form-control">
                                    </div>
                                </div>
                                <div class="my-2"></div>
                                <div class="form-group float-right">
                                    <a href="#" onclick="changePassword()" id="changePassword" class="btn btn-success">
                                        <span class="text">Save</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
function saveProfile(){
	var data = $('#profile-form').serializeFormJSON();
    Loading.add($('#saveProfile'));

	$.ajax({
        type: "POST",
        url: "{{route('adminSaveProfile')}}",
        data: data,
        dataType: 'json',
        success: function(response){
            if(response.status == 0){
                toastr['error'](response.message, 'Error');
            }
            if(response.status == 1){
                $('.admin_name_lbl').html(response.username);
                toastr['success']('Saved.', 'Success');
            }
            Loading.remove($('#saveProfile'));
        }
    });
}
function changePassword(){
	var data = $('#password-form').serializeFormJSON();
    // Loading.add($('#changePassword'));

	$.ajax({
        type: "POST",
        url: "{{route('adminChangePassword')}}",
        data: data,
        dataType: 'json',
        success: function(response){
            if(response.status == 0){
                toastr['error'](response.message, 'Error');
            }
            if(response.status == 1){
                toastr['success']('Saved.', 'Success');
            }
            Loading.remove($('#changePassword'));
        }
    });
}
</script>
@endsection