@if($orderUploads && count($orderUploads) > 0)
    @include('admin.blocks.fancy')
@endif
@if($hasGallery)
<link href="{!! asset('backend/plugins/dropzone/css/dropzone.css') !!}" media="all" rel="stylesheet" type="text/css" />
<script src="{!! asset('backend/plugins/dropzone/dropzone.js') !!}" type="text/javascript"></script>
<script src="{!! asset('backend/js/scripts/gallery.js?8') !!}" type="text/javascript"></script>
<div id="preview-template" style="display:none">
	<div class="dz-preview dz-file-preview">
		<div class="dz-details">
			<div class="dz-filename"><span data-dz-name></span></div>
			<!-- <div class="dz-size" data-dz-size></div> -->
			<img data-dz-thumbnail />
		</div>
		<div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
		<div class="dz-success-mark"><span>✔</span></div>
		<div class="dz-error-mark"><span>✘</span></div>
		<div class="dz-error-message"><span data-dz-errormessage></span></div>
	</div>
</div>
<style>
.fade:not(.show) {
    opacity: 0;
    display: none;
}
</style>
@endif
<!-- Main page content-->
<div class="row">
    <div class="col-xxl-12">
        <!-- Tabbed dashboard card example-->
        <div class="card mb-4">
            <div class="card-header border-bottom">
                <!-- Dashboard card navigation-->
                <ul class="nav nav-tabs card-header-tabs" id="dashboardNav" role="tablist">
                    <li class="nav-item mr-1"><a class="nav-link active" id="overview-pill" href="#overview" data-toggle="tab" role="tab" aria-controls="overview" aria-selected="true">Overview</a></li>
                    <li class="nav-item"><a class="nav-link" id="uploads-pill" href="#uploads" data-toggle="tab" role="tab" aria-controls="uploads" aria-selected="false">Uploads</a></li>
                    <li class="nav-item"><a class="nav-link" id="log-pill" href="#log" data-toggle="tab" role="tab" aria-controls="log" aria-selected="false">Log</a></li>
                    <li class="nav-item"><a class="nav-link" id="review-pill" href="#review" data-toggle="tab" role="tab" aria-controls="review" aria-selected="false">Review</a></li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="dashboardNavContent">
                    <!-- Dashboard Tab Pane 1-->
                    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-pill">
                        <div class="container mt-4">
                            <!-- Account page navigation-->
                            <!-- <hr class="mt-0 mb-4" /> -->
                            <form id="save-overview-form" method="post">
                                <div class="row">
                                    @csrf
                                    <input type="hidden" name="id" id="id" value="{{$item->id}}" />
                                    <div class="col-lg-4 mb-4" style="display: inline-table;">
                                        <div class="card h-100 border-left-lg border-left-primary mt-md-2">
                                            <div class="card-body">
                                                <div class="small text-muted">Status</div>
                                                <div class="form-group">
                                                    <select class="form-select form-control" disabled name="status" aria-label="">
                                                        <option @if($item->status == 'new') selected @endif value="active">New</option>
                                                        <option @if($item->status == 'paid') selected @endif value="disabled">paid</option>
                                                        <option @if($item->status == 'declined') selected @endif value="disabled">Declined</option>
                                                    </select>
                                                </div>
                                                @if($masters && count($masters) > 0)
                                                <div class="small text-muted">Master</div>
                                                <div class="form-group">
                                                    <select class="form-select form-control" {{Auth::guard('admin')->user()->role != 'superadmin' ? 'disabled' : ''}} name="master_id" aria-label="">
                                                        <option value="0">- Assign master-</option>
                                                        @foreach($masters as $master)
                                                        <option @if($item->master_id == $master->id) selected @endif value="{{$master->id}}">{{$master->name.' '.$master->last_name}}</option>
                                                        @endforeach 
                                                    </select>
                                                </div>
                                                @endif
                                                @if(Auth::guard('admin')->user()->role == 'superadmin')
                                                <div class="form-group" style="text-align:center;">
                                                    <button type="button" style="width: 100%;" onclick="saveOrderOverview()"  id="saveOrderOverviewBtn" class="btn btn-success">Save</button>
                                                </div>
                                                @endif
                                                <div class="small text-muted">Total:</div>
                                                <div class="h5">{{$item->total}} $</div>
                                                <?php /* @if($item->replacment_price > 0)
                                                    <div class="small text-muted">Replacment_price</div>
                                                    <div class="h5">{{$item->replacment_price}} $</div>
                                                    <div class="small text-muted">Total</div>
                                                    <div class="h5">{{$item->total}} $</div>
                                                @endif */ ?>
                                            </div>
                                        </div>
                                        <!-- Billing card 1-->
                                        <div class="card h-100 border-left-lg border-left-primary mt-md-2">
                                            <div class="card-body">
                                                <div class="small text-muted">Notes</div>
                                                <div class="form-group">
                                                    <textarea class="form-control" name="notes" id="notes" rows="3">{{$item->notes}}</textarea>
                                                </div>
                                                <div class="form-group" style="text-align:center;">
                                                    <button type="button" style="width: 100%;" onclick="saveNotes()"  id="saveNotesBtn" class="btn btn-success">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card h-100 border-left-lg border-left-primary mt-md-2">
                                            <div class="card-body">
                                                <div class="small text-muted">Location type</div>
                                                <div class="form-group">
                                                    <select class="form-select form-control" disabled name="location_type" aria-label="">
                                                        <option @if($item->second_type == 'residential') selected @endif value="active">Residential</option>
                                                        <option @if($item->second_type == 'commercial') selected @endif value="disabled">Commercial</option>
                                                    </select>
                                                </div>
                                                <div class="small text-muted">For</div>
                                                <div class="form-group">
                                                    <select class="form-select form-control" disabled name="for" aria-label="">
                                                        <option @if($item->type == 'home_owner') selected @endif value="active">Homeowner</option>
                                                        <option @if($item->type == 'commercial') selected @endif value="disabled">Business</option>
                                                    </select>
                                                </div>
                                                <div class="small text-muted">Order:</div>
                                                <div class="h5">ID: {{$item->sku}} </div>
                                                <div class="small text-muted">Order date</div>
                                                <div class="h5">{{$item->order_date}} {{$item->order_time == 'am' ? 'AM(8:00-12:00)' : 'PM(12:00-18:00)' }}</div>
                                                <div class="small text-muted">Create at</div>
                                                <div class="h5">{{$item->created_at}}</div>
                                            </div>
                                        </div>
                                        <!-- Billing card 1-->
                                        <div class="card h-100 border-left-lg border-left-primary mt-md-2">
                                            <div class="card-body">
                                                <div class="small text-muted">Rate:</div>
                                                <div class="h5"> </div>
                                                <div class="small text-muted">Comment</div>
                                                <div class="h5"></div>
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
                                                        <label class="small mb-1" for="address">Address</label>
                                                        <input class="form-control" id="address" readonly disabled name="address" type="text" value="{{$item->address}}" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="service">Service</label>
                                                        <input class="form-control" id="service" readonly disabled name="service" type="text" value="{{$item->title}} ({{$item->service_price}} $) - {{$item->service_type_title}}" />
                                                    </div>
                                                    <div class="form-group">
                                                    @if(count($orderReplacement) > 0)
                                                        <label style="margin-bottom:5px;">Replacment(s)</label>
                                                        @foreach($orderReplacement as $replacment)
                                                            @if($replacment->price > 0)
                                                                <div class="checkout_item">{{ $replacment->title }} (Qty: {{ $replacment->qty }}) - {{ $replacment->price }}$ <span style="float:right" class="price_sub">{{ $replacment->qty * $replacment->price}} $</span></div>
                                                            @else
                                                                <div class="checkout_item">{{ $replacment->title }}</div>
                                                            @endif
                                                        @endforeach
                                                        <div class="hr"></div>
                                                    @endif
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="description">Client notes</label>
                                                        <textarea class="form-control" name="comment" readonly disabled rows="3">{{$item->comment}}</textarea>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="uploads" role="tabpanel"  aria-labelledby="uploads-tab">
                        <div class="container">
                            <div class="card">
                                <div class="card-header">
                                </div>
                                <div class="card-body">
                                    @if($orderUploads && count($orderUploads) > 0)
                                        <div class="flex fancybox-gallery  flex-wrap gap-5 justify-center max-w-5xl mx-auto px-6">
                                            @foreach($orderUploads as $upload)
                                                <a data-fancybox="gallery" href="{{asset('images/original/'.$upload->filename.'.'.$upload->ext)}}">
                                                    <img class="rounded" src="{{asset('images/backendSmall/'.$upload->filename.'.'.$upload->ext)}}" />
                                                </a>
                                            @endforeach
                                        </div>
                                    @else
                                        Images not uploads
                                    @endif
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
                                            @if($log->type == 'order_created')
                                            <i class="mr-2 text-green" data-feather="zap-off"></i>
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
                    <div class="tab-pane fade" id="review" role="tabpanel"  aria-labelledby="review-tab">
                        <div class="container">
                            <div class="card">
                                <div class="card-header">
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="small mb-1" for="description">Master review</label>
                                        <textarea class="form-control" name="master_review" id="master_review" rows="3">{{$item->master_review}}</textarea>
                                    </div>
                                    <div class="form-group" style="text-align:center;">
                                        <button type="button" style="float:right; margin-bottom:15px;" onclick="saveReview()"  id="saveReviewBtn" class="btn btn-success">Save</button>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div id="gallery-container"></div>
                                </div>
                            </div>
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
    function saveOrderOverview() {
        Loading.add($('#saveOrderOverviewBtn'));
        var data = $('#save-overview-form').serializeFormJSON();
        $.ajax({
            type: "POST",
            url: "{{ route('adminSaveOverview') }}",
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
                Loading.remove($('#saveOrderOverviewBtn'));
            },
            error: function(jqXHR, textStatus, errorThrown) {
                toastr['error'](errorThrown, 'Error');
                Loading.remove($('#saveOrderOverviewBtn'));
            }
        });
    }
    function saveReview() {
        Loading.add($('#saveReviewBtn'));

        var id = $('#id').val();
        var review = $('#master_review').val();
        
        $.ajax({
            type: "POST",
            url: "{{ route('adminSaveReview') }}",
            dataType: 'json',
            data:{_token: "<?php echo csrf_token(); ?>", id:id, review: review},
            success: function(response) {
                if (response.status == 0) {
                    toastr['error'](response.message, 'Error');
                }
                if (response.status == 1) {
                    toastr['success'](response.message, 'Success');
                }
                Loading.remove($('#saveReviewBtn'));
            },
            error: function(jqXHR, textStatus, errorThrown) {
                toastr['error'](errorThrown, 'Error');
                Loading.remove($('#saveReviewBtn'));
            }
        });
    }
    function saveNotes() {
        Loading.add($('#saveNotesBtn'));

        var id = $('#id').val();
        var notes = $('#notes').val();
        
        $.ajax({
            type: "POST",
            url: "{{ route('adminSaveNotes') }}",
            dataType: 'json',
            data:{_token: "<?php echo csrf_token(); ?>", id:id, notes: notes},
            success: function(response) {
                if (response.status == 0) {
                    toastr['error'](response.message, 'Error');
                }
                if (response.status == 1) {
                    toastr['success'](response.message, 'Success');
                }
                Loading.remove($('#saveNotesBtn'));
            },
            error: function(jqXHR, textStatus, errorThrown) {
                toastr['error'](errorThrown, 'Error');
                Loading.remove($('#saveNotesBtn'));
            }
        });
    }
</script>
@if($hasGallery)
<script>
    $(document).ready(function() {

        var gallery = new Gallery;
		gallery.init({
			gallery_id:'<?php echo $item->review_gallery_id; ?>',
			_token: '<?php echo csrf_token(); ?>',
			container: '#gallery-container',
		})
		window.gallery = gallery;
		gallery.load();
        feather.replace();
    });
</script>
@endif