/* ------------------------------------
	pointer.js
	Mignon Style
	http://mignonstyle.com/
------------------------------------ */

jQuery(function($){
	var width = $(window).width();
	if(width <= 640){
		return false;
	}else{
		option_pointer();

		$('#tabset ul li').click(function(){
			if($(this).attr('aria-labelledby') == 'tab-links'){
				option_pointer();
				$('#wp-pointer-0').show();
			}else{
				$('#wp-pointer-0').hide();
			}
		});
	}

	function option_pointer(){
		$(chocolat_pointer.target).pointer({
			content: chocolat_pointer.content,
			position: chocolat_pointer.position,
			pointerWidth: chocolat_pointer.pointerWidth,
			close: function(){
				$.post(ajaxurl, {
					pointer: chocolat_pointer.handler,
					action: 'dismiss-wp-pointer',
				});
			}
		}).pointer('open');
	}
});