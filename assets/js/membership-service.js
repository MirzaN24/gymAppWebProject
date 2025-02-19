MembershipService = {

    init: function () {
        $('#addMembershipForm').validate({
            submitHandler: function (form) {
                var entity = Object.fromEntries((new FormData(form)).entries());

                MembershipService.add(entity);
            }
        });

        $('#updateMembershipForm').validate({
            submitHandler: function (form) {
                var entity = Object.fromEntries((new FormData(form)).entries());
                console.log(entity);
                var id = entity.id;
                delete entity.id;
                console.log("Before update");
                // update method
                MembershipService.update(id, entity);
            }
        });

        MembershipService.list();
    },

    list: function () {
        $.ajax({
            url: "rest/usermembership",
            type: "GET",
            beforeSend: function(xhr){
              xhr.setRequestHeader('Authorization', localStorage.getItem('token'));
            },
            success: function (data) {
                $("#membership-table-full-list").html("");
                var html = "";
                for (let i = 0; i < data.length; i++) {
                    html += `<tr>
              <th class="bg-dark text-light">ID</th>
              <th class="bg-dark text-light">First Name</th>
              <th class="bg-dark text-light">Last Name</th>
              <th class="bg-dark text-light">Type</th>
              <th class="bg-dark text-light">Start Date</th>
              <th class="bg-dark text-light">End Date</th>
              <th class="bg-dark text-light">Action</th>
            </tr>
          <tr>
                        <th>`+ data[i].id + ` </th>
                        <th>`+ data[i].first_name + ` </th>
                        <th>`+ data[i].last_name + ` </th>
                        <th>`+ data[i].type + ` </th>
                        <th>`+ data[i].start_date + `</th>
                        <th>`+ data[i].end_date + `</th>
                        <td style="text-align: center;">
                            <button type="button" class="btn btn-success membership-button" onclick="MembershipService.get(`+ data[i].id + `) "><i class="fa fa-edit"></i></button>
                              <button type="button" class="btn btn-danger membership-button" onclick="MembershipService.delete(`+ data[i].id + `)"><i class="fa fa-trash"></i></button>
                        </td>
            </tr>`;

                }
                $("#membership-table-full-list").html(html);
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                toastr.error(XMLHttpRequest.responseJSON.message);
            }
        });
    },

    get: function (id) {
        $('.employe-button').attr('disabled', true);
        $.ajax({
            url: 'rest/user_membership/' + id,
            type: "GET",
            beforeSend: function (xhr) {
            xhr.setRequestHeader('Authorization', localStorage.getItem('token'));
            },
            success: function (data) {
                $('#updateMembershipForm input[name="id"]').val(id);
                $('#updateMembershipForm input[name="user_id"]').val(data.user_id);
                $('#updateMembershipForm input[name="membership_id"]').val(data.membership_id);
                $('#updateMembershipForm input[name="start_date"]').val(data.start_date);
                $('#updateMembershipForm input[name="end_date"]').val(data.end_date);

                $('.membership-button').attr('disabled', false);
                $('#updateMembershipModal').modal("show");
                $('.employe-button').attr('disabled', false);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                toastr.error(XMLHttpRequest.responseJSON.message);
            }
        });
    },

    add: function (user) {
        $.ajax({
            url: 'rest/user_membership',
            type: 'POST',
            data: JSON.stringify(user),
            contentType: "application/json",
            dataType: "json",
            beforeSend: function(xhr){
            xhr.setRequestHeader('Authorization', localStorage.getItem('token'));
            },
            success: function (result) {
                $("#membership-table-full-list").html('<div class="spinner-border" role="status"> <span class="sr-only"></span></div>');
                MembershipService.list(); // perf optimization
                $("#addMembershipModal").modal("hide");
                $('.modal-backdrop').remove();
                toastr.success("Added!");
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                toastr.error(XMLHttpRequest.responseJSON.message);
            }
        });
    },

    update: function (id, entity) {
        $.ajax({
            url: 'rest/user_membership/' + id,
            type: 'PUT',
            beforeSend: function(xhr){
            xhr.setRequestHeader('Authorization', localStorage.getItem('token'));
            },
            data: JSON.stringify(entity),
            contentType: "application/json",
            dataType: "json",
            success: function (result) {
                $("#membership-table-full-list").html('<div class="spinner-border" role="status"> <span class="sr-only"></span></div>');
                MembershipService.list(); // perf optimization
                $("#updateMembershipModal").modal("hide");
                toastr.success("Updated!");
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                toastr.error(XMLHttpRequest.responseJSON.message);
            }
        });
    },

    delete: function (id) {
        $.ajax({
            url: 'rest/user_membership/' + id,
            type: 'DELETE',
            beforeSend: function(xhr){
            xhr.setRequestHeader('Authorization', localStorage.getItem('token'));
            },
            success: function (result) {
                $("#membership-table-full-list").html('<div class="spinner-border" role="status"><span class="sr-only"></span></div>');
                MembershipService.list();
                toastr.success("Deleted!");
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                toastr.error(XMLHttpRequest.responseJSON.message);
            }
        });
    }


}