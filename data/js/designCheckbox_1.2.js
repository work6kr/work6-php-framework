/*
name : designCheckbox.js
version : 1.2
maker : work6.kr
Required :
fontawesome
*/
(function($){

	var ele;


	$.fn.designCheckbox = function(opt){

        ele = $(this);

        id = $(this).attr('id');

        if(typeof id ==='undefined'){
            i = $('[type="checkbox"]').index($(this));
            id='checkbox_'+$.now()+i;
        }

        $(this).after('<label class="designCheckbox" for="'+id+'"></label>');
        $(this).attr('id',id).css('display','none');



	}
})(jQuery);
