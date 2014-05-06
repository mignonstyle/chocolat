/* ------------------------------------
	thumbnail-image.js
	Mignon Style
	http://mignonstyle.com/
------------------------------------ */
jQuery(function($){
	var timer = false;

	// related-contents thumbnail
	if($('.related-contents li img.no-thumbnail-image').size()){
		chocolat_related_image_hieght();

		$(window).resize(function(){
			if(timer !== false){
				clearTimeout(timer);
			}
			timer = setTimeout(function(){
				chocolat_related_image_hieght();
			}, 200);
		});
	}

	function chocolat_related_image_hieght(){
		var thumbnail_size = $('.related-contents li img').width();
		$('.related-contents li img').height(thumbnail_size);
	}

	// new-contents thumbnail
	if($('.new-contents li img.no-thumbnail-image').size()){
		chocolat_newcontents_image_hieght();

		$(window).resize(function(){
			if(timer !== false){
				clearTimeout(timer);
			}
			timer = setTimeout(function(){
				chocolat_newcontents_image_hieght();
			}, 200);
		});
	}

	function chocolat_newcontents_image_hieght(){
		var thumbnail_size = $('.new-contents li img').width();
		$('.new-contents li img').height(thumbnail_size);
	}

	// sidebar thumbnail
	if($('.sidebar-thumbnail span img.no-thumbnail-image').size()){
		chocolat_widget_image_hieght();

		$(window).resize(function(){
			if(timer !== false){
				clearTimeout(timer);
			}
			timer = setTimeout(function(){
				chocolat_widget_image_hieght();
			}, 200);
		});
	}

	function chocolat_widget_image_hieght(){
		var thumbnail_size = $('.sidebar-thumbnail span img').width();
		$('.sidebar-thumbnail span img').height(thumbnail_size);
	}
});