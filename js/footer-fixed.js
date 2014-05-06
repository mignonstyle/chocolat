/* ------------------------------------
	footer-fixed.js
	Mignon Style
	http://mignonstyle.com/
------------------------------------ */
jQuery(function($){
	var conHeight = $('#wrapper').outerHeight(true);
	var maxWidth = 1000;
	var timer = false;
	var footer_content;

	chocolat_footer_fixed();

	$(window).resize(function(){
		if(timer !== false){
			clearTimeout(timer);
		}
		timer = setTimeout(function(){
			chocolat_fixed_remove();
			conHeight = $('#wrapper').outerHeight(true);
			chocolat_footer_fixed();
		}, 200);
	});

	function chocolat_footer_fixed(){
		var windowHeight =  parseInt($(window).height());
		var topPos = 0;

		if(conHeight < windowHeight){
			topPos = windowHeight - conHeight;
			topPos = topPos+'px';

			if($(window).width() < maxWidth){
				footer_content = $('#content-inner');
			}else if($(window).width() >= maxWidth){
				footer_content = $('#contents');
			}
			footer_content.after('<div class="footer-fixed"></div>');
			$('.footer-fixed').css({
				content: '',
				display:'block',
				height: topPos,
			});
		}else if(conHeight > windowHeight){
			chocolat_fixed_remove();
		}
	}

	// footer-fixed remove
	function chocolat_fixed_remove(){
		if($('.footer-fixed').size()){
			$('.footer-fixed').remove();
		}
	}
});