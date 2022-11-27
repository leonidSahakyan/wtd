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
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="services-tab" data-toggle="tab" href="#general" role="tab"
                           aria-controls="general" aria-selected="false">General</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="services-tab" data-toggle="tab" href="#Images" role="tab"
                           aria-controls="Images" aria-selected="false">Images</a>
                    </li>
                    <li class="nav-item mr-1" role="presentation" >
                        <a class="nav-link  " id="users-tab" data-toggle="tab" href="#SettingLinks" role="tab"
                           aria-controls="SettingLinks" aria-selected="true">Info</a>
                    </li>
                </ul>
            </div>
            <div class="card m-3 p-1 ">

                <div class="tab-content  ">
                    <div id="general" class="tab-pane active p-3">
                        <div class="form-row col-12 ">

                            <form id="save-Price-form" class="p-3 col-12" method="post">
                                @csrf
                                <div class="form-row ">
                                    <div class="form-group col-md-7">
                                        <label class="small mb-1" for="inputPrice1">Price 1</label>
                                        <input class="form-control" id="inputPrice1" type="number" name="inputPrice1"
                                               placeholder="Price 1" value="{{ $price1 }}" />
                                    </div>
                                    <div class="form-group col-md-7">
                                        <label class="small mb-1" for="inputPrice2">Price 2</label>
                                        <input class="form-control" id="inputPhone" type="number" name="inputPrice2"
                                               placeholder="Price 2" value="{{ $price2 }}"/>
                                    </div>

                                    <div class="form-group col-md-7">
                                        <label class="small mb-1" for="contact_email">contact email</label>
                                        <input class="form-control" id="contact_email" type="text" name="contact_email"
                                               placeholder="Price 2" value="{{ $contact_email }}"/>
                                    </div>

                                    <div class="form-group col-md-7">
                                        <label class="small mb-1" for="min_days">Minimum days before the order</label>
                                        <input class="form-control" id="min_days" type="number" name="min_days"
                                               placeholder="Minimum days before the order" value="{{ $min_days}}"/>
                                    </div>

                                    <div class="form-group col-md-7">
                                        <label class="small mb-1" for=" min_order">Orde daily limit</label>
                                        <input class="form-control" id=" min_order" type="number" name="min_order"
                                               placeholder="Orde daily limit" value="{{ $min_order }}"/>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <button type="button" onclick="priceSave()" id="saveItemBtnPrice" class="btn btn-success float-right">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div id="Images" class="tab-pane p-3">
                        <div class="form-row col-12 ">
                          <!-- <div id="contact" class="container">
                            <form method="POST" action="{{ route('updateimg') }}" enctype="multipart/form-data">
                             @csrf
                             <h1 class="text-center" style="margin-top: 100px">Logo</h1>
                             <img src="{{asset('storage/public/uploadimg/logo.png')}}"  width="300" height="200">
                             <img class="thumbnail" src="{{asset('assets/images/blog/news-1-1.jpg')}}" />
                             <input type="text" style="display: none" name="typeimg" value = "1"/>
                             <input type="file" class="form-control" name="image"/>

                             <button type="submit" class="btn btn-sm">Upload</button>
                            </form>
                            <form method="POST" action="{{ route('updateimg') }}" enctype="multipart/form-data">
                             @csrf
                             <input type="text" style="display: none" name="typeimg" value = "2"/>
                             <input type="file" class="form-control" name="image"/>

                             <button type="submit" class="btn btn-sm">Upload</button>
                            </form>
                          </div> -->

                        </div>
                    </div>
                    <div id="SettingLinks" class="tab-pane   p-3">
                        <form id="save-item-form" class="p-3" method="post">
                            @csrf
                            <div class="form-row ">
                                <div class="form-group col-md-6">
                                    <label class="small mb-1" for="inputEmail">Email</label>
                                    <input class="form-control" id="inputEmail" type="text" name="email"
                                           placeholder="Email" value="{{ $data->email }}" />
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="small mb-1" for="inputPhone">Phone</label>
                                    <input class="form-control" id="inputPhone" type="text" name="phone"
                                           placeholder="Phone" value="{{ $data->phone }}"/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="small mb-1" for="inputAddress">Address</label>
                                    <input class="form-control" id="inputAddress" type="text" name="address"
                                           placeholder="Address" value="{{ $data->address }}" />
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="small mb-1" for="inputFax">Fax</label>
                                    <input class="form-control" id="inputFax" type="text" name="fax"
                                           placeholder="Fax" value="{{ $data->fax }}" />
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="small mb-1" for="inputFacebook">Facebook</label>
                                    <input class="form-control" id="inputFacebook" type="text" name="facebook"
                                           placeholder="Facebook" value="{{ $data->facebook }}"/>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="small mb-1" for="inputTwitter">Twitter</label>
                                    <input class="form-control" id="inputTwitter" type="text" name="twitter"
                                           placeholder="Twitter" value="{{ $data->twitter }}"/>
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

    function priceSave(){
        Loading.add($('#saveItemBtnPrice'));
        let data = $('#save-Price-form').serializeFormJSON();
        console.log(data);
        $.ajax({
            type: "POST",
            url: "{{ route('updateSettingsPrice') }}",
            data: data,
            dataType: 'json',
            success: function(response) {
                if (response.status == 0) {
                    toastr['error'](response.message, 'Error');
                }
                if (response.status == 1) {
                    toastr['success']('Saved.', 'Success');
                }
                Loading.remove($('#saveItemBtnPrice'));
            }
        });
    }
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

