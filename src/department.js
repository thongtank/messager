$(function() {
    var $lblname = $('label#department_name');
    var $lblname_branch = $('label#branch_name');
    var dep_name = '';
    var branch_name = '';
    var $btnsubmit = $('#btnsubmit');
    var dep_id;
    $('input#department').keyup(function() {
        dep_name = $(this).val();
        $.ajax({
            url: '/utcmsg/php/already_department.php',
            type: 'POST',
            data: {
                name: $(this).val()
            }
        }).done(function(data) {
            if (data == 1) {
                $lblname.html('<b class=text-danger>แผนก ' + dep_name + ' ไม่สามารถใช้งานได้</b>');
                $btnsubmit.attr('disabled', 'disabled');
            } else {
                $lblname.html('<b class=text-success>แผนก ' + dep_name + ' สามารถใช้งานได้</b>');
                $btnsubmit.removeAttr('disabled');
            }

        });
    });

    $('input#branch').keyup(function() {
        branch_name = $(this).val();
        if ($('select#department').val() === '') {
            dep_id = $('#dep_id').val();
        } else {
            dep_id = $('#department').val();
        }
        $.ajax({
            url: '/utcmsg/php/already_branch.php',
            type: 'POST',
            data: {
                name: branch_name,
                dep_id: dep_id
            }
        }).done(function(data) {
            if (data == 1) {
                $lblname_branch.html('<b class=text-danger>' + branch_name + ' ไม่สามารถใช้งานได้</b>');
                $btnsubmit.attr('disabled', 'disabled');
            } else {
                $lblname_branch.html('<b class=text-success>' + branch_name + ' สามารถใช้งานได้</b>');
                $btnsubmit.removeAttr('disabled');
            }

        });
    });

    $.ajax({
            // url: '/utcmsg/php/logs/department.txt',
            url: '/utcmsg/php/query_department.php',
            dataType: "json",
            beforeSend: function() {
                $('.se-pre-con').show();
            },
            complete: function() {
                $('.se-pre-con').hide();
            }
        })
        .done(function(res) {
            $('select#department').html('<option value="">เลือกแผนกวิชา</option>');
            $.each(res, function(index, val) {
                $('select#department').append('<option value="' + val.dep_id + '">' + val.dep_name + '</option>');
            });
            console.log('department Loaded');
        });

    /** department Change Zone */
    $('select#department').change(function() {
        getdepartmentDetail($('select#branch'), $(this).val(), 'branch');
    });

    function getdepartmentDetail(element, id, table) {
        var path = '';
        if (table == 'branch') {
            path = '/utcmsg/php/query_branch.php';
        }
        $.ajax({
                url: path,
                dataType: 'json',
                beforeSend: function() {
                    $('.se-pre-con').show();
                },
                complete: function() {
                    $('.se-pre-con').hide();
                }
            })
            .done(function(res) {
                if (table == 'branch') {
                    element.html('<option value="">เลือกสาขาวิชา</option>');
                    $.each(res, function(index, val) {
                        if (val.dep_id == id) {
                            element.append('<option value="' + val.branch_id + '">' + val.branch_name + '</option>');
                        }
                    });
                }
            })
            .error(function(res) {
                console.log('error:' + res);
            });

    }
});
