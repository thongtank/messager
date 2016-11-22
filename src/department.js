$(function() {
    $.ajax({
            url: '/utcmsg/php/logs/department.txt',
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
            path = '/utcmsg/php/logs/branch.txt';
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
