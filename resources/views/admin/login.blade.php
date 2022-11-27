@extends('admin.layouts.guest')
@section('content')

<main>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <!-- Basic login form-->
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header justify-content-center"><h3 class="font-weight-light my-4">Login</h3></div>
                    <div class="card-body">
                        <!-- Login form-->
                        <form  id="admin_login" method="post" action="{{ route('adminLoginPost') }}">
                            <!-- Form Group (email address)-->
                            @csrf
                            <div class="form-group">
                                <label class="small mb-1" for="inputEmailAddress">Username</label>
                                <input class="form-control" name="username" id="inputEmailAddress" type="username" placeholder="Username" />
                            </div>
                            <!-- Form Group (password)-->
                            <div class="form-group">
                                <label class="small mb-1" for="inputPassword">Password</label>
                                <input class="form-control" name="password" id="inputPassword" type="password" placeholder="Enter password" />
                            </div>
                            <!-- Form Group (remember password checkbox)-->
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" id="rememberPasswordCheck" type="checkbox" />
                                    <label class="custom-control-label" for="rememberPasswordCheck">Remember password</label>
                                </div>
                            </div>
                            <!-- Form Group (login box)-->
                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                <a class="btn btn-primary" onclick="document.getElementById('admin_login').submit();" href="#">Login</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@push('script')
<script>
    $(document).keydown(function (e) {
        if (e.which == 13) {
            $('form#admin_login').submit();
            return false;
    }
    });
</script>
@endpush
@endsection