<form id="save-item-form" method="post">
    <div class="row">
            <input type="hidden" class="hidden_id" name="id" value="{{ $item->id }}" />
            @csrf
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-header">Image</div>
                    <div class="card-body text-center">
                        <div class="image-upload-container" id="cover">
                            <div class="image-part">
                                <img class="thumbnail"
                                        src="@if ($item->image) {{ $item->image->path }} @else {!! asset('backend/img/no_avatar.jpg') !!} @endif" />
                                <input type="hidden" name="image" class="cover"
                                        value="@if ($item->image) {{ $item->image->id }} @endif" />
                            </div>
                            <div class="image-action @if ($item->image) fileExist @else fileNotExist @endif">
                                <div>
                                    <span >size: ({{$item->pagename == 'faq' ? '569x613' : '1200 x 627'}}) </span>
                                </div>
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
                            <div class="form-row">
                                <div class="form-group col-12">
                                        <label class="small mb-1" for="pagename">Page name</label>
                                        <input class="form-control" id="pagename" name="title" type="text"
                                            placeholder="pagename" value="{{ $item->pagename }}" disabled />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label class="small mb-1" for="title">Title</label>
                                    <input class="form-control" id="title" name="title" type="text"
                                            placeholder="title" value="{{ $item->title }}" />
                                </div>
                            </div>
                            <div class="form-row">

                                <div class="form-row col-12">
                                    <div class="form-group col-12">
                                        <label class="small mb-1" for="title">Description</label>
                                        <textarea class="form-control col-12 textarea" name="description" rows="12">{{ $item->description }}</textarea>
                                    </div>
                                </div>

                                @if($item->pagename != 'home')
                                <div class="form-row col-md-6">
                                    <label class="small mb-1" for="title">Status</label>
                                    <select class="form-select form-control" name="published"
                                        aria-label="Default select example">
                                        <option @if ($item->published == 1) selected @endif value="1">Active
                                        </option>
                                        <option @if ($item->published == 0) selected @endif value="0">Disabled
                                        </option>
                                    </select>
                                </div>
                                @endif
                                <!-- Tab content end -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</form>
<div class="modal-buttons">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="button" onclick="save()" id="saveItemBtn" class="btn btn-success">Save</button>
</div>

<script>
    function save() {
        tinyMCE.triggerSave();
        Loading.add($('#saveItemBtn'));
        var data = $('#save-item-form').serializeFormJSON();
        console.log(data);

        $.ajax({
            type: "POST",
            url: "{{ route('adminMetaSave') }}",
            data: data,
            dataType: 'json',
            success: function(response) {
                if (response.status == 0) {
                    if (response.messages) {
                        toastr['error'](response.message, 'Error');
                    } else {
                        toastr['error'](response.message, 'Error');
                    }
                }
                if (response.status == 1) {
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
    $(document).ready(function() {

        var upload = new SUpload;
        upload.init({
            uploadContainer: 'cover',
            token: "<?php echo csrf_token(); ?>",
            imageIdReturnEl: ".cover",
            slider: "{{ $item->id }}"
        });

        $(document).on('focusin', function(e) {
            if ($(e.target).closest(".tox-dialog").length) {
                e.stopImmediatePropagation();
            }
        });
    });
</script>
