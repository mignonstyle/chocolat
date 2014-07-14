/* ------------------------------------
	theme-options.js
	Mignon Style
	http://mignonstyle.com/
------------------------------------ */
jQuery(function($){
	chocolat_options_checkbox();
	chocolat_contact_radio();
	chocolat_readmore_radio();
	chocolat_slider_checkbox();

	// input change
	$('.option-check input:checkbox').change(function(){
		var parent_id = $(this).parents('.option-check').attr('id');
		chocolat_checkbox_show_hide(parent_id);
	});

	$('#option-contact input:radio').change(function(){
		chocolat_contact_radio();
	});

	$('#option-readmore input:radio').change(function(){
		chocolat_readmore_radio();
	});

	// checkbox
	function chocolat_options_checkbox(){
		$('.option-check').each(function(){
			var parent_id = $(this).attr('id');
			chocolat_checkbox_show_hide(parent_id);
		});
	}

	function chocolat_checkbox_show_hide(parent_id){
		parent_id = '#'+parent_id+' ';

		if($(parent_id+'input:checkbox').prop('checked')){
			$(parent_id+'div.hidebox').show();
		}else{
			$(parent_id+'div.hidebox').hide();
		}
	}

	// slider checkbox
	$('#option-slider input:checkbox').change(function(){
		chocolat_slider_checkbox();
	});

	function chocolat_slider_checkbox(){
		if($('#option-slider input:checkbox').prop('checked')){
			$('.slider-parent').show();
		}else{
			$('.slider-parent').hide();
		}
	}

	// contact radio button
	function chocolat_contact_radio(){
		var input_value = $('#option-contact input:radio:checked').val();

		if(input_value == 'contact_mail'){
			$('#contact-mail div').show();
			$('#contact-page div').hide();
		}else{
			$('#contact-mail div').hide();
			$('#contact-page div').show();
		}
	}

	// Read More radio button
	function chocolat_readmore_radio(){
		var input_value = $('#option-readmore input:radio:checked').val();

		if(input_value == 'more_excerpt'){
			$('#readmore-excerpt div').show();
			$('#readmore-moretag div').hide();
		}else{
			$('#readmore-excerpt div').hide();
			$('#readmore-moretag div').show();
		}
	}

	/*
	* jquery.cookie.js
	* jquery.ui.tabs.min.js
	* Save to cookie open tabs
	* Cookies will be deleted if you close the browser
	*/
	function chocolat_cookie_tabs(){
		$('#tabset').tabs({
			active: ($.cookie('chocolat_tabs')) ? $.cookie('chocolat_tabs') : 0,
			activate: function(event, ui){
				// Expiration date of the cookie (30 minutes)
				var date = new Date();
				date.setTime(date.getTime()+(30*60*1000));

				// Register cookies
				$.cookie('chocolat_tabs', $(this).tabs('option', 'active'), {expires:date});
			}
		});
	}
	chocolat_cookie_tabs();
});