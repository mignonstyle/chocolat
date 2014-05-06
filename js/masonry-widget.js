/* ------------------------------------
	masonry-widget.js
	Mignon Style
	http://mignonstyle.com/
------------------------------------ */
jQuery(function($){
	var sidebar_flag;
	var replaceWidth = 800;
	var maxWidth = 1000;
	var timer = false;
	var column;
	var column_size;
	var wrapper_width;

	if($('#wrapper').outerHeight(true) > $(window).height()){
		maxWidth = maxWidth - 15;
	}

	chocolat_set_masonry();

	$(window).resize(function(){
		if(timer !== false){
			clearTimeout(timer);
		}
		timer = setTimeout(function(){
			chocolat_set_masonry();
		}, 200);
	});

	function chocolat_set_masonry(){
		if($(window).width() < maxWidth){
			if($(window).width() <= replaceWidth){
				column = 2;
				column_size = 10;
			}else if(replaceWidth < $(window).width()){
				column = 3;
				column_size = 20;
			}

			if($('#widget-footer-inner').size()){
				wrapper_width = parseInt($('#widget-footer-inner').width());
			}else if($('#sidebar .widget-inner').size()){
				wrapper_width = parseInt($('#sidebar .widget-inner').width());
			}else{
				return;
			}

			var column_width = parseInt((wrapper_width - column_size) / column);

			chocolat_set_widget_footer(column_width, 10);
			chocolat_set_widget_sidebar(column_width, 10);
		}else if(maxWidth <= $(window).width()){
			if(sidebar_flag){
				$('#sidebar .sidebar-widget').removeClass('widget-masonry');
				$('#sidebar .widget-inner').masonry('destroy');
				sidebar_flag = false;
			}
			chocolat_set_widget_footer(300, 40);
		}
	}

	function chocolat_set_widget_footer(column_width, gutter_size){
		$('#widget-footer .footer-widget').addClass('widget-masonry');

		$('#widget-footer .widget-inner').imagesLoaded(function(){
			$('#widget-footer .widget-inner').masonry({
				columnWidth: column_width,
				itemSelector: '.footer-widget',
				isAnimated: 'true',
				gutterWidth: gutter_size, // masonry v2
				gutter: gutter_size, // masonry v3
			});
		});
	}

	function chocolat_set_widget_sidebar(column_width, gutter_size){
		$('#sidebar .sidebar-widget').addClass('widget-masonry');

		$('#sidebar .widget-inner').imagesLoaded(function(){
			$('#sidebar .widget-inner').masonry({
				columnWidth: column_width,
				itemSelector: '.sidebar-widget',
				isAnimated: 'true',
				gutterWidth: gutter_size, // masonry v2
				gutter: gutter_size, // masonry v3
			});
		});
		sidebar_flag = true;
	}
});