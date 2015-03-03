/* ------------------------------------
	theme-options.js
	Mignon Style
	http://mignonstyle.com/
------------------------------------ */
jQuery(function($){
	var obj, obj_value, tar_obj01, tar_obj02;

	chocolat_options_checkbox();
	chocolat_contact_radio();
	chocolat_readmore_radio();
	chocolat_featured_position_radio();
	chocolat_featured_crop_radio();
	chocolat_featured_home_position_radio();
	chocolat_featured_home_crop_radio();
	chocolat_codemirror();

	// input change
	$('.option-check input:checkbox').change(function(){
		var parent_id = $(this).parents('.option-check').attr('id');
		chocolat_checkbox_show_hide(parent_id);
	});

	// checkbox
	function chocolat_options_checkbox(){
		$('.option-check').each(function(){
			var parent_id = $(this).attr('id');
			chocolat_checkbox_show_hide(parent_id);
		});
	}

	function chocolat_checkbox_show_hide(parent_id){
		var children = '.'+parent_id+'-children';
		parent_id = '#'+parent_id+' ';

		if($(parent_id+'input:checkbox').prop('checked')){
			$(parent_id+'div.hidebox').show();
			$(children).show();
		}else{
			$(parent_id+'div.hidebox').hide();
			$(children).hide();
		}
	}

	// radio button
	function chocolat_options_radio(obj, obj_value, tar_obj01, tar_obj02){
		var input_value = $(obj+':checked').val();

		if(input_value == obj_value){
			$(tar_obj01).show();
			$(tar_obj02).hide();
		}else{
			$(tar_obj01).hide();
			$(tar_obj02).show();
		}
	}

	// contact radio button
	$('#option-contact input:radio').change(function(){
		chocolat_contact_radio();
	});

	function chocolat_contact_radio(){
		obj = '#option-contact input:radio';
		obj_value = 'contact_mail';
		tar_obj01 = '#contact-mail div';
		tar_obj02 = '#contact-page div';
		chocolat_options_radio(obj, obj_value, tar_obj01, tar_obj02 );
	}

	// readmore radio button
	$('#option-readmore input:radio').change(function(){
		chocolat_readmore_radio();
	});

	function chocolat_readmore_radio(){
		obj = '#option-readmore input:radio';
		obj_value = 'more_excerpt';
		tar_obj01 = '#readmore-excerpt div';
		tar_obj02 = '#readmore-moretag div';
		chocolat_options_radio(obj, obj_value, tar_obj01, tar_obj02);
	}

	// Featured Image Position radio button
	$('input[name*="featured_position"]').change(function(){
		chocolat_featured_position_radio();
	});

	function chocolat_featured_position_radio(){
		obj = 'input[name*="featured_position"]';
		obj_value = 'center';
		tar_obj01 = '';
		tar_obj02 = '#featured-sneak';
		chocolat_options_radio(obj, obj_value, tar_obj01, tar_obj02);
	}

	// Featured Image Crop radio button
	$('input[name*="featured_crop"]').change(function(){
		chocolat_featured_crop_radio();
	});

	function chocolat_featured_crop_radio(){
		obj = 'input[name*="featured_crop"]';
		obj_value = 'crop';
		tar_obj01 = '#featured-crop-pos';
		tar_obj02 = '';
		chocolat_options_radio(obj, obj_value, tar_obj01, tar_obj02);
	}

	// Home page Featured Image Position radio button
	$('input[name*="featured_home_position"]').change(function(){
		chocolat_featured_home_position_radio();
	});

	function chocolat_featured_home_position_radio(){
		if($('#featured-home input:checkbox').prop('checked')){
			obj = 'input[name*="featured_home_position"]';
			obj_value = 'center';
			tar_obj01 = '';
			tar_obj02 = '#featured-home-sneak';
			chocolat_options_radio(obj, obj_value, tar_obj01, tar_obj02);
		}
	}

	// Home page Featured Image Crop radio button
	$('input[name*="featured_home_crop"]').change(function(){
		chocolat_featured_home_crop_radio();
	});

	function chocolat_featured_home_crop_radio(){
		if($('#featured-home input:checkbox').prop('checked')){
			obj = 'input[name*="featured_home_crop"]';
			obj_value = 'crop';
			tar_obj01 = '#featured-home-crop-pos';
			tar_obj02 = '';
			chocolat_options_radio(obj, obj_value, tar_obj01, tar_obj02);
		}
	}

	// notice option
	$('#notice-option .notice-close').hide();
	$('#notice-option .notice-desc').hide();
	notice_option();

	function notice_option(){
		$('#notice-option .notice-open').click(function(){
			$('#notice-option .notice-desc').show();
			$('#notice-option .notice-close').show();
			$('#notice-option .notice-open').hide();
		});

		$('#notice-option .notice-close').click(function(){
			$('#notice-option .notice-desc').hide();
			$('#notice-option .notice-close').hide();
			$('#notice-option .notice-open').show();
		});
	}

	$('#notice-option input').change(function(){
		notice_option();
	});

	/*
	* CodeMirror
	*/
	function chocolat_codemirror(){
		var editor = CodeMirror.fromTextArea(document.getElementById("chocolat_theme_options[custom_css]"), {
			lineNumbers: true,
			lineWrapping: true,
		});
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