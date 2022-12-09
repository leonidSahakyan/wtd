@include('admin.blocks.uploader')
@extends('admin.layouts.app')
@section('content')
<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="users"></i></div>
                        Masters
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
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>First name</th>
                                <th>Last name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>First name</th>
                                <th>Last name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Edit</th>
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
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            const capitalize = (s) => {
                if (typeof s !== 'string') return ''
                return s.charAt(0).toUpperCase() + s.slice(1)
                
            }
            var dataTable =  $('#dataTable').DataTable({
                "processing": true,
                "serverSide": true,
                'searching': true,
                "ajax": {
                    "url": "{{ route('adminMastersData') }}",
                    "data": function(data){
                        data['sort_field'] = data.columns[data.order[0].column].name;
                        data['sort_dir'] =  data.order[0].dir;
                        data['search'] = data.search.value;

                        delete data.columns;
                        delete data.order;
                    }
                },
                "fnDrawCallback": function( oSettings ) {
                    feather.replace();
                    $('[data-toggle="popover"]').popover();
                },
                "columns": [
                    { "data": "id", "name":'id', "orderable": true },
                    { "data": "name", "name":'name', "orderable": true },
                    { "data": "last_name", "name":'last_name', "orderable": true },
                    { "data": "phone", "name":'phone', "orderable": true },
                    { "data": "email", "name":'email', "orderable": true },
                    { "data": "id", "name":'edit', "orderable": false, "sClass": "content-middel selectOff", 
	            	    render: function ( data, type, row, meta) {
	            	    return '<a href="javascript:;" edit_item_id="'+row.id+'" class="item_edit"><button class="btn btn-datatable btn-icon btn-transparent-dark"><i data-feather="edit"></i></button></a>';
	                }},
                ],
                "columnDefs": [
                    {
                        "targets": [ 0 ],
                        "visible": false,
                    },
                    {"width": "10%", "targets": 0},
                    {"width": "20%", "targets": 1},
                    {"width": "20%", "targets": 2},
                    {"width": "20%", "targets": 3},
                    {"width": "40%", "targets": 4},
                    {"width": "10%", "targets": 5},
                ],
                "order": [
                    ['0', "desc"]
                ]
            });

            window.datatable = dataTable;

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
                itemPopup.setTitle('Edit master');
                itemPopup.load("{{route('adminMastersGet')}}?id="+ editId, function () {
                    this.open();
                });
            });

            $('#add_item').on('click', function (e) {
                Loading.add($('#add_item'));
                itemPopup.setTitle('Add master');
                itemPopup.load("{{route('adminMastersGet')}}", function () {
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
                            url: "",
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