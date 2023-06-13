function getTeacherById(id){
    $.ajax({
        url : "/teacher/" + id,
        type : "GET",
        success: function(teachers){
            var teachersData = JSON.parse(teachers);

            $('#teacher-id').val(teachersData.id);
            $('#name').val(teachersData.name);
            $('#nip').val(teachersData.nip);
            $('#position').val(teachersData.position);
            $('#email').val(teachersData.user.email);
        }
    });
}

function editStudent(){
    var teacher_id = $('#teacher-id').val();
    $('#form-edit').attr('action', '/teacher/' + teacher_id);

    $('#form-edit').unbind("submit");
    $('#form-edit').submit();
}