<form id="save-item-form" method="post">
    <div class="row">
        @csrf
        <input type="hidden" name="id" id="id" value="{{$item->id}}" /> 
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Word</h6>
                </div>
                <div class="card-body">
                    <div class="my-2"></div> 
                    <div class="form-row">  
                        <div class="form-group col-12">
                            <span class="el_item">Key:
                            <input type="text" name="key" id="key" readonly class="form-control" value="{{$item->key}}"/>
                            </span>
                        </div>
                        <div class="form-group col-12">
                            <span class="el_item">Type:
                            <input type="text" name="type" id="Type" readonly class="form-control" value="{{$item->type}}"/>
                            </span>
                        </div>
                    </div>
                    <div class="my-2"></div>
                    <!-- Tab nav start-->
                    <!-- <div class="card-header border-bottom" style="background-color:#fff;">
                        <ul class="nav nav-tabs card-header-tabs" id="dashboardNav" role="tablist">
                            @foreach (Session::get('bLangs') as $index => $lang)
                                <li class="nav-item mr-1"><a class="nav-link @if($index == 0) active @endif" id="multi_content_{{ $lang['lang'] }}-pill" href="#multi_content_{{ $lang['lang'] }}" data-toggle="tab" role="tab" aria-controls="multi_content_{{ $lang['lang'] }}" aria-selected="@if($index == 0) true @else false @endif">{{ $lang['title'] }}</a></li>
                            @endforeach
                        </ul>
                    </div> -->
                    <div class="my-2"></div>
                    <!-- Tab nav start-->
                    <!-- Tab content start-->
                    <div class="tab-content" id="dashboardNavContent">
                        @foreach (Session::get('bLangs') as $index => $lang)
                        <?php $title = $lang['lang']?>
                        <!-- Dashboard Tab Pane 1-->
                        <!-- <div class="tab-pane fade @if($index == 0) show active @endif" id="multi_content_{{ $lang['lang'] }}" role="tabpanel" aria-labelledby="multi_content_{{ $lang['lang'] }}-pill"> -->
                            <div class="container p-0">
                                <div class="form-group">
                                    <label class="small mb-1" for="{{ $lang['lang'] }}">Title</label>
                                    <input class="form-control" id="{{ $lang['lang'] }}" name="title" type="text" placeholder="{{$item->key}}" value="{{$item->$title}}" />
                                </div>
                            </div>
                            
                        <!-- </div> -->
                        @endforeach
                        <div class="modal-buttons">
                                <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" onclick="save()"  id="saveItemBtn" class="btn btn-success" >Save</button>
                            </div>
                    </div>
                    <!-- Tab content end -->
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
        url: "{{route('adminDicionarySave')}}",
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
                // tinymce.execCommand('mceRemoveControl', true, '.mytextarea');
                toastr['success']('Saved.', 'Success');
                window.datatable.ajax.reload(null, false);
                $('#sync').attr('disabled',false);
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

      $(document).on('focusin', function(e) {
        if ($(e.target).closest(".tox-dialog").length) {
            e.stopImmediatePropagation();
        }
    });
});
</script>