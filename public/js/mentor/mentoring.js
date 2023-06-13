async function populateStudentDropdown(studentId){
    $.ajax({
      url : "/all-student",
      type : "GET",
      success: function(student){
        var studentData = JSON.parse(student);

        var options = [];
        for (var i = 0; i < studentData.length; i++) {
          if(studentData[i].id == studentId){
            options.push('<option value="' + studentData[i].id + '" selected>' + studentData[i].name + '</option>');
          }else{
            options.push('<option value="' + studentData[i].id + '">' + studentData[i].name + '</option>');
          }
        }

        $("#student-dropdown").html(options.join(''));
      }
    });
}

async function populateMentorDropdown(mentorId){
    $.ajax({
      url : "/all-mentor",
      type : "GET",
      success: function(mentor){
        var mentorData = JSON.parse(mentor);
        console.log(mentorData);

        var options = [];
        for (var i = 0; i < mentorData.length; i++) {
            if(mentorData[i].id == mentorId){
              options.push('<option value="' + mentorData[i].id + '" selected>' + mentorData[i].teacher.name + ' - ' + mentorData[i].region.name + '</option>');
            }else{
              options.push('<option value="' + mentorData[i].id + '">' + mentorData[i].teacher.name + ' - ' + mentorData[i].region.name + '</option>');
            }
        }

        $("#mentor-dropdown").html(options.join(''));
      }
    });
}

async function getMentoringById(id){
    $.ajax({
        url : "/mentoring/" + id,
        type : "GET",
        success: function(mentoring){
            var mentoringData = JSON.parse(mentoring);

            $('#mentoring-id').val(mentoringData.id);
            populateStudentDropdown(mentoringData.student_id);
            populateMentorDropdown(mentoringData.mentor_id);
        }
    });
}

function editMentoring(){
  var id = $('#mentoring-id').val();

  $('#form-edit').attr('action', '/mentoring/' + id);
  $('#form-edit').unbind("submit");
  $('#form-edit').submit();
}