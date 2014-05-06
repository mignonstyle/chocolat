/* ------------------------------------
	slidenav.js
	Mignon Style
	http://mignonstyle.com/
------------------------------------ */
jQuery(function($){
	var replaceWidth = 640;
	var timer = false;
	var nav_control = $('#nav-control');
	var globalnav = $('div.globalnav');
	var search_label = $('.header-links .search-box label');
	var search_field = $('.header-links .search-box .search-field');

	chocolat_global_menu();

	// resize
	$(window).resize(function(){
		if(timer !== false){
			clearTimeout(timer);
		}
		timer = setTimeout(function(){
			if(nav_control.attr('class') == 'close'){
				chocolat_global_menu();
			}
		}, 200);
	});

	// globalnav
	$(nav_control).click(function(){
		search_field.slideUp();

		if($(this).attr('class') == 'close'){
			globalnav.slideDown();
			$(this).removeClass().addClass('active');
			$('span', nav_control).attr('class', 'icon-cancel');
		}else{
			globalnav.slideUp();
			$(this).removeClass().addClass('close');
			$('span', nav_control).attr('class', 'icon-menu');
		}
		return false;
	});

	// search
	search_label.click(function(){
		if($(nav_control).attr('class') != 'close'){
			globalnav.slideUp();
			$(nav_control).removeClass().addClass('close');
			$('span', nav_control).attr('class', 'icon-menu');
		}
		search_field.slideToggle();
	});

	// global menu
	function chocolat_global_menu(){
		var windowWidth = parseInt($(window).width());

		if(windowWidth <= replaceWidth){ // 640
			globalnav.css('display', 'none');
			search_field.css('display', 'none');
		}else if(windowWidth > replaceWidth){ // 641
			globalnav.css('display', 'inline');
			search_field.css('display', 'inline');
		}
	}
});