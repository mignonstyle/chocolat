/* ------------------------------------
	tooltips.js
	Mignon Style
	http://mignonstyle.com/

	jquery.ui.tooltip.min.js
------------------------------------ */
jQuery(function($){
	// add tooltip class and title
	$('.contactlink-top li, .contactlink-bottom li').addClass('tooltip');
	$('.contactlink-top li, .contactlink-bottom li').each(function(){
		var li_text = $(this).text();
		$(this).attr('title', li_text);
	});

	// jquery-ui-tooltip
	$('.tooltip').tooltip({
		position: {
		my: 'left bottom-10',
		at: 'left top',
		collision: 'none',
		}
	});
});