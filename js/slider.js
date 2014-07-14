/* ------------------------------------
	slider.js
	Mignon Style
	http://mignonstyle.com/
------------------------------------ */
jQuery(function($){
	$('#header-image.flexslider .slides > li:first-child ').css({
		display: 'none',
		visibility: 'visible',
	});

	$('.flexslider').flexslider({
		pauseOnHover: true,
	});

	/*
	* The navigation of flexslider is fixed 
	* in the center position of the image
	*/
	var timer = false;
	flexslider_nav_position();

	$(window).resize(function(){
		if(timer !== false){
			clearTimeout(timer);
		}
		timer = setTimeout(function(){
			flexslider_nav_position();
		}, 200);
	});

	function flexslider_nav_position() {
		var slide_heihgt = $('.flexslider .slides li img').innerHeight();
		var nav_height = $('.flex-direction-nav a').innerHeight();
		var nav_top = (slide_heihgt - nav_height) / 2;
		$('.flex-direction-nav a').css({top: nav_top, margin: 0});
	}
});