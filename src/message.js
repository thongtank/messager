$(function(){
    var $std = $('#student_form');
    var $grp = $('#group_form');
    $std.hide();
    $grp.hide();

    $('#show-std').click(function(event) {
        event.preventDefault();
        $std.show('slow/400/fast');
        $grp.hide('slow/400/fast');
    });

    $('#show-grp').click(function(event) {
        event.preventDefault();
        $grp.show('slow/400/fast');
        $std.hide('slow/400/fast');
    });

    // var kind = '';
    // $('input#kind_of_send').change(function(event) {
    //     // alert($(this).val());
    //     kind = $(this).val();
    //     if(kind == 'one'){
    //         $std.show('slow/400/fast');
    //         $grp.hide();
    //     } else {
    //         $grp.show('slow/400/fast');
    //         $std.hide();
    //     }
    // });
});