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
                        Dictionary   
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container mt-n10">
        <div class="card">
            <!-- <div class="card-header">
                <button class="btn btn-primary btn-sm" id="add_item" type="button">Add</button>
                <button class="btn btn-danger btn-sm" id="remove_item" type="button">Remove</button>
            </div> -->

            <div class="d-flex align-items-end flex-column mb-3 p-3" >
                <div class="form-group col-md-2 float-right nopadding p-2"  >
                        <select class="form-control" name="filter_type" id="filter_type">
                            <option value=''>-- All--</option>
                            <option value='dictionary'>Dictionary</option>
                            <option value='email'>Email</option>
                            <option value='notification'>Notification</option>
                    </select>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Key</th>
                                <th>Translation</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
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
            // const capitalize = (s) => {
            //     if (typeof s !== 'string') return ''
            //     return s.charAt(0).toUpperCase() + s.slice(1)
            // }

            var dataTable =  $('#dataTable').DataTable({
                "processing": true,
                "serverSide": true,
                'searching': true,
                "ajax": {
                    "url": "{{ route('aDictionaryData') }}",
                    "data": function(data){
                        data['sort_field'] = data.columns[data.order[0].column].name;
                        data['sort_dir'] =  data.order[0].dir;
                        data['search'] = data.search.value;

                        delete data.columns;
                        delete data.order;

                        var filter_type = $('#filter_type').val();
                        data.filter_type = filter_type;
                    }
                },
                "fnDrawCallback": function( oSettings ) {
                    feather.replace();
                },
                "columns": [
                    { "data": "key", "name":'key', "orderable": true },
                    { "data": "title", "name":'title', "orderable": true },
                    { "data": "key", "name":'edit', "orderable": false, "sClass": "content-middel selectOff", 
	            	    render: function ( data, type, row, meta) {
	            	    return '<a href="javascript:;" edit_item_id="'+row.key+'" class="item_edit"><button class="btn btn-datatable btn-icon btn-transparent-dark"><i data-feather="edit"></i></button></a>';
	                }},
                ],
                "columnDefs": [
                    {"width": "46%", "targets": 0},
                    {"width": "46%", "targets": 1},
                    {"width": "6%", "targets": 2},
                ],
                "order": [
                    ['0', "desc"]
                ],
            });

            window.datatable = dataTable;
            $('#filter_status').change(function(){
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
                itemPopup.setTitle('Edit word');
                itemPopup.load("{{route('aGetDictionary')}}?key="+editId, function () {
                    this.open();
                });
            });
        


            $('#dataTable tbody').on('click', 'tr td:not(.selectOff)', function (e) {
                $(this).parent('tr').toggleClass('selected');
            });
            $('#filter_type').change(function(){
                dataTable.draw();
            });

            
        });
    </script>
@endpush
@endsection