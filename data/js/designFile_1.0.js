/*
name : designFile.js
version : 1.0
maker : work6.kr
*/
(function($){

	var ele;


	$.fn.designFile = function(opt){

        ele = $(this);

        id = $(this).attr('id');

        if(typeof id ==='undefined'){
            i = $('[type="file"]').index($(this));
            id='file_'+$.now()+i;
        }

        $(this).after('<label class="designFile" for="'+id+'">파일첨부</label>');
        $(this).attr('id',id).css({'z-index':'-1','opacity':0,'width':'0px','height':'0px','position':'absolute','padding':0,'margin':0});

        $(this).change(function(){
            if(!$(this).val()){
                $("[for='"+id+"']").empty().html('파일첨부');
            }else{
                $("[for='"+id+"']").empty().html($(this).val());
            }
        });

	}
})(jQuery);
