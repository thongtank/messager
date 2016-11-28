// LOAD department, Aumphur and District from log not database
$(function() {
    $('.se-pre-con').hide();
    var $std_id = $('input#student_id');
    var $std_new_id = $('input#student_new_id');
    var $lblname = $('label#student_name');
    var $lblalready = $('label#std_already');    
    var $btnsubmit = $('button#btnown');
    var $btnsubmit_new_std = $('button#btn_submit_new_std');
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

    $std_new_id.keyup(function(event) {
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
                        $lblalready.html('');
                        $btnsubmit_new_std.removeAttr('disabled');
                    } else {
                        $lblalready.html('<b>รหัสนักเรียนซ้ำ ไม่สามารถใช้งานได้</b>');                    
                        $btnsubmit_new_std.attr('disabled', 'disabled');
                    }
                    
                });
        }
    });
});
