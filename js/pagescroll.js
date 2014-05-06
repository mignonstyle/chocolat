/* ------------------------------------
	pagescroll.js
	Mignon Style
	http://mignonstyle.com/
------------------------------------ */
jQuery(function($){
	var top_btn = $('#pagetop');
	var is_hidden = true;

	top_btn.hide();

	// to Top
	$(window).scroll(function(){
		chocolat_getbg_position($(this));
	});

	// page scroll
	$('a[href^=#]').not('[href="#"]').click(function(e){
		var obj_hash = $(this.hash);
		var hash_offset = obj_hash.offset().top;
		$('html, body').animate({scrollTop: hash_offset}, 'swing');
		return false;
		e.preventDefault();
	});

	// top button
	function chocolat_getbg_position(obj){
		if($(this).scrollTop() > 300){
			if(is_hidden){
				top_btn.stop(true, true).fadeIn();
				is_hidden = false;
			}
		}else if(!is_hidden){
			top_btn.stop(true, true).fadeOut();
			is_hidden = true;
		}
	}
});