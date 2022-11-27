<script type="text/javascript">
	if(typeof(servicesPopup) != "undefined"){
		$( servicesPopup ).one( "loaded", function(e){
			@if($mode == 'add')
			Loading.remove($('#add_item'));
			@endif
		});
	}
</script>
<form class="save-services-form">
    {{ csrf_field() }}
    <input type="hidden" name="servicesId" value="{{$item->id}}" />
    <input type="hidden" name="user_id" value="{{$item->owner_id}}" />
<div class="row" >
    <div class="col-xl-12">
        <!-- Account details card-->
        <div class="card mb-4">
            <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <div class="small text-muted">Price</div>
                            <input class="form-control " id="price" name="price" type="number" placeholder="Price" value="{{$item->price}}" />
                        </div>
                        <!-- Form Group (organization name)-->
                        <div class="form-group col-md-6">
                            <div class="small text-muted">Category</div>
                            <select class="form-control" name="category_id" id="exampleFormControlSelect1">
                                <option value="1" >category1</option>
                                <option value="2" >category2</option>
                                <option value="3" >category3</option>
                            </select>     
                        </div>
                    </div>
                   
                    <div class="form-group">
                        <div class="small text-muted">Description</div>
                        <textarea class="form-control" id="exampleFormControlTextarea1" name="description" rows="3">{{$item->description}}</textarea>
                    </div>
                    <div class="form-row">
                    <div class="form-group col-md-6">
                        <div class="small text-muted">Images</div>
                       <input type="file" class="form-control" name="image">
                    </div>
                    <div class="modal-buttons">
                        <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" onclick="saveServices()" id="saveServicesBtn" class="btn btn-success">Save</button>
                    </div>
            </div>
        </div>
    </div>
</div>
</form>
<!-- <script type="text/javascript">

	function saveServices(){
		var data = $('.save-services-form').serializeFormJSON();
		Loading.add($('#saveServicesBtn'));
		
		$.ajax({
	        type: "POST",
	        url: "{{ //route('saveServices') }}",
	        data: data,
	        dataType: 'json',
	        success: function(response){
	            if(response.status == 0){
                    toastr['error'](response.message, 'Error');
                }
                if(response.status == 1){
	                toastr['success']('Saved.', 'Success');
					if(typeof(videoPopup) != "undefined"){
	                	@if($mode == 'add') videoGrid.reload(); @else videoGrid.reload(false); @endif
						videoPopup.close();
					}
	            }
	            // Loading.remove($('#saveServicesBtn'));
	        }
            
	    });
	}
</script> -->