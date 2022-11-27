<link href="{!! asset('backend/plugins/dropzone/css/dropzone.css') !!}" media="all" rel="stylesheet" type="text/css" />
<script src="{!! asset('backend/plugins/dropzone/dropzone.js') !!}" type="text/javascript"></script>
<script src="{!! asset('backend/js/scripts/gallery.js?8') !!}" type="text/javascript"></script>
<div id="preview-template" style="display:none">
	<div class="dz-preview dz-file-preview">
		<div class="dz-details">
			<div class="dz-filename"><span data-dz-name></span></div>
			<div class="dz-size" data-dz-size></div>
			<img data-dz-thumbnail />
		</div>
		<div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
		<div class="dz-success-mark"><span>✔</span></div>
		<div class="dz-error-mark"><span>✘</span></div>
		<div class="dz-error-message"><span data-dz-errormessage></span></div>
	</div>
</div>
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
                            aria-controls="users" aria-selected="@if(!$page) true @else false @endif">Users</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="services-tab" data-toggle="tab" href="#services" role="tab"
                            aria-controls="services" aria-selected="false">Billing history</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="dashboardNavContent">
                    <div class="tab-pane fade @if(!$page)show active @endif" id="users" role="tabpanel" aria-labelledby="users-tab">
                        <div class="container mt-4">
                            <form id="save-item-form" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-header">Details</div>
                                            <div class="card-body">
                                                <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <input type="hidden" name="id" value="{{ $item->id }}" />
                                                    <label class="small mb-1" for="inputUsername">First name</label>
                                                    <input class="form-control" id="inputUsername" type="text" name="first_name"
                                                        placeholder="First Name" value="{{ $item->first_name }}" />
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="small mb-1" for="inputUsername">Last name</label>
                                                    <input class="form-control" id="inputUsername" type="text" name="last_name"
                                                        placeholder="Last Name" value="{{ $item->last_name }}" />
                                                </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label class="small mb-1" for="inputFirstName">Email</label>
                                                        <input class="form-control" id="email" name="email" type="email" placeholder="Email"
                                                            value="{{ $item->email }}" />
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
                    <div class="tab-pane fade" id="services" role="tabpanel"  aria-labelledby="services-tab">
                        <div class="container">
                            <div class="card">
                                <div class="card-header">
                                    <!-- <button class="btn btn-primary btn-sm" id="addServicesItem"
                                        type="button">Add</button>
                                    <button class="btn btn-danger btn-sm" id="remove_item"
                                        type="button">Remove</button> -->
                                </div>
                                <div class="card-body">
                                    @if($item->services && $item->services->count() > 0)
                                    <div class="datatable table-responsive">
                                        <table class="table table-bordered table-hover" id="dataTableServices" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Category</th>
                                                    <th>Price</th>
                                                    <th>Images</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Category</th>
                                                    <th>Price</th>
                                                    <th style="width: 50%;">Images</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                    @foreach ($item->services as $service)
                                                        <tr>
                                                            <td>{{$service->category_title}}</td>
                                                            <td>{{$service->price}}</td>
                                                            <td>
                                                            @if($service->images)
                                                                @foreach ($service->images as $image)
                                                                    <span style="display:inline-block; padding:5px;"><img src="{{$image['thumb_url']}}"></span>
                                                                @endforeach
                                                            @else
                                                                <span>Images not added</span>
                                                            @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @else
                                        <div id="gallery-container"></div>
                                        <span>Services not added</span>
                                    @endif
                                </div>
                            </div>
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

        var gallery = new Gallery;
		gallery.init({
			gallery_id:false,
			_token: '<?php echo csrf_token(); ?>',
			container: '#gallery-container',
			edit: 'editImage',
		})
		window.gallery = gallery;
		gallery.load();

        feather.replace();
    });

    function save() {
        Loading.add($('#saveItemBtn'));
        var data = $('#save-item-form').serializeFormJSON();
        $.ajax({
            type: "POST",
            url: "{{ route('aUserSave') }}",
            data: data,
            dataType: 'json',
            success: function(response) {
                if (response.status == 0) {
                    toastr['error'](response.message, 'Error');
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

    function saveVerification() {
        Loading.add($('#saveVerificationBtn'));
        var data = $('#verify-form').serializeFormJSON();
        $.ajax({
            type: "POST",
            url: "{{ route('aUserSaveVerify') }}",
            data: data,
            dataType: 'json',
            success: function(response) {
                if (response.status == 0) {
                    toastr['error'](response.message, 'Error');
                }
                if (response.status == 1) {
                    toastr['success']('Saved.', 'Success');
                    if(window.datatable){
                        window.datatable.ajax.reload();
                    }
                    itemPopup.close();
                }
                Loading.remove($('#saveVerificationBtn'));
            }
        });
    }
    jQuery(document).ready(function() {

        // var upload = new SUpload;
    	// upload.init({
    	// 	uploadContainer: 'cover',
    	// 	token: "<?php echo csrf_token(); ?>",
    	// 	imageIdReturnEl: ".cover",
    	// 	avatar: "{{$item->id}}"
    	// });

        var itemPopup = new Popup;
        itemPopup.init({
            size:'modal-xl',
            identifier:'edit-item',
            class: 'modal',
            minHeight: '200',
        })
        window.itemPopup = itemPopup;
    });
</script>

<script type="text/javascript">
jQuery(document).ready(function() {
    return
    var dataTableServices =  $('#dataTableServices').DataTable({
        "processing": true,
        "serverSide": true,
        'searching': true,
        "ajax": {
            "url": "/admin/get-services",
            "data": function(data){
                data['sort_field'] = data.columns[data.order[0].column].name;
                data['sort_dir'] =  data.order[0].dir;
                data['search'] = data.search.value;

                delete data.columns;
                delete data.order;

                var filter_status = $('#filter_status').val();
                data.filter_status = filter_status;
            }
        },
        "fnDrawCallback": function( oSettings ) {
            feather.replace();
            $('[data-toggle="popover"]').popover();
        },
        "columns": [
            { "data": "id", "name":'id', "orderable": true },
            { "data": "fullname", "name":'fullname', "orderable": true },
            { "data": "phone", "name":'phone', "orderable": true },
            { "data": "address", "name":'address', "orderable": true },
            { "data": "rating", "name":'rating', "orderable": true },
            { "data": "status", "name":'status', "orderable": true , "sClass": "content-middel",
            render: function ( data, type, row, meta) {
                switch(row.status){
                    case 'active':
                        colorClass = 'badge-success';
                        break;
                    case 'disabled':
                        colorClass = 'badge-info';
                        break;
                    default:
                        row.status = 'error'
                        colorClass = 'badge-danger';
                }
                return '<div style="font-size:12px;" class="badge '+colorClass+' badge-pill">'+row.status+'</div>';
            }},
            { "data": "is_customer", "name":'is_customer', "orderable": true, "sClass": "content-middel",
                render: function ( data, type, row, meta) {
                return row.is_customer ? '<i data-feather="check"></i>' : ''
            }},
            { "data": "is_employee", "name":'is_employee', "orderable": true, "sClass": "content-middel",
                render: function ( data, type, row, meta) {
                return row.is_employee ? '<i data-feather="check"></i>' : ''
            }},
            { "data": "id", "name":'edit', "orderable": false, "sClass": "content-middel",
                render: function ( data, type, row, meta) {
                return '<a href="javascript:;" edit_item_id="'+row.id+'" class="item_edit"><button class="btn btn-datatable btn-icon btn-transparent-dark"><i data-feather="edit"></i></button></a>';
            }},
        ],
        "columnDefs": [
            {"width": "10%", "targets": 0},
            {"width": "15%", "targets": 1},
            {"width": "15%", "targets": 2},
            {"width": "15%", "targets": 3},
            {"width": "5%", "targets": 4},
            {"width": "10%", "targets": 5},
            {"width": "5%", "targets": 6},
            {"width": "5%", "targets": 7},
            {"width": "5%", "targets": 8},

        ],
        "order": [
            ['0', "desc"]
        ]
    });
});
</script>
