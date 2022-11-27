var SUpload = function () {
    return {
        //main function to initiate the module
        init: function (options) {

            options = $.extend(true, {
              uploadContainer:false,
              token:false,
              temp:0,
              button:'uploadBtn',
              original:0,
              avatar:false,
              category:false,
              filename:0,
              imageIdReturnEl: '.upload_image'
            }, options);

            var uploadImageContainer = document.getElementById(options.uploadContainer); 
            $(uploadImageContainer).find('.remove-image').on('click', function(e) {
              var removeImageId = $(uploadImageContainer).find(options.imageIdReturnEl).val();
                if(removeImageId){
                      // console.log(options.token)
                      // Remove from server and db
                      $.ajax({
                        	type: "POST",
                        	url: "/admin/remove-image",
                        	dataType: 'JSON',
                        	data:{_token:options.token,imageId:removeImageId,avatar:options.avatar,category:options.category},
                        		success: function(response){
                              $(uploadImageContainer).find('.image-part img').attr('src','/backend/img/no_image.png');
                              $(uploadImageContainer).find(options.imageIdReturnEl).val('');
                              $(uploadImageContainer).find('.image-action').removeClass('fileExist').addClass('fileNotExist');    
                              if (options.onRemove) {
                                  options.onRemove.call(undefined, removeImageId);
                              }
                        		}
                        	});
                    }
            });
            var uploader = new ss.SimpleUpload({
                button: options.button,
                url: "/admin/upload-image", // server side handler
                responseType: 'json',
                name: 'file',
                method: 'POST',
                data: {'_token': options.token, 'temp': options.temp, 'avatar': options.avatar, 'category': options.category, 'original': options.original, 'filename': options.filename},
                allowedExtensions: ['jpg', 'jpeg', 'png'],
                maxSize: 10240,
                hoverClass: 'ui-state-hover',
                focusClass: 'ui-state-focus',
                disabledClass: 'ui-state-disabled',
                startXHR: function(filename, size) {
                  Loading.add($('#uploadBtn'));  
                },
                onComplete: function( filename, response ) {
                  if(response.status == 1){
                      if(options.original == 1){
                        var n = Date.now();
                        $(uploadImageContainer).find('.image-part img').attr('src',response.path+"?"+n);
                      }else{
                        $(uploadImageContainer).find('.image-part img').attr('src',response.path);
                        $(uploadImageContainer).find('.image-action').removeClass('fileNotExist').addClass('fileExist');
                        $(uploadImageContainer).find(options.imageIdReturnEl).val(response.imageId);
                        if (options.onSuccess) {
                          options.onSuccess.call(undefined, response.imageId);
                        }
                      }
                  }
                  if(response.status == 0){
                    toastr['error'](response.message, 'Error');    
                  }

                  Loading.remove($('#uploadBtn'));
                  },
                endXHR: function(filename) {
                  Loading.remove($('#uploadBtn')); 
                },
                startNonXHR: function(filename) {
                  Loading.remove($('#uploadBtn')); 
                },
                endNonXHR: function(filename) {
                  Loading.remove($('#uploadBtn')); 
                }

          });   
        },

    };
};