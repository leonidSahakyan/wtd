var Popup = function () {
    var self;
    var popupOptions;

    return {
        //main function to initiate the module
        init: function (options) {
            self = this;

            // default settings
            // modal type
            // modal-sm -> 300px;
            // modal-lg -> 800px;
            // modal-xl -> 1140px

            options = $.extend(true, {
              size:'modal-full',
              title: 'Untitled Window',
              identifier: 'popup_'+Math.floor((Math.random() * 100) + 1),
              classPrefix: 'panda-popup-',
              class: false,
              canClose: false,
              minHeight: false, //px
              height: false, //px 
              maxHeight: false, //px overflow-y: scroll;
            }, options);

            popupOptions = options;
        },

        setTitle: function(title){
          popupOptions.title = title;  
        },

        load: function(url){
          $( "#"+popupOptions.identifier ).remove();

          var $error = 0;
          $.ajax({
              type: "GET",
              url: url,
              dataType: 'JSON',
              async: false,
              success: function(response){
                if(response.status == 0){
                    if(response.message){
                        toastr['error'](response.message, 'Error');
                    }else{
                        toastr['error']("Can\'n load popup" , 'Error');
                    }
                    $error = 1;
                    return;
                }
                if(response.status == 1){
                  $content = response.data;
                }
              }
          });

          if($error) return false;

          modalHtml = self.createModal($content);

          $('#modal-container').append(modalHtml);
          self.setButtons();
          

          $( self ).trigger( "loaded" );
          
          $('.modal#'+popupOptions.identifier).on('hide.bs.modal', function (e) {
            if($(e.target).hasClass('close-tiny')){
              self.onClose(true);
            }else{
              self.onClose(false);
            }
          });
          
          $('.modal#'+popupOptions.identifier).modal();

        },

        createModal:function(content){
              
          backdrop = 'data-backdrop="static"';
          if (popupOptions.canClose) backdrop = '';

          popupClass = popupOptions.class ? popupOptions.classPrefix + popupOptions.class : popupOptions.classPrefix.substring(0, popupOptions.classPrefix.length - 1);

          modal = '<div class="modal fade '+popupClass+'" id="'+popupOptions.identifier+'" tabindex="-1" role="basic" '+backdrop+' aria-labelledby="modalTitle" aria-hidden="true">';
          if (popupOptions.minHeight) modal += '<style>#'+popupOptions.identifier+' .modal-body{min-height:'+popupOptions.minHeight+'px;}</style>';
          if (popupOptions.height) modal += '<style>#'+popupOptions.identifier+' .modal-body{height:'+popupOptions.height+'px;}</style>';
          if (popupOptions.maxHeight) modal += '<style>#'+popupOptions.identifier+' .modal-body{max-height:'+popupOptions.maxHeight+'px;overflow-y: scroll;}</style>';
          modal += '<div class="modal-dialog '+popupOptions.size+'" role="document">';
          modal += '<div class="modal-content">';
          modal += '<div class="modal-header">';
          modal += '<h4 class="modal-title" id="modalTitle">'+popupOptions.title+'</h4>';
          modal += '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
          modal += '</div>';
          modal += '<div class="modal-body">';
          modal += content;
          modal += '</div>';
          modal += '<div class="modal-footer popup">';
          modal += '</div>';
          modal += '</div>';
          modal += '</div>';
          modal += '</div>';


          return modal;
        },

        onClose:function(turnOffTiny){
          if(turnOffTiny){
            tinymce.remove('.wysihtml5');
          }
          $( "#"+popupOptions.identifier ).remove();
        },
        
        close:function(){
          $('.modal#'+popupOptions.identifier).modal('hide');
          $( "#"+popupOptions.identifier ).remove();
        },

        setButtons: function(){
          buttons = $('#'+popupOptions.identifier+' .modal-buttons').html();
          if(buttons){
            $(buttons).appendTo('#'+popupOptions.identifier+' .modal-footer.popup');
            $('#'+popupOptions.identifier+' .modal-buttons').remove();
          }
        }

    };
};