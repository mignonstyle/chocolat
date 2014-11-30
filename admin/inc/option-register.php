<?php
/**
 * Option Register
 * @package   Chocolat
 * @copyright Copyright (c) 2014 Mignon Style
 * @license   GNU General Public License v2.0
 * @since     Chocolat 1.1.6
 */

/**
 * ------------------------------------------------------------
 * 10.0 - Text
 * ------------------------------------------------------------
 */

function chocolat_textfield( $options, $option_name, $option_label = '', $option_type = 'text', $option_class = 'regular-text', $label_after = '' ) {
?>
	<p><?php
	if ( ! empty( $option_label ) ) {
		echo '<label for="chocolat_theme_options[' . esc_attr( $option_name ) . ']">' . esc_attr( $option_label ) . '</label>';
	} ?>
	<input id="chocolat_theme_options[<?php echo esc_attr( $option_name ); ?>]" class="<?php echo esc_attr( $option_class ); ?>" type="<?php echo esc_attr( $option_type ); ?>" name="chocolat_theme_options[<?php echo esc_attr( $option_name ); ?>]" value="<?php
	switch ( $option_type ){
		case 'url':
			echo esc_url( $options[$option_name] );
			break;
		case 'email':
			echo antispambot( $options[$option_name] );
			break;
		case 'number':
			echo absint( $options[$option_name] );
			break;
		default:
			echo esc_attr( $options[$option_name] );
	}
?>" /><?php
		echo ( ! empty( $label_after ) ) ? '&nbsp;' . esc_attr( $label_after ) : '';
	?></p>
<?php
}

/**
 * ------------------------------------------------------------
 * 10.1 - Textarea
 * ------------------------------------------------------------
 */

function chocolat_textarea( $options, $option_name, $option_cols = '60', $option_rows = '3', $content = '' ) {
	$content =  ( ! empty( $content ) ) ? $content : $options[$option_name];
?>
	<p><textarea id="chocolat_theme_options[<?php echo esc_attr( $option_name ); ?>]" cols="<?php echo absint( $option_cols ); ?>" rows="<?php echo absint( $option_rows ); ?>" name="chocolat_theme_options[<?php echo esc_attr( $option_name ); ?>]"><?php echo esc_textarea( $content ); ?></textarea></p>
<?php
}

/**
 * ------------------------------------------------------------
 * 10.2 - Checkbox
 * ------------------------------------------------------------
 */

function chocolat_checkbox( $options, $option_name, $option_text = '', $text_desc = '' ) {
?>
	<p class="checkbox"><label><input id="chocolat_theme_options[<?php echo esc_attr( $option_name ); ?>]" name="chocolat_theme_options[<?php echo esc_attr( $option_name ); ?>]" type="checkbox" value="1" <?php checked( $options[$option_name], 1 ); ?> />
<?php echo esc_attr( $option_text ); ?></label></p>
<?php if ( ! empty( $text_desc ) ) {
	echo '<p class="description checkbox-left-space">' . esc_attr( $text_desc ) . '</p>';
	}
}

/**
 * ------------------------------------------------------------
 * 10.3 - Radio Button
 * ------------------------------------------------------------
 */

function chocolat_radio( $options, $option_array, $option_name ) {
	if ( is_array( $option_array ) ) {
		$first_key = key( array_slice( $option_array, 0, 1 ) );
		echo ( ! empty( $option_array[$first_key]['img'] ) ) ? '<div class="radio-image">' : '';

		foreach ( $option_array as $option ) {
			chocolat_radio_input( $options, $option, $option_name );
		}

		echo ( ! empty( $option_array[$first_key]['img'] ) ) ? '</div>' : '';
	}
}

/**
 * ------------------------------------------------------------
 * 10.3.1 - Radio Button input
 * ------------------------------------------------------------
 */

function chocolat_radio_input( $options, $option, $option_name ) {
	$option_label = ( ! empty( $option['label'] ) ) ? '&nbsp;' . $option['label'] : '';
	$option_class = ( ! empty( $option['label'] ) ) ? 'right-space' : 'no-space';
?>
	<label class="<?php echo esc_attr( $option_class ); ?>"><input type="radio" name="chocolat_theme_options[<?php echo esc_attr( $option_name ); ?>]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $options[$option_name], $option['value'] ); ?> /><?php echo esc_attr( $option_label ); ?>

	<?php if ( ! empty( $option['img'] ) ) : ?>
		<img src="<?php echo get_template_directory_uri(); ?>/admin/img/<?php echo esc_attr( $option['img'] ); ?>" alt="<?php echo esc_attr( $option_label ); ?>">
	<?php endif;

	if ( ! empty( $option['label_2'] ) ) : ?>
		<br /><?php echo esc_attr( $option['label_2'] ); ?>
	<?php endif; ?></label>
<?php
}

/**
 * ------------------------------------------------------------
 * 10.4 - Select Box
 * ------------------------------------------------------------
 */

function chocolat_select( $options, $option_array, $option_name, $option_label = '', $option_label_before = '' ) {
	echo '<p>';

	if ( ! empty( $option_label ) ) : ?>
		<label for="chocolat_theme_options[<?php echo esc_attr( $option_name ); ?>]"><?php echo esc_attr( $option_label ); ?></label>
	<?php
		echo ( $option_label_before == 'br' ) ? '<br />' : esc_attr( $option_label_before ) ;
	endif;
?>
	<select id="chocolat_theme_options[<?php echo esc_attr( $option_name ); ?>]" name="chocolat_theme_options[<?php echo esc_attr( $option_name ); ?>]" >
	<?php if ( is_array( $option_array ) ) :
		foreach ( $option_array as $option ) : ?>
			<option value="<?php echo esc_attr( $option['value'] ); ?>" <?php selected( $options[$option_name], $option['value'] ); ?>><?php echo esc_attr( $option['label'] ); ?></option>
	<?php endforeach; endif; ?>
	</select></p>
<?php
}

/**
 * ------------------------------------------------------------
 * 10.5 - Color Picker
 * ------------------------------------------------------------
 */

function chocolat_color_picker( $options, $option_name, $default_color ) {
	$default_color = chocolat_sanitize_hex_color( $default_color );

?>
	<div class="color-picker">
		<input id="chocolat_theme_options[<?php echo esc_attr( $option_name ); ?>]" name="chocolat_theme_options[<?php echo esc_attr( $option_name ); ?>]" value="<?php
	$color = chocolat_sanitize_hex_color( $options[$option_name] );
	$color = ! empty( $color ) ? $color : $default_color;
	echo esc_attr( $color ); ?>" type="text" data-default-color="<?php echo esc_attr( $default_color ); ?>" class="color-picker-field" />
	</div>
<?php
}

/**
 * ------------------------------------------------------------
 * 10.5.1 - Color Sanitize
 * ------------------------------------------------------------
 */

function chocolat_sanitize_hex_color( $color ) {
	if ( '' === $color )
		return '';

	// 3 or 6 hex digits, or the empty string.
	if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) )
		return $color;

	return null;
}

/**
 * ------------------------------------------------------------
 * 10.6 - Media UpLoader
 * ------------------------------------------------------------
 */

function chocolat_media_uploader( $options, $option_id, $option_name, $option_desc = '' ) {
	$upload_remove_class = ( ! empty( $options[$option_name] ) ) ? 'remove-open' : 'upload-open';

	if ( function_exists( 'wp_enqueue_media' ) ) : ?>
		<div id="option-<?php echo esc_attr( $option_id ); ?>" class="media-upload">
			<?php if ( ! empty( $option_desc ) ) : ?>
				<p><?php echo esc_attr( $option_desc ); ?></p>
			<?php endif; ?>

			<div class="upload-remove <?php echo esc_attr( $upload_remove_class ); ?>">
				<input id="chocolat_theme_options[<?php echo esc_attr( $option_name ); ?>]" name="chocolat_theme_options[<?php echo esc_attr( $option_name ); ?>]" value="<?php echo esc_url( $options[$option_name] ); ?>" type="hidden" class="regular-text" />
				<table><tr>
					<td class="upload-button"><input id="option-upload-<?php echo esc_attr( $option_id ); ?>" class="button option-upload-button" value="<?php _e( 'Select Image', 'chocolat' ); ?>" type="button"></td>
					<?php if ( ! empty( $options[$option_name] ) ) {
						$image_src = esc_url( $options[$option_name] );
						if( preg_match( '/(^.*\.jpg|jpeg|png|gif|ico*)/i', $image_src ) ) {
							echo '<td class="upload-preview"><img src="'.$image_src.'" alt="" /></td>';
						}
					} ?>
					<td class="remove-button"><input id="option-remove-<?php echo esc_attr( $option_id ); ?>" class="button option-remove-button" value="<?php _e( 'Delete Image', 'chocolat' ); ?>" type="button"></td>
				</tr></table>
			</div>
		</div>
	<?php else : ?>
		<p><?php _e( 'Sorry, WordPress you are using is not supported. Upgrade your WordPress.', 'chocolat' ); ?></p>
<?php endif;
}