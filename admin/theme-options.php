<?php

/**
 * ------------------------------------------------------------
 * 0.0 - Title of theme options page
 * ------------------------------------------------------------
 */

function chocolat_options_title() {
	$options_title = sprintf( __( '%s Settings', 'chocolat' ), esc_attr( wp_get_theme() ) );
	return $options_title;
}

/**
 * ------------------------------------------------------------
 * 0.1 - Read css file
 * ------------------------------------------------------------
 */

function chocolat_admin_enqueue_style( $hook ) {
	if ( 'appearance_page_theme_options' != $hook ) {
		return;
	}
	wp_enqueue_style( 'chocolat_themeoptions_css', get_stylesheet_directory_uri().'/admin/css/theme-options.css' );
}
add_action( 'admin_enqueue_scripts', 'chocolat_admin_enqueue_style' );

/**
 * ------------------------------------------------------------
 * 0.2 - Read javascript file
 * ------------------------------------------------------------
 */

function chocolat_admin_print_scripts() {
	wp_enqueue_script( 'chocolat_cookie', get_template_directory_uri().'/admin/js/jquery.cookie.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'chocolat_theme_options_js', get_template_directory_uri().'/admin/js/theme-options.js', array( 'jquery', 'chocolat_cookie', 'jquery-ui-tabs' ), null, true );

	// Script of media uploader
	if ( function_exists( 'wp_enqueue_media' ) ) {
		wp_enqueue_media();
		wp_register_script( 'chocolat_media-uploader_js', get_template_directory_uri().'/admin/js/media-uploader.js', array( 'jquery' ), null, true );
		$translation_array = array(
			'title'  => __( 'Select Image', 'chocolat' ),
			'button' => __( 'Set up Image', 'chocolat' ),
		);
		wp_localize_script( 'chocolat_media-uploader_js', 'chocolat_media_text', $translation_array );
		wp_enqueue_script( 'chocolat_media-uploader_js' );
	}
}

/**
 * ------------------------------------------------------------
 * 1.0 - Register the theme options setting page, 
 *       to the "appearance" in admin page
 * ------------------------------------------------------------
 */

function chocolat_theme_options_add_page() {
	$options_title = chocolat_options_title();
	$page_hook = add_theme_page( $options_title, $options_title, 'edit_theme_options', 'theme_options', 'chocolat_theme_options_do_page' );

	// Read the script only to theme options page
	add_action( 'admin_print_scripts-'.$page_hook, 'chocolat_admin_print_scripts' );
}
add_action( 'admin_menu', 'chocolat_theme_options_add_page' );

/**
 * ------------------------------------------------------------
 * 1.1 - Delete the value of this theme options
 *       after changing the theme
 * ------------------------------------------------------------
 */

function chocolat_delete_option() {
	delete_option( 'chocolat_theme_options' );
}
add_action( 'switch_theme', 'chocolat_delete_option' );

/**
 * ------------------------------------------------------------
 * 2.0 - To register the setting of theme options
 * ------------------------------------------------------------
 */

function chocolat_theme_options_init(){
	register_setting( 'chocolat_options', 'chocolat_theme_options', 'chocolat_theme_options_validate' );
}
add_action( 'admin_init', 'chocolat_theme_options_init' );

/**
 * ------------------------------------------------------------
 * 3.0 - Create an array of theme options
 *       default options
 * ------------------------------------------------------------
 */

function chocolat_theme_default_options() {
	if ( strtoupper( get_locale() ) == 'JA' ) {
		$length = 110;
	} else {
		$length = 55;
	}

	$theme_default_options = array(
		'show_site_desc'      => 1,
		'show_author'         => 1,
		'show_breadcrumb'     => 1,
		'show_last_date'      => 0,
		'show_image_lightbox' => 1,
		'show_lightbox'       => 1,
		'show_widget_masonry' => 1,

		'read_more_radio' => 'more_excerpt',
		'excerpt_number'  => $length,
		'moretag_text'    => '',
		'show_more_link'  => 1,

		'favicon_url'   => '',
		'sp_icon_url'   => '',
		'site_logo_url' => '',
		'no_image_url'  => '',

		'show_related'         => 0,
		'related_title'        => '',
		'related_number'       => 10,
		'related_order_select' => 'desc',
		'related_class_select' => 'category',

		'show_new_posts'   => 0,
		'new_posts_title'  => '',
		'new_posts_number' => 10,

		'sidebar_radio' => 'right_sidebar',

		'show_links_top'    => 1,
		'show_links_side'   => 1,
		'links_side_title'  => '',
		'links_side_select'  => 'links_side_top',
		'show_links_bottom' => 1,

		'info_side_text' => '',

		'show_contact'  => 1,
		'contact_radio' => 'contact_mail',
		'mail_url'      => '',
		'page_url'      => '',

		'show_rss'    => 1,
		'show_feedly' => 1,

		'show_copyright' => 1,
		'copyright_text' => '',
		'credit_link_radio' => 'credit_disable',
	);
	return $theme_default_options;
}

/**
 * ------------------------------------------------------------
 * 3.1 - Create an array of theme options
 *       display settings
 * ------------------------------------------------------------
 */

function chocolat_settings_options() {
	$settings_options = array(
		'show_site_desc' => array(
			'id'   => 'show_site_desc',
			'text' => __( 'View a description of the Web site', 'chocolat' ),
		),
		'show_author' => array(
			'id'   => 'show_author',
			'text' => __( 'Show the name of the author of the posts', 'chocolat' ),
		),
		'show_breadcrumb' => array(
			'id'   => 'show_breadcrumb',
			'text' => __( 'Show breadcrumbs', 'chocolat' ),
		),
		'show_last_date' => array(
			'id'   => 'show_last_date',
			'text' => __( 'View Last updated post page', 'chocolat' ),
		),
		'show_image_lightbox' => array(
			'id'   => 'show_image_lightbox',
			'text' => __( 'Use the Lightbox to image', 'chocolat' ),
		),
		'show_lightbox' => array(
			'id'   => 'show_lightbox',
			'text' => __( 'Use the Lightbox to gallery', 'chocolat' ),
		),
		'show_widget_masonry' => array(
			'id'   => 'show_widget_masonry',
			'text' => __( 'Show a Fluid Grid Layout widgets', 'chocolat' ),
		),
	);
	return $settings_options;
}

/**
 * ------------------------------------------------------------
 * 3.2 - Create an array of theme options
 *       images (media-uploader)
 * ------------------------------------------------------------
 */

function chocolat_upload_image_options() {
	$upload_image_options = array(
		'favicon' => array(
			'id'    => 'favicon',
			'title' => __( 'Favicon Settings', 'chocolat' ),
			'text'  => __( 'favicon', 'chocolat' ),
			'desc'  => '',
			'size'  => __( 'favicon.ico (width 16px x height 16px)', 'chocolat' ),
			'name'  => 'favicon_url',
		),
		'sp_icon' => array(
			'id'    => 'sp-icon',
			'title' => __( 'Icon Settings', 'chocolat' ),
			'text'  => __( 'smartphone icon', 'chocolat' ),
			'desc'  => '',
			'size'  => __( 'apple-touch-icon.png (width 144px x height 144px)', 'chocolat' ),
			'name'  => 'sp_icon_url',
		),
		
		'site_logo_url' => array(
			'id'    => 'site-logo',
			'title' => __( 'Logo Settings', 'chocolat' ),
			'text'  => __( 'logo', 'chocolat' ),
			'desc'  => '',
			'size'  => __( '.png, .jpg and .gif (max-width 350px)', 'chocolat' ),
			'name'  => 'site_logo_url',
		),
		'no_image_url' => array(
			'id'    => 'no-image',
			'title' => __( 'No Image Settings', 'chocolat' ),
			'text'  => __( 'image of "No Image"', 'chocolat' ),
			'desc'  => '<span class="description">'.__( 'If you have not set, use the "No Image" image of theme defaults.', 'chocolat' ).'</span>',
			'size'  => __( '.png, .jpg and .gif (width 300px x height 300px)', 'chocolat' ),
			'name'  => 'no_image_url',
		),
	);
	return $upload_image_options;
}

/**
 * ------------------------------------------------------------
 * 3.3 - Create an array of theme options
 *       contact
 * ------------------------------------------------------------
 */

function chocolat_contact_options() {
	$contact_options = array(
		'contact_mail' => array(
			'value'    => 'contact_mail',
			'id'       => 'mail',
			'label'    => __( 'Use e-mail address', 'chocolat' ),
		),
		'contact_page' => array(
			'value'    => 'contact_page',
			'id'       => 'page',
			'label'    => __( 'Use the contact page', 'chocolat' ),
		),
	);
	return $contact_options;
}

/**
 * ------------------------------------------------------------
 * 3.4 - Create an array of theme options
 *       Order of Related posts
 * ------------------------------------------------------------
 */

function chocolat_related_order_options() {
	$related_order_options = array(
		'desc' => array(
			'value' => 'desc',
			'label' => __( 'Descending order', 'chocolat' ),
		),
		'asc' => array(
			'value' => 'asc',
			'label' => __( 'Ascending order', 'chocolat' ),
		),
		'random' => array(
			'value' => 'random',
			'label' => __( 'Random', 'chocolat' ),
		),
	);
	return $related_order_options;
}

/**
 * ------------------------------------------------------------
 * 3.5 - Create an array of theme options
 *       Classification of Related posts
 * ------------------------------------------------------------
 */

function chocolat_related_class_options() {
	$related_class_options = array(
		'category' => array(
			'value' => 'category',
			'label' => __( 'Category', 'chocolat' ),
		),
		'tag' => array(
			'value' => 'tag',
			'label' => __( 'Tag', 'chocolat' ),
		),
	);
	return $related_class_options;
}

/**
 * ------------------------------------------------------------
 * 3.6 - Create an array of theme options
 *       sidebar
 * ------------------------------------------------------------
 */

function chocolat_sidebar_options() {
	$sidebar_options = array(
		'left_sidebar' => array(
			'value' => 'left_sidebar',
			'img'   => 'sidebar_left.png',
		),
		'right_sidebar' => array(
			'value' => 'right_sidebar',
			'img'   => 'sidebar_right.png',
		),
		'no_sidebar' => array(
			'value' => 'no_sidebar',
			'img'   => 'sidebar.png',
		),
	);
	return $sidebar_options;
}

/**
 * ------------------------------------------------------------
 * 3.7 - Create an array of theme options
 *       links sidebar
 * ------------------------------------------------------------
 */

function chocolat_links_side_options() {
	$links_side_options = array(
		'links_side_top' => array(
			'value' => 'links_side_top',
			'label' => __( 'Top of the sidebar', 'chocolat' ),
		),
		'links_side_bottom' => array(
			'value' => 'links_side_bottom',
			'label' => __( 'Bottom of the sidebar', 'chocolat' ),
		),
	);
	return $links_side_options;
}

/**
 * ------------------------------------------------------------
 * 3.8 - Create an array of theme options
 *       Excerpt or Read More
 * ------------------------------------------------------------
 */

function chocolat_read_more_options() {
	$read_more_options = array(
		'more_excerpt' => array(
			'value' => 'more_excerpt',
			'id'    => 'excerpt',
			'label' => __( 'Use an excerpt', 'chocolat' ),
		),
		'more_quicktag' => array(
			'value' => 'more_quicktag',
			'id'    => 'moretag',
			'label' => __( 'Use the "more" quicktag', 'chocolat' ),
		),
	);
	return $read_more_options;
}

/**
 * ------------------------------------------------------------
 * 3.9 - Create an array of theme options
 *       Credit link
 * ------------------------------------------------------------
 */

function chocolat_credit_link_options() {
	$credit_link_options = array(
		'credit_enable' => array(
			'value' => 'credit_enable',
			'label' => __( 'Enable', 'chocolat' ),
		),
		'credit_disable' => array(
			'value' => 'credit_disable',
			'label' => __( 'Disable', 'chocolat' ),
		),
	);
	return $credit_link_options;
}

/**
 * ------------------------------------------------------------
 * 4.0 - Get the value of theme options 
 * ------------------------------------------------------------
 */

function chocolat_get_option() {
	return get_option( 'chocolat_theme_options', chocolat_theme_default_options() );
}

/**
 * ------------------------------------------------------------
 * 5.0 - Creating a theme options page
 * ------------------------------------------------------------
 */

function chocolat_theme_options_do_page() {
	$options_title = chocolat_options_title();

	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;
	?>
	<div class="wrap">
		<h2><?php echo $options_title; ?></h2>

		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
		<div class="updated fade"><p><strong><?php _e( 'Settings saved.', 'chocolat' ); ?></strong></p></div>
		<?php endif; ?>

		<form method="post" action="options.php" enctype="multipart/form-data">
			<?php
				settings_fields( 'chocolat_options' );

				$options = chocolat_get_option();
				$settings_title = __( 'Display settings for each item', 'chocolat' );
				$links_title = __( 'Links Setting', 'chocolat' );
			?>
			<div id="tabset">
				<ul class="tabs clearfix">
					<li><h3 class="title"><a href="#panel-settings" id="tab-settings"><?php echo $settings_title ?></a></h3></li>
					<li><h3 class="title"><a href="#panel-links" id="tab-links"><?php echo $links_title ?></a></h3></li>
				</ul>

				<div id="panel-settings" class="panel">
					<h3 class="title"><?php echo $settings_title ?></h3>
					<table class="form-table">
						<!-- Display Settings -->
						<tr>
							<th scope="row"><?php _e( 'Display Settings', 'chocolat' ); ?></th>
							<td><fieldset>
							<?php
							if ( is_array( chocolat_settings_options() ) ) :
								foreach ( chocolat_settings_options() as $option ) :
									$option_id = $option['id'];
							?>
							<p><label><input id="chocolat_theme_options[<?php echo $option_id; ?>]" name="chocolat_theme_options[<?php echo $option_id; ?>]" type="checkbox" value="1" <?php checked( $options[$option_id], 1 ); ?> />
								<?php echo $option['text']; ?></label></p>
							<?php endforeach; endif; ?>
							</fieldset></td>
						</tr>

						<!-- Excerpt or Read More -->
						<tr id="option-readmore">
							<th scope="row"><?php _e( 'Excerpt Settings', 'chocolat' ); ?></th>
							<td><fieldset>
						<p><?php _e( 'Set the display of posts of an archive page.', 'chocolat' ); ?><br /><?php _e( 'Please select from "excerpt" or "more quick tag".', 'chocolat' ); ?></p>
								<?php if ( is_array( chocolat_read_more_options() ) ) :
									foreach ( chocolat_read_more_options() as $option ) : ?>
									<p><label><input type="radio" name="chocolat_theme_options[read_more_radio]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $options['read_more_radio'], $option['value'] ); ?> /> <?php echo $option['label']; ?></label></p>

									<div id="readmore-<?php echo $option['id']; ?>" class="theme-left-space">
									<?php if ( $option['id'] == 'excerpt' ) : ?>
									<div>
										<p><?php _e( 'Number of characters to be displayed in the excerpt', 'chocolat' ); ?>:&nbsp;
										<input id="chocolat_theme_options[excerpt_number]" class="small-text" type="number" name="chocolat_theme_options[excerpt_number]" value="<?php echo absint( $options['excerpt_number'] ); ?>" />
										<?php if ( get_bloginfo( 'language' ) == 'ja' ) : ?>
											<br /><span class="description"><?php _e( 'In the Japanese version of WordPress, please activate WP Multibyte Patch plugin.', 'chocolat' ); ?></span>
										<?php endif; ?></p><br />
									</div>
									<?php elseif ( $option['id'] == 'moretag' ) : ?>
									<div>
										<p><label><input id="chocolat_theme_options[show_more_link]" name="chocolat_theme_options[show_more_link]" type="checkbox" value="1" <?php checked( $options['show_more_link'], 1 ); ?> />
										<?php _e( 'Display the "more" link', 'chocolat' ); ?></label></p>

										<p><?php _e( 'Character of the "more" link', 'chocolat' ); ?>:&nbsp;
										<input id="chocolat_theme_options[moretag_text]" class="regular-text" type="text" name="chocolat_theme_options[moretag_text]" value="<?php echo esc_attr( $options['moretag_text'] ); ?>" /></p>
									</div>
									<?php endif; ?>
									</div>
								<?php endforeach; endif; ?>
							</fieldset></td>
						</tr>

						<!-- Image Settings -->
						<?php
						// Make sure that it will work with the media uploader
						if ( function_exists( 'wp_enqueue_media' ) ) :
							if ( is_array( chocolat_upload_image_options() ) ) :
								foreach ( chocolat_upload_image_options() as $option ) :
									$upload_remove_class = 'upload-open';
									$option_id = $option['id'];
									$option_name = $option['name'];
									$option_desc = '';

									if ( ! empty( $options[$option_name] ) ) {
										$upload_remove_class = 'remove-open';
									}

									if ( $option['desc'] ) {
										$option_desc = $option['desc'];
									}
						?>
						<tr id="option-<?php echo $option_id; ?>" class="media-upload">
							<th scope="row"><?php echo $option['title']; ?></th>
							<td><fieldset>
								<p><?php printf( __( 'Once you have set the image, it is used as the %s for your Web site.', 'chocolat' ), $option['text'] ); ?><br /><span class="description"><?php printf( __( 'Recommended files %s', 'chocolat' ), $option['size'] ); ?></span><?php echo $option_desc; ?></p>
								<div class="upload-remove <?php echo $upload_remove_class; ?>">
									<input id="chocolat_theme_options[<?php echo $option_name; ?>]" class="regular-text" type="hidden" name="chocolat_theme_options[<?php echo $option_name; ?>]" value="<?php echo esc_url( $options[$option_name] ); ?>" />
									<table><tr>
									<td class="upload-button"><input id="option-upload-<?php echo $option_id; ?>" class="button option-upload-button" value="<?php _e( 'Select Image', 'chocolat' ); ?>" type="button"></td>
									<?php
									if ( ! empty( $options[$option_name] ) ) {
										$image_src = esc_url( $options[$option_name] );
										if( preg_match( '/(^.*\.jpg|jpeg|png|gif|ico*)/i', $image_src ) ) {
											echo '<td class="upload-preview"><img src="'.$image_src.'" alt="" /></td>';
										}
									}
									?>
									<td class="remove-button"><input id="option-remove-<?php echo $option_id; ?>" class="button option-remove-button" value="<?php _e( 'Delete Image', 'chocolat' ); ?>" type="button"></td>
									</tr></table>
								</div>
							</fieldset></td>
						</tr>
						<?php endforeach; endif; ?>
						<?php else : ?>
						<tr>
							<th scope="row"><?php _e( 'Image Settings', 'chocolat' ); ?></th>
							<td><p><?php _e( 'Sorry, WordPress you are using is not supported. Upgrade your version of WordPress.', 'chocolat' ); ?></p></td>
						</tr>
						<?php endif; ?>

						<!-- Related Posts -->
						<tr id="option-related-posts" class="option-check">
							<th scope="row"><?php _e( 'Related Entry', 'chocolat' ); ?></th>
							<td><fieldset>
								<p><?php _e( 'Displays a list of related articles, under the article of a single post page if you check.', 'chocolat' ); ?></p>
								<p><label><input id="chocolat_theme_options[show_related]" name="chocolat_theme_options[show_related]" type="checkbox" value="1" <?php checked( $options['show_related'], 1 ); ?> />
								<?php _e( 'View Related Posts after the content', 'chocolat' ); ?></label></p>
								<div class="theme-left-space hidebox">
									<p><label><?php _e( 'Title:', 'chocolat' ); ?><br />
									<input id="chocolat_theme_options[related_title]" class="regular-text" type="text" name="chocolat_theme_options[related_title]" value="<?php echo esc_attr( $options['related_title'] ); ?>" /></label></p>

									<p><label><?php _e( 'Number of posts to show:', 'chocolat' ); ?>&nbsp;
									<input id="chocolat_theme_options[related_number]" class="small-text" type="number" name="chocolat_theme_options[related_number]" value="<?php echo absint( $options['related_number'] ); ?>" />&nbsp;<?php _e( 'posts', 'chocolat' ); ?></label></p>

									<p><label><?php _e( 'Alignment sequence', 'chocolat' ); ?>:</label>&nbsp;
									<select id="chocolat_theme_options[related_order_select]" name="chocolat_theme_options[related_order_select]" >
									<?php
									if ( is_array( chocolat_related_order_options() ) ) :
										foreach ( chocolat_related_order_options() as $option ) :
									?>
									<option value="<?php echo $option['value']; ?>" <?php selected( $options['related_order_select'], $option['value'] ); ?>><?php echo esc_attr( $option['label'] ); ?></option>
									<?php endforeach; endif; ?>
									</select></p>

									<p><label><?php _e( 'Classification', 'chocolat' ); ?>:</label>&nbsp;
									<select id="chocolat_theme_options[related_class_select]" name="chocolat_theme_options[related_class_select]" >
									<?php
									if ( is_array( chocolat_related_class_options() ) ) :
										foreach ( chocolat_related_class_options() as $option ) :
									?>
									<option value="<?php echo $option['value']; ?>" <?php selected( $options['related_class_select'], $option['value'] ); ?>><?php echo esc_attr( $option['label'] ); ?></option>
									<?php endforeach; endif; ?>
									</select></p>
								</div>
							</fieldset></td>
						</tr>

						<!-- New Posts -->
						<tr id="option-new-posts" class="option-check">
							<th scope="row"><?php _e( 'New Entry', 'chocolat' ); ?></th>
							<td><fieldset>
								<p><?php _e( 'Displays a list of new articles, under the article of a single post page if you check.', 'chocolat' ); ?></p>
								<p><label><input id="chocolat_theme_options[show_new_posts]" name="chocolat_theme_options[show_new_posts]" type="checkbox" value="1" <?php checked( $options['show_new_posts'], 1 ); ?> />
								<?php _e( 'View New Posts after the content', 'chocolat' ); ?></label></p>

								<div class="theme-left-space hidebox">
									<p><label><?php _e( 'Title:', 'chocolat' ); ?><br />
									<input id="chocolat_theme_options[new_posts_title]" class="regular-text" type="text" name="chocolat_theme_options[new_posts_title]" value="<?php echo esc_attr( $options['new_posts_title'] ); ?>" /></label><br />

									<label><?php _e( 'Number of posts to show:', 'chocolat' ); ?>&nbsp;<input id="chocolat_theme_options[new_posts_number]" class="small-text" type="number" name="chocolat_theme_options[new_posts_number]" value="<?php echo absint( $options['new_posts_number'] ); ?>" />&nbsp;<?php _e( 'posts', 'chocolat' ); ?></label></p>
								</div>
							</fieldset></td>
						</tr>

						<!-- Sidebar settings -->
						<tr id="option-sidebar">
							<th scope="row"><?php _e( 'Sidebar settings', 'chocolat' ); ?></th>
							<td><fieldset>
								<?php if ( is_array( chocolat_sidebar_options() ) ) :
									foreach ( chocolat_sidebar_options() as $option ) : ?>
								<label><input type="radio" name="chocolat_theme_options[sidebar_radio]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $options['sidebar_radio'], $option['value'] ); ?> />
								<img src="<?php echo get_template_directory_uri(); ?>/admin/img/<?php echo $option['img']; ?>" alt=""></label>
								<?php endforeach; endif; ?>
							</fieldset></td>
						</tr>
					</table>
				</div><!-- /panel -->

				<div id="panel-links" class="panel">
					<h3 class="title"><?php echo $links_title ?></h3>
					<p class="panel-caption"><?php _e( 'Set the display of contact or RSS and copyright.Copyright will be displayed in the footer.', 'chocolat' ); ?></p>

					<table class="form-table">
						<!-- Position to display -->
						<tr>
							<th scope="row"><?php _e( 'Position to display', 'chocolat' ); ?></th>
							<td><fieldset>
								<p><label><input id="chocolat_theme_options[show_links_top]" name="chocolat_theme_options[show_links_top]" type="checkbox" value="1" <?php checked( $options['show_links_top'], 1 ); ?> />
								<?php _e( 'Display in the header', 'chocolat' ); ?></label></p>

								<div id="option-links-sidebar" class="option-check">
									<p><label><input id="chocolat_theme_options[show_links_side]" name="chocolat_theme_options[show_links_side]" type="checkbox" value="1" <?php checked( $options['show_links_side'], 1 ); ?> />
									<?php _e( 'Display in the sidebar', 'chocolat' ); ?></label></p>

									<div class="theme-left-space hidebox">
										<p><label><?php _e( 'Title:', 'chocolat' ); ?><br />
										<input id="chocolat_theme_options[links_side_title]" class="regular-text" type="text" name="chocolat_theme_options[links_side_title]" value="<?php echo esc_attr( $options['links_side_title'] ); ?>" /></label><br />

										<p><label><?php _e( 'Display position', 'chocolat' ); ?>:</label>&nbsp;
										<select id="chocolat_theme_options[links_side_select]" name="chocolat_theme_options[links_side_select]" >
										<?php
										if ( is_array( chocolat_links_side_options() ) ) :
											foreach ( chocolat_links_side_options() as $option ) :
										?>
										<option value="<?php echo $option['value']; ?>" <?php selected( $options['links_side_select'], $option['value'] ); ?>><?php echo esc_attr( $option['label'] ); ?></option>
										<?php endforeach; endif; ?>
										</select></p><br />
									</div>
								</div>

								<p><label><input id="chocolat_theme_options[show_links_bottom]" name="chocolat_theme_options[show_links_bottom]" type="checkbox" value="1" <?php checked( $options['show_links_bottom'], 1 ); ?> />
								<?php _e( 'Display in the footer', 'chocolat' ); ?></label></p>
							</fieldset></td>
						</tr>

						<!-- Information -->
						<tr id="option-info" class="option-check">
							<th scope="row"><?php _e( 'Information', 'chocolat' ); ?></th>
							<td>
								<p><?php _e( 'When you fill in a profile or information, it will be displayed in the sidebar.', 'chocolat' ); ?></p>
								<p><textarea id="chocolat_theme_options[info_side_text]" cols="60" rows="3" name="chocolat_theme_options[info_side_text]"><?php echo esc_textarea( $options['info_side_text'] ); ?></textarea></p>
							</td>
						</tr>

						<!-- Contact -->
						<tr id="option-contact" class="option-check">
							<th scope="row"><?php _e( 'Contact', 'chocolat' ); ?></th>
							<td><fieldset>
								<p><label><input id="chocolat_theme_options[show_contact]" name="chocolat_theme_options[show_contact]" type="checkbox" value="1" <?php checked( $options['show_contact'], 1 ); ?> />
								<?php _e( 'View Contact', 'chocolat' ); ?></label></p>

								<?php if ( is_array( chocolat_contact_options() ) ) :
									foreach ( chocolat_contact_options() as $option ) : ?>
									<div id="contact-<?php echo $option['id']; ?>" class="hidebox">
										<p class="theme-left-space"><label><input type="radio" name="chocolat_theme_options[contact_radio]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $options['contact_radio'], $option['value'] ); ?> /> <?php echo $option['label']; ?></label></p>
										<div class="theme-left-space">
											<?php if ( $option['id'] == 'mail' ) : ?>
												<p><?php _e( 'E-mail address that is registered with the general settings are used. Please enter if you want to use the e-mail address of the other.', 'chocolat' ); ?></p>
												<p><label>mailto:&nbsp;<input id="chocolat_theme_options[mail_url]" class="regular-text" type="text" name="chocolat_theme_options[mail_url]" value="<?php echo antispambot( $options['mail_url'] ); ?>" /></label></p>
											<?php elseif ( $option['id'] == 'page' ) : ?>
												<p><?php _e( 'URL of the Contact Page', 'chocolat' ); ?></p>
												<p><input id="chocolat_theme_options[page_url]" class="regular-text" type="text" name="chocolat_theme_options[page_url]" value="<?php echo esc_url( $options['page_url'] ); ?>" /></p>
											<?php endif; ?>
										</div>
									</div>
								<?php endforeach; endif; ?>
							</fieldset></td>
						</tr>

						<!-- RSS -->
						<tr>
							<th scope="row"><?php _e( 'RSS', 'chocolat' ); ?></th>
							<td><fieldset>
								<p><label><input id="chocolat_theme_options[show_rss]" name="chocolat_theme_options[show_rss]" type="checkbox" value="1" <?php checked( $options['show_rss'], 1 ); ?> />
								<?php _e( 'View RSS', 'chocolat' ); ?></label></p>

								<p><label><input id="chocolat_theme_options[show_feedly]" name="chocolat_theme_options[show_feedly]" type="checkbox" value="1" <?php checked( $options['show_feedly'], 1 ); ?> />
								<?php _e( 'View Feedly', 'chocolat' ); ?></label></p>
							</fieldset></td>
						</tr>

						<!-- Copyright -->
						<tr id="option-copy" class="option-check">
							<th scope="row"><?php _e( 'Copyright', 'chocolat' ); ?></th>
							<td><fieldset>
							<p><label><input id="chocolat_theme_options[show_copyright]" name="chocolat_theme_options[show_copyright]" type="checkbox" value="1" <?php checked( $options['show_copyright'], 1 ); ?> />
								<?php _e( 'Display the copyright of Web site', 'chocolat' ); ?></label></p>
								<div class="theme-left-space hidebox">
									<p><?php echo chocolat_get_copyright_text(); ?><br />
									<?php _e( 'It will be displayed.', 'chocolat' ); ?>
									<?php _e( 'Please enter if you want to change the text of copyright.', 'chocolat' ); ?></p>
									<p><textarea id="chocolat_theme_options[copyright_text]" cols="60" rows="3" name="chocolat_theme_options[copyright_text]"><?php echo esc_textarea( $options['copyright_text'] ); ?></textarea></p>
								</div>
							</fieldset></td>
						</tr>

						<!-- Credit link -->
						<tr id="option-creditlink" class="option-check">
							<th scope="row"><?php _e( 'Credit link', 'chocolat' ); ?></th>
							<td><fieldset>
								<p><?php _e( 'Choose to enable or disable  the credit link of the author of the theme.', 'chocolat' ); ?><br /><span class="description"><?php _e( 'If you display credit link, I am very pleased :)', 'chocolat' ); ?></span></p>
								<?php if ( is_array( chocolat_credit_link_options() ) ) :
									foreach ( chocolat_credit_link_options() as $option ) : ?>
								<label class="right-space"><input type="radio" name="chocolat_theme_options[credit_link_radio]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $options['credit_link_radio'], $option['value'] ); ?> />&nbsp;<?php echo $option['label']; ?></label>
								<?php endforeach; endif; ?>
							</fieldset></td>
						</tr>
					</table>
				</div><!-- /panel -->
			</div><!-- /#tabset -->
			<div id="submit-button">
				<?php submit_button( __( 'Save Changes', 'chocolat' ), 'primary', 'save' ); ?>
				<?php submit_button( __( 'Reset Defaults', 'chocolat' ), 'secondary', 'reset' ); ?>
			</div>
		</form>
	</div><!-- /.wrap -->
	<?php
}

/**
 * ------------------------------------------------------------
 * 6.0 - sanitize and validate
 *       By clicking the "Save" button,
 *       to sanitize and validate input. Accepts an array, return a sanitized array.
 *       By clicking the "Reset" button,
 *       to return to the default settings array.
 * ------------------------------------------------------------
 */

function chocolat_theme_options_validate( $input ) {
	if ( isset( $_POST['reset'] ) ) {
		$input = chocolat_theme_default_options();
	} else {
		if ( ! isset( $input['show_site_desc'] ) )
			$input['show_site_desc'] = null;
		$input['show_site_desc'] = ( $input['show_site_desc'] == 1 ? 1 : 0 );

		if ( ! isset( $input['show_author'] ) )
			$input['show_author'] = null;
		$input['show_author'] = ( $input['show_author'] == 1 ? 1 : 0 );

		if ( ! isset( $input['show_breadcrumb'] ) )
			$input['show_breadcrumb'] = null;
		$input['show_breadcrumb'] = ( $input['show_breadcrumb'] == 1 ? 1 : 0 );

		if ( ! isset( $input['show_last_date'] ) )
			$input['show_last_date'] = null;
		$input['show_last_date'] = ( $input['show_last_date'] == 1 ? 1 : 0 );

		if ( ! isset( $input['show_image_lightbox'] ) )
			$input['show_image_lightbox'] = null;
		$input['show_image_lightbox'] = ( $input['show_image_lightbox'] == 1 ? 1 : 0 );

		if ( ! isset( $input['show_lightbox'] ) )
			$input['show_lightbox'] = null;
		$input['show_lightbox'] = ( $input['show_lightbox'] == 1 ? 1 : 0 );

		if ( ! isset( $input['show_widget_masonry'] ) )
			$input['show_widget_masonry'] = null;
		$input['show_widget_masonry'] = ( $input['show_widget_masonry'] == 1 ? 1 : 0 );

		// Excerpt or Read More
		if ( ! isset( $input['read_more_radio'] ) )
			$input['read_more_radio'] = null;
		if ( ! array_key_exists( $input['read_more_radio'], chocolat_read_more_options() ) )
			$input['read_more_radio'] = null;

		$input['excerpt_number'] = absint( $input['excerpt_number'] );

		$input['moretag_text'] = sanitize_text_field( $input['moretag_text'] );

		if ( ! isset( $input['show_more_link'] ) )
			$input['show_more_link'] = null;
		$input['show_more_link'] = ( $input['show_more_link'] == 1 ? 1 : 0 );

		// Related Posts
		if ( ! isset( $input['show_related'] ) )
			$input['show_related'] = null;
		$input['show_related'] = ( $input['show_related'] == 1 ? 1 : 0 );

		$input['related_title'] = sanitize_text_field( $input['related_title'] );

		$input['related_number'] = absint( $input['related_number'] );

		if ( ! array_key_exists( $input['related_order_select'], chocolat_related_order_options() ) )
			$input['related_order_select'] = null;

		if ( ! array_key_exists( $input['related_class_select'], chocolat_related_class_options() ) )
			$input['related_class_select'] = null;

		// New Posts
		if ( ! isset( $input['show_new_posts'] ) )
			$input['show_new_posts'] = null;
		$input['show_new_posts'] = ( $input['show_new_posts'] == 1 ? 1 : 0 );

		$input['new_posts_title'] = sanitize_text_field( $input['new_posts_title'] );

		$input['new_posts_number'] = absint( $input['new_posts_number'] );

		// Sidebar settings
		if ( ! isset( $input['sidebar_radio'] ) )
			$input['sidebar_radio'] = null;
		if ( ! array_key_exists( $input['sidebar_radio'], chocolat_sidebar_options() ) )
			$input['sidebar_radio'] = null;

		// Position to display
		if ( ! isset( $input['show_links_top'] ) )
			$input['show_links_top'] = null;
		$input['show_links_top'] = ( $input['show_links_top'] == 1 ? 1 : 0 );

		if ( ! isset( $input['show_links_side'] ) )
			$input['show_links_side'] = null;
		$input['show_links_side'] = ( $input['show_links_side'] == 1 ? 1 : 0 );

		$input['links_side_title'] = sanitize_text_field( $input['links_side_title'] );

		if ( ! array_key_exists( $input['links_side_select'], chocolat_links_side_options() ) )
			$input['links_side_select'] = null;

		if ( ! isset( $input['show_links_bottom'] ) )
			$input['show_links_bottom'] = null;
		$input['show_links_bottom'] = ( $input['show_links_bottom'] == 1 ? 1 : 0 );

		// Information
		$input['info_side_text'] = esc_textarea( $input['info_side_text'] );

		// Contact
		if ( ! isset( $input['show_contact'] ) )
			$input['show_contact'] = null;
		$input['show_contact'] = ( $input['show_contact'] == 1 ? 1 : 0 );

		if ( ! isset( $input['contact_radio'] ) )
			$input['contact_radio'] = null;
		if ( ! array_key_exists( $input['contact_radio'], chocolat_contact_options() ) )
			$input['contact_radio'] = null;

		$input['mail_url'] = sanitize_email( $input['mail_url'] );
		$input['page_url'] = esc_url_raw( $input['page_url'] );

		// RSS
		if ( ! isset( $input['show_rss'] ) )
			$input['show_rss'] = null;
		$input['show_rss'] = ( $input['show_rss'] == 1 ? 1 : 0 );

		if ( ! isset( $input['show_feedly'] ) )
			$input['show_feedly'] = null;
		$input['show_feedly'] = ( $input['show_feedly'] == 1 ? 1 : 0 );

		// Copyright
		if ( ! isset( $input['show_copyright'] ) )
			$input['show_copyright'] = null;
		$input['show_copyright'] = ( $input['show_copyright'] == 1 ? 1 : 0 );

		$input['copyright_text'] = esc_textarea( $input['copyright_text'] );

		// credit link
		if ( ! isset( $input['credit_link_radio'] ) )
			$input['credit_link_radio'] = null;
		if ( ! array_key_exists( $input['credit_link_radio'], chocolat_credit_link_options() ) )
			$input['credit_link_radio'] = null;

		// Image Settings
		$input['favicon_url'] = esc_url_raw( $input['favicon_url'] );
		$input['sp_icon_url'] = esc_url_raw( $input['sp_icon_url'] );
		$input['site_logo_url'] = esc_url_raw( $input['site_logo_url'] );
		$input['no_image_url'] = esc_url_raw( $input['no_image_url'] );
	}
	return $input;
}