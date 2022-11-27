$.fn.serializeFormJSON = function () {
    var o = {};
    var a = this.serializeArray();
    $.each(a, function () {
        if (o[this.name]) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};




var errorHelper = {
    showError: function (message) {
        return '<span class="error">' + message + '</span>';
    }
};


jQuery(document).ready(function ($) {
   
    $("#forgot-password-form").submit(function (event) {
        event.preventDefault();
        auth.sendPasswordRecover();
    });
    $("#recover-password-form").submit(function (event) {
        event.preventDefault();
        auth.recoverPassword();
    });
});



var auth = {
    
    sendPasswordRecover: function () {
       
        var data = $('#forgot-password-form').serializeFormJSON();
        $.ajax({
            type: "POST",
            url:'/users/sendPasswordRecover',
            data: data,
           
            // data: {"myObj": myObject, "_token": "{{ csrf_token() }}"},
            success: function (response) {
                if (response.status == 1) {
                    $("#forgot-password-form").find("input[type=text]").val("");
                    // (trans.success, response.message, "success");
                }
                if (response.status == 0) {
                    // (trans.error, response.message, "error");
                }
            },
            error: function (xhr, status, error) {
                // (trans.error, trans.validation_form_data, "error");
                return;
            },
            dataType: 'json'
        });
    },
    recoverPassword: function () {
        var data = $('#recover-password-form').serializeFormJSON();
        btn = $('#recover-password-form .btn');

        Loading.add(btn);

        $.ajax({
            type: "POST",
            url: $apiVerstion + '/user/recoveryPassword',
            data: data,
            success: function (response) {
                if (response.status == 1) {
                    swal(trans.success, response.message, "success");
                    setTimeout(function () {
                        window.location = '/#sign-in';
                    }, 1000);
                }
                Loading.remove(btn);
            },
            error: function (xhr, status, error) {
                if (xhr.responseJSON.error) {
                    swal(trans.error, xhr.responseJSON.error, "error");
                } else {
                    swal(trans.error, trans.validation_form_data, "error");
                }
                Loading.remove(btn);
                return;
            },
            dataType: 'json'
        });
    },
   
    }
       