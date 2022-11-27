<script type="text/javascript">
    if (typeof(itemPopup) != "undefined") {
        Loading.remove($('#add_item'));
    }
</script>
<style>
.fade:not(.show) {
    opacity: 0;
    display: none;
}
</style>
<!-- Main page content-->
<div class="row">
    <div class="col-xxl-12">
        <div class="card mb-4">
            <div class="card-header border-bottom">
                <ul class="nav nav-tabs card-header-tabs" id="dashboardNav" role="tablist">
                    <li class="nav-item mr-1" role="presentation">
                        <a class="nav-link @if(!$page)active @endif" id="users-tab" data-toggle="tab" href="#users" role="tab"
                            aria-controls="users" aria-selected="@if(!$page) true @else false @endif">Main</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="dashboardNavContent">
                    <div class="tab-pane fade @if(!$page)show active @endif" id="users" role="tabpanel" aria-labelledby="users-tab">
                        <div class="container mt-4">
                            <form id="save-item-form" method="post">
                                <input type="hidden" class="hidden_id" name="id" value={{ $item->id }} />
                                @csrf
                                <div class="row">
                                    <?php /* <div class="col-xl-4">
                                        <!-- Profile picture card-->
                                        <div class="card">
                                            <div class="card-header">Avatar</div>
                                            <div class="card-body text-center">
                                                <!-- Profile picture image-->
                                                <input type="hidden" class="hidden_id" name="id" value={{ $item->id }} />
                                                <div class="image-upload-container" id="cover">
                                                    <div class="image-part">
                                                        <img class="thumbnail" src="@if ($item->avatar) {{ $item->avatar }} @else {!! asset('backend/img/no_avatar.jpg') !!} @endif"/>
                                                        <input type="hidden" name="cover" class="cover" value="@if ($item->avatar) {{ $item->id }} @endif" />
                                                    </div>
                                                    <div class="image-action @if ($item->avatar) fileExist @else fileNotExist @endif">
                                                        <div class="img-not-exist">
                                                            <span id="uploadBtn" class="btn btn-success">Select image </span>
                                                        </div>
                                                        <div class="img-exist">
                                                            <span class="btn btn-danger remove-image">Remove </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> */ ?>
                                    <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-header">Details</div>
                                            <div class="card-body">
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label class="small mb-1" for="inputFirstName">First Name</label>
                                                        <input class="form-control" id="inputFirstName" type="text" name="name"
                                                            placeholder="First name" value="{{ $item->name }}" />
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="small mb-1" for="inputLastName">Last Name</label>
                                                        <input class="form-control" id="inputLastName" name="last_name" type="text" placeholder="Last name"
                                                            value="{{ $item->last_name }}" />
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="small mb-1" for="inputEmail">E-mail</label>
                                                        <input class="form-control " id="inputEmail" name="email" type="email"
                                                            placeholder="Email" value="{{ $item->email }}" />
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="small mb-1" for="inputPhone">Phone</label>
                                                        <input class="form-control" id="inputPhone" name="phone" type="tel"
                                                            placeholder="Phone" value="{{ $item->phone}}" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <button type="button" onclick="save()" id="saveItemBtn" class="btn btn-success float-right">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!-- end form -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-buttons">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        feather.replace();
    });

    function save() {
        Loading.add($('#saveItemBtn'));
        var data = $('#save-item-form').serializeFormJSON();
        $.ajax({
            type: "POST",
            url: "{{ route('adminMastersSave') }}",
            data: data,
            dataType: 'json',
            success: function(response) {
                if (response.status == 0) {
                    toastr['error'](response.message, "Error");
                }
                if (response.status == 1) {
                    toastr['success']('Saved.', 'Success');
                    if(window.datatable){
                        window.datatable.ajax.reload();
                    }
                    itemPopup.close();
                }
                Loading.remove($('#saveItemBtn'));
            }
        });
    }
    
    jQuery(document).ready(function() {

        //remove not working
        // var upload = new SUpload;
    	// upload.init({
    	// 	uploadContainer: 'cover',
    	// 	token: "<?php // echo csrf_token(); ?>",
    	// 	imageIdReturnEl: ".cover",
        //     temp: 1,
		// 	onRemove: function (imageId) {
		// 		$.ajax({
		// 			type: "POST",
		// 			url: "{!! url('/admin/master/unAttachImage') !!}",
		// 			data: {_token: "<?php // echo csrf_token(); ?>", 'id': {!! $item->id !!}},
		// 			dataType: 'json',
		// 		});		
		// 	},
    	// });

        var itemPopup = new Popup;
        itemPopup.init({
            size: 'modal-lg',
            identifier: 'edit-item',
            class: 'modal',
            minHeight: '200',
        })
        window.itemPopup = itemPopup;
    });
</script>