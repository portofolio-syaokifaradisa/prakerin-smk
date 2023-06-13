function populateClassDropdown(id){
    $.ajax({
      url : "/all-class",
      type : "GET",
      success: function(gradeClass){
        $.ajax({
          url : "/student/" + id,
          type : "GET",
          success: function(students){

            console.log(gradeClass);
            var gradeClassData = JSON.parse(gradeClass);
            var studentData = JSON.parse(students);

            $('#student-id').val(studentData.id);
            $('#name').val(studentData.name);
            $('#nisn').val(studentData.nisn);
            $('#email').val(studentData.user.email);

            var options = [];
            for (var i = 0; i < gradeClassData.length; i++) {
              if(gradeClassData[i].id == studentData.grade_class_id){
                options.push('<option value="' + gradeClassData[i].id + '" selected>' + gradeClassData[i].grade + '-' + gradeClassData[i].department.name + '</option>');
              }else{
                options.push('<option value="' + gradeClassData[i].id + '">' + gradeClassData[i].grade + '-' + gradeClassData[i].department.name + '</option>');
              }
            }

            $("#class-dropdown").html(options.join(''));
          }
        });
      }
    });
}

function editStudent(){
    var student_id = $('#student-id').val();
    $('#form-edit').attr('action', '/student/' + student_id);

    $('#form-edit').unbind("submit");
    $('#form-edit').submit();
}