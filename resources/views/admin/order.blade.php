<!-- Main page content-->
<style>
.customSelect option[disabled] { color: #ccc; }
</style>
<div class="row">
    <div class="col-xxl-12">
        <!-- Tabbed dashboard card example-->
        <div class="card mb-4">
            <div class="card-header border-bottom">
                <!-- Dashboard card navigation-->
                <ul class="nav nav-tabs card-header-tabs" id="dashboardNav" role="tablist">
                    <li class="nav-item mr-1"><a class="nav-link active" id="overview-pill" href="#overview" data-toggle="tab" role="tab" aria-controls="overview" aria-selected="true">Overview</a></li>
                    <li class="nav-item"><a class="nav-link" id="items-pill" href="#items" data-toggle="tab" role="tab" aria-controls="items" aria-selected="false">Item(s)</a></li>
                    <li class="nav-item"><a class="nav-link" id="log-pill" href="#log" data-toggle="tab" role="tab" aria-controls="log" aria-selected="false">Log</a></li>
                    <li class="nav-item"><a class="nav-link" id="billing-pill" href="#billing" data-toggle="tab" role="tab" aria-controls="review" aria-selected="false">Billing</a></li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="dashboardNavContent">
                    <!-- Dashboard Tab Pane 1-->
                    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-pill">
                        <div class="container mt-4">
                            <!-- Account page navigation-->
                            <!-- <hr class="mt-0 mb-4" /> -->
                            <form id="save-form" method="post">
                                <div class="row">
                                    @csrf
                                    <input type="hidden" name="id" id="id" value="{{$item->id}}" />
                                    <div class="col-lg-4 mb-4" style="display: inline-table;">
                                        <div class="card h-100 border-left-lg border-left-primary mt-md-2">
                                            <div class="card-body">
                                                <div class="small text-muted">Status</div>
                                                <div class="form-group">
                                                    <select class="form-select form-control customSelect" @if(!$item->is_paid) disabled @endif name="status" aria-label="">
                                                        <option @if($item->status == 'new') selected @endif @if($item->is_paid) disabled @endif value="new">New</option>
                                                        <option @if($item->status == 'paid') selected @endif value="paid">Paid</option>
                                                        <option @if($item->status == 'shipping') selected @endif value="shipping">Shipping</option>
                                                        <option @if($item->status == 'done') selected @endif value="done">Done</option>
                                                        <option @if($item->status == 'canceled') selected @endif value="canceled">Canceled</option>
                                                    </select>
                                                </div>
                                                <div class="small text-muted">Notes</div>
                                                <div class="form-group">
                                                    <textarea class="form-control" name="comment" id="comment" rows="3">{{$item->comment}}</textarea>
                                                </div>
                                                <div class="form-group" style="text-align:center;">
                                                    <button type="button" style="width: 100%;" onclick="saveOrder()"  id="saveOrderBtn" class="btn btn-success">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Billing card 1-->
                                        <div class="card h-100 border-left-lg border-left-primary mt-md-2">
                                            <div class="card-body">
                                                <div class="h6">
                                                    <span class="small text-muted">Order Id:</span> 
                                                    <span class="float-right">{{$item->sku}}</span> 
                                                </div>
                                                <div class="h6">
                                                    <span class="small text-muted">Created:</span> 
                                                    <span class="float-right">{{$item->created_at}}</span> 
                                                </div>
                                                <hr>
                                                <div class="h6">
                                                    <span class="small text-muted">{{$item->qty}} Item(s):</span> 
                                                    <span class="float-right">${{$item->items_price}}</span> 
                                                </div>
                                                <div class="h6">
                                                    <span class="small text-muted">Shipping price:</span> 
                                                    <span class="float-right">${{$item->shipping_price}}</span> 
                                                </div>
                                                <hr>
                                                <div class="h6">
                                                    <span class="small text-muted">Total:</span> 
                                                    <span class="float-right">${{$item->total}}</span> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-8">
                                        <!-- Account details card-->
                                        <div class="card mb-4">
                                            <div class="card-header">Details
                                                @if(!$item->is_paid)
                                                    <span class='float-right' style="color:red">Not Paid</span>
                                                @else
                                                    <span class='float-right' style="color:#6900c7">Paid</span>
                                                @endif
                                            </div>
                                            <div class="card-body">
                                                <form>
                                                    <!-- Form Group (username)-->
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="firstname">Firstname</label>
                                                        <input class="form-control" id="Firstname" readonly disabled name="firstname" type="text" value="{{$item->first_name}}" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="lastname">Lastname</label>
                                                        <input class="form-control" id="lastname" readonly disabled name="lastname" type="text" value="{{$item->last_name}}" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="phone">Phone</label>
                                                        <input class="form-control" id="phone" readonly disabled name="phone" type="text" value="{{$item->phone}}" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="email">Email</label>
                                                        <input class="form-control" id="email" readonly disabled name="email" type="text" value="{{$item->email}}" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="small mb-1">Country</label>
                                                        <input class="form-control" readonly disabled type="text" value="{{$country}}" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="small mb-1">City</label>
                                                        <input class="form-control" readonly disabled type="text" value="{{$item->city}}" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="address">Address</label>
                                                        <input class="form-control" id="address" readonly disabled name="address" type="text" value="{{$item->address}}" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="small mb-1">Post code</label>
                                                        <input class="form-control" readonly disabled type="text" value="{{$item->post_code}}" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="description">Client notes</label>
                                                        <textarea class="form-control" name="comment" readonly disabled rows="3">{{$item->notes}}</textarea>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="items" role="tabpanel"  aria-labelledby="items-tab">
                        <div class="container">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        @if(count($orderItems) > 0)
                                            <!-- <label style="margin-bottom:5px;">{{$item->qty}} Item(s)</label>-->
                                            @foreach($orderItems as $orderItem)
                                            <div class="card">
                                                <div class="row no-gutters">
                                                    <div class="col-lg-2"><img class="img-fluid" src="{{$orderItem->imagePath}}" alt=""></div>
                                                    <div class="col-lg-4">
                                                        <div class="card-body">
                                                            <p class="card-text"><b>Title:</b>{{$orderItem->title}}</p>
                                                            <p class="card-text"><b>Collection:</b> {{$orderItem->collection}}</p>
                                                            <p class="card-text"><b>Sku:</b> {{$orderItem->sku}}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <div class="card-body">
                                                            @if(isset($orderItem->color))
                                                            <p class="card-text"><b>Color:</b> {{$orderItem->color}}</p>
                                                            @endif
                                                            @if(isset($orderItem->size))
                                                            <p class="card-text"><b>Size:</b> {{$orderItem->size}}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <div class="card-body">
                                                            <p class="card-text"><b>Price:</b> ${{$orderItem->price}}</p>
                                                            <p class="card-text"><b>Quantity:</b> {{$orderItem->qty}}</p>
                                                            <p class="card-text"><b>Total:</b> ${{$orderItem->price * $orderItem->qty}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                            </div>
                                                <!-- <h5 class="card-title">Card Image (Left)</h5>
                                                <p class="card-text">Use the Bootstrap grid with utility classes to create this card variant.</p>
                                                <div class="checkout_item">{{ $orderItem->title }} (Qty: {{ $orderItem->qty }}) - {{ $orderItem->price }}$ <span style="float:right" class="price_sub">{{ $orderItem->qty * $orderItem->price}} $</span></div> -->
                                            @endforeach
                                            <!--<div class="hr"></div> -->
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="log" role="tabpanel" aria-labelledby="log-pill">
                        <div class="datatable table-responsive">
                            <table class="table table-bordered table-hover"  width="100%" cellspacing="0">
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
                                    @if($logs)
                                    @foreach ($logs as $log)
                                    <?php $created_at = explode(' ',$log->created_at); ?> 
                                    <tr>
                                        <td><?= $created_at[0] ?></td>
                                        <td>
                                            @if($log->type == 'status_changed')
                                                <i class="mr-2 text-green" data-feather="tag"></i>
                                                Status changed from:
                                                <?php $payload = json_decode($log->data); echo $payload->old_status; ?>
                                                - to: <?php echo $payload->new_status; ?>
                                            @endif
                                            @if($log->type == 'order_created')
                                            <i class="mr-2 text-green" data-feather="zap"></i>
                                            Order created
                                            @endif
                                            @if($log->type == 'order_paid')
                                            <i class="mr-2 text-purple" data-feather="shopping-cart"></i>
                                            Order paid
                                            @endif
                                        </td>
                                        <td><?= $created_at[1] ?></td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="billing" role="tabpanel"  aria-labelledby="billing-tab">
                        <div class="datatable table-responsive">
                            <table class="table table-bordered table-hover"  width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Invoice</th>
                                        <th>Created</th>
                                        <th>Paid</th>
                                        <th>Amount</th>
                                        <th>TRX</th>
                                        <th>Type</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Invoice</th>
                                        <th>Created</th>
                                        <th>Paid</th>
                                        <th>Amount</th>
                                        <th>TRX</th>
                                        <th>Type</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @if($invoce)
                                        <tr>
                                            <td>{{$invoce->hash}}</td>
                                            <td>{{$invoce->created}}</td>
                                            <td>{{$invoce->paid}}</td>
                                            <td>{{$invoce->amount}} $</td>
                                            <td>{{$invoce->paypal_transaction_id}}</td>
                                            <td>{{ucfirst($invoce->type)}}</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>   
                    </div>
                </div>
            </div>
            <div class="modal-buttons">
                    <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <!-- <button type="button" onclick="save()"  id="saveItemBtn" class="btn btn-success" data-dismiss="modal">Save</button> -->
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        feather.replace();
    });
    function saveOrder() {
        Loading.add($('#saveOrderBtn'));
        var data = $('#save-form').serializeFormJSON();
        $.ajax({
            type: "POST",
            url: "{{ route('saveOrder') }}",
            data: data,
            dataType: 'json',
            success: function(response) {
                if (response.status == 0) {
                    toastr['error'](response.message, 'Error');
                }
                if (response.status == 1) {
                    toastr['success'](response.message, 'Success');
                    window.datatable.ajax.reload(null, false);
                }
                Loading.remove($('#saveOrderBtn'));
            },
            error: function(jqXHR, textStatus, errorThrown) {
                toastr['error'](errorThrown, 'Error');
                Loading.remove($('#saveOrderBtn'));
            }
        });
    }
</script>
<script>
    $(document).ready(function() {
        feather.replace();
    });
</script>