function getAdminById(id){
    $.ajax({
        url : "/admin/" + id,
        type : "GET",
        success: function(admins){
            var adminsData = JSON.parse(admins);

            $('#admin-id').val(adminsData.id);
            $('#name').val(adminsData.name);
            $('#email').val(adminsData.user.email);
        }
    });
}

function editAdmin(){
    var admin_id = $('#admin-id').val();
    $('#form-edit').attr('action', '/admin/' + admin_id);

    $('#form-edit').unbind("submit");
    $('#form-edit').submit();
}