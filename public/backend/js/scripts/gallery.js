
var Gallery = function () {
    var self;
    var galleryOptions;
    var _token;

    return {
        //main function to initiate the module
        init: function (options) {
            self = this;

            options = $.extend(true, {
              gallery_id: false,
              title: false,
              identifier: 'gallery'+Math.floor((Math.random() * 100) + 1),
              classPrefix: 'panda-gallery-',
              container: '#gallery-container',
              class: false,
               _token,
               maxFiles: null,
               maxFilesize: 20,
               edit: false,
            }, options);

            galleryOptions = options;
        },

        load: function(){

          var $uploadedImages = false;
          var $error = 0;
          
          $.ajax({
              type: "POST",
              url: '/admin/gallery-data',
              dataType: 'JSON',
              async: false,
              data:{gallery_id: galleryOptions.gallery_id, _token: galleryOptions._token}, 
              success: function(response){
                if(response.status == 1){ // get Gallery
                    $uploadedImages = response.data.images;
                }else if(response.status == 2){ // get temp Gallery
                    galleryOptions.gallery_id = response.new_gallery_id;
                    $('#new_gallery_id').val(galleryOptions.gallery_id);
                }else{ // gallery id is empty
                    $error = 1;
                    console.log(response.message)
                    // toastr['error'](response.message, 'Error');
                  }
                }
              });

          if($error) return false;
          if(!galleryOptions.gallery_id){
            console.log('Gallery id is require')
            // toastr['error']("Gallery id is require" , 'Error');
            return false;
          }

          galleryHtml = self.createGalleryForm();

          $(galleryOptions.container).append(galleryHtml);

          self.initSorting();
          Dropzone.autoDiscover = false;
          Dropzone.options.myDropzone = {
              url: "/admin/upload-image",
              maxFilesize: galleryOptions.maxFilesize,
              maxFiles: galleryOptions.maxFiles,
              previewTemplate: $('#preview-template').html(),
              init: function() {
                  this.on("addedfile", function(file) {
                      // Create the remove button
                      var removeButton = Dropzone.createElement("<button class='btn btn-info removeImage btn-xs btn-block'>Remove</button>");

                      
                      // Capture the Dropzone instance as closure.
                      var _this = this;

                      // Listen to the click event
                      removeButton.addEventListener("click", function(e) {
                        // Make sure the button click doesn't submit the form:
                        e.preventDefault();
                        e.stopPropagation();
                        
                        // Remove the file preview.
                        _this.removeFile(file);
                        // If you want to the delete the file on the server as well,
                        // you can do the AJAX request here.
                        removeImageId = $(file.previewElement).filter('.dz-preview').attr('imageId');
                        if(removeImageId){
                          // Remove from server and db
                          $.ajax({
                              type: "POST",
                              url: '/admin/remove-image',
                              dataType: 'JSON',
                              data:{_token:galleryOptions._token,imageId:removeImageId}
                          });  
                        }
                      });

                      // Add the button to the file preview element.
                      file.previewElement.appendChild(removeButton);
                      //$(file.previewElement).after('<div class="portlet-sortable-empty"></div>');
                      // $(file.previewElement).attr('order','2');
                  });
                  this.on('sending', function(file, xhr, formData){
                      formData.append('gallery_id', galleryOptions.gallery_id);
                      formData.append('_token', galleryOptions._token);
                  });

                  if($uploadedImages){
                    var self = this;
                    uploadedImagesCount = 0;
                    $.each($uploadedImages, function( index, value ) {                      
                      var mockFile = { name: value.title, id:value.id, color:value.color };//size: value.size,
                      self.emit("addedfile", mockFile);
                      self.emit("thumbnail", mockFile, value.path);
                      
                      self.emit("complete", mockFile);
                      self.emit("success", mockFile, {status:2});
                      self.files[index] = mockFile;
                      uploadedImagesCount++;
                    });
                    if(galleryOptions.maxFiles){
                      self.options.maxFiles = self.options.maxFiles - uploadedImagesCount;
                    }
                  }
              },
              success: function(file, response){
                if(response.status == 0){
                    var node, _i, _len, _ref, _results;
                    var message = response.message // modify it to your error message
                    file.previewElement.classList.add("dz-error");
                    _ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
                    _results = [];
                    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                      node = _ref[_i];
                      _results.push(node.textContent = message);
                    }
                    return _results; 
                }
                if(response.status == 1){
                  file.previewElement.classList.add("dz-success"); 
                  $(file.previewElement).filter('.dz-preview').attr('imageId',response.imageId); 
                  self.appendEdit(file);
                }
                if(response.status == 2){
                  $(file.previewElement).filter('.dz-preview').attr('imageId',file.id);
                  self.appendEdit(file);
                }
              },

              error: function(file, response) {
                var node, _i, _len, _ref, _results;
                var message = "Server is unavailable" // modify it to your error message
                file.previewElement.classList.add("dz-error");
                _ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
                _results = [];
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                  node = _ref[_i];
                  _results.push(node.textContent = message);
                }
                return _results; 
            }        
          };
          var myDropzone = new Dropzone("form#myDropzone");
          
        },

        createGalleryForm:function(){
          galleryClass = galleryOptions.class ? galleryOptions.classPrefix + galleryOptions.class : galleryOptions.classPrefix.substring(0, galleryOptions.classPrefix.length - 1);
          gallerForm = '<form class="dropzone '+galleryClass+' " id="myDropzone"></form>';
          return gallerForm;
        },

        getGallerId:function(){
          return galleryOptions.gallery_id;
        },

        initSorting: function(){
          $(galleryOptions.container).sortable({
              // connectWith: ".dz-image-preview",
              items: ".dz-image-preview", 
              opacity: 0.8,
              coneHelperSize: true,
              placeholder: 'gallery-sortable-placeholder',
              forcePlaceholderSize: true,
              tolerance: "pointer",
              helper: "clone",
              tolerance: "pointer",
              forcePlaceholderSize: !0,
              revert: 250, // animation in milliseconds
              update: function(event, ui) {
                  var ids = new Array();
                  $(galleryOptions.container+' .dz-image-preview').each(function(index) {
                    ids.push($(this).attr('imageid'));
                  });

                  $.ajax({
                    type: "POST",
                    url: '/admin/gallery-sort',
                    dataType: 'JSON',
                    data:{_token: galleryOptions._token, ids:ids}
                });                
              },
              start: function( event, ui ) {
                $(".dz-clickable").css( 'pointer-events', 'none' );
              },
              stop: function( event, ui ) {
                $(".dz-clickable").css( 'pointer-events', 'auto');
              }
          });
        },

        appendEdit:function(file){
          if(galleryOptions.edit){
            colors = ['black','white','blue','green','red'];
            selectHtml = "<select class='custom-select-uploader'><option value=''>None</option>";
            colors.forEach(element => selectHtml += '<option '+(file.color == element ? 'selected' : '')+'  value="'+element+'">'+element+'</option>');
            selectHtml += "</select>";
            var editButton =  Dropzone.createElement(selectHtml);
            editButton.addEventListener("change", function(e) {
              editImageId = $(file.previewElement).filter('.dz-preview').attr('imageId');
              color = $(editButton).val();
              // Make sure the button click doesn't submit the form:
              e.preventDefault();
              e.stopPropagation();
              
              var editFn = window[galleryOptions.edit];
              if(typeof editFn === 'function') {
                editFn(editImageId,color);
              }
              
            });
            $(editButton).insertBefore($(file.previewElement).find('.removeImage'));
          }
        }

    };
};