@extends('admin.layouts.app')
@section('content')
<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="dollar-sign"></i></div>
                        Orders
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container mt-n10">
        <div class="card">
            <div class="card-header"></div>
            <div class="card-body">
                <div class="col-12 col-xl-auto float-left">
                    <div class="small text-muted">Date range</div>
                    <button class="btn btn-white p-3" id="reportrange">
                        <i class="mr-2 text-primary" data-feather="calendar"></i>
                        <span></span>
                        <i class="ml-1" data-feather="chevron-down"></i>
                    </button>
                </div>
                <div class="form-group col-md-2 float-right  p-0">
                    <div class="small text-muted">Status</div>
                    <select class="form-control" name="filter_status" id="filter_status">
                        <option value=''>-- All--</option>
                        <option value='new'>New</option>
                        <option value='paid'>Paid</option>
                        <option value='shipping'>Shipping</option>
                        <option value='done'>Done</option>
                        <option value='canceled'>Canceled</option>
                    </select>
                </div>
                <!-- @if($collections)
                <div class="form-group col-md-2 float-right">
                    <div class="small text-muted">Collection</div>
                    <select class="form-control" name="filter_collection" id="filter_collection">
                        <option value=''>-- All--</option>
                        @foreach($collections as $collection)
                            <option value='{{$collection->id}}'>{{$collection->title}}</option>
                        @endforeach
                    </select>
                </div>
                @endif -->
                <div class="table-responsive">
                        <table class="table table-bordered table-hover " id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>SKU</th>
                                <th>First name</th>
                                <th>Last name</th>
                                <th>Country</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Show</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Date</th>
                                <th>SKU</th>
                                <th>First name</th>
                                <th>Last name</th>
                                <th>Country</th>
                                <th>Total</th>
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
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    
    <script>
        $(document).ready(function() {
            // $(function () {
                var start = moment();//.subtract(29, "days");
                var end = moment();

                function cb(start, end) {
                    $("#reportrange span").html(
                        start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY")
                    );
                }

                var picker =  $("#reportrange").daterangepicker(
                    {
                        onSelect: function() {
                            // start = this.startDate
                            // end = this.endDate
                            // $(this).change();
                        },
                        startDate: start,
                        endDate: end,
                        ranges: {
                            Today: [moment(), moment()],
                            Yesterday: [
                                moment().subtract(1, "days"),
                                moment().subtract(1, "days"),
                            ],
                            "Last 7 Days": [moment().subtract(6, "days"), moment()],
                            "Last 30 Days": [moment().subtract(29, "days"), moment()],
                            "This Month": [
                                moment().startOf("month"),
                                moment().endOf("month"),
                            ],
                            "Last Month": [
                                moment().subtract(1, "month").startOf("month"),
                                moment().subtract(1, "month").endOf("month"),
                            ],
                        },
                    },
                    cb
                );

                cb(start, end);
            // });

            const capitalize = (s) => {
                if (typeof s !== 'string') return ''
                return s.charAt(0).toUpperCase() + s.slice(1)
            }

            var dataTable =  $('#dataTable').DataTable({
                "processing": true,
                "serverSide": true,
                'searching': true,
                "ajax": {
                    "url": "{{ route('orderData') }}",
                    "data": function(data){
                        data['sort_field'] = data.columns[data.order[0].column].name;
                        data['sort_dir'] =  data.order[0].dir;
                        data['search'] = data.search.value;

                        delete data.columns;
                        delete data.order;

                        var filter_status = $('#filter_status').val();
                        data.filter_status = filter_status;
                        
                        var filter_collection = $('#filter_collection').val();
                        data.filter_collection = filter_collection;
                        
                        data.start_date = picker.data('daterangepicker').startDate.format("YYYY-MM-DD");
                        data.end_date = picker.data('daterangepicker').endDate.format("YYYY-MM-DD");
                    }
                },
                "fnDrawCallback": function( oSettings ) {
                    feather.replace();
                    $('[data-toggle="popover"]').popover();
                },
                "columns": [
                    { "data": 'created_at', 'name': 'orders.created_at',"orderable": true},
                    { "data": 'sku', 'name': 'orders.sku',"orderable": true},
                    { "data": "first_name", "name":'first_name', "orderable": true },
                    { "data": "last_name", "name":'last_name', "orderable": true },
                    { "data": "country", "name":'countries.id', "orderable": true },
                    { "data": "total", "name":'total', "orderable": true, render : function ( data, type, row, meta) {return "$"+row.total}},
                    { "data": "status", "name":'status', "orderable": true , "sClass": "content-middel",
                    render: function ( data, type, row, meta) {
                        switch(row.status){
                            case 'new':
                                colorClass = 'badge-warning';
                                break;
                            case 'paid':
                                colorClass = 'badge-secondary';
                                break;
                            case 'shipping':
                                colorClass = 'badge-info';
                            break;
                            case 'done':
                                colorClass = 'badge-success';
                            break;
                            case 'canceled':
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
                    {"width": "10%", "targets": 0},
                    {"width": "15%", "targets": 1},
                    {"width": "15%", "targets": 2},
                    {"width": "15%", "targets": 3},
                    {"width": "15%", "targets": 4},
                    {"width": "10%", "targets": 5},
                    {"width": "10%", "targets": 6},
                    {"width": "10%", "targets": 7},
                ],
                "order": [
                    ['1', "desc"]
                ]
            });

            window.datatable = dataTable;  
            
            $('#filter_status, #filter_collection').change(function(){
                dataTable.draw();
            });

            $('#reportrange').on('apply.daterangepicker', (e, picker) => {
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
                itemPopup.load("{{route('aGetOrder')}}?id="+editId, function () {
                    this.open();
                });
            });
        });
    </script>
@endpush
@endsection