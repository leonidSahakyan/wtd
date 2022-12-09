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
                            Settings
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container mt-n10">
        <div class="card" >
            <div class="card-header border">
                <ul class="nav nav-tabs card-header-tabs " id="dashboardNav" role="tablist">
                    <li class="nav-item mr-1" role="presentation" >
                        <a class="nav-link active" id="users-tab" data-toggle="tab" href="#settings" role="tab"
                           aria-controls="settings" aria-selected="true">Info</a>
                    </li>
                </ul>
            </div>
            <div class="card m-3 p-1 ">
                <div class="tab-content">
                    <div id="settings" class="tab-pane active p-3">
                        <form id="save-item-form" class="p-3" method="post">
                            @csrf
                            <div class="form-row ">
                                <div class="form-group col-md-6">
                                    <label class="small mb-1" for="inputEmail">Email</label>
                                    <input class="form-control" id="inputEmail" type="text" name="email"
                                           placeholder="Email" value="{{ @$data->email }}" />
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="small mb-1" for="inputPhone">Phone</label>
                                    <input class="form-control" id="inputPhone" type="text" name="phone"
                                           placeholder="Phone" value="{{ @$data->phone }}"/>
                                </div>
                                <!-- <div class="form-group col-md-6">
                                    <label class="small mb-1" for="inputAddress">Address</label>
                                    <input class="form-control" id="inputAddress" type="text" name="address"
                                           placeholder="Address" value="{{ @$data->address }}" />
                                </div> -->
                                <div class="form-group col-md-6">
                                    <label class="small mb-1" for="inputFacebook">Facebook</label>
                                    <input class="form-control" id="inputFacebook" type="text" name="facebook"
                                           placeholder="Facebook" value="{{ @$data->facebook }}"/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="small mb-1" for="inputInstagram">Instagram</label>
                                    <input class="form-control" id="inputInstagram" type="text" name="instagram"
                                           placeholder="Instagram" value="{{ @$data->instagram }}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="button" onclick="save()" id="saveItemBtn" class="btn btn-success float-right">Save</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>

<script>
    function save() {
        Loading.add($('#saveItemBtn'));
        var data = $('#save-item-form').serializeFormJSON();
        $.ajax({
            type: "POST",
            url: "{{ route('updateSettings') }}",
            data: data,
            dataType: 'json',
            success: function(response) {
                if (response.status == 0) {
                    toastr['error'](response.message, 'Error');
                }
                if (response.status == 1) {
                    toastr['success']('Saved.', 'Success');
                }
                Loading.remove($('#saveItemBtn'));
            }
        });
    }
</script>
@endsection

