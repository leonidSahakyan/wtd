function Board(){
    var self = this;
    
    self.load = (token) => {        
        var $boardItems = false;
        var $error = 0;

        $.ajax({
            type: "POST",
            url: '/admin/order-data',
            dataType: 'JSON',
            async: false,
            data:{_token: token}, 
            success: function(response){
                if(response.status == 1){
                    $boardItems = response.data;
                }else{ // gallery id is empty
                    $error = 1;
                    toastr['error'](response.message, 'Error');
                }
            }
        });
    }

    self.rend = (boarItems) => {
        
    }
}