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
                                        @case('order_created')
                                            <div class="timeline-item-marker">
                                                <div class="timeline-item-marker-text">{{$log->humanTime}}</div>
                                                <div class="timeline-item-marker-indicator bg-yellow"></div>
                                            </div>
                                            <div class="timeline-item-content">
                                                New order created !
                                                <a class="font-weight-bold text-dark order_edit" page="overview" edit_item_id="{{$log->owner_id}}" href="#!"><br>Order #{{$log->sku}}</a>
                                            </div>
                                        @break
                                        @case('order_paid')
                                            <div class="timeline-item-marker">
                                                <div class="timeline-item-marker-text">{{$log->humanTime}}</div>
                                                <div class="timeline-item-marker-indicator bg-purple"></div>
                                            </div>
                                            <div class="timeline-item-content">
                                                Order paid !
                                                <a class="font-weight-bold text-dark order_edit" page="billing" edit_item_id="{{$log->owner_id}}" href="#!"><br>Order #{{$log->sku}}</a>
                                            </div>
                                        @break
                                    @endswitch
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-4 col-xl-6 mb-4">
                <div class="card card-header-actions h-100">
                    <div class="card-header">
                        Progress Tracker
                    </div>
                    <div class="card-body">
                        <h4 class="small">
                            Orders complete {{$ordersDone}} / {{$ordersTotal}}
                            <span class="float-right font-weight-bold">{{$ordersPercent == '100' ? 'Complete!' : $ordersPercent.'%'}}</span>
                        </h4>
                        <div class="progress mb-4"><div class="progress-bar bg-success" role="progressbar" style="width: {{$ordersPercent}}%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xxl-3 col-lg-6">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="mr-3">
                                <div class="text-white-75 small">Orders</div>
                                <div class="text-lg font-weight-bold">{{$ordersTotal}}</div>
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
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="mr-3">
                                <div class="text-white-75 small">Total paid</div>
                                <div class="text-lg font-weight-bold">{{$total}}</div>
                            </div>
                            <i class="feather-xl text-white-50" data-feather="users"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('adminOrder') }}">View billings</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6 mb-4">
                <div class="card card-header-actions h-100">
                    <div class="card-header">
                        Activity data
                    </div>
                    <div class="card-body">
                        <div class="chart-area"><canvas id="myAreaChart" width="100%" height="30"></canvas></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 mb-4">
                <div class="card card-header-actions h-100">
                    <div class="card-header">
                        Monthly Revenue
                    </div>
                    <div class="card-body">
                        <div class="chart-bar"><canvas id="myBarChart" width="100%" height="30"></canvas></div>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" crossorigin="anonymous"></script>
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

            let months = <?php echo json_encode($chartData['month_title']);?>;
            let ordersCount = <?php echo json_encode($chartData['orders_count']);?>;
            console.log(months);
            var ctx = document.getElementById("myAreaChart");
            var myLineChart = new Chart(ctx, {
                type: "line",
                data: {
                    labels: months,
                    datasets: [
                    {
                        label: "Orders",
                        lineTension: 0.3,
                        backgroundColor: "rgba(0, 172, 105, 0.05)",
                        borderColor: "rgba(0, 172, 105, 1)",
                        pointRadius: 3,
                        pointBackgroundColor: "rgba(0, 172, 105, 1)",
                        pointBorderColor: "rgba(0, 172, 105, 1)",
                        pointHoverRadius: 3,
                        pointHoverBackgroundColor: "rgba(0, 172, 105, 1)",
                        pointHoverBorderColor: "rgba(0, 172, 105, 1)",
                        pointHitRadius: 10,
                        pointBorderWidth: 2,
                        data: ordersCount
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    layout: {
                        padding: {
                            left: 10,
                            right: 25,
                            top: 25,
                            bottom: 0
                        }
                    },
                    scales: {
                        xAxes: [{
                            time: {
                                unit: "date"
                            },
                            gridLines: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                maxTicksLimit: 7
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                maxTicksLimit: 5,
                                padding: 10,
                                // Include a dollar sign in the ticks
                                callback: function(value, index, values) {
                                    return number_format(value);
                                }
                            },
                            gridLines: {
                                color: "rgb(234, 236, 244)",
                                zeroLineColor: "rgb(234, 236, 244)",
                                drawBorder: false,
                                borderDash: [2],
                                zeroLineBorderDash: [2]
                            }
                        }]
                    },
                    legend: {
                        display: false
                    },
                    tooltips: {
                        backgroundColor: "rgb(255,255,255)",
                        bodyFontColor: "#858796",
                        titleMarginBottom: 10,
                        titleFontColor: "#6e707e",
                        titleFontSize: 14,
                        borderColor: "#dddfeb",
                        borderWidth: 1,
                        xPadding: 15,
                        yPadding: 15,
                        displayColors: false,
                        intersect: false,
                        mode: "index",
                        caretPadding: 10,
                        callbacks: {
                            label: function(tooltipItem, chart) {
                                var datasetLabel =
                                    chart.datasets[tooltipItem.datasetIndex].label || "";
                                return datasetLabel + ": " + number_format(tooltipItem.yLabel);
                            }
                        }
                    }
                }
            });
            ////
            let revenues = <?php echo json_encode($chartData['revenues']);?>;
            var ctx = document.getElementById("myBarChart");
            var myBarChart = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: months,
                    datasets: [{
                        label: "Revenue",
                        backgroundColor: "rgba(0, 97, 242, 1)",
                        hoverBackgroundColor: "rgba(0, 97, 242, 0.9)",
                        borderColor: "#4e73df",
                        data: revenues,
                        maxBarThickness: 25
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    layout: {
                        padding: {
                            left: 10,
                            right: 25,
                            top: 25,
                            bottom: 0
                        }
                    },
                    scales: {
                        xAxes: [{
                            time: {
                                unit: "month"
                            },
                            gridLines: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                maxTicksLimit: 6
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                min: 0,
                                max: 15000,
                                maxTicksLimit: 5,
                                padding: 10,
                                // Include a dollar sign in the ticks
                                callback: function(value, index, values) {
                                    return "$" + number_format(value);
                                }
                            },
                            gridLines: {
                                color: "rgb(234, 236, 244)",
                                zeroLineColor: "rgb(234, 236, 244)",
                                drawBorder: false,
                                borderDash: [2],
                                zeroLineBorderDash: [2]
                            }
                        }]
                    },
                    legend: {
                        display: false
                    },
                    tooltips: {
                        titleMarginBottom: 10,
                        titleFontColor: "#6e707e",
                        titleFontSize: 14,
                        backgroundColor: "rgb(255,255,255)",
                        bodyFontColor: "#858796",
                        borderColor: "#dddfeb",
                        borderWidth: 1,
                        xPadding: 15,
                        yPadding: 15,
                        displayColors: false,
                        caretPadding: 10,
                        callbacks: {
                            label: function(tooltipItem, chart) {
                                var datasetLabel =
                                    chart.datasets[tooltipItem.datasetIndex].label || "";
                                return datasetLabel + ": $" + number_format(tooltipItem.yLabel);
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush
@endsection
