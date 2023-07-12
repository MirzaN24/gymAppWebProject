var EmployeesService = {

    init: function () {
        $('#addEmployeeForm').validate({
            submitHandler: function (form) {
                var employee = Object.fromEntries((new FormData(form)).entries()); //converting form to JSON
                EmployeesService.add(employee);
            }
        });
        EmployeesService.list();
    },

    list: function () {
        $.get("rest/employees", function (data) {

            $("#employee-cards").html("");

            var html = "";
            for (let i = 0; i < data.length; i++) { //only id and name, pw and email are not displayed
                html += `
            <div class="col-lg-3" style="margin-bottom: 20px; margin-top: 20px;">     
                <div class="card" style="width: 18rem; transition: transform .2s;" 
                onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0px 0px 10px 0px rgba(0,0,0,0.75)';" 
                onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0px 0px 0px 0px rgba(0,0,0,0.75)';">
                    <img src="https://icons.veryicon.com/png/o/miscellaneous/core-music/staff-8.png" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title" style="text-align: center;">`+ data[i].id + `</h5>
                        <p class="card-text" style="text-align: center;">`+ data[i].full_name + `</p>
                        <div class="btn-group" role="group" style="display: flex; justify-content: center;">
                            <button type="button" class="btn btn-primary see-employee" onclick="EmployeesService.get(` + data[i].id + `)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                </svg>
                            </button>

                            <button type="button" class="btn btn-danger see-employee" onclick="EmployeesService.delete(`+ data[i].id + `)">
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
            $("#employee-cards").html(html);
        });
    },

    get: function (id) {
        $('.see-employee').attr('disabled', true);
        $.get('rest/employees/' + id, function (data) {
            console.log(data);
            $("#id").val(data.id);
            $("#full_name").val(data.full_name);
            $("#phone_number").val(data.phone_number);
            $("#email").val(data.email);
            $("#position").val(data.position);

            $('#exampleModal').modal("show");
            $('.see-employee').attr('disabled', false);
        })
    },

    add: function (employee) {
        $.ajax({
            url: 'rest/employees',
            type: 'POST',
            data: JSON.stringify(employee),
            contentType: "application/json",
            dataType: "json",
            success: function (result) {
                $('#employee-cards').html('<div class="text-center"> <div class="spinner-border" role="status"> <span class="visually-hidden">Loading...</span> </div> </div>');
                $('#addEmployeeModal').modal("hide");
                toastr.success("Added!");
                EmployeesService.list(); //include performance optimization where only one emp card refreshes instead of whole page
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                toastr.error(XMLHttpRequest.responseJSON.message);
            }
        });
    },

    update: function () {
        $('.save-employee').attr('disabled', true);

        var employee = {};

        employee.id = $('#id').val();
        employee.full_name = $('#full_name').val();
        employee.phone_number = $('#phone_number').val();
        employee.email = $('#email').val();
        employee.position = $('#position').val();

        $.ajax({
            url: 'rest/employees/' + $('#id').val(),
            type: 'PUT',
            data: JSON.stringify(employee),
            contentType: "application/json",
            dataType: "json",
            success: function (result) {
                $('#exampleModal').modal("hide");
                $('.see-employee').attr('disabled', false);
                $('#employee-cards').html('<div class="text-center"> <div class="spinner-border" role="status"> <span class="visually-hidden">Loading...</span> </div> </div>');
                toastr.success("Updated!");
                EmployeesService.list(); //include performance optimization where only one emp card refreshes instead of whole page
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                toastr.error(XMLHttpRequest.responseJSON.message);
            }
        });
    },

    delete: function (id) {
        $('.see-employee').attr('disabled', true);
        $.ajax({
            url: 'rest/employees/' + id,
            type: 'DELETE',
            success: function (result) {
                $('#employees-cards').html('<div class="text-center"> <div class="spinner-border" role="status"> <span class="visually-hidden">Loading...</span> </div> </div>');
                toastr.success("Deleted!");
                EmployeesService.list();
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                toastr.error(XMLHttpRequest.responseJSON.message);
            }
        });
    },

}