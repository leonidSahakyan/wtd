
<form id="save-service-type-form" method="post">
    <input type="hidden" name="id" value="{{ $item->id }}" />
    <input type="hidden" name="parent_id" value="{{ $item->parent_id }}" />
    @csrf
    <div class="row">
        <div class="col-xl-12">
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
                            <div class="form-group col-md-6">
                                Status:
                                <select class="form-select form-control" name="published"
                                    aria-label="Default select example">
                                    <option @if ($item->published == 1) selected @endif value="1">Active
                                    </option>
                                    <option @if ($item->published == 0) selected @endif value="0">Disabled
                                    </option>
                                </select>
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
    <button type="button" onclick="save()" id="saveServiceTypeBtn" class="btn btn-success">Save</button>
</div>

<script>
    function save() {
        tinyMCE.triggerSave();
        Loading.add($('#saveServiceTypeBtn'));
        var data = $('#save-service-type-form').serializeFormJSON();
        $.ajax({
            type: "POST",
            url: "{{ route('adminServicesTypeSave') }}",
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
                    window.dataTableTypes.ajax.reload(null, false);
                    typePopup.close();
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
        $(document).on('focusin', function(e) {
            if ($(e.target).closest(".tox-dialog").length) {
                e.stopImmediatePropagation();
            }
        });
    });
</script>