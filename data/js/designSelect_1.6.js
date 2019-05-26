/*
name : designSelect.js
version : 1.6
maker : work6.kr
*/
(function($){

	var ele;


	$.fn.designSelect = function(opt){
		ele = $(this);
		selectbox = null;
        id = $(this).attr('id');
        box_width = $(this).width()+30;
        box_height = $(this).height();
        div_option = '';
        option_ea = 0;

        if(typeof id ==='undefined'){
            i = $('select').index($(this));
            id='select_'+$.now()+i;;
            virtual = 'dssingSelect_'+$.now()+i;;
        }


        $(this).children('option').each(function(){

            option_ea++;
            if(option_ea==1){
                title = $(this).text();
            }

            if($(this).attr('selected')=='selected'){
                title = $(this).text();
            }


            div_option += "<div class='option' style='height:"+box_height+"px; line-height:"+box_height+"px; padding:0px 8px; ' value='"+$(this).val()+"'>"+$(this).text()+"</div>";
        });

        $(this).attr('id',id).css('display','none');


        div_html = "<div class='designSelect' id='"+virtual+"'><div class='box' style='width:"+box_width+"px; height:"+box_height+"px; padding:0px 8px; vertical-align:middle; line-height:"+box_height+"px;' for='"+id+"'>"+title+"</div><div class='option_container' style='width:"+(box_width+2)+"px; height:"+((box_height*option_ea)+2)+"px; margin-left:-1px;'>"+div_option+"</div></div>";


        $(this).before(div_html);




        //div셀랙트박스 클릭시 동작
		$(document).on("click",'#'+virtual,function(){
			selectbox = $(this).find('.box').next('.option_container');
			if(selectbox.css('display')=='block'){
				selectbox.slideUp(200);
			}else{
				selectbox.slideDown(200);
			}
		});



		//option 클릭시 동작
		$(document).on("click",'#'+virtual+" .option",function(){
			option = $(this);
			box = option.parents('.designSelect').children('.box');
			box.text(option.text());
			value = $(this).attr('value');

			//원본 select에 반영
			id = '#'+box.attr('for');
			$(id).val(value);


			selectbox.slideUp();


            $(id).trigger('change',[value]);

		});




        //body 클릭시 동작
		$(document).click(function(e){

            $('.designSelect').each(function(){
                selectbox = $(this).find('.box').next('.option_container');
    			if(selectbox.css('display')=='block'){
                    if(!$(e.target).parent('.designSelect').hasClass('designSelect')){
                        selectbox.slideUp();
                    }
                }
            });


		});


	}
})(jQuery);
