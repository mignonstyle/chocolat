/**
 * custom-css.js
 * @package   Chocolat
 * @copyright Copyright (c) 2014 Mignon Style
 * @license   GNU General Public License v2.0
 * @since     Chocolat 1.0
 */

jQuery(function($){
	var timer = false;
	var margin_h = '25px';
	var margin_w = '15px';

/* -----------------------------------------------------
   1.0 - Resize
----------------------------------------------------- */

	$(window).resize(function(){
		if(timer !== false){
			clearTimeout(timer);
		}
		timer = setTimeout(function(){
			if(chocolat_script.featured_sneak_js){
				featured_css();
			}

			if(chocolat_script.featured_sneak_home_js){
				featured_home_css();
			}
		}, 200);
	});

/* -----------------------------------------------------
   2.1 - Featured image sneak
----------------------------------------------------- */

	// featured sneak
	if(chocolat_script.featured_sneak_js){
		var img_width = chocolat_script.featured_size_w;
		var featured_pos = chocolat_script.featured_pos;
		featured_css();
	}

	// featured sneak style
	function featured_css(){
		var content_width = $('.post-content').width();
		if ( img_width >= content_width ) {
			$('section .entry-thumbnail').css({'float':'none', 'margin':margin_h+' 0 '+margin_h+' 0'});
		} else {
			$('section .entry-thumbnail').css({'float':'left', 'margin':'0 '+margin_w+' '+margin_h+' 0'});
			if(featured_pos == 'right'){
				$('section .entry-thumbnail').css({'float':'right', 'margin':'0 0 '+margin_h+' '+margin_w});
			}
			$('.single section .entry-thumbnail').css({'margin-top':margin_h});
		}
	}

/* -----------------------------------------------------
   2.2 - Featured image sneak of home page
----------------------------------------------------- */

	// featured sneak of home page
	if(chocolat_script.featured_sneak_home_js){
		var img_width_home = chocolat_script.featured_home_size_w;
		var featured_pos_home = chocolat_script.featured_home_pos;
		featured_home_css();
	}

	// featured sneak style of home page
	function featured_home_css(){
		var content_width = $('.post-content').width();
		if ( img_width_home >= content_width ) {
			$('section .entry-thumbnail.home-thumbnail').css({'float':'none', 'margin':margin_h+' 0 '+margin_h+' 0'});
		} else {
			$('section .entry-thumbnail.home-thumbnail').css({'float':'left', 'margin':'0 '+margin_w+' '+margin_h+' 0'});
			if(featured_pos_home == 'right'){
				$('section .entry-thumbnail.home-thumbnail').css({'float':'right', 'margin':'0 0 '+margin_h+' '+margin_w});
			}
		}
	}
});