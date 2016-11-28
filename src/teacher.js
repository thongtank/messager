// LOAD department, Aumphur and District from log not database
$(function() {
    $('.se-pre-con').hide();
    var $teacher = $('input#teacher_username');
    var $lblalready = $('label#teacher_already');
    var $btnsubmit = $('button[type=submit]');
    var teacher_username;
    $teacher.keyup(function(event) {
        event.preventDefault();
        // console.log($(this).val());
        teacher_username = $(this).val();

        $.ajax({
                url: '/utcmsg/php/get_teacher.php',
                type: 'POST',
                dataType: 'json',
                data: { teacher_username: teacher_username },
                beforeSend: function() {
                    $('.se-pre-con').show();
                },
                complete: function() {
                    $('.se-pre-con').hide();
                }
            })
            .done(function(data) {
                console.log(data);
                if (data === null) {
                    $lblalready.html('');
                    $btnsubmit.removeAttr('disabled');
                } else {
                    $lblalready.html('<b>ชื่อผู้ใช้ดังกล่าวซ้ำ ไม่สามารถใช้งานได้</b>');
                    $btnsubmit.attr('disabled', 'disabled');
                }

            });

    });
});
