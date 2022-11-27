
@extends('app.layouts.app')
@section('content')

<link href="{!! asset('assets/css/profile/styles.css') !!}" media="all" rel="stylesheet" type="text/css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
<section class="service-detail">
    <div class="container">
        <div class="row clearfix">
            @include("components.menu-profile")
            <div class="col-lg-8 col-md-12 col-sm-12">
                <h2 class="service-detail__title">Orders</h2>
                <div class="service-detail__text">
                    
                        <div class="card">
                            <div class="card-header"></div>
                            <div class="card-body">
                                <div class="form-group col-md-2 float-right">
                                    <div class="small text-muted">Status</div>
                                    <select class="form-control" name="filter_status" id="filter_status">
                                        <option value=''>-- All--</option>
                                        <option value='waiting'>Waiting</option>
                                        <option value='approved'>Approved</option>
                                        <option value='declined'>Declined</option>
                                        <option value='canceled'>Canceled</option>
                                    </select>
                                </div>
                                <div class="table-responsive">
                                        <table class="table table-bordered table-hover " id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Date</th>
                                                <th>Price</th>
                                                <th>Status</th>
                                                <th>Show</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>ID</th>
                                                <th>Date</th>
                                                <th>Price</th>
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
            </div>
        </div>
    </div>
</section>

<script src="{!! asset('backend/vendor/popup.js') !!}" type="text/javascript"></script>

<div id="modal-container"></div>

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
                'searching': false,
                "ajax": {
                    "url": "{{ route('orderDataProfile') }}",
                    "data": function(data){
                        data['sort_field'] = data.columns[data.order[0].column].name;
                        data['sort_dir'] =  data.order[0].dir;

                        delete data.columns;
                        delete data.order;
                        delete data.search;

                        var filter_status = $('#filter_status').val();
                        data.filter_status = filter_status;
                        
                        var filter_category = $('#filter_category').val();
                        data.filter_category = filter_category;
                    }
                },
                "fnDrawCallback": function( oSettings ) {
                    feather.replace();
                    $('[data-toggle="popover"]').popover();
                },
                "columns": [
                    { "data": 'id', 'name': 'orders.id',"orderable": true},
                    { "data": 'created_at', 'name': 'orders.created_at',"orderable": true},
                    { "data": "total", "name":'total', "orderable": true },
                    { "data": "status", "name":'status', "orderable": true , "sClass": "content-middel",
                    render: function ( data, type, row, meta) {
                        switch(row.status){
                            case 'approved':
                                colorClass = 'badge-success';
                                break;
                            case 'waiting':
                                colorClass = 'badge-info';
                                break;
                            case 'declined':
                                colorClass = 'badge-danger';
                                break;
                            default:
                                colorClass = 'badge-danger';
                        }
                        str = capitalize(row.status.replace("_", " "));
	            	    // return capitalize(str)
                        return '<div style="font-size:12px;" class="badge '+colorClass+' badge-pill">'+str+'</div>';
	                }},
                    { "data": "id", "name":'edit', "orderable": false, "sClass": "content-middel", 
	            	    render: function ( data, type, row, meta) {
	            	    return '<a href="javascript:;" edit_item_id="'+row.id+'" class="item_edit"><button class="btn btn-datatable btn-icon btn-transparent-dark"><i data-feather="edit"></i></button></a>';
	                }},
                ],
                "columnDefs": [
                    {"width": "5%", "targets": 0},
                    {"width": "5%", "targets": 1},
                    {"width": "5%", "targets": 2},
                    {"width": "5%", "targets": 3},
                    {"width": "5%", "targets": 4},
                ],
                "order": [
                    ['0', "desc"]
                ]
            });

            $('#filter_status, #filter_category').change(function(){
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
                itemPopup.setTitle('Order');
                itemPopup.load("{{route('profileGetOrder')}}?id="+editId, function () {
                    console.log(6585);
                    this.open();
                });
            });
        });
    </script>
@endpush
@endsection