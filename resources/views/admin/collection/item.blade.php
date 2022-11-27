<script type="text/javascript">
	if(typeof(itemPopup) != "undefined"){
		$( itemPopup ).one( "loaded", function(e){
			@if($mode == 'add')
			Loading.remove($('#add_item'));
			@endif
		});
	}
</script>
@include('admin.blocks.uploader')
<form id="save-item-form" method="post">
    <input type="hidden" class="hidden_id" name="id" value="{{ $item->id }}" />
    @csrf
    <div class="row">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">Cover</div>
                <div class="card-body text-center">
                    <!-- Profile picture image-->
                    <div class="image-upload-container" id="cover">
                        <div class="image-part">
                            <img class="thumbnail" src="@if ($item->image_id) {{ $item->image->path }} @else {!! asset('backend/img/no_avatar.jpg') !!} @endif"/>
                            <input type="hidden" name="cover" class="cover" value="@if ($item->image_id) {{ $item->image_id }} @endif" />
                        </div>
                        <div class="image-action @if ($item->image_id) fileExist @else fileNotExist @endif">
                            <div class="img-not-exist">
                                <span id="uploadBtn" class="btn btn-success">Select image </span>
                            </div>
                            <div class="img-exist">
                                <span class="btn btn-danger remove-image">Remove </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header">Details</div>
                <div class="card-body">
                    <div class="card-body">
                        <div class="form-group">
                            <label class="small mb-1" for="title">Title</label>
                            <input class="form-control" name="title" type="text"
                                placeholder="title" value="{{ $item->title }}" />
                        </div>
                        <div class="form-group">
                            <label class="small mb-1" for="title">Slug</label>
                            <input class="form-control" name="slug" type="text"
                                placeholder="Slug" value="{{ $item->slug }}" />
                        </div>
                        <div class="my-2"></div>
                        <div class="form-group">
                            <label class="small mb-1" for="title">Featured</label>:
                            <input class="admin_checkbox" value="1" type="checkbox" name="featured" {{$item->featured == 1 ? 'checked' : ''}} />
                        </div>
                        <div class="my-2"></div>
                        <div class="form-group">
                            <span class="el_item">Status:
                                <select class="form-select form-control" name="status" aria-label="Default select example">
                                    <option @if($item->status == 1) selected @endif value="1">Published</option>
                                    <option @if($item->status == 0) selected @endif value="0">Unublished</option>
                                </select>
                            </span>
                        </div>
                        <div class="my-2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<div class="modal-buttons">
    <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="button" onclick="save()"  id="saveItemBtn" class="btn btn-success">Save</button>
</div>
<script>
function save(){
    Loading.add($('#saveItemBtn'));
    var data = $('#save-item-form').serializeFormJSON();
    
    $.ajax({
        type: "POST",
        url: "{{route('adminCollectionSave')}}",
        data: data,
        dataType: 'json',
        success: function(response){
            if(response.status == 0){
                if(response.messages){
                    toastr['error'](response.messages, 'Error');
                }else{
                    toastr['error'](response.errors, 'Error');
                }
            }
            if(response.status == 1){
                toastr['success']('Saved.', 'Success');
                window.datatable.ajax.reload(null, false);
                itemPopup.close();
            }
            Loading.remove($('#saveItemBtn'));
        },
        error: function(jqXHR, textStatus, errorThrown) {
            toastr['error'](errorThrown, 'Error');
            Loading.remove($('#saveItemBtn'));
        }
    });  
}
$(document).ready(function(){

        var upload = new SUpload;
    	upload.init({
    		uploadContainer: 'cover',
    		token: "<?php echo csrf_token(); ?>",
    		imageIdReturnEl: ".cover",
            temp: 1,
    		onRemove: function (imageId) {
				$.ajax({
					type: "POST",
					url: "{!! route('aCollectionsUnAttachImage') !!}",
					data: {_token: "<?php echo csrf_token(); ?>", 'id': {!! $item->id !!}},
					dataType: 'json',
				});		
			},
    	});

      $(document).on('focusin', function(e) {
        if ($(e.target).closest(".tox-dialog").length) {
            e.stopImmediatePropagation();
        }
    });
});
</script>