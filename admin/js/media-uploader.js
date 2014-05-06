/* ------------------------------------
	media-uploader.js
	Mignon Style
	http://mignonstyle.com/
------------------------------------ */
jQuery(function($){
	var frame;

	chocolat_options_media_uploader();

	function chocolat_options_media_uploader(){
		$('.option-upload-button').on('click', function(e){
			if($('.media-upload.upload-select').size()){
				$('.media-upload.upload-select').removeClass('upload-select');
			}

			if($(e.target).closest('.media-upload')){
				var parent = $(e.target).closest('.media-upload');
				parent = parent.addClass('upload-select');
				chocolat_options_add_file(e, parent);
			}
		});

		$('.option-remove-button').on('click', function(e){
			if($(e.target).closest('.media-upload')){
				var parent = $(e.target).closest('.media-upload');
				chocolat_options_remove_file(parent);
			}
		});
	}

	function chocolat_options_add_file(e, parent){
		e.preventDefault();

		// If the media frame already exists, reopen it.
		if (frame) {
			frame.open();
			return;
		}

		// Create the media frame.
		frame = wp.media({
			title: chocolat_media_text.title,
			library: {
				type: 'image'
			},
			button: {
				text: chocolat_media_text.button,
				close: false,
			},
			multiple: false,
		});

		// When an image is selected, run a callback.
		frame.on('select', function() {
			var image = frame.state().get('selection').first();
			frame.close();

			var parent_ID = $('.upload-select').attr('ID');
			parent = $('#'+parent_ID);

			if(image.attributes.type == 'image'){
				$('input[name*="_url"]', parent).val(image.attributes.url);
				$('.upload-remove table tr', parent).prepend('<td class="upload-preview"><img src="'+image.attributes.url+'" alt="" /></td>');
				$('.upload-remove', parent).addClass('remove-open').removeClass('upload-open');
			}
		});

		// Finally, open the modal.
		frame.open();
	}

	function chocolat_options_remove_file(parent){
		$('input[name*="_url"]', parent).val('');
		$('.upload-remove', parent).addClass('upload-open').removeClass('remove-open');
		$('td.upload-preview', parent).empty();
	}
});