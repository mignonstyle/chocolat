/* ------------------------------------
	pagescroll.js
	Mignon Style
	http://mignonstyle.com/
------------------------------------ */
jQuery(function($){
	var top_btn = $('#pagetop');
	var pagetop_link = $('#pagetop a');
	var is_hidden = true;
	var replaceWidth = 640;
	var timer = false;
	var sp = '300';

	top_btn.hide();
	chocolat_top_button();

	// resize
	$(window).resize(function(){
		if(timer !== false){
			clearTimeout(timer);
		}
		timer = setTimeout(function(){
			chocolat_top_button();
		}, 200);
	});

	function chocolat_top_button(){
		var windowWidth = parseInt($(window).width());

		if(windowWidth <= replaceWidth){ // 640
			top_btn.show().css('background', '#ba8d65');
			$(window).off('load scroll');
			chocolat_pagetop_small();
		}else if(windowWidth > replaceWidth){ // 641
			top_btn.hide().css('background', 'none');
			pagetop_link.css('background', 'none').off('.pagetop');

			// to Top
			$(window).on({'load scroll': function(){
				chocolat_getbg_position($(this));
				}
			});
		}
	}

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

	// page scroll
	$('a[href^=#]').not('[href="#"]').click(function(e){
		var obj_hash = $(this.hash);
		var hash_offset = obj_hash.offset().top;
		$('html, body').animate({scrollTop: hash_offset}, 'swing');
		return false;
		e.preventDefault();
	});

	// pagetop_small
	function chocolat_pagetop_small(){
		pagetop_link.on({'mouseenter.pagetop': function(){
				$(this).css('background', '#f56993').animate({opacity:'1'}, sp);
			},'mouseleave.pagetop': function(){
				$(this).css('background', '#ba8d65').animate({opacity:'1'}, sp);
			}
		});
	}
});