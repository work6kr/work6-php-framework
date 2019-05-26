$(function(){

	var profile = false;
    var menu = false;

    $('#body_header .profile .btn_element').click(function(){

        if(profile){
            $(this).parent('.profile').find('ul').removeClass('on');
            profile = false;
        }else{
            $(this).parent('.profile').find('ul').addClass('on');
            profile = true;
        }
    });


    $('#body_header .btn_menu').click(function(){
        if(menu){
            $('#admin_body').removeClass('menu_close');
            menu = false;
        }else{
            $('#admin_body').addClass('menu_close');
            menu = true;
        }
    });


    $('.chkall').click(function(){
        table = $(this).closest('table');
        chkbox = $(table).find('input[type="checkbox"]');
        len = chkbox.length;

        checkdd_chkbox = $(table).find('input[type="checkbox"]:checked');
        checkdd_len = checkdd_chkbox.length;

        if(len!=checkdd_len){
            $(chkbox).each(function(){
                $(this).prop('checked','checked');
            });
        }else{
            $(chkbox).each(function(){
                $(this).prop('checked','');
            });
        }

    });



    if ($("select")[0]) {
        $("select").each(function(){
            $(this).designSelect();
        });
    }



    if ($(".toggle")[0]) {
        $(".toggle").each(function(){
            $(this).designToggle();
        });
    }


    if ($('.checkbox')[0]) {
        $('.checkbox').each(function(){
            $(this).designCheckbox();
        });
    }


    if ($('.calendar')[0]) {
        $('.calendar').each(function(){
            $(this).datepicker({
                dateFormat: 'yy-mm-dd',
                prevText: '이전 달',
                nextText: '다음 달',
                monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
                monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
                dayNames: ['일','월','화','수','목','금','토'],
                dayNamesShort: ['일','월','화','수','목','금','토'],
                dayNamesMin: ['일','월','화','수','목','금','토'],
                showMonthAfterYear: true,
                changeMonth: true,
                changeYear: true,
                yearSuffix: '년'
            });
        });
    }



});


//글자수체크
function strLen(data){

    len = data.length;
    total = 0;
    var str2 = "";

    for (var i = 0; i < len; i++) {
        one = data.charAt(i);
        total++;
    }

    return total;

}


function comma(num) {
	return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
