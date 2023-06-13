function editRegion(){
    var region_id = $('#region-id').val();
    $('#form-edit').attr('action', '/region/' + region_id);

    $('#form-edit').unbind("submit");
    $('#form-edit').submit();
  }

function populateRegionDropdown(){
    $.ajax({
      url : "/all-region",
      type : "GET",
      success: function(region){
        var regionData = JSON.parse(region);

        var options = [];
        for (var i = 0; i < regionData.length; i++) {
            options.push('<option value="' + regionData[i].id + '">' + regionData[i].name + '</option>');
        }

        $("#region-dropdown").html(options.join(''));
      }
    });
}

function populateTeacherDropdown(){
    $.ajax({
      url : "/all-teacher",
      type : "GET",
      success: function(teacher){
        var teacherData = JSON.parse(teacher);

        var options = [];
        for (var i = 0; i < teacherData.length; i++) {
            options.push('<option value="' + teacherData[i].id + '">' + teacherData[i].name + '</option>');
        }

        $("#teacher-dropdown").html(options.join(''));
      }
    });
}

function getMentorById(id){
    populateRegionDropdown();
    populateTeacherDropdown();
    $.ajax({
        url : "/mentor/" + id,
        type : "GET",
        success: function(mentor){
            var mentorData = JSON.parse(mentor);

            $('#mentor-id').val(mentorData.id);
            $('#teacher-dropdown').val(mentorData.teacher_id).change();
            $('#region-dropdown').val(mentorData.region_id).change();
        }
    });
}

function editMentor(){
    var id = $('#mentor-id').val();

    $('#form-edit').attr('action', '/mentor/' + id);
    $('#form-edit').unbind("submit");
    $('#form-edit').submit();
}