function editDepartment(){
    var department_id = $('#department-id').val();
    $('#form-department-edit').attr('action', '/department/' + department_id);

    $('#form-department-edit').unbind("submit");
    $('#form-department-edit').submit();
  }

  function getDepartmentById(id){
    $.ajax({
      url : "/department/" + id,
      type : "GET",
      success: function(department){
          var departmentData = JSON.parse(department);

          $('#department-id').val(departmentData.id);
          $('#department-name').val(departmentData.name);
      }
    });
  }