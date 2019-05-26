/*
name : designToggle.js
version : 1.2
maker : work6.kr
*/
(function($){

	var ele;


	$.fn.designToggle = function(opt){
		ele = $(this);

        id = $(this).attr('id');

        if(typeof id ==='undefined'){
            i = $('[type="checkbox"]').index($(this));
            id='toggle_'+$.now()+i;
        }

        html = "<label class='designToggle' for='"+id+"'></label>";
        $(this).after(html);

        $(this).attr('id',id).css('display','none');

	}
})(jQuery);
