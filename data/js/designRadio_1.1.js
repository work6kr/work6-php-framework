/*
name : designRadio.js
version : 1.1
maker : work6.kr
Required :
fontawesome
*/
(function($){

	var ele;


	$.fn.designRadio = function(opt){
		ele = $(this);

		$(ele).find("input[type='radio']").each(function(i){

			id = $(this).attr('id');

			if(typeof id ==='undefined'){
				id='radio_'+$.now()+""+i;
			}

            $(this).after('<label class="radio" for="'+id+'"><i class="fa fa-circle" aria-hidden="true"></i></label>');
            $(this).attr('id',id).css('display','none');


		});

	}
})(jQuery);
