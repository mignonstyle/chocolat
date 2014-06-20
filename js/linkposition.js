/* ------------------------------------
	linkposition.js
	Mignon Style
	http://mignonstyle.com/
------------------------------------ */
jQuery(function($){
	var replaceWidth = 640;
	var timer = false;

	chocolat_link_position();

	// resize
	$(window).resize(function(){
		if(timer !== false){
			clearTimeout(timer);
		}
		timer = setTimeout(function(){
			chocolat_link_position();
		}, 200);
	});

	/* -----------------------------------------------------
	Depending on the length of the character of 
	the site title and site description, 
	change the position of the link button and search box.
	----------------------------------------------------- */
	function chocolat_link_position() {
		var windowWidth = parseInt($(window).width());

		if(replaceWidth < windowWidth){ // 640
			var header_width = $('#header-top').width();
			var title_width = $('#header #site-title').width();

			var sns_width = $('#header .contactlink-top').outerWidth(true);
			var search_width = $('#header .search-box').outerWidth(true);
			var links_width = sns_width + search_width + 20;

			if($('#header #site-description').size()){ // When there is description
				var desc_width = $('#header #site-description').width();

				if(links_width < (header_width - desc_width)){ // When description is short
					if((header_width - title_width) < links_width){ // When a title is long
						$('#header #site-title').css('margin-bottom', '37px');
					}
				}else{ // When description is long
					if((header_width - title_width) < links_width){ // When a title is long
						$('#header #site-description').css('margin-bottom', '50px');
					}else{ // When a title is short
						$('#header .contactlink-top').css('top', '1px');
						$('#header .header-links .search-box').css('top', '-2px');
					}
				}
			}else{ // When there is no description
				if((header_width - title_width) < links_width){ // When a title is long
					$('#header #site-title').css('margin-bottom', '50px');
				}
			}
		}else if(windowWidth <= replaceWidth){
			$('#header #site-title').css('margin-bottom', 'auto');
			$('#header #site-description').css('margin-bottom', 'auto');
		}
	}
});