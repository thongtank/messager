// LOAD department, Aumphur and District from log not database
$(function() {
    $('.se-pre-con').hide();
    var $std_id = $('input#student_id');
    var $lblname = $('label#student_name');
    var $btnsubmit = $('button#btnown');
    var student_id = '';
    $std_id.keyup(function(event) {
        event.preventDefault();
        student_id = $(this).val();
        if (student_id.length == 10) {
            $lblname.html('');
            $.ajax({
                    url: '/utcmsg/php/get_student.php',
                    type: 'POST',
                    dataType: 'json',
                    data: { student_id: student_id },
                    beforeSend: function() {
                        $('.se-pre-con').show();
                    },
                    complete: function() {
                        $('.se-pre-con').hide();
                    }
                })
                .done(function(data) {
                    if (data === null) {
                        $lblname.html('<b class=text-danger>ไม่พบข้อมูล</b>');
                        $btnsubmit.attr('disabled', 'disabled');
                    } else {
                        $lblname.html('<b>' + data.fname + ' ' + data.lname + '</b>');                    
                        $btnsubmit.removeAttr('disabled');
                    }
                    
                });
        }
    });
});
