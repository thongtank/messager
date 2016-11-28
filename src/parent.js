// LOAD department, Aumphur and District from log not database
$(function() {
    $('.se-pre-con').hide();
    var $parent_id = $('input#parent_id');
    var $lblalready = $('label#parent_already');    
    var $btnsubmit = $('button[type=submit]');
    var parent_id;
    $parent_id.keyup(function(event) {
        event.preventDefault();
        // console.log($(this).val());
        parent_id = $(this).val();
        if (parent_id.length == 13) {
            $.ajax({
                    url: '/utcmsg/php/get_parent.php',
                    type: 'POST',
                    dataType: 'json',
                    data: { parent_id: parent_id },
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
                        $lblalready.html('<b>เลขประจำตัวประชาชนดังกล่าวถูกใช้ไปแล้ว</b>');
                        $btnsubmit.attr('disabled', 'disabled');
                    }
                    
                });
        }
    });
});
