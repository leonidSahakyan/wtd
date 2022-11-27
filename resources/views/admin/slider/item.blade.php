<script type="text/javascript">
    if (typeof(itemPopup) != "undefined") {
        $(itemPopup).one("loaded", function(e) {
            initTinymce();
            @if ($mode == 'add')
            Loading.remove($('#add_item'));
            @endif
        });
    }
</script>
<form id="save-item-form" method="post">
    <input type="hidden" class="hidden_id" name="id" value="{{ $item->id }}" />
    @csrf
    <div class="row">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">Image</div>
                <div class="card-body text-center">
                    <!-- Profile picture image-->
                    <div class="image-upload-container" id="cover">
                        <div class="image-part">
                            <img class="thumbnail"
                                 src="@if ($item->image) {{ $item->image->path }} @else {!! asset('backend/img/no_avatar.jpg') !!} @endif" />
                             <input type="hidden" name="image" class="cover"
                                   value="@if ($item->image) {{ $item->image->id }} @endif" />
                        </div>
                        <div class="image-action @if ($item->image) fileExist @else fileNotExist @endif">
                            <div>
                                <span >size: (1920 x 828) </span>
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
                                <label class="small mb-1" for="title">Title</label>
                                <input class="form-control" id="title" name="title" type="text"
                                       placeholder="title" value="{{ $item->title }}" />
                            </div>
                        </div>
                        <div class="form-row">
                        <label class="small mr-3 mt-2 ml-1">Link Type:</label>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="linktype" id="inlineRadio1" value="1" @if ($item->linktype == 1) checked @endif>
                          <label class="form-check-label" for="inlineRadio1">Internal</label>
                        </div>
                        <div class="form-check form-check-inline">
                           <input class="form-check-input" type="radio" name="linktype" id="inlineRadio2" value="0" @if ($item->linktype == 0) checked @endif >
                            <label class="form-check-label" for="inlineRadio2">External</label>
                        </div>

                        </div>

                        <div class="form-row">
                            <div class="form-group col-12">
                                <label class="small mb-1" for="link">Link</label>
                                <input class="form-control" id="link" name="link" type="text"
                                       placeholder="link" value="{{ $item->link }}"
                                       />
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-12">
                                <label class="small mb-1" for="namebutton">Button Name</label>
                                <input class="form-control" id="namebutton" name="namebutton" type="text"
                                       placeholder="Nuttonname" value="{{ $item->namebutton }}" />
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-12">
                                <label class="small mb-1" for="title">Description</label>
                                <textarea class="form-control textarea" name="description" rows="12">{{ $item->description }}</textarea>
                            </div>
                        </div>

                        <div class="form-row">

                            <div class="form-group col-md-6">
                                Status:
                                <select class="form-select form-control" name="published"
                                        aria-label="Default select example">
                                    <option @if ($item->published == 1) selected @endif value="1">Active
                                    </option>
                                    <option @if ($item->published == 0) selected @endif value="0">Disabled
                                    </option>
                                </select>
                                </span>
                            </div>
                        </div>
                        <!-- Tab content end -->
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
            url: "{{ route('adminSliderSave') }}",
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
