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
      $.get("rest/user", function (data) {

        $("#user-cards").html("");

        var html = "";
        for (let i = 0; i < data.length; i++) { //only id and name, pw and email are not displayed
          html += `
            <div class="col-lg-4">
            <!--I CAN ADD IMAGES OF USERS HERE-->
            <h2 class="fw-normal">`+ data[i].id + `</h2>
        <p>`+ data[i].first_name + `</p>
            <p>`+ data[i].last_name + `</p>
            <p> 
          <div class="btn-group" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-primary see-user" onclick="UserService.get(`+ data[i].id + `)">EDIT</button>
            <button type="button" class="btn btn-danger see-user" onclick="UserService.delete(`+ data[i].id + `)">DELETE</button>
          </div>
        </p>
      </div> `;
        }
        $("#user-cards").html(html);
      });

    },

    get: function (id) {
      $('.see-user').attr('disabled', true);
      $.get('rest/user/' + id, function (data) {
        console.log(data);
        $("#id").val(data.id);
        $("#first_name").val(data.first_name);
        $("#last_name").val(data.last_name);
        $("#email").val(data.email);
        $("#pass").val(data.pass);
        $('#exampleModal').modal("show");
        $('.see-user').attr('disabled', false);
      })
    },

    add: function (user) {
      $.ajax({
        url: 'rest/user',
        type: 'POST',
        data: JSON.stringify(user),
        contentType: "application/json",
        dataType: "json",
        success: function (result) {
          $('#user-cards').html('<div class="text-center"> <div class="spinner-border" role="status"> <span class="visually-hidden">Loading...</span> </div> </div>');
          $('#addUserModal').modal("hide");
          UserService.list(); //include performance optimization where only one user card refreshes instead of whole page
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
        success: function (result) {
          $('#exampleModal').modal("hide");
          $('.see-user').attr('disabled', false);
          $('#user-cards').html('<div class="text-center"> <div class="spinner-border" role="status"> <span class="visually-hidden">Loading...</span> </div> </div>');
          UserService.list(); //include performance optimization where only one user card refreshes instead of whole page
        }
      });
    },

    delete: function (id) {
      $('.see-user').attr('disabled', true);
      $.ajax({
        url: 'rest/user/' + id,
        type: 'DELETE',
        success: function (result) {
          $('#user-cards').html('<div class="text-center"> <div class="spinner-border" role="status"> <span class="visually-hidden">Loading...</span> </div> </div>');
          UserService.list();
        }
      });
    },


  }