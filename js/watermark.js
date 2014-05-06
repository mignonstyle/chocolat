/* ------------------------------------
	watermark.js
	Mignon Style
	http://mignonstyle.com/
------------------------------------ */
jQuery(function($){
	var watermarkClass = 'watermark';
	$('.watermark-text').each(function(){
		var watermarkText = this.defaultValue;
		var element = $(this);

		element.focus(function(){
			if(element.val() === watermarkText){
			element.val('').removeClass(watermarkClass);
			}
		})
		.blur(function(){
			if(element.val() === ''){
				element.val(watermarkText).addClass(watermarkClass);
			}
		});

		if(element.val() === watermarkText){
			element.addClass(watermarkClass);
		}
	});
});