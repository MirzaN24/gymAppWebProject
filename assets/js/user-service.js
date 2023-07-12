var UserService = {

    init: function () {
        $('#addUserForm').validate({
            submitHandler: function (form) {
                var user = Object.fromEntries((new FormData(form)).entries()); //converting form to JSON
                UserService.add(user);
            }
        });
        UserService.list();
    },

    list: function () {
        $.ajax({
            url: "rest/user",
            type: "GET",
            beforeSend: function (xhr) { 
                xhr.setRequestHeader('Authorization', localStorage.getItem('token')); 
            },
            success: function (data) {$("#user-cards").html("");
    
            var html = "";
            for (let i = 0; i < data.length; i++) { //only id and name, pw and email are not displayed
                html += `
            <div class="col-lg-3" style="margin-bottom: 20px; margin-top: 20px;">     
                <div class="card" style="width: 18rem; transition: transform .2s;" 
                onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0px 0px 10px 0px rgba(0,0,0,0.75)';" 
                onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0px 0px 0px 0px rgba(0,0,0,0.75)';">
                    <img src="https://icons-for-free.com/iconfiles/png/512/customer+information+personal+profile+user+icon-1320086045331670685.png" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title" style="text-align: center;">`+ data[i].id + `</h5>
                        <p class="card-text" style="text-align: center;">`+ data[i].first_name + `</p>
                        <p class="card-text" style="text-align: center;">`+ data[i].last_name + `</p>
                        <div class="btn-group" role="group" style="display: flex; justify-content: center;">
                            <button type="button" class="btn btn-primary see-user" onclick="UserService.get(`+ data[i].id + `)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                </svg>
                            </button>
    
                            <button type="button" class="btn btn-danger see-user" onclick="UserService.delete(`+ data[i].id + `)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
                                </svg>
                          </button>
                        </div>
                    </div>
                </div>
            </div>`;
            }
            $("#user-cards").html(html);
            },
        });

    },

    get: function (id) {
        $('.see-user').attr('disabled', true);
        $.ajax({
            url: 'rest/user/' + id,
            type: "GET",
            beforeSend: function (xhr) {
                xhr.setRequestHeader('Authorization', localStorage.getItem('token'));
            },
            success: function (data) {
                console.log(data);
                $("#id").val(data.id);
                $("#first_name").val(data.first_name);
                $("#last_name").val(data.last_name);
                $("#email").val(data.email);
                $("#pass").val(data.pass);

                $('#exampleModal').modal("show");
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                toastr.error(XMLHttpRequest.responseJSON.message);
                $('.see-user').attr('disabled', false);
            }
        })
    },

    add: function (user) {
        $.ajax({
            url: 'rest/user',
            type: 'POST',
            data: JSON.stringify(user),
            contentType: "application/json",
            dataType: "json",
            beforeSend: function (xhr) {
                xhr.setRequestHeader('Authorization', localStorage.getItem('token'));
            },
            success: function (result) {
                $('#user-cards').html('<div class="text-center"> <div class="spinner-border" role="status"> <span class="visually-hidden">Loading...</span> </div> </div>');
                $('#addUserModal').modal("hide");
                toastr.success("Added!");
                UserService.list(); //include performance optimization where only one user card refreshes instead of whole page
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                toastr.error(XMLHttpRequest.responseJSON.message);
            }
        });
    },

    update: function () {
        $('.save-user').attr('disabled', true);

        var user = {};

        user.id = $('#id').val();
        user.first_name = $('#first_name').val();
        user.last_name = $('#last_name').val();
        user.email = $('#email').val();
        user.pass = $('#pass').val();

        $.ajax({
            url: 'rest/user/' + $('#id').val(),
            type: 'PUT',
            data: JSON.stringify(user),
            contentType: "application/json",
            dataType: "json",
            beforeSend: function (xhr) {
                xhr.setRequestHeader('Authorization', localStorage.getItem('token'));
            },
            success: function (result) {
                $('#exampleModal').modal("hide");
                $('.see-user').attr('disabled', false);
                $('#user-cards').html('<div class="text-center"> <div class="spinner-border" role="status"> <span class="visually-hidden">Loading...</span> </div> </div>');
                toastr.success("Updated!");
                UserService.list(); //include performance optimization where only one user card refreshes instead of whole page
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                toastr.error(XMLHttpRequest.responseJSON.message);
                $('.user-button').attr('disabled', false);
            }
        });
    },

    delete: function (id) {
        $('.see-user').attr('disabled', true);
        $.ajax({
            url: 'rest/user/' + id,
            type: 'DELETE',
            beforeSend: function (xhr) {
                xhr.setRequestHeader('Authorization', localStorage.getItem('token'));
            },
            success: function (result) {
                $('#user-cards').html('<div class="text-center"> <div class="spinner-border" role="status"> <span class="visually-hidden">Loading...</span> </div> </div>');
                toastr.success("Deleted!");
                UserService.list();
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                toastr.error(XMLHttpRequest.responseJSON.message);
            }
        });
    },


}