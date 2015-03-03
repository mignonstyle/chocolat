<?php
/**
 * Theme Options
 * @package   Chocolat
 * @copyright Copyright (c) 2014 Mignon Style
 * @license   GNU General Public License v2.0
 * @since     Chocolat 1.0
 */

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
	wp_enqueue_style( 'chocolat-themeoptions', get_template_directory_uri().'/admin/css/theme-options.css' );

	// CodeMirror
	wp_enqueue_style( 'chocolat-codemirror', get_template_directory_uri().'/admin/inc/codemirror/codemirror.css' );
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

	// CodeMirror
	wp_enqueue_script( 'chocolat-codemirror-js', get_template_directory_uri().'/admin/inc/codemirror/codemirror.js', array(), null, true );
	wp_enqueue_script( 'chocolat-codemirror-css-js', get_template_directory_uri().'/admin/inc/codemirror/css.js', array( 'chocolat-codemirror-js' ), null, true );
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
	$options = chocolat_get_option();
	if ( ! empty( $options['save_chocolat_option'] ) ) {
		return false;
	}
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
	get_template_part( 'admin/inc/option-register' );
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
		'show_no_comment'     => 1,
		'show_archives_posts' => 1,
		'show_header_link'    => 0,
		'show_index_comments' => 0,
		'show_last_date'      => 0,
		'show_image_lightbox' => 1,
		'show_lightbox'       => 1,
		'show_widget_masonry' => 1,

		'read_more_radio' => 'more_excerpt',
		'excerpt_number'  => $length,
		'moretag_text'    => '',
		'show_more_link'  => 1,

		'featured_size_w'   => 700,
		'featured_size_h'   => 350,
		'featured_position' => 'center',
		'featured_sneak'    => 'no_sneak',
		'featured_crop'     => 'crop',
		'featured_crop_x'   => 'center',
		'featured_crop_y'   => 'center',

		'show_featured_home'     => 0,
		'featured_home_size_w'   => 700,
		'featured_home_size_h'   => 350,
		'featured_home_position' => 'center',
		'featured_home_sneak'    => 'no_sneak',
		'featured_home_crop'     => 'crop',
		'featured_home_crop_x'   => 'center',
		'featured_home_crop_y'   => 'center',

		'thumbnail_crop_x'  => 'center',
		'thumbnail_crop_y'  => 'center',

		'favicon_url'   => '',
		'sp_icon_url'   => '',
		'site_logo_url' => '',
		'no_image_url'  => '',

		'show_related'         => 0,
		'related_title'        => '',
		'related_number'       => 5,
		'related_row'          => 2,
		'related_order_select' => 'desc',
		'related_class_select' => 'category',

		'show_new_posts'   => 0,
		'new_posts_title'  => '',
		'new_posts_number' => 5,
		'new_posts_row'    => 2,

		'sidebar_radio' => 'right_sidebar',

		'show_links_top'    => 1,
		'show_links_side'   => 1,
		'links_side_title'  => '',
		'links_side_select' => 'links_side_top',
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

		'show_slider'  => 0,
		'slider_color' => 'slider_light',

		'slider_image01_url' => '',
		'slider_image02_url' => '',
		'slider_image03_url' => '',
		'slider_image04_url' => '',
		'slider_image05_url' => '',

		'slider_image01_caption' => '',
		'slider_image02_caption' => '',
		'slider_image03_caption' => '',
		'slider_image04_caption' => '',
		'slider_image05_caption' => '',

		'slider_image01_link' => '',
		'slider_image02_link' => '',
		'slider_image03_link' => '',
		'slider_image04_link' => '',
		'slider_image05_link' => '',

		'custom_css' => '',

		'save_chocolat_option' => 0,
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
		'show_no_comment' => array(
			'id'   => 'show_no_comment',
			'text' => __( 'Show the message when you have closed the comment', 'chocolat' ),
		),
		'show_archives_posts' => array(
			'id'   => 'show_archives_posts',
			'text' => __( 'Show the heading of number of posts in the archives page', 'chocolat' ),
		),
		'show_header_link' => array(
			'id'   => 'show_header_link',
			'text' => __( 'Add a link to the home page in the header image', 'chocolat' ),
		),
		'show_index_comments' => array(
			'id'   => 'show_index_comments',
			'text' => __( 'Shows the number of comments in the posts home page', 'chocolat' ),
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
			'id'        => 'show_lightbox',
			'text'      => __( 'Use the Lightbox to gallery', 'chocolat' ),
			'text_desc' => __( 'When you use "Tiled Galleries" of jetpack plugin, clear the check box.', 'chocolat' ),
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
			'value' => 'contact_mail',
			'id'    => 'mail',
			'label' => __( 'Use e-mail address', 'chocolat' ),
		),
		'contact_page' => array(
			'value' => 'contact_page',
			'id'    => 'page',
			'label' => __( 'Use the contact page', 'chocolat' ),
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
 * 3.10 - Create an array of theme options
 *       slider_color
 * ------------------------------------------------------------
 */

function chocolat_slider_color_options() {
	$slider_color_options = array(
		'slider_light' => array(
			'value'   => 'slider_light',
			'img'     => 'slider-light.png',
			'label_2' => __( 'Light Color', 'chocolat' ),
		),
		'slider_dark' => array(
			'value'   => 'slider_dark',
			'img'     => 'slider-dark.png',
			'label_2' => __( 'Dark Color', 'chocolat' ),
		),
	);
	return $slider_color_options;
}

/**
 * ------------------------------------------------------------
 * 3.11 - Create an array of theme options
 *       slider images (media-uploader)
 * ------------------------------------------------------------
 */

function chocolat_upload_slider_image_options() {
	$upload_slider_image_options = array(
		'slider_image01' => array(
			'id'    => 'slider_image01',
			'title' => __( 'Slider Image 1', 'chocolat' ),
		),
		'slider_image02' => array(
			'id'    => 'slider_image02',
			'title' => __( 'Slider Image 2', 'chocolat' ),
		),
		'slider_image03' => array(
			'id'    => 'slider_image03',
			'title' => __( 'Slider Image 3', 'chocolat' ),
		),
		'slider_image04' => array(
			'id'    => 'slider_image04',
			'title' => __( 'Slider Image 4', 'chocolat' ),
		),
		'slider_image05' => array(
			'id'    => 'slider_image05',
			'title' => __( 'Slider Image 5', 'chocolat' ),
		),
	);
	return $upload_slider_image_options;
}

/**
 * ------------------------------------------------------------
 * 3.12 - Create an array of theme options
 *       Featured Image Position
 * ------------------------------------------------------------
 */

function chocolat_featured_position_options() {
	$options_array = array(
		'left' => array(
			'value'   => 'left',
			'img'     => 'featured_pos_left.png',
			'label_2' => __( 'Left', 'chocolat' ),
		),
		'center' => array(
			'value'   => 'center',
			'img'     => 'featured_pos_center.png',
			'label_2' => __( 'Center', 'chocolat' ),
		),
		'right' => array(
			'value'   => 'right',
			'img'     => 'featured_pos_right.png',
			'label_2' => __( 'Right', 'chocolat' ),
		),
	);
	return $options_array;
}

/**
 * ------------------------------------------------------------
 * 3.13 - Create an array of theme options
 *       Featured Image Sneak
 * ------------------------------------------------------------
 */

function chocolat_featured_sneak_options() {
	$options_array = array(
		'sneak' => array(
			'value'   => 'sneak',
			'img'     => 'featured_sneak.png',
			'label_2' => __( 'To Sneak', 'chocolat' ),
		),
		'no_sneak' => array(
			'value'   => 'no_sneak',
			'img'     => 'featured_pos_left.png',
			'label_2' => __( 'Not Sneak', 'chocolat' ),
		),
	);
	return $options_array;
}

/**
 * ------------------------------------------------------------
 * 3.14 - Create an array of theme options
 *       Featured Image Crop
 * ------------------------------------------------------------
 */

function chocolat_featured_crop_options() {
	$options_array = array(
		'crop' => array(
			'value'   => 'crop',
			'img'     => 'featured_x_center.png',
			'label_2' => __( 'Crop', 'chocolat' ),
		),
		'resize' => array(
			'value'   => 'resize',
			'img'     => 'featured_resize.png',
			'label_2' => __( 'Resize', 'chocolat' ),
		),
	);
	return $options_array;
}

/**
 * ------------------------------------------------------------
 * 3.15 - Create an array of theme options
 *       Position X
 * ------------------------------------------------------------
 */

function chocolat_position_x_options() {
	$options_array = array(
		'left' => array(
			'value'   => 'left',
			'img'     => 'featured_x_left.png',
			'label_2' => __( 'Left', 'chocolat' ),
		),
		'center' => array(
			'value'   => 'center',
			'img'     => 'featured_x_center.png',
			'label_2' => __( 'Center', 'chocolat' ),
		),
		'right' => array(
			'value'   => 'right',
			'img'     => 'featured_x_right.png',
			'label_2' => __( 'Right', 'chocolat' ),
		),
	);
	return $options_array;
}

/**
 * ------------------------------------------------------------
 * 3.16 - Create an array of theme options
 *       Position Y
 * ------------------------------------------------------------
 */

function chocolat_position_y_options() {
	$options_array = array(
		'top' => array(
			'value'   => 'top',
			'img'     => 'featured_y_top.png',
			'label_2' => __( 'Top', 'chocolat' ),
		),
		'center' => array(
			'value'   => 'center',
			'img'     => 'featured_y_center.png',
			'label_2' => __( 'Center', 'chocolat' ),
		),
		'bottom' => array(
			'value'   => 'bottom',
			'img'     => 'featured_y_bottom.png',
			'label_2' => __( 'Bottom', 'chocolat' ),
		),
	);
	return $options_array;
}

/**
 * ------------------------------------------------------------
 * 3.99 - Tabs Title
 * ------------------------------------------------------------
 */

function chocolat_tab_title() {
	$tab_title = array(
		'settings' => array(
			'id'    => 'settings',
			'title' => __( 'Display Settings', 'chocolat' ),
		),
		'featured' => array(
			'id'    => 'featured',
			'title' => __( 'Featured Image Settings', 'chocolat' ),
		),
		'links' => array(
			'id'    => 'links',
			'title' => __( 'Links Setting', 'chocolat' ),
		),
		'slider' => array(
			'id'    => 'slider',
			'title' => __( 'Slider Setting', 'chocolat' ),
		),
		'css' => array(
			'id'    => 'css',
			'title' => __( 'Custom CSS', 'chocolat' ),
		),
	);
	return $tab_title;
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
				$tab_title = chocolat_tab_title();
			?>
			<div id="tabset">
				<ul class="tabs clearfix">
				<?php if ( is_array( $tab_title ) ) :
					foreach( $tab_title as $tabs ) :
						echo '<li><h3 class="title"><a href="#panel-'.$tabs['id'].'" id="tab-'.$tabs['id'].'">'.$tabs['title'].'</a></h3></li>'."\n";
				endforeach; endif; ?>
				</ul>

				<div id="panel-settings" class="panel">
					<h3 class="title"><?php echo $tab_title['settings']['title']; ?></h3>
					<table class="form-table">
						<!-- Display Settings -->
						<tr>
							<th scope="row"><?php _e( 'Display Settings', 'chocolat' ); ?></th>
							<td><fieldset>
							<?php if ( is_array( chocolat_settings_options() ) ) {
								foreach ( chocolat_settings_options() as $option ) {
									$option_id = $option['id'];
									$option_name = $option_id;
									$option_text = $option['text'];
									$text_desc =  ( array_key_exists( 'text_desc', $option ) ) ? $option['text_desc'] : '';
									chocolat_checkbox( $options, $option_name, $option_text, $text_desc );
								}
							} ?>
							</fieldset></td>
						</tr>

						<!-- Excerpt or Read More -->
						<tr id="option-readmore">
							<th scope="row"><?php _e( 'Excerpt Settings', 'chocolat' ); ?></th>
							<td><fieldset>
								<p><?php _e( 'Set the display of posts of an archive page.', 'chocolat' ); ?><br /><?php _e( 'Please select from "excerpt" or "more quick tag".', 'chocolat' ); ?></p>
								<?php if ( is_array( chocolat_read_more_options() ) ) :
									foreach ( chocolat_read_more_options() as $option ) : ?>
									<p><?php
										$option_name = 'read_more_radio';
										chocolat_radio_input( $options, $option, $option_name );
									?></p>

									<div id="readmore-<?php echo $option['id']; ?>" class="theme-left-space">
									<?php if ( $option['id'] == 'excerpt' ) : ?>
									<div><?php
										$option_name = 'excerpt_number';
										$option_label = __( 'Number of characters to be displayed in the excerpt', 'chocolat' ) . __( ':', 'chocolat' ) . '&nbsp;';
										$option_type = 'number';
										$option_class = 'small-text';
										chocolat_textfield( $options, $option_name, $option_label, $option_type, $option_class );

										if ( get_bloginfo( 'language' ) == 'ja' ) : ?>
											<p class="description"><?php _e( 'In the Japanese version of WordPress, please activate WP Multibyte Patch plugin.', 'chocolat' ); ?></p>
										<?php endif; ?><br />
									</div>

									<?php elseif ( $option['id'] == 'moretag' ) : ?>
									<div><?php
										$option_name = 'show_more_link';
										$option_text = __( 'Display the "more" link', 'chocolat' );
										chocolat_checkbox( $options, $option_name, $option_text );

										$option_name = 'moretag_text';
										$option_label = __( 'Character of the "more" link', 'chocolat' ) . __( ':', 'chocolat' ) . '&nbsp;';
										chocolat_textfield( $options, $option_name, $option_label );
									?></div>
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
									$option_id = $option['id'];
									$option_name = $option['name'];
									$option_text = ( ! empty( $option['desc'] ) ) ? $option['desc'] : '';
						?><tr>
							<th scope="row"><?php echo $option['title']; ?></th>
							<td><fieldset>
								<p><?php printf( __( 'Once you have set the image, it is used as the %s for your Web site.', 'chocolat' ), $option['text'] ); ?><br /><span class="description"><?php printf( __( 'Recommended files %s', 'chocolat' ), $option['size'] ); ?></span><?php echo $option_text; ?></p>
								<?php chocolat_media_uploader( $options, $option_id, $option_name ); ?>
							</fieldset></td>
						</tr><?php endforeach; endif;
						else : ?>
						<tr>
							<th scope="row"><?php _e( 'Image Settings', 'chocolat' ); ?></th>
							<td><p><?php _e( 'Sorry, WordPress you are using is not supported. Upgrade your WordPress.', 'chocolat' ); ?></p></td>
						</tr>
						<?php endif; ?>

						<!-- Related Posts -->
						<tr id="option-related-posts" class="option-check">
							<th scope="row"><?php _e( 'Related Entry', 'chocolat' ); ?></th>
							<td><fieldset>
								<p><?php _e( 'Displays a list of related articles, under the article of a single post page if you check.', 'chocolat' ); ?></p>
								<?php
									$option_name = 'show_related';
									$option_text = __( 'View Related Posts after the content', 'chocolat' );
									chocolat_checkbox( $options, $option_name, $option_text );
								?>
								<div class="theme-left-space hidebox"><?php
									$option_name = 'related_title';
									$option_label = __( 'Title', 'chocolat' ) . __( ':', 'chocolat' ) . '&nbsp;';
									chocolat_textfield( $options, $option_name, $option_label );

									echo '<table><tr><td>';

									$option_name = 'related_number';
									$option_label = __( 'Number of posts to show', 'chocolat' ) . __( ':', 'chocolat' ) . '&nbsp;';
									$option_type = 'number';
									$option_class = 'small-text';
									$label_after = __( 'posts', 'chocolat' );
									chocolat_textfield( $options, $option_name, $option_label, $option_type, $option_class, $label_after );

									echo '</td><td>' . __( 'x', 'chocolat' ) . '</td><td>';

									$option_name = 'related_row';
									$option_type = 'number';
									$option_class = 'small-text';
									$label_after = __( 'row', 'chocolat' );
									chocolat_textfield( $options, $option_name, '', $option_type, $option_class, $label_after );

									echo '</td></tr></table>';

									$option_label = __( 'Alignment sequence', 'chocolat' ) . __( ':', 'chocolat' ) . '&nbsp;';
									$option_array = chocolat_related_order_options();
									$option_name = 'related_order_select';
									chocolat_select( $options, $option_array, $option_name, $option_label );

									$option_label = __( 'Classification', 'chocolat' ) . __( ':', 'chocolat' ) . '&nbsp;';
									$option_array = chocolat_related_class_options();
									$option_name = 'related_class_select';
									chocolat_select( $options, $option_array, $option_name, $option_label );
								?></div>
							</fieldset></td>
						</tr>

						<!-- New Posts -->
						<tr id="option-new-posts" class="option-check">
							<th scope="row"><?php _e( 'New Entry', 'chocolat' ); ?></th>
							<td><fieldset>
								<p><?php _e( 'Displays a list of new articles, under the article of a single post page if you check.', 'chocolat' ); ?></p>
								<?php
									$option_name = 'show_new_posts';
									$option_text = __( 'View New Posts after the content', 'chocolat' );
									chocolat_checkbox( $options, $option_name, $option_text );
								?>
								<div class="theme-left-space hidebox"><?php
									$option_name = 'new_posts_title';
									$option_label = __( 'Title', 'chocolat' ) . __( ':', 'chocolat' ) . '&nbsp;';
									chocolat_textfield( $options, $option_name, $option_label );

									echo '<table><tr><td>';

									$option_name = 'new_posts_number';
									$option_label = __( 'Number of posts to show', 'chocolat' ) . __( ':', 'chocolat' ) . '&nbsp;';
									$option_type = 'number';
									$option_class = 'small-text';
									$label_after = __( 'posts', 'chocolat' );
									chocolat_textfield( $options, $option_name, $option_label, $option_type, $option_class, $label_after );

									echo '</td><td>' . __( 'x', 'chocolat' ) . '</td><td>';

									$option_name = 'new_posts_row';
									$option_type = 'number';
									$option_class = 'small-text';
									$label_after = __( 'row', 'chocolat' );
									chocolat_textfield( $options, $option_name, '', $option_type, $option_class, $label_after );

									echo '</td></tr></table>';
								?></div>
							</fieldset></td>
						</tr>

						<!-- Sidebar settings -->
						<tr id="option-sidebar">
							<th scope="row"><?php _e( 'Sidebar Settings', 'chocolat' ); ?></th>
							<td><fieldset><?php
								$option_array = chocolat_sidebar_options();
								$option_name = 'sidebar_radio';
								chocolat_radio( $options, $option_array, $option_name );
							?></fieldset></td>
						</tr>
					</table>
				</div><!-- /panel -->

				<div id="panel-featured" class="panel">
					<h3 class="title"><?php echo $tab_title['featured']['title']; ?></h3>
					<p class="panel-caption"><?php _e( 'Set the size and the position of the featured image.', 'chocolat' ); ?></p>

					<table class="form-table">
						<!-- Featured Image Settings -->
						<tr>
							<th scope="row"><?php _e( 'Featured image size', 'chocolat' ); ?></th>
							<td><fieldset>
								<table class="nest"><tr>
									<td><?php
										$option_name = 'featured_size_w';
										$option_label = __( 'Width', 'chocolat' ) . __( ':', 'chocolat' ) . '&nbsp;';
										$option_type = 'number';
										$option_class = 'small-text';
										$label_after = __( 'px', 'chocolat' );
										chocolat_textfield( $options, $option_name, $option_label, $option_type, $option_class, $label_after );
									?></td>
									<td><?php
										$option_name = 'featured_size_h';
										$option_label = __( 'Height', 'chocolat' ) . __( ':', 'chocolat' ) . '&nbsp;';
										$option_type = 'number';
										$option_class = 'small-text';
										$label_after = __( 'px', 'chocolat' );
										chocolat_textfield( $options, $option_name, $option_label, $option_type, $option_class, $label_after );
									?></td>
								</tr></table>
								<p class="description"><?php _e( 'The default size of the featured image is width 700px, height 350px.', 'chocolat' ); ?><br /><?php _e( 'Maximum width that can be used for featured image is 940px.', 'chocolat' ); ?></p>
							</fieldset></td>
						</tr>

						<tr id="featured-position">
							<th scope="row"><?php _e( 'Featured image position', 'chocolat' ); ?></th>
							<td><fieldset><?php
								$option_array = chocolat_featured_position_options();
								$option_name = 'featured_position';
								chocolat_radio( $options, $option_array, $option_name );
							?></fieldset></td>
						</tr>

						<tr id="featured-sneak">
							<th scope="row"><?php _e( 'Sneak settings', 'chocolat' ); ?></th>
							<td><fieldset><?php
								$option_array = chocolat_featured_sneak_options();
								$option_name = 'featured_sneak';
								chocolat_radio( $options, $option_array, $option_name );
							?></fieldset></td>
						</tr>

						<tr id="featured-crop">
							<th scope="row"><?php _e( 'Crop settings', 'chocolat' ); ?></th>
							<td><fieldset>
								<p><?php _e( 'Make the crop setting of the featured image.', 'chocolat' ); ?><br /><span class="description"><?php _e( 'The default is to crop in the center of the image to the size you have set.', 'chocolat' ); ?></span></p>
							<?php
								$option_array = chocolat_featured_crop_options();
								$option_name = 'featured_crop';
								chocolat_radio( $options, $option_array, $option_name );
							?></fieldset></td>
						</tr>

						<tr id="featured-crop-pos">
							<th scope="row"><?php _e( 'Crop position', 'chocolat' ); ?></th>
							<td><fieldset><?php
								$option_array = chocolat_position_x_options();
								$option_name = 'featured_crop_x';
								chocolat_radio( $options, $option_array, $option_name );

								$option_array = chocolat_position_y_options();
								$option_name = 'featured_crop_y';
								chocolat_radio( $options, $option_array, $option_name );
							?></fieldset></td>
						</tr>

						<!-- Home Page Featured Image Settings -->
						<tr id="featured-home" class="option-check">
							<th scope="row"><?php _e( 'Featured image settings of home page', 'chocolat' ); ?></th>
							<td><fieldset>
								<p><?php _e( 'If you want to the featured image of home page and posts page to another setting, please put a check.', 'chocolat' ); ?></p>
							<?php
								$option_name = 'show_featured_home';
								$option_text = __( 'Setting the featured image of home page', 'chocolat' );
								chocolat_checkbox( $options, $option_name, $option_text );
							?></fieldset></td>
						</tr>

						<tr class="featured-home-children">
							<th scope="row"><?php _e( 'Featured image size of home page', 'chocolat' ); ?></th>
							<td><fieldset>
								<table class="nest"><tr>
									<td><?php
										$option_name = 'featured_home_size_w';
										$option_label = __( 'Width', 'chocolat' ) . __( ':', 'chocolat' ) . '&nbsp;';
										$option_type = 'number';
										$option_class = 'small-text';
										$label_after = __( 'px', 'chocolat' );
										chocolat_textfield( $options, $option_name, $option_label, $option_type, $option_class, $label_after );
									?></td>
									<td><?php
										$option_name = 'featured_home_size_h';
										$option_label = __( 'Height', 'chocolat' ) . __( ':', 'chocolat' ) . '&nbsp;';
										$option_type = 'number';
										$option_class = 'small-text';
										$label_after = __( 'px', 'chocolat' );
										chocolat_textfield( $options, $option_name, $option_label, $option_type, $option_class, $label_after );
									?></td>
								</tr></table>
								<p class="description"><?php _e( 'The default size of the featured image is width 700px, height 350px.', 'chocolat' ); ?><br /><?php _e( 'Maximum width that can be used for featured image is 940px.', 'chocolat' ); ?></p>
							</fieldset></td>
						</tr>

						<tr id="featured-home-position" class="featured-home-children">
							<th scope="row"><?php _e( 'Featured image position of home page', 'chocolat' ); ?></th>
							<td><fieldset><?php
								$option_array = chocolat_featured_position_options();
								$option_name = 'featured_home_position';
								chocolat_radio( $options, $option_array, $option_name );
							?></fieldset></td>
						</tr>

						<tr id="featured-home-sneak" class="featured-home-children">
							<th scope="row"><?php _e( 'Sneak settings of home page', 'chocolat' ); ?></th>
							<td><fieldset><?php
								$option_array = chocolat_featured_sneak_options();
								$option_name = 'featured_home_sneak';
								chocolat_radio( $options, $option_array, $option_name );
							?></fieldset></td>
						</tr>

						<tr id="featured-home-crop" class="featured-home-children">
							<th scope="row"><?php _e( 'Crop settings of home page', 'chocolat' ); ?></th>
							<td><fieldset>
								<p><?php _e( 'Make the crop setting of the featured image of home page.', 'chocolat' ); ?><br /><span class="description"><?php _e( 'The default is to crop in the center of the image to the size you have set.', 'chocolat' ); ?></span></p>
							<?php
								$option_array = chocolat_featured_crop_options();
								$option_name = 'featured_home_crop';
								chocolat_radio( $options, $option_array, $option_name );
							?></fieldset></td>
						</tr>

						<tr id="featured-home-crop-pos" class="featured-home-children">
							<th scope="row"><?php _e( 'Crop position of home page', 'chocolat' ); ?></th>
							<td><fieldset><?php
								$option_array = chocolat_position_x_options();
								$option_name = 'featured_home_crop_x';
								chocolat_radio( $options, $option_array, $option_name );

								$option_array = chocolat_position_y_options();
								$option_name = 'featured_home_crop_y';
								chocolat_radio( $options, $option_array, $option_name );
							?></fieldset></td>
						</tr>

						<!-- Thumbnail Settings -->
						<tr>
							<th scope="row"><?php _e( 'Thumbnail crop settings', 'chocolat' ); ?></th>
							<td><fieldset>
								<p><?php _e( 'Make the crop position setting of the thumbnail.', 'chocolat' ); ?><br /><span class="description"><?php _e( 'The default is to crop in the center of the image.', 'chocolat' ); ?></span></p>
								<?php
									$option_array = chocolat_position_x_options();
									$option_name = 'thumbnail_crop_x';
									chocolat_radio( $options, $option_array, $option_name );

									$option_array = chocolat_position_y_options();
									$option_name = 'thumbnail_crop_y';
									chocolat_radio( $options, $option_array, $option_name );
								?>
							</fieldset></td>
						</tr>
					</table>
				</div><!-- /panel -->

				<div id="panel-links" class="panel">
					<h3 class="title"><?php echo $tab_title['links']['title']; ?></h3>
					<p class="panel-caption"><?php _e( 'Set the display of contact or RSS and copyright.Copyright will be displayed in the footer.', 'chocolat' ); ?></p>

					<table class="form-table">
						<!-- Position to display -->
						<tr>
							<th scope="row"><?php _e( 'Position to display', 'chocolat' ); ?></th>
							<td><fieldset>
								<?php
									$option_name = 'show_links_top';
									$option_text = __( 'Display in the header', 'chocolat' );
									$text_desc   = __( 'In a smartphone, it is displayed at the position of the footer.', 'chocolat' );
									chocolat_checkbox( $options, $option_name, $option_text, $text_desc );
								?><br />

								<div id="option-links-sidebar" class="option-check">
									<?php
										$option_name = 'show_links_side';
										$option_text = __( 'Display in the sidebar', 'chocolat' );
										chocolat_checkbox( $options, $option_name, $option_text );
									?>

									<div class="theme-left-space hidebox"><?php
										$option_name = 'links_side_title';
										$option_label = __( 'Title', 'chocolat' ) . __( ':', 'chocolat' ) . '&nbsp;';
										chocolat_textfield( $options, $option_name, $option_label );

										$option_label = __( 'Display position', 'chocolat' ) . __( ':', 'chocolat' ) . '&nbsp;';
										$option_array = chocolat_links_side_options();
										$option_name = 'links_side_select';
										chocolat_select( $options, $option_array, $option_name, $option_label );
										?><br />
									</div>
								</div>

								<?php
									$option_name = 'show_links_bottom';
									$option_text = __( 'Display in the footer', 'chocolat' );
									chocolat_checkbox( $options, $option_name, $option_text );
								?>
							</fieldset></td>
						</tr>

						<!-- Information -->
						<tr id="option-info" class="option-check">
							<th scope="row"><?php _e( 'Information', 'chocolat' ); ?></th>
							<td>
								<p><?php _e( 'When you fill in a profile or information, it will be displayed in the sidebar.', 'chocolat' ); ?></p>
								<?php
									$option_name = 'info_side_text';
									chocolat_textarea( $options, $option_name );
								?>
							</td>
						</tr>

						<!-- Contact -->
						<tr id="option-contact" class="option-check">
							<th scope="row"><?php _e( 'Contact', 'chocolat' ); ?></th>
							<td><fieldset>
								<?php
									$option_name = 'show_contact';
									$option_text = __( 'View Contact', 'chocolat' );
									chocolat_checkbox( $options, $option_name, $option_text );
								?>
								<?php if ( is_array( chocolat_contact_options() ) ) :
									foreach ( chocolat_contact_options() as $option ) : ?>
									<div id="contact-<?php echo $option['id']; ?>" class="hidebox">
										<p class="theme-left-space"><?php
											$option_name = 'contact_radio';
											chocolat_radio_input( $options, $option, $option_name );
										?></p>
										<div class="theme-left-space">
										<?php if ( $option['id'] == 'mail' ) : ?>
										<p><?php _e( 'E-mail address that is registered with the general settings are used. Please enter if you want to use the e-mail address of the other.', 'chocolat' ); ?></p><?php
											$option_name = 'mail_url';
											$option_label = __( 'mailto', 'chocolat' ) . __( ':', 'chocolat' ) . '&nbsp;';
											$option_type = 'email';
											chocolat_textfield( $options, $option_name, $option_label, $option_type );

										elseif ( $option['id'] == 'page' ) : ?>
										<p><?php _e( 'URL of the Contact Page', 'chocolat' ); ?></p><?php
											$option_name = 'page_url';
											$option_label = '';
											$option_type = 'url';
											chocolat_textfield( $options, $option_name, $option_label, $option_type );
										endif; ?>
										</div>
									</div>
								<?php endforeach; endif; ?>
							</fieldset></td>
						</tr>

						<!-- RSS -->
						<tr>
							<th scope="row"><?php _e( 'RSS', 'chocolat' ); ?></th>
							<td><fieldset><?php
								$option_name = 'show_rss';
								$option_text = __( 'View RSS', 'chocolat' );
								chocolat_checkbox( $options, $option_name, $option_text );

								$option_name = 'show_feedly';
								$option_text = __( 'View Feedly', 'chocolat' );
								chocolat_checkbox( $options, $option_name, $option_text );
							?></fieldset></td>
						</tr>

						<!-- Social Link -->
						<tr id="option-sociallink" >
							<th scope="row"><?php _e( 'Social Links', 'chocolat' ); ?></th>
							<td><p><?php _e( 'To display the social links, use the "Social Links" of the custom menu.', 'chocolat' ); ?></p>
								<p><?php _e( 'Position to display', 'chocolat' ) . _e( ':', 'chocolat' ); ?><br /><?php _e( 'Displays in a position that is set in the "Position to display" of "Links Setting".', 'chocolat' ); ?>
								</p>
								<p><?php _e( 'A corresponding social links', 'chocolat' ) . _e( ':', 'chocolat' ); ?><br /><?php
									echo __( 'Twitter', 'chocolat' ) . ', ' . 
									__( 'Facebook', 'chocolat' ) . ', ' . 
									__( 'Google+', 'chocolat' ) . ', ' . 
									__( 'Tumblr', 'chocolat' ) . ', ' . 
									__( 'Pinterest', 'chocolat' ) . ', ' . 
									__( 'Instagram', 'chocolat' ) . ', ' . 
									__( 'LinkedIn', 'chocolat' ) . ', ' . 
									__( 'Flickr', 'chocolat' ) . ', ' . 
									__( 'Dribbble', 'chocolat' ) . ', ' . 
									__( 'YouTube', 'chocolat' ) . ', ' . 
									__( 'Vimeo', 'chocolat' ) . ', ' . 
									__( 'GitHub', 'chocolat' ) . ', ' . 
									__( 'Viadeo', 'chocolat' ) . ', ' . 
									__( 'Bloglovin', 'chocolat' ) . ', ' . 
									__( 'pixiv', 'chocolat' );
							?></p></td>
						</tr>

						<!-- Copyright -->
						<tr id="option-copy" class="option-check">
							<th scope="row"><?php _e( 'Copyright', 'chocolat' ); ?></th>
							<td><fieldset>
								<?php
									$option_name = 'show_copyright';
									$option_text = __( 'Display the copyright of Web site', 'chocolat' );
									chocolat_checkbox( $options, $option_name, $option_text );
								?>
								<div class="theme-left-space hidebox">
									<p><?php echo chocolat_get_copyright_text(); ?><br />
									<?php _e( 'It will be displayed.', 'chocolat' ) . _e( 'Please enter if you want to change the text of copyright.', 'chocolat' ); ?></p>
									<?php
										$option_name = 'copyright_text';
										chocolat_textarea( $options, $option_name );
									?>
								</div>
							</fieldset></td>
						</tr>

						<!-- Credit link -->
						<tr id="option-creditlink" class="option-check">
							<th scope="row"><?php _e( 'Credit link', 'chocolat' ); ?></th>
							<td><fieldset>
								<p><?php _e( 'Choose to enable or disable  the credit link of the author of the theme.', 'chocolat' ); ?><br /><span class="description"><?php _e( 'If you display credit link, I am very pleased :)', 'chocolat' ); ?></span></p>
								<p><?php
									$option_array = chocolat_credit_link_options();
									$option_name = 'credit_link_radio';
									chocolat_radio( $options, $option_array, $option_name );
								?></p>
							</fieldset></td>
						</tr>
					</table>
				</div><!-- /panel -->

				<!-- Slider -->
				<div id="panel-slider" class="panel">
					<h3 class="title"><?php echo $tab_title['slider']['title']; ?></h3>
				<p class="panel-caption"><?php _e( 'Setting an image to be displayed the slider.', 'chocolat' ); ?><br /><?php _e( 'Please use the image of the same size.', 'chocolat' ); ?><?php printf( __( 'Recommended files %s', 'chocolat' ), __( '.png and .jpg (width 980px)', 'chocolat') ); ?></p>

				<?php if ( function_exists( 'wp_enqueue_media' ) ) : ?>
				<table class="form-table">
					<tr>
						<th scope="row"><?php _e( 'Slider Setting', 'chocolat' ); ?></th>
						<td id="option-slider" class="option-check"><?php
							$option_name = 'show_slider';
							$option_text = __( 'Use the slider to the header image', 'chocolat' );
							chocolat_checkbox( $options, $option_name, $option_text );
						?></td>
					</tr>

					<tr id="option-slider-color" class="option-slider-children">
						<th scope="row"><?php _e( 'The color of the slider', 'chocolat' ); ?></th>
						<td><fieldset><?php
							$option_array = chocolat_slider_color_options();
							$option_name = 'slider_color';
							chocolat_radio( $options, $option_array, $option_name );
						?></fieldset></td>
					</tr>
<?php
					// Make sure that it will work with the media uploader
					if ( is_array( chocolat_upload_slider_image_options() ) ) :
						foreach ( chocolat_upload_slider_image_options() as $option ) :
							$option_id = $option['id'];
							$option_name = $option_id.'_url';
							?><tr id="<?php echo esc_attr( $option_id ); ?>" class="option-slider-children">
						<th scope="row"><?php echo $option['title']; ?></th>
						<td><fieldset>
							<?php chocolat_media_uploader( $options, $option_id, $option_name ); ?>
						<table class="table-no-space">
							<tr>
								<td><?php _e( 'Caption', 'chocolat' ) . _e( ':', 'chocolat' ); ?></td>
								<td><?php
									$option_name = $option_id.'_caption';
									chocolat_textfield( $options, $option_name );
								?></td>
							</tr>
							<tr>
								<td><?php _e( 'Link URL', 'chocolat' ) . _e( ':', 'chocolat' ); ?></td>
								<td><?php
									$option_name = $option_id.'_link';
									$option_type = 'url';
									chocolat_textfield( $options, $option_name, '' , $option_type );
								?></td>
							</tr>
						</table>
						</fieldset></td>
					</tr><?php endforeach; endif; ?>
				</table>
				<?php else : ?>
				<p><?php _e( 'Sorry, WordPress you are using is not supported. Upgrade your version of WordPress.', 'chocolat' ); ?></p>
				<?php endif; ?>
				</div><!-- /panel -->

				<!-- Custom CSS -->
				<div id="panel-css" class="panel">
					<h3 class="title"><?php echo $tab_title['css']['title']; ?></h3>
					<p class="panel-caption"><?php _e( 'The Custom CSS editor gives you can edit the theme, add or replace your theme\'s CSS.', 'chocolat' ); ?><br /><?php _e( 'This gives syntax coloring, auto-indent feature comes with.', 'chocolat' ); ?></p>
					<table class="form-table">
						<tr><td><?php
							$option_name = 'custom_css';
							$option_cols = 50;
							$option_rows = 3;
							$content = isset( $options['custom_css'] ) && ! empty( $options['custom_css'] ) ? $options['custom_css'] : '/* ' . __( 'Enter Your Custom CSS Here', 'chocolat' ) . ' */';
							chocolat_textarea( $options, $option_name, $option_cols, $option_rows, $content );
						?></td></tr>
					</table>
				</div><!-- /panel -->
			</div><!-- /#tabset -->

			<table id="save-option" class="form-table">
				<tr><td><?php
					$option_name = 'save_chocolat_option';
					$option_text = __( 'Save the value of the option of Chocolat in the database', 'chocolat' );
					$text_desc = __( 'If you want to use the value of the option of Chocolat a child theme, please check the check box.', 'chocolat' );
					chocolat_checkbox( $options, $option_name, $option_text, $text_desc );
				?></td></tr>
			</table>

			<div id="submit-button" class="clearfix">
				<?php submit_button( __( 'Save Changes', 'chocolat' ), 'primary', 'save' ); ?>
				<?php submit_button( __( 'Reset Defaults', 'chocolat' ), 'secondary', 'reset' ); ?>
			</div>

			<!-- Notice Option -->
			<div id="notice-option" class="update-nag clearfix">
				<p class="notice-title"><?php _e( 'If you can not "Save changes" or "reset":', 'chocolat' ); ?><span class="notice-open"><?php _e( 'More detailed', 'chocolat' ); ?></span><span class="notice-close"><?php _e( 'Dismiss this notice', 'chocolat' ); ?></span></p>
				<p class="notice-desc"><?php echo __( 'When WAF setting of the server is enabled, you can not "Save changes" or "reset".', 'chocolat' ) . ' ' . __( 'Please save the settings of Chocolat after you disable the WAF configuration.', 'chocolat' ); ?><br /><?php _e( 'Once you have save the settings of Chocolat, for security, please reenable the WAF setting.', 'chocolat' ); ?><br /><?php _e( 'Please contact the server administrator for more information.', 'chocolat' ); ?></p>
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

		if ( ! isset( $input['show_no_comment'] ) )
			$input['show_no_comment'] = null;
		$input['show_no_comment'] = ( $input['show_no_comment'] == 1 ? 1 : 0 );

		if ( ! isset( $input['show_archives_posts'] ) )
			$input['show_archives_posts'] = null;
		$input['show_archives_posts'] = ( $input['show_archives_posts'] == 1 ? 1 : 0 );

		if ( ! isset( $input['show_header_link'] ) )
			$input['show_header_link'] = null;
		$input['show_header_link'] = ( $input['show_header_link'] == 1 ? 1 : 0 );

		if ( ! isset( $input['show_index_comments'] ) )
			$input['show_index_comments'] = null;
		$input['show_index_comments'] = ( $input['show_index_comments'] == 1 ? 1 : 0 );

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

		// Featured Image Settings
		if ( isset( $input['featured_size_w'] ) && $input['featured_size_w'] > 940 )
			$input['featured_size_w'] = 940;
		$input['featured_size_w'] = absint( $input['featured_size_w'] );

		$input['featured_size_h'] = absint( $input['featured_size_h'] );

		if ( ! isset( $input['featured_position'] ) )
			$input['featured_position'] = null;
		if ( ! array_key_exists( $input['featured_position'], chocolat_featured_position_options() ) )
			$input['featured_position'] = null;

		if ( ! isset( $input['featured_sneak'] ) )
			$input['featured_sneak'] = null;
		if ( ! array_key_exists( $input['featured_sneak'], chocolat_featured_sneak_options() ) )
			$input['featured_sneak'] = null;

		if ( ! isset( $input['featured_crop'] ) )
			$input['featured_crop'] = null;
		if ( ! array_key_exists( $input['featured_crop'], chocolat_featured_crop_options() ) )
			$input['featured_crop'] = null;

		if ( ! isset( $input['featured_crop_x'] ) )
			$input['featured_crop_x'] = null;
		if ( ! array_key_exists( $input['featured_crop_x'], chocolat_position_x_options() ) )
			$input['featured_crop_x'] = null;

		if ( ! isset( $input['featured_crop_y'] ) )
			$input['featured_crop_y'] = null;
		if ( ! array_key_exists( $input['featured_crop_y'], chocolat_position_y_options() ) )
			$input['featured_crop_y'] = null;

		// Home Page Featured Image Settings
		if ( ! isset( $input['show_featured_home'] ) )
			$input['show_featured_home'] = null;
		$input['show_featured_home'] = ( $input['show_featured_home'] == 1 ? 1 : 0 );

		if ( isset( $input['featured_home_size_w'] ) && $input['featured_home_size_w'] > 940 )
			$input['featured_home_size_w'] = 940;
		$input['featured_home_size_w'] = absint( $input['featured_home_size_w'] );

		$input['featured_home_size_h'] = absint( $input['featured_home_size_h'] );

		if ( ! isset( $input['featured_home_position'] ) )
			$input['featured_home_position'] = null;
		if ( ! array_key_exists( $input['featured_home_position'], chocolat_featured_position_options() ) )
			$input['featured_home_position'] = null;

		if ( ! isset( $input['featured_home_sneak'] ) )
			$input['featured_home_sneak'] = null;
		if ( ! array_key_exists( $input['featured_home_sneak'], chocolat_featured_sneak_options() ) )
			$input['featured_home_sneak'] = null;

		if ( ! isset( $input['featured_home_crop'] ) )
			$input['featured_home_crop'] = null;
		if ( ! array_key_exists( $input['featured_home_crop'], chocolat_featured_crop_options() ) )
			$input['featured_home_crop'] = null;

		if ( ! isset( $input['featured_home_crop_x'] ) )
			$input['featured_home_crop_x'] = null;
		if ( ! array_key_exists( $input['featured_home_crop_x'], chocolat_position_x_options() ) )
			$input['featured_home_crop_x'] = null;

		if ( ! isset( $input['featured_home_crop_y'] ) )
			$input['featured_home_crop_y'] = null;
		if ( ! array_key_exists( $input['featured_home_crop_y'], chocolat_position_y_options() ) )
			$input['featured_home_crop_y'] = null;

		// Thumbnail Image Settings
		if ( ! isset( $input['thumbnail_crop_x'] ) )
			$input['thumbnail_crop_x'] = null;
		if ( ! array_key_exists( $input['thumbnail_crop_x'], chocolat_position_x_options() ) )
			$input['thumbnail_crop_x'] = null;

		if ( ! isset( $input['thumbnail_crop_y'] ) )
			$input['thumbnail_crop_y'] = null;
		if ( ! array_key_exists( $input['thumbnail_crop_y'], chocolat_position_y_options() ) )
			$input['thumbnail_crop_y'] = null;

		// Related Posts
		if ( ! isset( $input['show_related'] ) )
			$input['show_related'] = null;
		$input['show_related'] = ( $input['show_related'] == 1 ? 1 : 0 );

		$input['related_title'] = sanitize_text_field( $input['related_title'] );

		if ( $input['related_number'] > 5 ) {
			$input['related_row'] = absint( ceil( $input['related_number'] / 5 ) );
			$input['related_number'] = 5;
		}
		$input['related_number'] = absint( $input['related_number'] );

		if ( $input['related_row'] < 1 )
			$input['related_row'] = 2;
		$input['related_row'] = absint( $input['related_row'] );

		if ( ! array_key_exists( $input['related_order_select'], chocolat_related_order_options() ) )
			$input['related_order_select'] = null;

		if ( ! array_key_exists( $input['related_class_select'], chocolat_related_class_options() ) )
			$input['related_class_select'] = null;

		// New Posts
		if ( ! isset( $input['show_new_posts'] ) )
			$input['show_new_posts'] = null;
		$input['show_new_posts'] = ( $input['show_new_posts'] == 1 ? 1 : 0 );

		$input['new_posts_title'] = sanitize_text_field( $input['new_posts_title'] );

		if ( $input['new_posts_number'] > 5 ) {
			$input['new_posts_row'] = absint( ceil( $input['new_posts_number'] / 5 ) );
			$input['new_posts_number'] = 5;
		}
		$input['new_posts_number'] = absint( $input['new_posts_number'] );

		if ( $input['new_posts_row'] < 1 )
			$input['new_posts_row'] = 2;
		$input['new_posts_row'] = absint( $input['new_posts_row'] );

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

		// slider
		if ( ! isset( $input['show_slider'] ) )
			$input['show_slider'] = null;
		$input['show_slider'] = ( $input['show_slider'] == 1 ? 1 : 0 );

		if ( ! isset( $input['slider_color'] ) )
			$input['slider_color'] = null;
		if ( ! array_key_exists( $input['slider_color'], chocolat_slider_color_options() ) )
			$input['slider_color'] = null;

		$input['slider_image01_url'] = esc_url_raw( $input['slider_image01_url'] );
		$input['slider_image02_url'] = esc_url_raw( $input['slider_image02_url'] );
		$input['slider_image03_url'] = esc_url_raw( $input['slider_image03_url'] );
		$input['slider_image04_url'] = esc_url_raw( $input['slider_image04_url'] );
		$input['slider_image05_url'] = esc_url_raw( $input['slider_image05_url'] );

		$input['slider_image01_caption'] = sanitize_text_field( $input['slider_image01_caption'] );
		$input['slider_image02_caption'] = sanitize_text_field( $input['slider_image02_caption'] );
		$input['slider_image03_caption'] = sanitize_text_field( $input['slider_image03_caption'] );
		$input['slider_image04_caption'] = sanitize_text_field( $input['slider_image04_caption'] );
		$input['slider_image05_caption'] = sanitize_text_field( $input['slider_image05_caption'] );

		$input['slider_image01_link'] = esc_url_raw( $input['slider_image01_link'] );
		$input['slider_image02_link'] = esc_url_raw( $input['slider_image02_link'] );
		$input['slider_image03_link'] = esc_url_raw( $input['slider_image03_link'] );
		$input['slider_image04_link'] = esc_url_raw( $input['slider_image04_link'] );
		$input['slider_image05_link'] = esc_url_raw( $input['slider_image05_link'] );

		// Custom Css
		$input['custom_css'] = wp_kses_stripslashes( $input['custom_css'] );

		// save Chocolat option value ( child theme )
		if ( ! isset( $input['save_chocolat_option'] ) )
			$input['save_chocolat_option'] = null;
		$input['save_chocolat_option'] = ( $input['save_chocolat_option'] == 1 ? 1 : 0 );
	}
	return $input;
}