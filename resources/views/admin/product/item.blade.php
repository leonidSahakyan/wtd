@if($mode == 'add')
    <script type="text/javascript">
    if(typeof(itemPopup) != "undefined"){
        $( itemPopup ).one( "loaded", function(e){
            console.log('asdasd')
            Loading.remove($('#add_item'));
        });
    }
    </script>
@endif
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
<!-- Main page content-->
<div class="row">
    <div class="col-xxl-12">
        <!-- Tabbed dashboard card example-->
        <div class="card mb-4">
            <div class="card-header border-bottom">
                <!-- Dashboard card navigation-->
                <ul class="nav nav-tabs card-header-tabs" id="dashboardNav" role="tablist">
                    <li class="nav-item mr-1"><a class="nav-link active" id="overview-pill" href="#overview" data-toggle="tab" role="tab" aria-controls="overview" aria-selected="true">Overview</a></li>
                    <li class="nav-item"><a class="nav-link" id="attributes-pill" href="#attributes" data-toggle="tab" role="tab" aria-controls="attributes" aria-selected="false">Attributes</a></li>
                    <!-- <li class="nav-item"><a class="nav-link" id="log-pill" href="#log" data-toggle="tab" role="tab" aria-controls="log" aria-selected="false">Log</a></li> -->
                    <li class="nav-item"><a class="nav-link" id="gallery-pill" href="#gallery" data-toggle="tab" role="tab" aria-controls="gallery" aria-selected="false">Gallery</a></li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="dashboardNavContent">
                    <!-- Dashboard Tab Pane 1-->
                    <form id="save-form" method="post">
                    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-pill">
                        <div class="container mt-4">
                            <div class="row">
                                @csrf
                                <input type="hidden" name="id" id="id" value="{{$item->id}}" />
                                <div class="col-lg-4 mb-4" style="display: inline-table;">
                                    <div class="card h-100 border-left-lg border-left-primary">
                                        <div class="card-header">General</div>
                                        <div class="card-body">
                                            <div class="small">Status</div>
                                            <div class="form-group">
                                                <select class="form-select form-control" name="status" aria-label="">
                                                    <option @if($item->status == 1) selected @endif value="1">Published</option>
                                                    <option @if($item->status == 0) selected @endif value="0">Unpublished</option>
                                                </select>
                                            </div>
                                            @if($collections)
                                            <div class="small">Colleconts</div>
                                            <div class="form-group">
                                                <select class="form-select form-control" name="parent_id" aria-label="">
                                                    <option value="0">- Select collecont -</option>
                                                    @foreach($collections as $collection)
                                                        <option @if($item->parent_id == $collection->id) selected @endif value="{{$collection->id}}">{{$collection->title}}</option>
                                                    @endforeach 
                                                </select>
                                            </div>
                                            @endif
                                            <div class="small">Price $</div>
                                            <div class="form-group">
                                                <input class="form-control" type="number" id="price" name="price" type="text" value="{{$item->price}}" />
                                            </div>
                                            <div class="form-group">
                                                <?php $checked = $item->featured == '1' ? 'checked' : ''; ?>
                                                <input class="admin_checkbox" id="featured" value="1" type="checkbox" name="featured" <?= $checked ?> />
                                                <label for="featured" class="small">Featured</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-8">
                                    <!-- Account details card-->
                                    <div class="card mb-4">
                                        <div class="card-header">Details</div>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label class="small mb-1" for="slug">Slug</label>
                                                <input class="form-control" id="slug" name="slug" type="text" value="{{$item->slug}}" />
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="title">Title</label>
                                                <input class="form-control" id="title" name="title" type="text" value="{{$item->title}}" />
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="sku">Sku</label>
                                                <input class="form-control" id="sku" name="sku" type="text" value="{{$item->sku}}" />
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="title">Description</label>
                                                <textarea class="form-control textarea" id="description" name="description" rows="12">{{ $item->description }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="attributes" role="tabpanel"  aria-labelledby="attributes-tab">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-6 mb-4" style="display: inline-table;">
                                    <div class="card">
                                        <div class="card-header">
                                            Colors
                                        </div>
                                        <div class="card-body">
                                            @foreach(config('constants.attributes.colors') as $color )
                                                <div class="form-group ">
                                                    <?php $checked = in_array($color,$item->colors) ? 'checked' : ''; ?>
                                                    <input class="admin_checkbox" id="color_{{$color}}" value="{{$color}}" type="checkbox" name="colors[]" <?= $checked ?> />
                                                    <label for="color_{{$color}}" class="small">{{$color}}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4" style="display: inline-table;">
                                    <div class="card">
                                        <div class="card-header">
                                            Sizes
                                        </div>
                                        <div class="card-body">
                                            @foreach(config('constants.attributes.sizes') as $size )
                                                <div class="form-group ">
                                                    <?php $checked = in_array($size,$item->sizes) ? 'checked' : ''; ?>
                                                    <input class="admin_checkbox" id="size_{{$size}}" value="{{$size}}" type="checkbox" name="sizes[]" <?= $checked ?> />
                                                    <label for="size_{{$size}}" class="small">{{$size}}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="gallery" role="tabpanel"  aria-labelledby="gallery-tab">
                        <div class="container">
                            <div class="card">
                                <div class="card-header">
                                </div>
                                <div class="card-body">
                                    <div class="clearfix"></div>
                                    <div id="gallery-container"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
            <div class="modal-buttons">
                    <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" onclick="save()" id="saveBtn" class="btn btn-success">Save</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        // initTinymce();
        var gallery = new Gallery;
        gallery.init({
			gallery_id:'{{$item->gallery_id}}',
			_token: '{{ csrf_token() }}',
			container: '#gallery-container',
            edit: 'editImage',
		})

        function editImage(imageId,color){
			$.ajax({
                type: "POST",
                url: "{{ route('changeImageColor') }}",
                data:{_token:"<?php echo csrf_token(); ?>", imageId:imageId,color:color},
                dataType: 'json',
                success: function(response) {
                    if (response.status == 1) {
                        toastr['success']("Changed", 'Success');
                    }else{
                        toastr['error']("Something wrong", 'Error');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    toastr['error'](errorThrown, 'Error');
                }
            });
		}
		window.editImage = editImage;

		window.gallery = gallery;
        @if($hasGallery)
            gallery.load({{$item->gallery_id}})
        @else
            gallery.load()
        @endif
        feather.replace();
    });
    function save() {
        tinyMCE.triggerSave()
        Loading.add($('#saveBtn'));
        var data = $('#save-form').serializeFormJSON();
        $.ajax({
            type: "POST",
            url: "{{ route('productSave') }}",
            data: data,
            dataType: 'json',
            success: function(response) {
                if (response.status == 0) {
                    toastr['error'](response.errors, 'Error');
                }
                if (response.status == 1) {
                    toastr['success'](response.message, 'Success');
                    window.datatable.ajax.reload(null, false);
                    itemPopup.close();
                }
                Loading.remove($('#saveBtn'));
            },
            error: function(jqXHR, textStatus, errorThrown) {
                toastr['error'](errorThrown, 'Error');
                Loading.remove($('#saveBtn'));
            }
        });
    }
</script>