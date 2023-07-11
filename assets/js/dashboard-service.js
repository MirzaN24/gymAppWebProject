var DashboardService = {

    init: function () {
        DashboardService.count();
        DashboardService.earned();
    },

    count: function () {
        $.ajax({
            url: "rest/usercount",
            type: "GET",
            //beforeSend: function(xhr){
            //  xhr.setRequestHeader('Authorization', localStorage.getItem('token'));
            //},
            success: function (data) {
                var html = "";
                for (let i = 0; i < data.length; i++) {
                    html += `<div class="text-info text-center mt-2" id="count"><h1>` + data[i].count + `</h1></div>`;
                }
                let oldHtml = $("#count").html();
                $("#count").html(oldHtml + html);
            },
            //error: function(XMLHttpRequest, textStatus, errorThrown) {
            //toastr.error(XMLHttpRequest.responseJSON.message);

            //}
        });
    },

    earned: function () {
        $.ajax({
            url: "rest/earned",
            type: "GET",
            //beforeSend: function (xhr) {
              //  xhr.setRequestHeader('Authorization', localStorage.getItem('token'));
            //},
            success: function (data) {
                var html = "";
                for (let i = 0; i < data.length; i++) {
                    html += `<div class="text-dark text-center mt-2" id="earned"> <h1>` + data[i].earned + ` KM</h1></div>`;
                }
                let oldHtml = $("#earned").html();
                $("#earned").html(oldHtml + html);
            },
            //error: function (XMLHttpRequest, textStatus, errorThrown) {
            //    toastr.error(XMLHttpRequest.responseJSON.message);

            //}
        });
    },

}