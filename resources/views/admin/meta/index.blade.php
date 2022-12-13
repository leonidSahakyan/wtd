@extends('admin.layouts.app')
@section('content')
    @include('admin.blocks.uploader')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="layout"></i></div>
                                Meta
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="container mt-n10">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Pagename</th>
                                <th>Status</th>
                                <th>Edit</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Pagename</th>
                                <th>Status</th>
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
        @include('admin.blocks.ui')
        <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="{!! asset('backend/plugins/tinymce/tinymce.min.js') !!}" type="text/javascript"></script>
        <script>
            $(document).ready(function() {
                var dataTable =  $('#dataTable').DataTable({
                    "processing": true,
                    "serverSide": true,
                    'searching': false,
                    "ajax": {
                        "url": "{{ route('aMetaData') }}",
                        "data": function(data){
                            data['sort_field'] = data.columns[data.order[0].column].name;
                            data['sort_dir'] =  data.order[0].dir;
                            data['search'] = data.search.value;

                            delete data.columns;
                            delete data.order;
                            // delete data.search;
                        }
                    },
                    "fnDrawCallback": function( oSettings ) {
                        feather.replace();
                    },
                    "columns": [
                        { "data": "id", "name":'id', "orderable": false },
                        { "data": "pagename", "name":'pagename', "orderable": true },
                        { "data": "published", "name":'published', "orderable": true , "sClass": "content-middel",
                            render: function ( data, type, row, meta) {
                                switch(row.published){
                                    case 1:
                                        colorClass = 'badge-success';
                                        status = 'Active';
                                        break;
                                    case 0:
                                        colorClass = 'badge-info';
                                        status = 'Disabled';
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
                            }},
                    ],
                    "columnDefs": [
                        {
                            "targets": [ 0 ],
                            "visible": false,
                        },
                        {"width": "70%", "targets": 1},
                        {"width": "15%", "targets": 2},
                        {"width": "15%", "targets": 3},
                    ],
                    "lengthMenu": [
                        [10, 20, 50, 100, -1],
                        [10, 20, 50, 100, "All"] // change per page values here
                    ],
                    "order": [
                        ['0', "asc"]
                    ],
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
                    itemPopup.setTitle('Edit Meta');
                    itemPopup.load("{{route('aGetMeta')}}?id="+editId, function () {
                        this.open();
                    });
                });
                $('#dataTable tbody').on('click', 'tr td:not(.selectOff)', function (e) {
                    $(this).parent('tr').toggleClass('selected');
                });

            });
        </script>
    @endpush
@endsection
