/* ------------------------------------
	rollover.js
	Mignon Style
	http://mignonstyle.com/
------------------------------------ */
jQuery(function($){
	var sp = '300';
	var elm = $('.rollover a');

	elm.each(function(){
		var txt = $(this).html();
		$(this).append('<span class="ro-off">' + txt + '</span>');
		$(this).append('<span class="ro-on">' + txt + '</span>');

		$('span.ro-off, span.ro-on', elm).css({
			cursor:'pointer',
			display:'block',
			height:'100%',
			opacity:'0',
			position:'absolute',
			left:'0',
			top:'0',
			width:'100%',
		});

		$(this).css({
			display: 'block',
			overflow: 'hidden',
			position: 'relative',
		});

		elm.css('background', 'none');
		$('span.ro-off', elm).css('opacity', '1');
		$('span.ro-on', elm).css('opacity', '0');
	});

	elm.hover(function(){
		var elm_class = $(this).attr('class');
		if(elm_class == 'pagetop-btn'){
			$(this).children('span.ro-on').stop().animate({opacity:'1'}, sp, function(){
				$(this).children('span.ro-off').stop().animate({opacity:'0'}, sp);
			});
		}else {
			$(this).children('span.ro-on').stop().animate({opacity:'1'}, sp);
			$(this).children('span.ro-off').stop().animate({opacity:'0'}, sp);
		}
	}, function(){
		$(this).children('span.ro-off').stop().animate({opacity:'1'}, sp);
		$(this).children('span.ro-on').stop().animate({opacity:'0'}, sp);
	});
});