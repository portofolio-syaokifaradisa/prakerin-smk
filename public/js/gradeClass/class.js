function populateDepartmentDropdown(classId){
    $.ajax({
      url : "/all-department",
      type : "GET",
      success: function(departments){
        $.ajax({
          url : "/class/" + classId,
          type : "GET",
          success: function(gradeClass){
            var gradeClassData = JSON.parse(gradeClass);
            var departmentsData = JSON.parse(departments);

            $('#class-id').val(gradeClassData.id);
            $('#grade-dropdown').val(gradeClassData.grade);

            var options = [];
            for (var i = 0; i < departmentsData.length; i++) {
              if(departmentsData[i].id == gradeClassData.department_id){
                options.push('<option value="' + departmentsData[i].id + '" selected>' + departmentsData[i].name + '</option>');
              }else{
                options.push('<option value="' + departmentsData[i].id + '">' + departmentsData[i].name + '</option>');
              }
            }

            $("#department-dropdown").html(options.join(''));
          }
        });
      }
    });
}

function editClass(){
    var id = $('#class-id').val();

    $('#form-class-edit').attr('action', '/class/' + id);
    $('#form-class-edit').unbind("submit");
    $('#form-class-edit').submit();
}