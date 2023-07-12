var LoginService = {

    init: function () {
        var token = localStorage.getItem("token");
        if (token) {
            $(document).ready(function () {
                var app = $.jQuerySPApp({ defaultView: "home" });
                //define routes
                app.run();
            })
        }
        $('#login-form').validate({
            submitHandler: function (form) {
                var entity = Object.fromEntries((new FormData(form)).entries()); //converting form to JSON
                LoginService.login(entity);
            }
        });
    },

    login: function (entity) {
        $.ajax({
            url: 'rest/login',
            type: 'POST',
            data: JSON.stringify(entity),
            contentType: "application/json",
            dataType: "json",
            success: function (result) {
                console.log(result);
                localStorage.setItem("token", result.token);
                window.location.replace("index.html");
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                toastr.error(XMLHttpRequest.responseJSON.message);
            }
        });
    },

    logout: function () {
        localStorage.clear();
        window.location.replace("login.html");
    }


}