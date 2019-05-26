/*
name : fullPopup.js
maker : work6.kr
*/
(function($){

	$.fn.extend({
		fullPopupOn : function(opt) {
			ele = this;
			ele_w = this.width();
			ele_h = this.height();

			if(opt){
				if(opt.width){
					ele_w = opt.width;
					this.css('width',ele_w);
				}


				if(opt.height){
					ele_h = opt.height;
					this.css('height',ele_h);
				}

			}


			marginleft = (ele_w/2)*(-1);
			margintop = (ele_h/2)*(-1);

			html = "<div class='fullpopupbg' style='background:rgba(1,1,1,0.8); position:fixed; top:0; left:0; width:100%; height:105%; z-index:9998;'></div>";
			$('body').append(html);
			this.css({'position':'fixed','left':'50%','top':'50%','margin-left':marginleft+'px','margin-top':margintop+'px','z-index':'9999','display':'block'});


            $(window).resize(function(){

                ele_w = $(ele).width();
    			ele_h = $(ele).height();

    			if(opt){
    				if(opt.width){
    					ele_w = opt.width;
    					$(ele).css('width',ele_w);
    				}


    				if(opt.height){
    					ele_h = opt.height;
    					$(ele).css('height',ele_h);
    				}

    			}

                marginleft = (ele_w/2)*(-1);
    			margintop = (ele_h/2)*(-1);

                $(ele).css({'margin-left':marginleft+'px','margin-top':margintop+'px'});
            });


			$(document).on('click','.fullpopupbg',function(){
				$(ele).fullPopupOff();
			});


		},
		fullPopupOff : function() {
			$('.fullpopupbg').remove();
			this.css('display','none');
			this.attr('src','');
		},
		fullPopupChg:function(){
			marginleft = (this.width()/2)*(-1);
			margintop = (this.height()/2)*(-1);
			this.css({'margin-left':marginleft+'px','margin-top':margintop+'px'});
		}

	});

})(jQuery);
