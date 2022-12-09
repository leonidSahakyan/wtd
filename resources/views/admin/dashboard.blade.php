@include('admin.blocks.uploader')
@extends('admin.layouts.app')
@section('content')
<main>
    <!-- <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            Dashboard
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header> -->
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="activity"></i></div>
                            Dashboard
                        </h1>
                        <div class="page-header-subtitle">Dashboard overview and content summary</div>
                    </div>
                    <!-- <div class="col-12 col-xl-auto mt-4">
                        <button class="btn btn-white p-3" id="reportrange">
                            <i class="mr-2 text-primary" data-feather="calendar"></i>
                            <span></span>
                            <i class="ml-1" data-feather="chevron-down"></i>
                        </button>
                    </div> -->
                </div>
            </div>
        </div>
    </header>
    <div class="container mt-n10">
        <div class="row">
            <div class="col-xxl-4 col-xl-12 mb-4">
                <div class="card h-100">
                    <div class="card-body h-100 d-flex flex-column justify-content-center py-5 py-xl-4">
                        <div class="row align-items-center">
                            <div class="col-xl-8 col-xxl-12">
                                <div class="text-center text-xl-left text-xxl-center px-4 mb-4 mb-xl-0 mb-xxl-4">
                                    <h1 class="text-primary">Welcome WTD Admin !</h1>
                                    <!-- <p class="text-gray-700 mb-0"></p> -->
                                </div>
                            </div>
                            <div class="col-xl-4 col-xxl-12 text-center"><img class="img-fluid" src="{!! asset('backend/assets/img/illustrations/at-work.svg') !!}" style="max-width: 26rem" /></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-4 col-xl-6 mb-4">
                <div class="card card-header-actions h-100">
                    <div class="card-header">
                        Recent Activity
                        <!-- <div class="dropdown no-caret">
                            <button class="btn btn-transparent-dark btn-icon dropdown-toggle" id="dropdownMenuButton" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="text-gray-500" data-feather="more-vertical"></i></button>
                            <div class="dropdown-menu dropdown-menu-right animated--fade-in-up" aria-labelledby="dropdownMenuButton">
                                <h6 class="dropdown-header">Filter Activity:</h6>
                                <a class="dropdown-item" href="#!"><span class="badge badge-green-soft text-green my-1">Commerce</span></a>
                                <a class="dropdown-item" href="#!"><span class="badge badge-blue-soft text-blue my-1">Reporting</span></a>
                                <a class="dropdown-item" href="#!"><span class="badge badge-yellow-soft text-yellow my-1">Server</span></a>
                                <a class="dropdown-item" href="#!"><span class="badge badge-purple-soft text-purple my-1">Users</span></a>
                            </div>
                        </div> -->
                    </div>
                    <div class="card-body">
                        <div class="timeline timeline-xs" id="log-timeline">
                            @foreach ($logs as $log)
                                <div class="timeline-item">
                                    @switch($log->type)
                                        @case('registration')
                                            <div class="timeline-item-marker">
                                                <div class="timeline-item-marker-text">{{$log->humanTime}}</div>
                                                <div class="timeline-item-marker-indicator bg-purple"></div>
                                            </div>
                                            <div class="timeline-item-content">
                                                New user
                                                <a class="font-weight-bold text-dark user_edit" page="registration" edit_item_id="{{$log->owner_id}}" href="#!"> Id #{{$log->owner_id}}</a>
                                                has registered
                                            </div>
                                            @break
                                        @case('verification')
                                            <div class="timeline-item-marker">
                                                <div class="timeline-item-marker-text">{{$log->humanTime}}</div>
                                                <div class="timeline-item-marker-indicator bg-blue"></div>
                                            </div>
                                            <div class="timeline-item-content">
                                                User
                                                <a class="font-weight-bold text-dark user_edit" page="verification" edit_item_id="{{$log->owner_id}}" href="#!"> Id #{{$log->owner_id}}</a>
                                                pending verification
                                            </div>
                                            @break
                                        @case('order_request')
                                            <div class="timeline-item-marker">
                                                <div class="timeline-item-marker-text">{{$log->humanTime}}</div>
                                                <div class="timeline-item-marker-indicator bg-green"></div>
                                            </div>
                                            <div class="timeline-item-content">
                                                New order placed!
                                                <a class="font-weight-bold text-dark order_edit" edit_item_id="{{$log->owner_id}}" href="#!">Order #{{$log->owner_id}}</a>
                                            </div>
                                            @break
                                    @endswitch

                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="col-xxl-4 col-xl-6 mb-4">
                <div class="card card-header-actions h-100">
                    <div class="card-header">
                        Progress Tracker
                        <div class="dropdown no-caret">
                            <button class="btn btn-transparent-dark btn-icon dropdown-toggle" id="dropdownMenuButton" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="text-gray-500" data-feather="more-vertical"></i></button>
                            <div class="dropdown-menu dropdown-menu-right animated--fade-in-up" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#!">
                                    <div class="dropdown-item-icon"><i class="text-gray-500" data-feather="list"></i></div>
                                    Manage Tasks
                                </a>
                                <a class="dropdown-item" href="#!">
                                    <div class="dropdown-item-icon"><i class="text-gray-500" data-feather="plus-circle"></i></div>
                                    Add New Task
                                </a>
                                <a class="dropdown-item" href="#!">
                                    <div class="dropdown-item-icon"><i class="text-gray-500" data-feather="minus-circle"></i></div>
                                    Delete Tasks
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h4 class="small">
                            Server Migration
                            <span class="float-right font-weight-bold">20%</span>
                        </h4>
                        <div class="progress mb-4"><div class="progress-bar bg-danger" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div></div>
                        <h4 class="small">
                            Sales Tracking
                            <span class="float-right font-weight-bold">40%</span>
                        </h4>
                        <div class="progress mb-4"><div class="progress-bar bg-warning" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div></div>
                        <h4 class="small">
                            Customer Database
                            <span class="float-right font-weight-bold">60%</span>
                        </h4>
                        <div class="progress mb-4"><div class="progress-bar" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div></div>
                        <h4 class="small">
                            Payout Details
                            <span class="float-right font-weight-bold">80%</span>
                        </h4>
                        <div class="progress mb-4"><div class="progress-bar bg-info" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div></div>
                        <h4 class="small">
                            Account Setup
                            <span class="float-right font-weight-bold">Complete!</span>
                        </h4>
                        <div class="progress"><div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div></div>
                    </div>
                    <a class="card-footer" href="#!">
                        <div class="d-flex align-items-center justify-content-between small text-body">
                            Visit Task Center
                            <i data-feather="arrow-right"></i>
                        </div>
                    </a>
                </div>
            </div> -->
        </div>
        <!-- Example Colored Cards for Dashboard Demo-->
         <div class="row">
            <div class="col-xxl-3 col-lg-6">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="mr-3">
                                <div class="text-white-75 small">Users registred</div>
                                <div class="text-lg font-weight-bold">{{$users}}</div>
                            </div>
                            <i class="feather-xl text-white-50" data-feather="users"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('ausers') }}">View Users</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-lg-6">
                <div class="card bg-warning text-white mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="mr-3">
                                <div class="text-white-75 small">Active services</div>
                                <div class="text-lg font-weight-bold"></div>
                            </div>
                            <i class="feather-xl text-white-50" data-feather="dollar-sign"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('ausers') }}?page=employees">View Employees</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-lg-6">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="mr-3">
                                <div class="text-white-75 small">Order placed</div>
                                <div class="text-lg font-weight-bold">{{$orders}}</div>
                            </div>
                            <i class="feather-xl text-white-50" data-feather="check-square"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('adminOrder') }}">View Orders</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-lg-6">
                <div class="card bg-danger text-white mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="mr-3">
                                <div class="text-white-75 small">Pending Requests</div>
                                {{-- <div class="text-lg font-weight-bold">{{$pending}}</div> --}}
                            </div>
                            <i class="feather-xl text-white-50" data-feather="message-circle"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('ausers') }}?page=pending">View Requests</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
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
            var itemPopup = new Popup;
            itemPopup.init({
                size:'modal-xl',
                identifier:'edit-item',
                class: 'modal',
                minHeight: '200',
            })
            window.itemPopup = itemPopup;
            $('#log-timeline').on('click', '.user_edit', function (e) {
                editId = $(this).attr('edit_item_id');
                page = $(this).attr('page');
                itemPopup.setTitle('Edit Users');
                itemPopup.load("{{route('aGetUser')}}?id="+ editId+"&page="+page, function () {
                    this.open();
                });
            });

            var orderPopup = new Popup;
            orderPopup.init({
                size:'modal-xl',
                identifier:'edit-item',
                class: 'modal',
                minHeight: '200',
            })
            window.orderPopup = orderPopup;

            $('#log-timeline').on('click', '.order_edit', function (e) {
                editId = $(this).attr('edit_item_id');
                orderPopup.setTitle('Order');
                orderPopup.load("{{route('aGetOrder')}}?id="+editId, function () {
                    this.open();
                });
            });

            // $('#add_item').on('click', function (e) {
            //     Loading.add($('#add_item'));
            //     itemPopup.setTitle('Add Users');
            //     itemPopup.load("{{route('aGetUser')}}", function () {
            //         this.open();
            //     });
            // });
        });
    </script>
@endpush
@endsection
