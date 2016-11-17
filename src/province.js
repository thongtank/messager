// LOAD Province, Aumphur and District from log not database
$(function() {
    $.ajax({
            url: '/utcmsg/php/logs/provinces.txt',
            dataType: "json",
            beforeSend: function() {
                $('.se-pre-con').show();
            },
            complete: function() {
                $('.se-pre-con').hide();
            }
        })
        .done(function(res) {
            $('select#province').html('<option value="">เลือกจังหวัด</option>');
            $.each(res, function(index, val) {
                $('select#province').append('<option value="' + val.PROVINCE_ID + '">' + val.PROVINCE_NAME + '</option>');
            });
            console.log('Province Loaded');
        });

    /** Province Change Zone */
    $('select#province').change(function() {
        getProvinceDetail($('select#amphur'), $(this).val(), 'amphur');
    });

    /** Amphur Change Zone */
    $('select#amphur').change(function() {
        getProvinceDetail($('select#district'), $(this).val(), 'district');
    });
    /**
     * Filter Amphur and District
     * @param  {text} element element of filter select
     * @param  {number} id      id of province/amphur
     * @param  {text} table   table of survay's database
     * @return {}         
     */
    function getProvinceDetail(element, id, table) {
        var path = '';
        if (table == 'amphur') {
            path = '/utcmsg/php/logs/amphur.txt';
        } else {
            path = '/utcmsg/php/logs/district.txt';
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
                if (table == 'amphur') {
                    element.html('<option value="">เลือกอำเภอ</option>');
                    /*
                    $.each(res, function(index, val) {
                        element.append('<option value="' + val.AMPHUR_ID + '">' + val.AMPHUR_NAME + '</option>');
                    });
                    */
                    $.each(res, function(index, val) {
                        if (val.PROVINCE_ID == id) {
                            element.append('<option value="' + val.AMPHUR_ID + '">' + val.AMPHUR_NAME + '</option>');
                        }
                    });
                } else {
                    element.html('<option value="">เลือกตำบล</option>');
                    $.each(res, function(index, val) {
                        if (val.AMPHUR_ID == id) {
                            element.append('<option value="' + val.DISTRICT_ID + '">' + val.DISTRICT_NAME + '</option>');
                        }
                    });
                }

            })
            .error(function(res) {
                console.log('error:' + res);
            });
    }
});
