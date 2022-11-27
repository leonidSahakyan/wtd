DataTypes = {};

DataTypes.Real = {
    format: function (data) {
        return data;
    }
}
DataTypes.Checkbox = {
    format: function (data) {
        return '<input type="checkbox" class="sb-checkbox" value="'+data.id+'"/>';
    }
}
DataTypes.Published = {
    format: function (data, row) {
    	if(data == 0){
    		return '<a href="javascript:void(0);" pub_item_id="'+row.id+'"  class="btn btn-dark btn-sm btn-circle item_published"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></a>';
    	}else{
    		return '<a href="javascript:void(0);" pub_item_id="'+row.id+'" class="btn btn-success btn-sm  btn-circle item_published"><i class="fa fa-check" aria-hidden="true"></i></a>';
    	}
    }
}