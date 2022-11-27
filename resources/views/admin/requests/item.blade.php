<div class="row">
    <div class="col-xxl-12">
        <!-- Tabbed dashboard card example-->
        <div class="card mb-4">
            <div class="card-header border-bottom">
                <!-- Dashboard card navigation-->
                <ul class="nav nav-tabs card-header-tabs" id="dashboardNav" role="tablist">
                    <li class="nav-item mr-1"><a class="nav-link active" id="overview-pill" href="#overview" data-toggle="tab" role="tab" aria-controls="overview" aria-selected="true">Overview</a></li>
                    <!-- <li class="nav-item"><a class="nav-link" id="activities-pill" href="#activities" data-toggle="tab" role="tab" aria-controls="activities" aria-selected="false">Activities</a></li> -->
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="dashboardNavContent">
                    <!-- Dashboard Tab Pane 1-->
                    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-pill">
                        <div class="container mt-4">
                            <!-- Account page navigation-->
                            <!-- <hr class="mt-0 mb-4" /> -->
                            <form id="save-item-form" method="post">
                                <div class="row">
                                    @csrf
                                    <input type="hidden" name="id" id="id" value="{{$item->id}}" />
                                    <div class="col-lg-4 mb-4" style="display: inline-table;">
                                        <!-- Billing card 1-->
                                        <div class="card h-100 border-left-lg border-left-primary">
                                            <div class="card-body">
                                                <div class="small text-muted">Status</div>
                                                <div class="form-group">
                                                    <select class="form-select form-control" disabled name="status" aria-label="">
                                                        <option @if($item->status == 'waiting') selected @endif value="active">Waiting</option>
                                                        <option @if($item->status == 'approved') selected @endif value="disabled">Approved</option>
                                                        <option @if($item->status == 'declined') selected @endif value="disabled">Declined</option>
                                                    </select>
                                                </div>
                                                <div class="small text-muted">Order:</div>
                                                <div class="h5">ID: {{$item->id}} </div>
                                                <div class="small text-muted">Create</div>
                                                <div class="h5">{{$item->created_at}}</div>
                                            </div>
                                        </div>
                                        <!-- Billing card 1-->
                                        <div class="card h-100 border-left-lg border-left-primary mt-md-2">
                                            <div class="card-body">
                                                <div class="small text-muted">Rate:</div>
                                                <div class="h5">{{$item->rate}} </div>
                                                <div class="small text-muted">Comment</div>
                                                <div class="h5">{{$item->comment}}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-8">
                                        <!-- Account details card-->
                                        <div class="card mb-4">
                                            <div class="card-header">Details</div>
                                            <div class="card-body">
                                                <form>
                                                    <!-- Form Group (username)-->
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="customer">Customer</label>
                                                        <input class="form-control" id="customer" readonly disabled name="customer" type="text" value="({{$customer->id}}) {{$customer->fullname}}" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="employee">Employee</label>
                                                        <input class="form-control" id="employee" readonly disabled name="employee" type="text" value="({{$item->employee_id}}) {{$item->fullname}}" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="Category">Category</label>
                                                        <select class="form-select form-control" name="parent_id" id="parent_id" disabled aria-label="Default select example">
                                                            <option value="0">{{$item->category_title}}</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="price">Price</label>
                                                        <input class="form-control" id="price" readonly disabled name="price" type="text" value="{{$item->price ? $item->price : 0 }}" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="description">Description</label>
                                                        <textarea class="form-control" name="description" readonly disabled rows="3">{{$item->description}}</textarea>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Dashboard Tab Pane 2-->
                    <!-- <div class="tab-pane fade" id="activities" role="tabpanel" aria-labelledby="activities-pill">
                        <div class="datatable table-responsive">
                            <table class="table table-bordered table-hover" id="dataTableActivity" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Event</th>
                                        <th>Time</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Date</th>
                                        <th>Event</th>
                                        <th>Time</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <tr>
                                        <td>01/03/22</td>
                                        <td>
                                            <i class="mr-2 text-green" data-feather="zap"></i>
                                            Success transfer - Transfer #<a href="#!">1126550</a>
                                        </td>
                                        <td>1:21 AM</td>
                                    </tr>
                                    <tr>
                                        <td>01/03/22</td>
                                        <td>
                                            <i class="mr-2 text-green" data-feather="zap"></i>
                                            Find card & supplier
                                        </td>
                                        <td>1:21 AM</td>
                                    </tr>
                                    <tr>
                                        <td>01/03/22</td>
                                        <td>
                                            <i class="mr-2 text-green" data-feather="zap"></i>
                                            Start transfer - Transfer #<a href="#!">1126550</a>
                                        </td>
                                        <td>1:21 AM</td>
                                    </tr>
                                    <tr>
                                        <td>01/03/22</td>
                                        <td>
                                            <i class="mr-2 text-red" data-feather="zap-off"></i>
                                            Start order processing
                                        </td>
                                        <td>1:00 AM</td>
                                    </tr>
                                    <tr>
                                        <td>01/03/22</td>
                                        <td>
                                            <i class="mr-2 text-purple" data-feather="shopping-cart"></i>
                                            New order placed - Order #
                                            <a href="#!">1126550</a>
                                        </td>
                                        <td>5:45 AM</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>  -->
                    <div class="modal-buttons">
                            <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <!-- <button type="button" onclick="save()"  id="saveItemBtn" class="btn btn-success" data-dismiss="modal">Save</button> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
