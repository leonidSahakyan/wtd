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
        <div class="col-12">
            <div class="card">
                <div class="card-header">Details</div>
                <div class="card-body">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label class="small mb-1" for="title">Question</label>
                                <input class="form-control" id="title" name="question" type="text"
                                       placeholder="title" value="{{ $item->question }}" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label class="small mb-1" for="title">Answer</label>
                                <textarea class="form-control" id="price" name="answer" rows="12">{{ $item->answer }}</textarea>
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

        $.ajax({
            type: "POST",
            url: "{{ route('adminFaqSave') }}",
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
            faq: "{{ $item->id }}"
        });

        $(document).on('focusin', function(e) {
            if ($(e.target).closest(".tox-dialog").length) {
                e.stopImmediatePropagation();
            }
        });
    });
</script>
