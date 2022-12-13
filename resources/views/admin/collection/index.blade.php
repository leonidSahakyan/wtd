<!-- @include('admin.blocks.uploader') -->
@extends('admin.layouts.app')
@section('content')
<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="folder"></i></div>
                        Collections
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container mt-n10">
        <div class="card">
            <div class="card-header">
                <button class="btn btn-primary btn-sm" id="add_item" type="button">Add</button>
                <button class="btn btn-danger btn-sm" id="remove_item" type="button">Remove</button>
            </div>
            <div class="card-body">
                <div class="form-group col-md-2 float-right nopadding" style="margin-bottom: 10px!important;">
                    <div class="small text-muted">Status</div>
                    <select class="form-control" name="filter_status" id="filter_status">
                        <option value=''>-- All--</option>
                        <option value='1'>Published</option>
                        <option value='0'>Unpublished</option>
                    </select>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover " id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ordering</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Show</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ordering</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Show</th>
                            </tr>
                        </tfoot>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Main page content-->    
</main>
@push('css')
    <link href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
@endpush
@push('script')
    @include('admin.blocks.ui')
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            // const capitalize = (s) => {
            //     if (typeof s !== 'string') return ''
            //     return s.charAt(0).toUpperCase() + s.slice(1)
            // }
            
            $('#dataTable').sortable({
                items: "tbody tr", 
                opacity: 0.8,
                coneHelperSize: true,
                tolerance: "pointer",
                helper: "clone",
                tolerance: "pointer",
                revert: 250, // animation in milliseconds
                update: function(event, ui) {
                    var ids = new Array();
                    $('tbody tr', '#dataTable').each(function(index) {
                      ids.push($(this).attr('id'));
                    });
                    $.ajax({
                      type: "POST",
                      url: "{{ route('aCollectionsSort') }}",
                      dataType: 'JSON',
                      data:{_token: "<?php echo csrf_token(); ?>", ids:ids}
                  });                
                },
            });
            $( "#dataTable" ).sortable( "disable" );  

            var dataTable =  $('#dataTable').DataTable({
                "processing": true,
                "serverSide": true,
                'searching': true,
                "ajax": {
                    "url": "{{ route('aCollectionsData') }}",
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
                },
                "columns": [
                    { "data": 'ordering', "name":'ordering', "orderable": true },
                    { "data": "title", "name":'title', "orderable": true },
                    { "data": "status", "name":'status', "orderable": true , "sClass": "content-middel",
                    render: function ( data, type, row, meta) {
                        switch(row.status){
                            case 1:
                                colorClass = 'badge-success';
                                status = 'Published';
                                break;
                                case 0:
                                colorClass = 'badge-info';
                                status = 'Unpublished';
                                break;
                            default:
                                status = 'error' 
                                colorClass = 'badge-danger';
                        }
                        return '<div style="font-size:12px;" class="badge '+colorClass+' badge-pill">'+status+'</div>';
	                }},
                    { "data": "id", "name":'edit', "orderable": false, "sClass": "content-middel selectOff", 
	            	    render: function ( data, type, row, meta) {
	            	    return '<a href="javascript:;" edit_item_id="'+row.id+'" class="item_edit"><button class="btn btn-datatable btn-icon btn-transparent-dark"><i data-feather="edit"></i></button></a>';
	                }}
                ],
                "columnDefs": [
                    {"visible": false, "targets": 0},
                    {"width": "80%", "targets": 1},
                    {"width": "10%", "targets": 2},
                    {"width": "10%", "targets": 3}
                ],
                "lengthMenu": [
                    [10, 20, 50, 100, -1],
                    [10, 20, 50, 100, "All"] // change per page values here
                ],
                "order": [
                    ['0', "desc"]
                ],
            });

            window.datatable = dataTable;  
            
            $('#filter_status').change(function(){
                dataTable.draw();
            });

            $("[name='dataTable_length']").change(function(){
                var info = dataTable.page.info();
                if(info.length == "-1"){
                    $( "#dataTable" ).sortable( "enable" );   
                }else{
                    $( "#dataTable" ).sortable( "disable" );
                }
                dataTable.draw();
            });

            var itemPopup = new Popup;
            itemPopup.init({
                size:'modal-xl',
                identifier:'edit-item',
                class: 'modal',
                minHeight: '200',
            })
            window.itemPopup = itemPopup;

            $('#dataTable').on('click', '.item_edit', function (e) {
                editId = $(this).attr('edit_item_id');
                itemPopup.setTitle('Edit collection');
                itemPopup.load("{{route('aGetCollection')}}?id="+editId, function () {
                    this.open();
                });
            });

            $('#add_item').on('click', function (e) {
                Loading.add($('#add_item'));
                itemPopup.setTitle('Add collection');
                itemPopup.load("{{route('aGetCollection')}}", function () {
                    this.open();
                });
            });


            $('#dataTable tbody').on('click', 'tr td:not(.selectOff)', function (e) {
                $(this).parent('tr').toggleClass('selected');
            });

            $("#remove_item").on('click', function (e) {
                if(dataTable.rows('.selected').data().length <= 0){
                    toastr['info']("Please select item", 'Information');    
                }else{
                    var rows = [];
                    dataTable.rows('.selected').data().each(function (row) {
                        rows.push(row.id);    
                    })
                    if(rows.length <= 0){
                        toastr['info']("Please select item", 'Information');    
                        return
                    }
                    bootbox.confirm("Are you sure?", function(result) {
                        if(result){
                            $.ajax({
                            type: "POST",
                            url: "{{route('aRemoveCollection')}}",
                            dataType: 'JSON',
                            data:{_token: "<?php echo csrf_token(); ?>", ids:rows},
                                success: function(response){
                                    if(response.status == 1){
                                        datatable.ajax.reload(null, false);
                                    }else{
                                        toastr['error'](response.message, 'Error');
                                    }
                                }
                            });	
                        }
                    }); 
                }
            });
            
        });
    </script>
@endpush
@endsection