$(function() {
    $('.se-pre-con').hide();
    $('.btn-success').click(function() {
        console.log($('input[type=date]').val());
    });


    /*
    $('.btn-success').confirm({
        text: 'ยืนยันการกรอกข้อมูลของท่าน ถูกต้องหรือไม่ ?',
        title: 'ยืนยันข้อมูล',
        confirm: function(button) {
            var datas = $('form').serializeArray();
            var obj = {};
            $.each(datas, function(index, val) {
                console.log('key: ' + index + ', val: ' + val.value + '\n');
                obj[val.name] = val.value;
            });
            $.ajax({
                    url: 'php/research.inc.php',
                    type: 'POST',
                    data: {
                        obj: JSON.stringify(obj)
                    },
                    beforeSend: function() {
                        $('.se-pre-con').show();
                    },
                    complete: function() {
                        $('.se-pre-con').hide();
                    }
                })
                .done(function(res) {
                    if (res == 'success') {
                        window.location.href = 'thank.html';
                    } else {
                        console.log(res);
                        // window.location.href = 'error.html';
                    }
                });

        },
        cancel: function(button) {

        },
        confirmButton: 'ยืนยัน',
        cancelButton: 'ยกเลิก',
        confirmButtonClass: "btn-success",
        cancelButtonClass: "btn-danger",
        dialogClass: "modal-dialog modal-lg" // Bootstrap classes for large modal

    });
    */
   
});
