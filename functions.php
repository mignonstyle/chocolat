<?php
/**
 * The functions and definitions
 * @package   Chocolat
 * @copyright Copyright (c) 2014 Mignon Style
 * @license   GNU General Public License v2.0
 * @since     Chocolat 1.0
 */

/* ----------------------------------------------
 * 1.0 - contents width
 * Set the contents width.
 * --------------------------------------------*/

if ( ! isset( $content_width ) ) {
	$content_width = 980;
}

// Size of the video
if ( ! function_exists( 'chocolat_content_width' ) ) :
function chocolat_content_width() {
	global $content_width;

	if ( is_home() || is_archive() || has_post_format( 'video' ) ) {
		$content_width = 620;
		if ( chocolat_is_mobile() ) {
			$content_width = 276;
		} else {
			$content_width = 620;
		}
	}
}
endif;
add_action( 'template_redirect', 'chocolat_content_width' );

/* ----------------------------------------------
 * 1.1 - I18n of style.css the Description
 * This function is used to I18n the Description of style.css of the theme
 * There is no sense to return
 * --------------------------------------------*/

function chocolat_theme_description() {
	$theme_description = __( 'Chocolat is a simple WordPress theme for the blog. Use the Responsive layout of CSS media queries, and automatically respond to tablets and smartphones. Equipped with its own widget, it is also possible to display ads easily in the widget. By theme options, display related posts, new articles you can easily.', 'chocolat' );
	return $theme_description;
}

/* ----------------------------------------------
 * 1.2 - Smartphone user agent
 * Exclude tablet from is_mobile().
 * --------------------------------------------*/

if ( ! function_exists( 'chocolat_is_mobile' ) ) :
function chocolat_is_mobile() {
	$ua = $_SERVER['HTTP_USER_AGENT'];
	$_ret = true;

	if ( wp_is_mobile() ) {
		if ( preg_match( '/ipad/i', $ua ) ) {
			$_ret = false;
		} elseif ( preg_match( '/Android/i', $ua ) && !( preg_match( '/Mobile/i', $ua ) ) ) {
			$_ret = false;
		}
	} else {
		$_ret = false;
	}
	return $_ret;
}
endif;

/* ----------------------------------------------
 * 2.1.0 - Set up
 * 2.1.0.1 - Reading of the language file
 * 2.1.0.2 - Theme Options file
 * 2.1.1 - post-thumbnails
 * 2.1.2 - menus (custom menu)
 * 2.1.3 - editor-style
 * 2.1.4 - custom-header
 * 2.1.5 - custom-background
 * 2.1.6 - automatic-feed-links
 * 2.1.7 - post-formats
 * 2.1.8 - html5
 * 2.1.9 - gallery styles
 * 2.1.10- title-tag
 * --------------------------------------------*/

/* ----------------------------------------------
 * 2.1.0 - Set up
 * --------------------------------------------*/

if ( ! function_exists( 'chocolat_setup' ) ) :
function chocolat_setup() {
	// 2.1.0.1 - Reading of the language file
	load_theme_textdomain( 'chocolat', get_template_directory() . '/languages' );

	// 2.1.0.2 - Theme Options file
	require_once( get_template_directory() . '/admin/theme-options.php' );
	$options = chocolat_get_option();

	// 2.1.0.3 - Include file
	require_once( get_template_directory() . '/admin/inc/custom-css.php' );

	// 2.1.0.4 - TGM Plugin Activation
	if ( current_user_can( 'edit_theme_options' ) ) {
		require_once( get_template_directory() . '/admin/inc/tgm-plugin-installer.php' );
	}

	// 2.1.1 - post-thumbnails
	add_theme_support( 'post-thumbnails' );

	// 2.1.1.0 - thumbnail image
	$thumbnail_crop_x = ( ! empty( $options['thumbnail_crop_x'] ) ) ? esc_attr( $options['thumbnail_crop_x'] ) : 'center';
	$thumbnail_crop_y = ( ! empty( $options['thumbnail_crop_y'] ) ) ? esc_attr( $options['thumbnail_crop_y'] ) : 'center';
	set_post_thumbnail_size( 300, 300, array( $thumbnail_crop_x, $thumbnail_crop_y ) );

	// 2.1.1.1 - Registers a new image size (post_thumbnails, single-post-thumbnail)
	$featured_size_w = ( ! empty( $options['featured_size_w'] ) ) ? absint( $options['featured_size_w'] ) : 700;
	$featured_size_h = ( ! empty( $options['featured_size_h'] ) ) ? absint( $options['featured_size_h'] ) : 350;
	$featured_crop = true;

	if ( ! empty( $options['featured_crop'] ) ) {
		if ( $options['featured_crop'] == 'crop' ) {
			$featured_crop_x = ( ! empty( $options['featured_crop_x'] ) ) ? esc_attr( $options['featured_crop_x'] ) : 'center';
			$featured_crop_y = ( ! empty( $options['featured_crop_y'] ) ) ? esc_attr( $options['featured_crop_y'] ) : 'center';
			$featured_crop = array( $featured_crop_x, $featured_crop_y );
		} else {
			$featured_crop = false;
		}
	}

	// 2.1.1.2 - Changed the name to "single-post-thumbnail" from "post_thumbnail"
	add_image_size( 'post_thumbnail', $featured_size_w, $featured_size_h, $featured_crop );
	add_image_size( 'single-post-thumbnail', $featured_size_w, $featured_size_h, $featured_crop );

	// 2.1.1.3 - Registers a new image size of home page (home-post-thumbnail)
	if ( ! empty( $options['show_featured_home'] ) ) {
		$featured_home_size_w = ( ! empty( $options['featured_home_size_w'] ) ) ? absint( $options['featured_home_size_w'] ) : 700;
		$featured_home_size_h = ( ! empty( $options['featured_home_size_h'] ) ) ? absint( $options['featured_home_size_h'] ) : 350;
		$featured_home_crop = true;

		if ( ! empty( $options['featured_home_crop'] ) ) {
			if ( $options['featured_home_crop'] == 'crop' ) {
				$featured_home_crop_x = ( ! empty( $options['featured_home_crop_x'] ) ) ? esc_attr( $options['featured_home_crop_x'] ) : 'center';
				$featured_home_crop_y = ( ! empty( $options['featured_home_crop_y'] ) ) ? esc_attr( $options['featured_home_crop_y'] ) : 'center';
				$featured_home_crop = array( $featured_home_crop_x, $featured_home_crop_y );
			} else {
				$featured_home_crop = false;
			}
		}

		add_image_size( 'home-post-thumbnail', $featured_home_size_w, $featured_home_size_h, $featured_home_crop );
	}

	// 2.1.2 - menus (custom menu)
	register_nav_menus( array(
		'globalnav'   => __( 'Global Navigation', 'chocolat' ),
		'sociallinks' => __( 'Social Links', 'chocolat' ),
	) );

	// 2.1.3 - editor-style
	add_editor_style( 'css/editor-style.css' );

	// 2.1.4 - custom header
	$args = array(
		'default-image'      => '%s/img/headers/header-leaves.jpg',
		'random-default'     => true,
		'width'              => 980,
		'height'             => 350,
		'flex-height'        => true,
		'flex-width'         => true,
		'default-text-color' => '333333',
		'header-text'        => false,
		'uploads'            => true,
	);
	add_theme_support( 'custom-header', $args );

	// Default custom headers
	register_default_headers( array(
		'leaves' => array(
			'url'           => '%s/img/headers/header-leaves.jpg',
			'thumbnail_url' => '%s/img/headers/header-leaves-s.jpg',
			'description'   => __( 'leaves', 'chocolat' ),
		),

		'cutlery' => array(
			'url'           => '%s/img/headers/header-cutlery.jpg',
			'thumbnail_url' => '%s/img/headers/header-cutlery-s.jpg',
			'description'   => __( 'cutlery', 'chocolat' ),
		),

		'rose' => array(
			'url'           => '%s/img/headers/header-rose.jpg',
			'thumbnail_url' => '%s/img/headers/header-rose-s.jpg',
			'description'   => __( 'rose', 'chocolat' ),
		),

		'bird' => array(
			'url'           => '%s/img/headers/header-bird.jpg',
			'thumbnail_url' => '%s/img/headers/header-bird-s.jpg',
			'description'   => __( 'bird', 'chocolat' ),
		),
	) );

	// 2.1.5 - custom-background
	$defaults = array(
		'default-color' => 'f9f6ed',
		'default-image' => '%s/img/base/bg_body.png',
	);
	add_theme_support( 'custom-background', $defaults );

	// 2.1.6 - automatic-feed-links
	add_theme_support( 'automatic-feed-links' );

	// 2.1.7 - post-formats
	add_theme_support( 'post-formats', array(
		'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video'
	) );

	// 2.1.8 - html5
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form' ) );

	// 2.1.9 - This theme uses its own gallery styles.
	add_filter( 'use_default_gallery_style', '__return_false' );

	// 2.1.10 - title-tag
	add_theme_support( 'title-tag' );
}
endif;
add_action( 'after_setup_theme', 'chocolat_setup' );

/* ----------------------------------------------
 * 2.1.1 - post-thumbnails
 * Image size square
 * --------------------------------------------*/

if ( ! function_exists( 'chocolat_post_thumbnail' ) ) :
function chocolat_post_thumbnail() {
	$img_size = 300;
	if ( has_post_thumbnail() ) {
		the_post_thumbnail( 'thumbnail', array( 'alt' => the_title_attribute( 'echo=0' ) ) );
	} else {
		global $post;
		$str = $post->post_content;
		$searchPattern = '/<img.*?src=(["\'])(.+?)\1.*?>/i';
		$noimage_url = get_template_directory_uri() .'/img/common/thumbnail.png';
		$img_class = '';

		if ( preg_match( $searchPattern, $str, $imgurl ) ) {
			$noimage_url = $imgurl[2];
			$img_class = ' no-thumbnail-image';
		} else {
			$options = chocolat_get_option();
			if ( ! empty( $options['no_image_url'] ) ) {
				$noimage_url = $options['no_image_url'];
			}
		}
		echo '<img src="'.esc_url( $noimage_url ).'" class="attachment-thumbnail wp-post-image'.esc_attr( $img_class ).'" alt="'.the_title_attribute( 'echo=0' ).'" width="'.absint( $img_size ).'" height="'.absint( $img_size ).'" />';
	}
}
endif;

/* ----------------------------------------------
 * 2.1.2 - menus (custom menu)
 * --------------------------------------------*/

// When the navigation is not registered,
// it displays a menu on the top page
if ( ! function_exists( 'chocolat_page_menu_args' ) ) :
function chocolat_page_menu_args( $args ) {
	$args['show_home'] = __( 'Home', 'chocolat' );
	return $args;
}
endif;
add_filter( 'wp_page_menu_args', 'chocolat_page_menu_args' );

/* ----------------------------------------------
 * 2.1.3 - editor-style
 * --------------------------------------------*/

if ( ! function_exists( 'chocolat_editor_settings' ) ) :
function chocolat_editor_settings( $initArray ) {
	$initArray['body_class'] = 'editor-area';
	return $initArray;
}
endif;
add_filter( 'tiny_mce_before_init', 'chocolat_editor_settings' );

/* ----------------------------------------------
 * 2.1.10 - title-tag
 * --------------------------------------------*/

if ( ! function_exists( '_wp_render_title_tag' ) ) :
	function chocolat_render_title() {
	?><title><?php wp_title( '|', true, 'right' ); ?></title>
<?php
	}
	add_action( 'wp_head', 'chocolat_render_title', 1 );
endif;

/* ----------------------------------------------
 * 2.2 - widgets
 * --------------------------------------------*/

if ( ! function_exists( 'chocolat_widgets_init' ) ) :
function chocolat_widgets_init() {
	$my_before_widget = '<nav id="%1$s" class="widget %2$s clearfix">'."\n";
	$my_before_widget_1 = '<nav id="%1$s" class="widget ';
	$my_before_widget_2 = ' %2$s clearfix">'."\n";

	$my_after_widget = '</nav>'."\n";
	$my_before_title = '<h3 class="widget-title">';
	$my_after_title = '</h3>'."\n";

	register_sidebar( array(
		'name'          => __( 'Sidebar Widget', 'chocolat' ),
		'id'            => 'sidebar_widget',
		'description'   => __( 'Widgets in this area will be shown at the position that has been set for "Sidebar settings" of theme options (right-hand or left-hand side).', 'chocolat' ),
		'before_widget' => $my_before_widget_1.'sidebar-widget widget-common'.$my_before_widget_2,
		'after_widget'  => $my_after_widget,
		'before_title'  => '<div class="widget-top"><h3 class="widget-title icon-crown">',
		'after_title'   => '</h3></div>'."\n",
	) );

	register_sidebar( array(
		'name'          => __( 'AdSense Small', 'chocolat' ),
		'id'            => 'ad_small',
		'description'   => __( 'Widgets in this area will be shown at the top of the sidebar widget.', 'chocolat' ),
		'before_widget' => $my_before_widget_1.'ad-small widget-adsense'.$my_before_widget_2,
		'after_widget'  => $my_after_widget,
		'before_title'  => $my_before_title,
		'after_title'   => $my_after_title,
	) );

	register_sidebar( array(
		'name'          => __( 'AdSense Medium', 'chocolat' ),
		'id'            => 'ad_medium',
		'description'   => __( 'Widgets in this area will be shown after posts of single post page.', 'chocolat' ),
		'before_widget' => $my_before_widget_1.'ad-medium widget-adsense'.$my_before_widget_2,
		'after_widget'  => $my_after_widget,
		'before_title'  => $my_before_title,
		'after_title'   => $my_after_title,
	) );

	register_sidebar( array(
		'name'          => __( 'AdSense Large', 'chocolat' ),
		'id'            => 'ad_large',
		'description'   => __( 'Widgets in this area will be shown between the footer and sidebar.', 'chocolat' ),
		'before_widget' => $my_before_widget_1.'ad-large widget-adsense'.$my_before_widget_2,
		'after_widget'  => $my_after_widget,
		'before_title'  => $my_before_title,
		'after_title'   => $my_after_title,
	) );

	register_sidebar( array(
		'name'          => __( 'Ad Banner', 'chocolat' ),
		'id'            => 'ad_banner',
		'description'   => __( 'Widgets in this area will be shown at the bottom of the sidebar widget.', 'chocolat' ),
		'before_widget' => $my_before_widget_1.'ad-banner widget-adsense'.$my_before_widget_2,
		'after_widget'  => $my_after_widget,
		'before_title'  => $my_before_title,
		'after_title'   => $my_after_title,
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Widget', 'chocolat' ),
		'id'            => 'footer_widget',
		'description'   => __( 'Widgets in this area will be shown in the footer.', 'chocolat' ),
		'before_widget' => $my_before_widget_1.'footer-widget widget-common'.$my_before_widget_2,
		'after_widget'  => $my_after_widget,
		'before_title'  => '<div class="widget-top"><h3 class="widget-title icon-crown">',
		'after_title'   => '</h3></div>'."\n",
	) );
}
endif;
add_action( 'widgets_init', 'chocolat_widgets_init' );

//-----------------------------------------------
// adsense widgets
if ( ! function_exists( 'chocolat_ad_widget_medium' ) ) :
function chocolat_ad_widget_medium() {
	if ( is_single() && !is_attachment() ) {
		if ( is_active_sidebar( 'ad_medium' ) ) {
			if ( chocolat_is_mobile() ) {
				if ( is_active_sidebar( 'ad_small' ) ) {
					echo '<div class="content-adsense">';
					dynamic_sidebar( 'ad_small' );
					echo '</div>'."\n";
				}
			} else {
				echo '<div class="content-adsense">';
				dynamic_sidebar( 'ad_medium' );
				echo '</div>'."\n";
			}
		}
	}
}
endif;

//-----------------------------------------------
// adsense widgets
if ( ! function_exists( 'chocolat_ad_widget_medium_bottom' ) ) :
function chocolat_ad_widget_medium_bottom( $pos ) {
	if ( is_single() && !is_attachment() ) {
		if ( is_active_sidebar( 'ad_medium' ) && ! is_active_sidebar( 'ad_large' ) ) {
			if ( chocolat_is_mobile() ) {
				if ( is_active_sidebar( 'ad_small' ) && ( $pos == 'bottom' ) ) {
					echo '<div class="content-adsense content-adsense-bottom">';
					dynamic_sidebar( 'ad_small' );
					echo '</div>'."\n";
				}
			} else {
				if ( is_active_sidebar( 'ad_medium' ) && ( $pos == 'center' ) ) {
					echo '<div class="content-adsense">';
					dynamic_sidebar( 'ad_medium' );
					echo '</div>'."\n";
				}
			}
		}
	}
}
endif;

/* ----------------------------------------------
 * 2.3 - comment form
 * --------------------------------------------*/

/* ----------------------------------------------
 * 2.3.1 - comments number
 * --------------------------------------------*/

if ( ! function_exists( 'chocolat_get_comments_only_number' ) ) :
function chocolat_get_comments_only_number() {
	global $id;
	$comment_cnt = 0;
	$comments = get_approved_comments( $id );
	foreach ( $comments as $comment ) {
		if ( $comment->comment_type === '' ) {
			$comment_cnt++;
		}
	}
	return $comment_cnt;
}
endif;

/* ----------------------------------------------
 * 2.3.2 - pings (trackback + pingback) number
 * --------------------------------------------*/

if ( ! function_exists( 'chocolat_get_pings_only_number' ) ) :
function chocolat_get_pings_only_number() {
	$trackback_cnt = get_comments_number() - chocolat_get_comments_only_number();
	return $trackback_cnt;
}
endif;

/* ----------------------------------------------
 * 2.3.3 - comment
 * --------------------------------------------*/

if ( ! function_exists( 'chocolat_theme_comment' ) ) :
function chocolat_theme_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	$no_avatars = '';
	if ( ! get_avatar( $comment ) ) {
		$no_avatars = 'no-avatars';
	}
?>
	<li <?php comment_class( $no_avatars ); ?>>
	<article id="comment-<?php comment_ID(); ?>" class="comment-body clearfix">
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<p class="comment-awaiting-moderation"><?php _e( 'This comment is awaiting moderation.', 'chocolat' ) ?></p>
		<?php else : ?>
		<div class="comment-author-img"><?php echo get_avatar( $comment, $size='50' ); ?></div>

		<div class="comment-center">
			<div class="comment-author-data">
				<span class="comment-author"><?php comment_author_url_link( comment_author_link() , '', '' ); ?><span class="says">says:</span></span>

				<span class="reply"><?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'chocolat' ), 'depth' => $depth, 'max_depth' => $args['max_depth']) ) ); ?></span>
				<?php edit_comment_link( __( 'Edit', 'chocolat' ), '<span class="edit-link">', '</span>' ); ?>
			</div>

			<div class="comment-content">
				<?php comment_text(); ?>
			</div>

			<div class="comment-meta commentmetadata">
				<div class="comment-metadata"><?php comment_date(); ?>&nbsp;<?php comment_time(); ?></div>
			</div>
		</div>
		<?php endif; ?>
	</article>
<?php
}
endif;

/* ----------------------------------------------
 * 2.3.4 - pings (trackback + pingback)
 * --------------------------------------------*/

if ( ! function_exists( 'chocolat_theme_ping' ) ) :
function chocolat_theme_ping() {
	global $comments, $comment, $post;

	$my_order = 'DESC';
	if ( get_option( 'comment_order' ) == 'asc' )
		$my_order = 'ASC';

	$my_comments = get_comments( array(
		'number'      => '',
		'status'      => 'approve',
		'post_status' => 'publish',
		'post_id'     => $post->ID,
		'order'       => $my_order,
	) );

	$pings_number = chocolat_get_pings_only_number();
?>
<div id="pings" class="comments-inner pings-inner common-contents clearfix">
	<h3 id="pings-title" class="common-title"><?php printf( __( 'Trackback %d', 'chocolat' ), absint( $pings_number ) ); ?></h3>
	<ol class="comment-list">
	<?php foreach ( $my_comments as $comment ) : ?>
		<?php if ( get_comment_type() != 'comment' ) : ?>
		<li <?php comment_class(); ?>>
		<article id="comment-<?php comment_ID(); ?>" class="comment-body clearfix">
			<div class="comment-center">
				<div class="comment-author-data"><span class="comment-author"><?php comment_author_url_link( comment_author_link() , '', '' ); ?></span>
					<?php edit_comment_link( __( 'Edit', 'chocolat' ), '<span class="edit-link">', '</span>' ); ?>
				</div>

				<div class="comment-meta commentmetadata">
					<div class="comment-metadata"><?php comment_date(); ?>&nbsp;<?php comment_time(); ?></div>
				</div>
			</div>
		</article>
		</li>
		<?php endif; ?>
	<?php endforeach; ?>
	</ol><!-- /comment-list -->
</div><!-- /comments-inner -->
<?php
}
endif;

/* ----------------------------------------------
 * 2.3.5 - no comments
 * --------------------------------------------*/

if ( ! function_exists( 'chocolat_no_comment' ) ) :
function chocolat_no_comment() {
	$options = chocolat_get_option();
	if ( ! empty( $options['show_no_comment'] ) ) {
?>
	<div class="no-comments common-contents clearfix">
		<p><?php _e( 'Comments are closed.', 'chocolat' ); ?></p>
	</div>
<?php
	}
}
endif;

/* ----------------------------------------------
 * 2.4 - Read More
 * --------------------------------------------*/

/* ----------------------------------------------
 * 2.4.1 - add more link p class
 * --------------------------------------------*/

if ( ! function_exists( 'chocolat_content_more_link' ) ) :
function chocolat_content_more_link( $output, $more_link_text ) {
	global $post;

	$target_text = array( '&lt;', '&gt;' );
	$replace_text = array( '<', '>' );
	$more_link_text = str_replace( $target_text , $replace_text , $more_link_text );

	return '<p class="more-link rollover"><a href="'.get_permalink().'#more-'.$post->ID.'" class="more-link">'.$more_link_text.'</a></p>';
}
endif;
add_filter( 'the_content_more_link', 'chocolat_content_more_link', 10, 2 );

/* ----------------------------------------------
 * 2.4.2 - Specify the number of characters
 *         in the excerpt
 * --------------------------------------------*/

if ( ! function_exists( 'chocolat_excerpt_length' ) ) :
function chocolat_excerpt_length( $length ) {
	$options = chocolat_get_option();
	// If the value is 0, use the value of the default
	$length = ( ! empty( $options['excerpt_number'] ) ) ? absint( $options['excerpt_number'] ) : $length;
	return $length;
}
if ( strtoupper( get_locale() ) == 'JA' ) {
	add_filter( 'excerpt_mblength', 'chocolat_excerpt_length' );
} else {
	add_filter( 'excerpt_length', 'chocolat_excerpt_length' );
}
endif;

/* ----------------------------------------------
 * 2.4.3 - Change the last character of
 *         the excerpt [...]
 * --------------------------------------------*/

if ( ! function_exists( 'chocolat_excerpt_more' ) ) :
function chocolat_excerpt_more( $more ) {
	return '&nbsp;&hellip;';
}
endif;
add_filter( 'excerpt_more', 'chocolat_excerpt_more' );

/* ----------------------------------------------
 * 2.4.4 - Read More (the_excerpt or the_content )
 * --------------------------------------------*/

if ( ! function_exists( 'chocolat_excerpt_content' ) ) :
function chocolat_excerpt_content() {
	$options = chocolat_get_option();
	echo '<div class="entry-summary">';

	if ( ! empty( $options['read_more_radio'] ) && $options['read_more_radio'] == 'more_quicktag' ) {
		$more_link_text = $options['moretag_text'] ? esc_attr( $options['moretag_text'] ) : sprintf( __( 'READ%sMORE', 'chocolat' ), '<br />' );
		$strip_teaser = false;

		if ( empty( $options['show_more_link'] ) ) {
			$more_link_text ='';
			$strip_teaser = true;
		}
		the_content( $more_link_text, $strip_teaser, '' );
	} else {
		echo '<div class="clearfix">'.get_the_excerpt().'</div>';
		echo '<p class="more-link rollover"><a href="'.get_permalink().'">'.sprintf( __( 'READ%sPOST', 'chocolat' ), '<br />' ).'</a></p>';
	}
	echo '</div>';
}
endif;

/* ----------------------------------------------
 * 3.1 - page title
 * filter function for wp_title hook
 * --------------------------------------------*/

if ( ! function_exists( 'chocolat_page_title' ) ) :
function chocolat_page_title( $title, $sep = true, $seplocation = 'right' ) {
	global $paged, $page;
	$sep = ' ' . $sep . ' ';

	// page title
	if ( is_search() ) {
		$title = sprintf( __( 'Search Results of " %s "', 'chocolat' ), get_search_query() ).$sep;
	} elseif ( is_date() ) {
		if ( is_year() ) {
			$title = get_the_time( __( 'Y', 'chocolat' ) ).$sep;
		} elseif ( is_month() ) {
			$title = get_the_time( __( 'F Y', 'chocolat' ) ).$sep;
		} elseif ( is_day() ) {
			$title = get_the_time( __( 'F j, Y', 'chocolat' ) ).$sep;
		}
	} elseif ( is_404() ) {
		$title = __( '404 Not found', 'chocolat' ).$sep;
	} else {
		$title = $title;
	}

	// Add the blog name
	$title .= apply_filters( 'chocolat_wp_title_name', get_bloginfo( 'name', 'display' ) );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title_desc = $sep.$site_description;
		$title .= apply_filters( 'chocolat_wp_title_desc', $title_desc );
	}

	// Add a page number if necessary:
	if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
		$title_page = $sep.sprintf( __( 'Page %d', 'chocolat' ), max( $paged, $page) );
		$title .= apply_filters( 'chocolat_wp_title_page', $title_page );
	}

	return $title;
}
endif;
add_filter( 'wp_title', 'chocolat_page_title', 10, 3 );

/* ----------------------------------------------
 * 3.3 - Show page slug to body_class()
 * --------------------------------------------*/

if ( ! function_exists( 'chocolat_body_class' ) ) :
function chocolat_body_class( $classes ) {
	$options = chocolat_get_option();

	if ( ! is_front_page() && ( is_page() || is_single() ) ) {
		$page = get_page( get_the_ID() );
		$classes[] = $page -> post_name;
	}
	if ( chocolat_sidebar() ) {
		$classes[] = 'active-sidebar';
		
		if ( $options['sidebar_radio'] == 'right_sidebar' ) {
			$classes[] = 'right-sidebar';
		
		} elseif ( $options['sidebar_radio'] == 'left_sidebar' ) {
			$classes[] = 'left-sidebar';
		}
	} else {
		$classes[] = 'inactive-sidebar';
	}
	return $classes;
}
endif;
add_filter( 'body_class', 'chocolat_body_class' );

//-----------------------------------------------
//  if ( chocolat_sidebar() )
if ( ! function_exists( 'chocolat_sidebar' ) ) :
function chocolat_sidebar() {
	$options = chocolat_get_option();

	if ( ! empty( $options['sidebar_radio'] ) ) {
		$sidebar = ( $options['sidebar_radio'] == 'right_sidebar' ) || ( $options['sidebar_radio'] == 'left_sidebar' );
		return $sidebar;
	}
}
endif;

/* ----------------------------------------------
 * 3.5 - Adding a class name 
 * --------------------------------------------*/

/* ----------------------------------------------
 * 3.5.1 - Add class to edit_post_link
 * --------------------------------------------*/

if ( ! function_exists( 'chocolat_edit_post_link' ) ) :
function chocolat_edit_post_link( $output ) {
	$output = str_replace( 'class="post-edit-link"', 'class="post-edit-link icon-pencil"', $output );
	return $output;
}
endif;
add_filter( 'edit_post_link', 'chocolat_edit_post_link' );

/* ----------------------------------------------
 * 3.5.2 - Add class to edit_comment_link
 * --------------------------------------------*/

if ( ! function_exists( 'chocolat_edit_comment_link' ) ) :
function chocolat_edit_comment_link( $output ) {
	$output = str_replace( 'class="comment-edit-link"', 'class="comment-edit-link icon-pencil"', $output );
	return $output;
}
endif;
add_filter( 'edit_comment_link', 'chocolat_edit_comment_link' );

/* ----------------------------------------------
 * 3.5.3 - Add class to comment_reply_link
 * --------------------------------------------*/

if ( ! function_exists( 'chocolat_comment_reply_link' ) ) :
function chocolat_comment_reply_link( $output ) {
	if ( get_option( 'comment_registration' ) && ! is_user_logged_in() ) {
		$output = str_replace( 'class="comment-reply-login"', 'class="comment-reply-login icon-comment"', $output );
	} else {
		$output = str_replace( "class='comment-reply-link'", "class='comment-reply-link icon-comment'", $output );
	}
	return $output;
}
endif;
add_filter( 'comment_reply_link', 'chocolat_comment_reply_link' );

/* ----------------------------------------------
 * 3.5.4 - Add class to cancel_comment_reply_link
 * --------------------------------------------*/

if ( ! function_exists( 'chocolat_cancel_comment_reply_link' ) ) :
function chocolat_cancel_comment_reply_link( $output ) {
	$output = str_replace( 'id="cancel-comment-reply-link"', 'id="cancel-comment-reply-link" class="icon-cancel"', $output );
	return $output;
}
endif;
add_filter( 'cancel_comment_reply_link', 'chocolat_cancel_comment_reply_link' );

/* ----------------------------------------------
 * 3.5.5 - Add class to previous_post_link
 * --------------------------------------------*/

if ( ! function_exists( 'chocolat_previous_post_link' ) ) :
function chocolat_previous_post_link( $output ) {
	$search = array( 'rel="prev">', '</a>' );
	$replace = array( 'rel="prev"><p class="prev-btn icon-left"></p><p class="prev-link">', '</p></a>' );
	$output = str_replace( $search, $replace, $output );
	return $output;
}
endif;
add_filter( 'previous_post_link', 'chocolat_previous_post_link' );

/* ----------------------------------------------
 * 3.5.6 - Add class to next_post_link
 * --------------------------------------------*/

if ( ! function_exists( 'chocolat_next_post_link' ) ) :
function chocolat_next_post_link( $output ) {
	$search = array( 'rel="next">', '</a>' );
	$replace = array( 'rel="next"><p class="next-link">', '</p><p class="next-btn icon-right"></p></a>' );
	$output = str_replace( $search, $replace, $output );
	return $output;
}
endif;
add_filter( 'next_post_link', 'chocolat_next_post_link' );

/* ----------------------------------------------
 * 3.5.7 - The removal of the HTML tag title
 * --------------------------------------------*/

if ( ! function_exists( 'chocolat_the_title' ) ) :
function chocolat_the_title( $title ) {
	$title = esc_attr( strip_tags( $title ) );
	return $title;
}
endif;
add_filter( 'the_title', 'chocolat_the_title' );

/* ----------------------------------------------
 * 4.1 - favicon
 * --------------------------------------------*/

if ( ! function_exists( 'chocolat_favicon' ) ) :
function chocolat_favicon() {
	$options = chocolat_get_option();

	if ( ! empty( $options['favicon_url'] ) ) {
		$favicon_url = $options['favicon_url'];
		echo '<link rel="shortcut icon" href="'.esc_url( $favicon_url ).'" type="image/x-icon" />'."\n";
		echo '<link rel="icon" href="'.esc_url( $favicon_url ).'" type="image/x-icon" />'."\n";
	}
}
endif;

/* ----------------------------------------------
 * 4.2 - apple-touch-icon
 * --------------------------------------------*/

if ( ! function_exists( 'chocolat_sp_icon' ) ) :
function chocolat_sp_icon() {
	$options = chocolat_get_option();

	if ( ! empty( $options['sp_icon_url'] ) ) {
		echo '<link rel="apple-touch-icon" href="'.esc_url( $options['sp_icon_url'] ).'" />'."\n";
	}
}
endif;

/* ----------------------------------------------
 * 4.4 - Reading css file
 * --------------------------------------------*/

if ( ! function_exists( 'chocolat_enqueue_styles' ) ) :
function chocolat_enqueue_styles() {
	$options = chocolat_get_option();
	wp_enqueue_style( 'chocolat_style', get_template_directory_uri().'/style.css' );
	wp_enqueue_style( 'chocolat_common', get_template_directory_uri().'/css/common.css' );

	if( mb_ereg( 'MSIE', getenv( 'HTTP_USER_AGENT' ) ) ) {
		wp_enqueue_style( 'chocolat_ie', get_template_directory_uri().'/css/ie.css' );
	}

	wp_enqueue_style( 'chocolat_quicksand', '//fonts.googleapis.com/css?family=Quicksand' );
	wp_enqueue_style( 'chocolat_font', get_template_directory_uri().'/css/font.css' );
	wp_enqueue_style( 'chocolat_boxer', get_template_directory_uri().'/plugin/boxer/jquery.fs.boxer.css' );

	if ( chocolat_is_mobile() ) {
		wp_enqueue_style( 'chocolat_smart', get_template_directory_uri().'/css/smart.css' );
	} else {
		wp_enqueue_style( 'chocolat_pc', get_template_directory_uri().'/css/pc.css' );
	}

	if ( strtoupper( get_locale() ) == 'JA' ) {
		wp_enqueue_style( 'chocolat_ja', get_template_directory_uri().'/css/ja.css' );
	}

	// Child Theme Style
	if ( is_child_theme() ) {
		wp_enqueue_style( 'chocolat_child_style', get_stylesheet_uri() );
	}
}
endif;
add_action( 'wp_enqueue_scripts', 'chocolat_enqueue_styles' );

/* ----------------------------------------------
 * 4.5 - Read the js file
 * --------------------------------------------*/

if ( ! function_exists( 'chocolat_enqueue_scripts' ) ) :
function chocolat_enqueue_scripts() {
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	$options = chocolat_get_option();

	wp_enqueue_script( 'chocolat_watermark', get_template_directory_uri() . '/js/watermark.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'chocolat_navimenu', get_template_directory_uri().'/js/navimenu.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'chocolat_slidenav', get_template_directory_uri().'/js/slidenav.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'chocolat_rollover', get_template_directory_uri().'/js/rollover.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'chocolat_thumbnail_image', get_template_directory_uri().'/js/thumbnail-image.js', array( 'jquery' ), null, true );

	if ( ! empty( $options['show_lightbox'] ) || ! empty( $options['show_image_lightbox'] ) ) {
		wp_enqueue_script( 'chocolat_boxer_min', get_template_directory_uri().'/plugin/boxer/jquery.fs.boxer.min.js', array( 'jquery' ), null, true );
		wp_enqueue_script( 'chocolat_boxer', get_template_directory_uri().'/js/boxer.js', array( 'jquery', 'chocolat_boxer_min' ), null, true );
	}

	if ( ! empty( $options['show_slider'] ) && ! empty( $options['slider_image01_url'] ) && ! empty( $options['slider_image02_url'] ) ) {
		wp_enqueue_script( 'chocolat_flexslider_js', get_template_directory_uri().'/plugin/flexslider/jquery.flexslider-min.js', array( 'jquery' ), null, true );
		wp_enqueue_script( 'chocolat_slider_js', get_template_directory_uri().'/js/slider.js', array( 'jquery', 'chocolat_flexslider_js' ), null, true );
	}

	if ( ! chocolat_is_mobile() ) {
		wp_enqueue_script( 'chocolat_tooltips', get_template_directory_uri().'/js/tooltips.js', array( 'jquery', 'jquery-ui-tooltip' ), null, true );
		wp_enqueue_script( 'chocolat_linkpos', get_template_directory_uri().'/js/linkposition.js', array( 'jquery' ), null, true );

		if ( ! empty( $options['show_widget_masonry'] ) && ( chocolat_sidebar() || is_active_sidebar( 'footer_widget' ) ) ) {
			wp_enqueue_script( 'jquery-masonry' );
			wp_enqueue_script( 'chocolat_masonry_widget', get_template_directory_uri().'/js/masonry-widget.js', array( 'jquery', 'jquery-masonry' ), null, true );
		}
	}

	// script to be read after the masonry
	wp_enqueue_script( 'chocolat_footer_fixed', get_template_directory_uri().'/js/footer-fixed.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'chocolat_pagescroll', get_template_directory_uri().'/js/pagescroll.js', array( 'jquery' ), null, true );

	// Custom style
	if ( chocolat_featured_sneak_js() || chocolat_featured_sneak_home_js() ) {
		wp_enqueue_script( 'chocolat_css_js', get_template_directory_uri().'/js/custom-css.js', array( 'jquery' ), null, true );
		wp_localize_script( 'chocolat_css_js', 'chocolat_script', array(
			// Featured image
			'featured_sneak_js' => chocolat_featured_sneak_js(),
			'featured_size_w'   => $options['featured_size_w'],
			'featured_pos'      => $options['featured_position'],

			// Featured image of home page
			'featured_sneak_home_js' => chocolat_featured_sneak_home_js(),
			'featured_home_size_w'   => $options['featured_home_size_w'],
			'featured_home_pos'      => $options['featured_home_position'],
		) );
	}
}
endif;
add_action( 'wp_enqueue_scripts', 'chocolat_enqueue_scripts' );

/* ----------------------------------------------
 * 5.0 - Copyright
 * --------------------------------------------*/

if ( ! function_exists( 'chocolat_footer_copyright' ) ) :
function chocolat_footer_copyright() {
	$options = chocolat_get_option();
	$footer_copyright = '';

	// Display of copyright
	if ( ! empty( $options['show_copyright'] ) ) {
		$footer_copyright = chocolat_get_copyright_text();

		if ( ! empty( $options['copyright_text'] ) ) {
			$footer_copyright = esc_textarea( $options['copyright_text'] );
		}
	}

	// Display of credit
	if ( ! empty( $options['credit_link_radio'] ) && $options['credit_link_radio'] == 'credit_enable' ) {
		if ( ! empty( $options['show_copyright'] ) ) {
			$footer_copyright .= '&nbsp;';
		}

		$credit_link_url = 'http://mignonstyle.com/';
		$wp_url = 'http://wordpress.org/';

		$credit_link = '<a href="'.esc_url( $credit_link_url ).'" target="_blank">';
		$wp_link = '<a href="'.esc_url( $wp_url ).'" target="_blank">';
		$anchor_after = '</a>';

		$footer_copyright .= sprintf( __( 'Chocolat theme by %1$sMignon Style%2$s.', 'chocolat' ), $credit_link, $anchor_after ).'&nbsp;'.sprintf( __( 'Powered by %1$sWordPress%2$s.', 'chocolat' ), $wp_link, $anchor_after );
	}

	echo $footer_copyright;
}
endif;

// Get the first date of the article
if ( ! function_exists( 'chocolat_copyright_first_date' ) ) :
function chocolat_copyright_first_date() {
	$args = array(
		'numberposts' => 1,
		'orderby'     => 'post_date',
		'order'       => 'ASC',
	);
	$posts = get_posts( $args );

	foreach ( $posts as $post ) {
		$first_date = $post->post_date;
	}

	$first_date = ( ! empty( $first_date ) ) ? mysql2date( 'Y', $first_date, true ) : '';
	return $first_date;
}
endif;

// Get the latest Date of article
if ( ! function_exists( 'chocolat_copyright_last_date' ) ) :
function chocolat_copyright_last_date() {
	$last_date = get_lastpostmodified( 'blog' );
	return mysql2date( 'Y', $last_date, true );
}
endif;

// Notation of copyright
if ( ! function_exists( 'chocolat_get_copyright_text' ) ) :
function chocolat_get_copyright_text() {
	$first_date = chocolat_copyright_first_date();
	$last_date = chocolat_copyright_last_date();
	$copyright_date = $first_date;

	if ( ! empty( $first_date ) && ( $first_date != $last_date ) ) {
		$copyright_date .= '-'.$last_date;
	} else {
		$copyright_date = $last_date;
	}

	$site_anchor = '<a href="'.esc_url( home_url( '/' ) ).'">'.get_bloginfo( 'name' ).'</a>';
	$copyright_text = sprintf( __( 'Copyright &copy; %1$s %2$s All Rights Reserved.', 'chocolat' ), $copyright_date, $site_anchor );

	return $copyright_text;
}
endif;

/* ----------------------------------------------
 * 5.1.1 - site title
 * --------------------------------------------*/

if ( ! function_exists( 'chocolat_site_title' ) ) :
function chocolat_site_title() {
	$site_title = get_bloginfo( 'name' );
	$options = chocolat_get_option();

	if ( ! empty( $options['site_logo_url'] ) ) {
		$site_title = '<img class="logo" src="'.esc_url( $options['site_logo_url'] ).'" alt="">'."\n";
	}
	echo $site_title;
}
endif;

/* ----------------------------------------------
 * 5.1.2 - site description
 * --------------------------------------------*/

// site description (header)
if ( ! function_exists( 'chocolat_site_description' ) ) :
function chocolat_site_description() {
	$options = chocolat_get_option();

	if ( ! empty( $options['show_site_desc'] ) ) {
		echo '<h2 id="site-description">'.get_bloginfo( 'description' ).'</h2>'."\n";
	}
}
endif;

//-----------------------------------------------
// site description (footer)
if ( ! function_exists( 'chocolat_footer_description' ) ) :
function chocolat_footer_description() {
	$options = chocolat_get_option();

	if ( ! empty( $options['show_site_desc'] ) ) {
	echo '<h4 class="footer-description"><a href="'.esc_url( home_url( '/' ) ).'">'.get_bloginfo( 'description' ).'</a></h4>'."\n";
	}
}
endif;

/* ----------------------------------------------
 * 5.1.3 - main image
 * --------------------------------------------*/

if ( ! function_exists( 'chocolat_header_image' ) ) :
function chocolat_header_image() {
	$main_visual = '';
	$header_image_class = '';
	$options = chocolat_get_option();

	// 1. slider
	if ( ! empty( $options['show_slider'] ) && ! empty( $options['slider_image01_url'] ) && ! empty( $options['slider_image02_url'] ) ) {
		$slider_color = ( ! empty( $options['slider_color'] ) && $options['slider_color'] == 'slider_dark' ? ' slider-dark' : '' );
		$header_image_class = ' flexslider clearfix'.$slider_color;
		$main_visual .= '<ul class="slides clearfix">'."\n";

		for ( $count = 1; $count <= 5; $count++ ) {
			$slider_image = 'slider_image0'.$count;
			$slider_caption = $slider_image.'_caption';
			$slider_url = $slider_image.'_url';
			$slider_link = $slider_image.'_link';

			if ( ! empty( $options[$slider_url] ) ) {
				$image_caption = ( ! empty( $options[$slider_caption] ) ) ? $options[$slider_caption] : '';
				$main_visual .= '<li>';
				$main_visual .= ( ! empty( $options[$slider_link] ) ) ? '<span><a href="'.esc_url( $options[$slider_link] ).'">' : '';
				$main_visual .= '<img src="'.$options[$slider_url].'" width="'.get_custom_header() -> width.'" alt="'.esc_attr( $image_caption ).'">';
				$main_visual .= ( ! empty( $options[$slider_link] ) ) ? '</a></span>' : '';
				$main_visual .= ( ! empty( $options[$slider_caption] ) ) ? '<p class="slider-caption">'.esc_attr( $options[$slider_caption] ).'</p>' : '<p class="slider-caption no-caption"></p>';
				$main_visual .= '</li>'."\n";
			}
		}
		$main_visual .= '</ul>';

		echo '<div id="header-image" class="thumbnail'.$header_image_class.'">'."\n";
		echo $main_visual."\n";
		echo '</div>'."\n";
	}
	// 2. custom_header
	elseif ( get_header_image() ) { ?>
		<div id="header-image" class="thumbnail">
			<?php if ( ! empty( $options['show_header_link'] ) )
				echo '<a class="home-link" href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" rel="home">';
			?><img src="<?php header_image(); ?>" height="<?php echo get_custom_header() -> height; ?>" width="<?php echo get_custom_header() -> width; ?>" alt="<?php esc_attr_e( get_bloginfo( 'name', 'display' ) ); ?>" /><?php
			if ( ! empty( $options['show_header_link'] ) )
				echo '</a>'; ?>
		</div>
	<?php }
}
endif;

/* ----------------------------------------------
 * 5.2 - View Last updated 
 * --------------------------------------------*/

if ( ! function_exists( 'chocolat_last_update' ) ) :
function chocolat_last_update() {
	$options = chocolat_get_option();
	if ( ! empty( $options['show_last_date'] ) ) {
		if ( is_singular() && ( get_the_modified_date() != get_the_date() ) ) {
			echo '<div class="last-update">'.__( 'Last updated', 'chocolat' ).' : '.get_the_modified_date().'</div>';
		}
	}
}
endif;

/* ----------------------------------------------
 * 5.3 - entry sticky & date
 * --------------------------------------------*/

if ( ! function_exists( 'chocolat_entry_dates' ) ) :
function chocolat_entry_dates() {
	if (! is_page() ) {
		echo '<div class="entry-dates rollover">'."\n";
		if ( ! is_singular() ) {
			echo '<a href="'.get_permalink().'">';
		}

		if ( is_sticky() && ! is_single() && ! is_paged() ) {
			echo '<p class="entry-sticky icon-crown"><span>'.__( 'Attention', 'chocolat' ).'</span></p>';
		}

		echo '<time class="entry-date updated" datetime="'.get_the_date( 'Y-m-d' ).'">';
		echo '<span class="entry-year">'.get_the_date( 'Y' ).'</span><span class="entry-month">'.get_the_date( 'm/d' ).'</span>';
		echo '</time>';

		if ( ! is_singular() ) {
			echo '</a>'."\n";
		}
		echo '</div>';
	}
}
endif;

/* ----------------------------------------------
 * 5.4 - entry category & tags & author
 * --------------------------------------------*/

if ( ! function_exists( 'chocolat_entry_meta' ) ) :
function chocolat_entry_meta() {
	if ( ! is_page() ) {
		global $wp_query, $post;
		$options = chocolat_get_option();
		$taxonomy_names = '';

		echo '<div class="entry_meta clearfix">'."\n";
		// Categorys or Custom taxonomy
		if ( get_post_type() == 'post' ) {
			$taxonomy_names = 'category';
		} else {
			$taxonomy_names = get_post_taxonomies( $post->ID );
		}
		if ( ! empty( $taxonomy_names ) ) {
			$taxonomy_names = is_array( $taxonomy_names ) ? $taxonomy_names[0] : $taxonomy_names;
			the_terms( $post->ID, $taxonomy_names, '<p class="entry-category icon-folder-open clearfix">', ' | ', '</p>' );
		}
		// Tags
		$tag_list = get_the_tag_list( '', ', ' );
		if ( $tag_list ) {
			echo '<p class="entry-tags icon-tag clearfix">'.$tag_list.'</p>'."\n";
		}
		// show index page comments number
		if ( ! is_singular() &&  ! empty( $options['show_index_comments'] ) ) {
			echo '<p class="comments-number">';
			comments_popup_link( __( 'No Comments', 'chocolat' ), __( '1 Comment', 'chocolat' ), __( '% Comments', 'chocolat' ), 'icon-comment', __( 'Comments Off', 'chocolat' ) );
			echo '</p>';
		}
		// Post author
		if ( ! empty( $options['show_author'] ) && ( ! in_array( get_post_type(), array( 'page', 'attachment' ) ) ) ) {
			echo '<p class="entry-author"><span class="author vcard"><a href="'.get_author_posts_url( get_the_author_meta( 'ID' ) ).'" rel="author" class="icon-pencil fn">'.get_the_author().'</a></span></p>'."\n";
		}
		echo '</div>'."\n";
	}
}
endif;

/* ----------------------------------------------
 * 5.5 - feedly link
 * --------------------------------------------*/

// feedly URL
if ( ! function_exists( 'chocolat_feedly_url' ) ) :
function chocolat_feedly_url() {
	$feedly_href = 'http://cloud.feedly.com/#subscription%2Ffeed%2F'.get_bloginfo('rss2_url');
	return $feedly_href;
}
endif;

/* ----------------------------------------------
 * 5.5.1 - Contact, RSS
 * --------------------------------------------*/

// contact
if ( ! function_exists( 'chocolat_is_contact' ) ) :
function chocolat_is_contact() {
	$options = chocolat_get_option();

	if ( ! empty( $options['show_contact'] ) ) {
		$my_contact = $options['show_contact'];
		return $my_contact;
	}
}
endif;

//-----------------------------------------------
// RSS
if ( ! function_exists( 'chocolat_is_rss' ) ) :
function chocolat_is_rss() {
	$options = chocolat_get_option();

	if ( ! empty( $options['show_rss'] ) || ! empty( $options['show_feedly'] ) ) {
		$my_rss = $options['show_rss'] || $options['show_feedly'];
		return $my_rss;
	}
}
endif;

/* ----------------------------------------------
 * 5.5.2 - Contact, RSS tags
 * --------------------------------------------*/

// RSS
if ( ! function_exists( 'chocolat_rss_link' ) ) :
function chocolat_rss_link() {
	$link_text = '<a href="'.get_bloginfo('rss2_url').'" target="_blank"><span class="icon-rss"></span>'.__( 'RSS', 'chocolat' ).'</a>';
	return $link_text;
}
endif;

//-----------------------------------------------
// feedly
if ( ! function_exists( 'chocolat_feedly_link' ) ) :
function chocolat_feedly_link() {
	$link_text = '<a href="'.esc_url( chocolat_feedly_url() ).'" target="_blank"><span><img src="'.get_template_directory_uri().'/img/common/aicon_feedly.png" alt="follow us in feedly"></span><span class="icon-text"></span>'.__( 'Feedly', 'chocolat' ).'</a>';
	return $link_text;
}
endif;

//-----------------------------------------------
// contact
if ( ! function_exists( 'chocolat_contact_link' ) ) :
function chocolat_contact_link() {
	$options = chocolat_get_option();
	$contact_link = 'mailto:'.antispambot( get_bloginfo( 'admin_email' ) );

	if ( ! empty( $options['contact_radio'] ) && $options['contact_radio'] == 'contact_page' ) {
		if ( ! empty( $options['page_url'] ) ) {
			$contact_link = $options['page_url'];
		}
	} else {
		if ( ! empty( $options['mail_url'] ) ) {
			$link_email = sanitize_email( $options['mail_url'] );
			if ( is_email( $link_email ) ) {
				$contact_link = 'mailto:'.antispambot( $link_email );
			}
		}
	}

	$link_text = '<a href="'.esc_url( $contact_link ).'" target="_blank"><span class="icon-mail"></span>'.__( 'Contact', 'chocolat' ).'</a>';
	return $link_text;
}
endif;

/* ----------------------------------------------
 * 5.5.3 - Contact Links (top, bottom)
 * --------------------------------------------*/

if ( ! function_exists( 'chocolat_contactlink' ) ) :
function chocolat_contactlink( $link_pos ) {
	$options = chocolat_get_option();
	$show_links ='';
	$contactlink_class ='';

	if ( ! empty( $options['show_links_top'] ) && $link_pos == 'contactlink-top' ) {
		if ( chocolat_is_mobile() ) {
			return false;
		}
		$show_links = $options['show_links_top'];
		$contactlink_class = 'contactlink-top';
	} elseif ( $link_pos == 'contactlink-bottom' ) {
		if ( ! empty( $options['show_links_bottom'] ) ) {
			$show_links = $options['show_links_bottom'];
			$contactlink_class = 'contactlink-bottom';
		} elseif ( chocolat_is_mobile() && ! empty( $options['show_links_top'] ) ) {
			$show_links = $options['show_links_top'];
			$contactlink_class = 'contactlink-bottom';
		}
	} else {
		return false;
	}

	if ( $show_links && ( chocolat_is_contact() || chocolat_is_rss() ) ) : ?>
	<div class="<?php echo $contactlink_class; ?> links-aicon clearfix">
		<?php if ( $link_pos == 'contactlink-top' ) {
			chocolat_contactlink_ul( 'contactlink-top' );
		} elseif ( $link_pos == 'contactlink-bottom' ) {
			chocolat_contactlink_ul( 'contactlink-bottom' );
		} ?>
	</div>
	<?php endif;
}
endif;

/* ----------------------------------------------
 * 5.5.4 - Contact Links (sidebar)
 * --------------------------------------------*/

if ( ! function_exists( 'chocolat_contactlink_side' ) ) :
function chocolat_contactlink_side() {
	$options = chocolat_get_option();
	if ( ! empty( $options['info_side_text'] ) || ! empty( $options['show_links_side'] ) && ( chocolat_is_contact() || chocolat_is_rss() ) ) : ?>
	<nav class="widget sidebar-widget contactlink-side links-aicon clearfix">
		<div class="widget-top"><h3 class="widget-title icon-crown"><?php echo $options['links_side_title'] ? esc_attr( $options['links_side_title'] ) : __( 'Information', 'chocolat' ); ?></h3></div>
		<div class="contactlink-side-inner">
			<?php if ( ! empty( $options['info_side_text'] ) ) : ?>
			<div class="contactlink-side-top clearfix">
				<?php echo esc_textarea( $options['info_side_text'] ); ?>
			</div>
			<?php endif; ?>

		<?php if ( ! empty( $options['show_links_side'] ) && ( chocolat_is_contact() || chocolat_is_rss() ) ) : ?>
			<div class="contactlink-side-center clearfix">
				<?php chocolat_contactlink_ul(); ?>
			</div>
		<?php endif; ?>
	</div>
</nav>
<?php endif;
}
endif;

/* ----------------------------------------------
 * 5.5.5 - Contact Links ul
 * --------------------------------------------*/

if ( ! function_exists( 'chocolat_contactlink_ul' ) ) :
function chocolat_contactlink_ul( $link_pos = '' ) {
	$options = chocolat_get_option();

	echo '<ul class="social-links clearfix">'."\n";
	// rss
	if ( ! empty( $options['show_rss'] ) ) {
		$class_text = '';
		if ( ! empty( $link_pos ) ) {
			$class_text = ' tooltip" title="'.__( 'RSS', 'chocolat' );
		}
		echo '<li class="rss'.$class_text.'">'.chocolat_rss_link().'</li>'."\n";
	}

	// feedly
	if ( ! empty( $options['show_feedly'] ) ) {
		$class_text = '';
		if ( ! empty( $link_pos ) ) {
			$class_text = ' tooltip" title="'.__( 'Feedly', 'chocolat' );
		}
		echo '<li class="feedly'.$class_text.'">'.chocolat_feedly_link().'</li>'."\n";
	}

	// social links
	wp_nav_menu( array(
		'theme_location'  => 'sociallinks',
		'container'       =>  false,
		'items_wrap'      => '%3$s',
		'fallback_cb'     => '',
		'link_before'     => '<span class="icon-social"></span>',
		'depth'           => 1,
	) );

	// contact
	if ( ! empty( $options['show_contact'] ) ) {
		$class_text = '';
		if ( ! empty( $link_pos ) ) {
			$class_text = ' tooltip" title="'.__( 'Contact', 'chocolat' );
		}
		echo '<li class="mail'.$class_text.'">'.chocolat_contact_link().'</li>'."\n";
	}
	echo '</ul>'."\n";
}
endif;

/* ----------------------------------------------
 * 5.6 - pagination & prevnext-page
 * --------------------------------------------*/

/* ----------------------------------------------
 * 5.6.1 - pagination
 * --------------------------------------------*/

if ( ! function_exists( 'chocolat_pagination' ) ) :
function chocolat_pagination() {
	global $wp_query, $paged;
	$big = 999999999;

	$pages = $wp_query -> max_num_pages;
	if ( empty( $paged ) ) $paged = 1;

	if ( 1 < $pages ) {
		$mid_size = ( chocolat_is_mobile() ) ? 0 : 3 ;
		echo '<div class="pagination clearfix">'."\n";
		echo paginate_links( array(
			'base'      => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
			'format'    => '?paged=%#%',
			'current'   => max( 1, get_query_var( 'paged' ) ),
			'total'     => $wp_query -> max_num_pages,
			'mid_size'  => $mid_size,
			'prev_text' => '&lsaquo;',
			'next_text' => '&rsaquo;',
			'type'      => 'list'
		) );
		echo '</div>';
	}
}
endif;

/* ----------------------------------------------
 * 5.6.2 - prevnext-page
 * --------------------------------------------*/

if ( ! function_exists( 'chocolat_prevnext' ) ) :
function chocolat_prevnext( $prevnext_area = '' ) {
	if ( is_single() && ! is_attachment() ) {
		if ( get_previous_post() || get_next_post() ) {
			$prevnext_class = '';

			if ( $prevnext_area == 'footer' ) {
				$prevnext_class = ' prevnext-footer';
			}
			?>
			<div class="prevnext-page<?php echo $prevnext_class; ?>">
				<div class="paging clearfix">
					<?php previous_post_link( '<div class="page-prev clearfix">%link</div>' ); ?>
					<?php next_post_link( '<div class="page-new clearfix">%link</div>' ); ?>
				</div>
			</div>
			<?php
		}
	}
}
endif;

/* ----------------------------------------------
 * 5.7 - breadcrumb
 * --------------------------------------------*/

if ( ! function_exists( 'chocolat_breadcrumb' ) ) :
function chocolat_breadcrumb() {
	$options = chocolat_get_option();

	if ( ! empty( $options['show_breadcrumb'] ) ) {
		global $wp_query, $post, $page, $paged;

		$itemtype_url = 'http://data-vocabulary.org/Breadcrumb';
		$itemtype = 'itemscope itemtype="'.esc_url( $itemtype_url ).'"';

		$taxonomy_slug = get_query_var( 'taxonomy' );
		$cpt = get_query_var( 'post_type' );

		if ( !is_front_page() && !is_home() && !is_admin() ) : ?>
			<div class="breadcrumb" <?php echo $itemtype; ?>>
				<ol>
				<li <?php echo $itemtype; ?>><a href="<?php echo esc_url( home_url( '/' ) ); ?>" itemprop="url"><span itemprop="title" class="icon-home"><span class="bread-home"><?php bloginfo( 'name' ); ?></span></span></a></li><li class="breadmark">&gt;</li>

			<?php if ( $taxonomy_slug && is_tax( $taxonomy_slug ) ) :
				$query_tax = get_queried_object();
				$query_tax_parent = $query_tax -> parent;
				$post_types = get_taxonomy( $taxonomy_slug ) -> object_type;
				$cpt = $post_types[0];
			?>
			<li <?php echo $itemtype; ?>><a href="<?php echo get_post_type_archive_link( $cpt ); ?>" itemprop="url"><span itemprop="title"><?php echo esc_html( get_post_type_object( $cpt ) -> label ); ?></span></a></li>
			<li class="breadmark">&gt;</li>
			<?php if ( ! empty( $query_tax_parent ) ) :
				$ancestors = array_reverse( get_ancestors( $query_tax -> term_id, $query_tax -> taxonomy ) );
				foreach( $ancestors as $ancestor ) : ?>
					<li <?php echo $itemtype; ?>><a href="<?php echo get_term_link( $ancestor, $query_tax -> taxonomy ); ?>" itemprop="url"><span itemprop="title"><?php echo esc_html( get_term( $ancestor, $query_tax -> taxonomy ) -> name ); ?></span></a></li>
					<li class="breadmark">&gt;</li>
				<?php endforeach; endif; ?>
			<li><?php echo esc_html( $query_tax -> name ); ?>

			<?php elseif ( $cpt && is_singular( $cpt ) ) :
				$cpt_taxes = get_object_taxonomies( $cpt );

				if ( ! empty( $cpt_taxes ) ) :
					$taxonomy_name = $cpt_taxes[0];
					?>
					<li <?php echo $itemtype; ?>><a href="<?php echo get_post_type_archive_link( $cpt ); ?>" itemprop="url"><span itemprop="title"><?php echo esc_html( get_post_type_object( $cpt ) -> label ); ?></span></a></li>
					<li class="breadmark">&gt;</li>
					<?php
					$taxes = get_the_terms( $post -> ID, $taxonomy_name );
					$count = 0;

					if ( ! empty( $taxes ) ) {
						foreach( $taxes as $tax ) {
							$children = get_term_children( $tax -> term_id, $taxonomy_name ); 

							if ( $children ) {
								if ( $count < count( $children ) ) {
									$count = count( $children );
									$lot_children = $children;
									foreach( $lot_children as $child ) {
										if( is_object_in_term( $post -> ID, $taxonomy_name ) ) {
											$child_tax = get_term( $child, $taxonomy_name );
										}
									}
								}
							} else {
								$child_tax = $tax;
							}
						}
					}

					if( ! empty( $child_tax -> parent ) ) :
						$ancestors = array_reverse( get_ancestors( $child_tax -> term_id, $taxonomy_name ) );

						foreach( $ancestors as $ancestor ) : ?>
							<li <?php echo $itemtype; ?>><a href="<?php echo get_term_link( $ancestor, $taxonomy_name ); ?>" itemprop="url"><span itemprop="title"><?php echo esc_html( get_term( $ancestor, $taxonomy_name ) -> name ); ?></span></a></li>
							<li class="breadmark">&gt;</li>
						<?php endforeach; ?>

						<li <?php echo $itemtype; ?>><a href="<?php echo get_term_link( $child_tax, $taxonomy_name ); ?>" itemprop="url"><span itemprop="title"><?php echo esc_html( $child_tax -> name ); ?></span></a></li>
						<li class="breadmark">&gt;</li>
					<?php endif; ?>
				<?php endif; ?>
			<li><?php the_title_attribute(); ?>

			<?php elseif ( is_page() ) : ?>
			<?php $ancestors = get_post_ancestors( $post -> ID ); ?>
			<?php foreach ( array_reverse( $ancestors ) as $ancestor ) : ?>
			<li <?php echo $itemtype; ?>><a href="<?php echo get_page_link( $ancestor ); ?>" itemprop="url"><span itemprop="title"><?php echo get_the_title( $ancestor ); ?></span></a></li>
			<li class="breadmark">&gt;</li>
			<?php endforeach; ?>
			<li><?php the_title_attribute(); ?>

			<?php elseif ( is_search() ) : ?>
			<li><?php printf( __( 'Search Results of " %s "', 'chocolat' ), get_search_query() ); ?>&nbsp;(&nbsp;<?php printf( __( '%d posts', 'chocolat' ), esc_html( $wp_query -> found_posts ) ); ?>&nbsp;)

			<?php elseif ( is_404() ) : ?>
			<li><?php _e( '404 Not found', 'chocolat' ); ?>

			<?php elseif ( is_attachment() ) : ?>
			<?php if ( $post -> post_parent != 0 ) : ?>
			<li <?php echo $itemtype; ?>><a href="<?php echo get_permalink( $post -> post_parent ); ?>" itemprop="url"><span itemprop="title"><?php echo get_the_title( $post -> post_parent ); ?></span></a></li>
			<li class="breadmark">&gt;</li>
			<?php endif; ?>
			<li><?php the_title_attribute(); ?>

			<?php elseif ( is_single() ) : ?>
			<?php
			$cat = get_the_category();
			if ( ! empty( $cat ) ) {
				$cat = $cat[count( $cat )-1];

				$breadcrumbs = '<li>'.get_category_parents( $cat, true, '</li><li class="breadmark">&gt;</li><li>' ).'</li>';
				$breadcrumbs = str_replace( '</li><li></li>', '</li>', $breadcrumbs );

				$breadcrumbs = preg_replace( '/<a href="([^>]+)">/i', '<a href="\\1" itemprop="url"><span itemprop="title">', $breadcrumbs );
				$breadcrumbs = str_replace( '<li>', '<li '.$itemtype.'>', $breadcrumbs );
				$breadcrumbs = str_replace( '</a>', '</span></a>', $breadcrumbs );
				echo $breadcrumbs;
			} ?>
			<li><?php the_title_attribute(); ?>

			<?php elseif ( is_year() ) : ?>
			<li><?php the_time( __( 'Y', 'chocolat' ) ); ?>

			<?php elseif ( is_month() || is_day() ) : ?>
			<li <?php echo $itemtype; ?>><a href="<?php echo get_year_link( get_the_time( 'Y' ) ); ?>" itemprop="url"><span itemprop="title"><?php the_time( __( 'Y', 'chocolat' ) ); ?></span></a></li>
			<li class="breadmark">&gt;</li>

			<?php if ( is_month() ) : ?>
			<li><?php the_time( __( 'F', 'chocolat' ) ); ?>

			<?php elseif ( is_day() ) : ?>
			<li <?php echo $itemtype; ?>><a href="<?php echo get_year_link( get_the_time( 'm' ) ); ?>" itemprop="url"><span itemprop="title"><?php the_time( __( 'F', 'chocolat' ) ); ?></span></a></li>
			<li class="breadmark">&gt;</li>
			<li><?php the_time( __( 'j', 'chocolat' ) ); ?>
			<?php endif; ?>

			<?php elseif ( is_category() ) : ?>
			<?php
			$cat = get_queried_object();
			$breadcrumbs = '<li>'.get_category_parents( $cat, true, '</li><li class="breadmark">&gt;</li><li>' ).'</li>';

			$pattern = '/<li><a href=\"([^>]+)\">([^<]+)<\/a><\/li><li class="breadmark">&gt;<\/li><li><\/li>/i';
			$breadcrumbs = preg_replace( $pattern, '', $breadcrumbs );

			$breadcrumbs = preg_replace( '/<a href="([^>]+)">/i', '<a href="\\1" itemprop="url"><span itemprop="title">', $breadcrumbs );
			$breadcrumbs = str_replace( '<li>', '<li '.$itemtype.'>', $breadcrumbs );
			$breadcrumbs = str_replace( '</a>', '</span></a>', $breadcrumbs );

			echo $breadcrumbs; ?>
			<li><?php single_cat_title(); ?>

			<?php elseif ( is_tag() ) : ?>
			<li><?php single_cat_title(); ?>

			<?php elseif ( is_author() ) : ?>
			<li><?php
				if ( get_the_author_meta( 'display_name' ) ) {
					the_author_meta( 'display_name', $post -> post_author );
				} else {
					_e( 'Nothing Found', 'chocolat' );
				} ?>
			<?php else : ?>
			<li><?php
				add_filter( 'chocolat_wp_title_name', '__return_false' );
				add_filter( 'chocolat_wp_title_desc', '__return_false' );
				add_filter( 'chocolat_wp_title_page', '__return_false' );
				wp_title( '' ); ?>

			<?php endif;
			if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
				$page_num = sprintf( __( 'Page %d', 'chocolat' ), max( $paged, $page ) );
				echo ' - '.$page_num;
			} ?></li>
		</ol>
	</div>
	<?php endif;
	}
}
endif;

/* ----------------------------------------------
 * 5.8 - post data list
 * --------------------------------------------*/

if ( ! function_exists( 'chocolat_post_list_number' ) ) :
function chocolat_post_list_number( $show_num = '' ) {
	$num_class = 'five-column';

	switch ( $show_num ){
		case '4':
			$num_class = 'four-column';
			break;
		case '3':
			$num_class = 'three-column';
			break;
	}
	return $num_class;
}
endif;

/* ----------------------------------------------
 * 5.8.1 - Show Post List
 * --------------------------------------------*/

// Related Post List
if ( ! function_exists( 'chocolat_related_post_list' ) ) :
function chocolat_related_post_list( $show_tag ) {
	$options = chocolat_get_option();

	if ( ! empty( $options['show_related'] ) ) {
		chocolat_post_list( $show_tag );
	}
}
endif;

//-----------------------------------------------
// New Post List
if ( ! function_exists( 'chocolat_new_post_list' ) ) :
function chocolat_new_post_list( $show_tag ) {
	$options = chocolat_get_option();

	if ( ! empty( $options['show_new_posts'] ) ) {
		chocolat_post_list( $show_tag );
	}
}
endif;

/* ----------------------------------------------
 * 5.8.2 - View Post list
 * --------------------------------------------*/

if ( ! function_exists( 'chocolat_post_list' ) ) :
function chocolat_post_list( $show_tag ) {
	$options = chocolat_get_option();
	// If the value is 0, use the value of the default
	$show_num = 10; 
	$num_class = 'five-column';

	if ( $show_tag == 'new' ) {
		$my_title = $options['new_posts_title'] ? $options['new_posts_title'] : __( 'New Entry', 'chocolat' );

		if ( ! empty( $options['new_posts_number'] ) ) {
			$show_num = absint( $options['new_posts_number'] );
			$num_class = chocolat_post_list_number( $show_num );
		}

		$order = 'DESC';
		$order_by = '';
	} elseif ( $show_tag == 'related' ) {
		$my_title = $options['related_title'] ? esc_attr( $options['related_title'] ) : __( 'Related Entry', 'chocolat' );

		if ( ! empty( $options['related_number'] ) ) {
			$show_num = absint( $options['related_number'] );
			$num_class = chocolat_post_list_number( $show_num );
		}

		if ( ! empty( $options['related_order_select'] ) ) {
			$order = 'DESC';
			$order_by = '';

			$related_order = esc_attr( $options['related_order_select'] );
			switch ( $related_order ){
				case 'random':
					$order = '';
					$order_by = 'rand';
					break;
				case 'asc':
					$order = 'ASC';
					$order_by = '';
					break;
			}
		}
	} else {
		return;
	}

	$my_query = chocolat_post_data( $show_num, $show_tag, $order, $order_by );

	if ( $my_query -> have_posts() ) : ?>
	<div class="<?php echo $show_tag; ?>-contents common-contents clearfix">
		<h3 id="<?php echo $show_tag; ?>-title" class="common-title"><?php echo esc_attr( $my_title ); ?></h3>
		<ul class="<?php echo $num_class; ?> clearfix">
		<?php while ( $my_query -> have_posts() ) : $my_query -> the_post(); ?>
			<li class="<?php echo $show_tag; ?>-thumbnail">
			<span class="thumbnail"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php chocolat_post_thumbnail(); ?></a></span>
			<h4 class="<?php echo $show_tag; ?>-post-title common-post-title"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title_attribute(); ?></a></h4>
			</li>
		<?php endwhile; wp_reset_query(); ?>
		</ul>
	</div>
	<?php endif;
}
endif;

/* ----------------------------------------------
 * 5.8.3.2 - post data
 * --------------------------------------------*/

if ( ! function_exists( 'chocolat_post_data' ) ) :
function chocolat_post_data( $show_num, $show_tag, $order, $order_by ) {
	global $post;
	$tag_ID = '';
	$category_ID = '';

	$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

	// Related article
	if ( $show_tag == 'related' ) {
		$options = chocolat_get_option();

		// Tag or category
		if ( ! empty( $options['related_class_select'] ) && esc_attr( $options['related_class_select'] ) == 'tag' ) {
			$posttags = get_the_tags( $post -> ID );
			$tag_ID = array();

			if ( $posttags ) {
				foreach( $posttags as $tag ) {
				array_push( $tag_ID, $tag -> term_id );
				}
			}
		} else {
			$categories = get_the_category( $post -> ID );
			$category_ID = array();

			foreach( $categories as $category ) {
				array_push( $category_ID, $category -> cat_ID );
			}
		}
	}

	$args = array(
		'tag__in'             => $tag_ID,
		'category__in'        => $category_ID,
		'post__not_in'        => array( $post -> ID ),
		'posts_per_page'      => $show_num,
		'ignore_sticky_posts' => true,
		'order'               => $order,
		'orderby'             => $order_by,
		'paged'               => $paged,
	);

	$my_query = new WP_Query( $args );
	return $my_query;
}
endif;

/* ----------------------------------------------
 * 9.1 - Lightbox of the image (boxer)
 * --------------------------------------------*/

// Add class to image_send_to_editor
if ( ! function_exists( 'chocolat_image_send_to_editor' ) ) :
function chocolat_image_send_to_editor( $html, $id, $caption ) {
	$options = chocolat_get_option();

	if ( ! empty( $options['show_image_lightbox'] ) ) {
		$class = "boxer";
		$a_title = '';
		$img_caption = esc_attr( $caption );

		if ( $img_caption ) {
			$a_title = ' title="'. $img_caption .'"';
		}

		$html = str_replace( '<a href=', '<a class="'. $class .'"'. $a_title .' href=', $html );
	}
	return $html;
}
endif;
add_filter( 'image_send_to_editor', 'chocolat_image_send_to_editor', 10, 3 );

/* ----------------------------------------------
 * 9.2 - gallery
 * --------------------------------------------*/

/* ----------------------------------------------
 * 9.2.1 - Add class to wp_get_attachment_link
 * --------------------------------------------*/

if ( ! function_exists( 'chocolat_boxer_wp_get_attachment_link' ) ) :
function chocolat_boxer_wp_get_attachment_link( $output, $id ) {
	$options = chocolat_get_option();

	if ( ! empty( $options['show_lightbox'] ) ) {
		$class = "boxer";
		$id = intval( $id );
		$_post = get_post( $id );
		$post_excerpt = esc_attr( $_post->post_excerpt );
		$a_title = "";

		if ( $post_excerpt ) {
			$a_title = " title='". $post_excerpt ."'";
		}

		$output = str_replace( "<a href=", "<a class='".$class."' rel='gallery'".$a_title." href=", $output );
	}
	return $output;
}
endif;

/* ----------------------------------------------
 * 9.2.2 - redesign gallery style
 *         originally in wp-includes/media.php
 * --------------------------------------------*/

if ( ! function_exists( 'chocolat_post_gallery' ) ) :
function chocolat_post_gallery( $output, $attr ) {
	$options = chocolat_get_option();

	if ( ! empty( $options['show_lightbox'] ) ) :
	global $post, $wp_locale;

	static $instance = 0;
	$instance++;

	add_filter( 'wp_get_attachment_link', 'chocolat_boxer_wp_get_attachment_link', 10, 2 );

	if ( ! empty( $attr['ids'] ) ) {
		// 'ids' is explicitly ordered, unless you specify otherwise.
		if ( empty( $attr['orderby'] ) )
			$attr['orderby'] = 'post__in';
		$attr['include'] = $attr['ids'];
	}

	// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}

	extract( shortcode_atts( array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post ? $post->ID : 0,
		'itemtag'    => 'li',        // 'dl'
		'icontag'    => 'span',      // 'dt'
		'captiontag' => 'p',         // 'dd'
		'columns'    => 3,
		'size'       => 'thumbnail', // 'thumbnail'
		'include'    => '',
		'exclude'    => '',
		'link'       => ''
	), $attr, 'gallery') );

	$attr['link'] = 'file';

	$id = intval($id);
	if ( 'RAND' == $order )
		$orderby = 'none';

	if ( !empty($include) ) {
		$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( !empty($exclude) ) {
		$attachments = get_children( array( 'post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );
	} else {
		$attachments = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );
	}

	if ( empty( $attachments ) )
		return '';

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment )
			$output .= wp_get_attachment_link( $att_id, $size, true ) . "\n";
		return $output;
	}

	$itemtag = tag_escape( $itemtag );
	$captiontag = tag_escape( $captiontag );
	$icontag = tag_escape( $icontag );
	$valid_tags = wp_kses_allowed_html( 'post' );
	if ( ! isset( $valid_tags[ $itemtag ] ) )
		$itemtag = 'li';   // 'dl'
	if ( ! isset( $valid_tags[ $captiontag ] ) )
		$captiontag = 'p'; // 'dd'
	if ( ! isset( $valid_tags[ $icontag ] ) )
		$icontag = 'span'; // 'dt'

	$columns = intval( $columns );
	$itemwidth = $columns > 0 ? floor( 100/$columns ) : 100;
	$float = is_rtl() ? 'right' : 'left';

	$selector = "gallery-{$instance}";

	$gallery_style = $gallery_div = '';
	// no style in default gallery.

	$size_class = sanitize_html_class( $size );
	$gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'><ul class='gallery-list clearfix'>\n";
	$output = apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );

	$i = 0;
	foreach ( $attachments as $id => $attachment ) {
		if ( ! empty( $link ) && 'file' === $link )
			$image_output = wp_get_attachment_link( $id, $size, false, false );
		elseif ( ! empty( $link ) && 'none' === $link )
			$image_output = wp_get_attachment_image( $id, $size, false );
		else {
			$options = chocolat_get_option();
			if ( ! empty( $options['show_lightbox'] ) ) {
				$image_output = wp_get_attachment_link( $id, $size, false, false );
			} else {
				$image_output = wp_get_attachment_link( $id, $size, true, false );
			}
		}

		$image_meta = wp_get_attachment_metadata( $id );

		$orientation = '';
		if ( isset( $image_meta['height'], $image_meta['width'] ) )
			$orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';

		$output .= "<{$itemtag} class='gallery-item'>";
		$output .= "
			<{$icontag} class='gallery-icon {$orientation}'>
				$image_output
			</{$icontag}>";
		if ( $captiontag && trim($attachment->post_excerpt) ) {
			$output .= "
				<{$captiontag} class='wp-caption-text gallery-caption'>
				" . wptexturize($attachment->post_excerpt) . "
				</{$captiontag}>\n";
		}
		$output .= "</{$itemtag}>\n";
	}
	$output .= "</ul></div>\n<p>";
	endif;
	return $output;
}
endif;
add_filter( 'post_gallery', 'chocolat_post_gallery', 10, 2 );

/* ----------------------------------------------
 * 99.0 - original widgets
 * --------------------------------------------*/

/* ----------------------------------------------
 * 99.1 - New Entrys widget
 * --------------------------------------------*/

class Chocolat_Widget_New_Entrys extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'chocolat_widget_new_entrys', 'description' => sprintf( __( 'It is a widget for the %s theme.', 'chocolat' ), esc_attr( wp_get_theme() ) ).__( 'The most recent posts on your site (with thumbnails)', 'chocolat' ) );
		parent::__construct( 'chocolat-new-posts', esc_attr( wp_get_theme() ).'&nbsp;'.__( 'New Entry', 'chocolat' ).'&nbsp;'.__( '(with thumbnails)', 'chocolat' ), $widget_ops );
		$this->alt_option_name = 'chocolat_widget_new_entrys';

		add_action( 'save_post', array( $this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array( $this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array( $this, 'flush_widget_cache' ) );
	}

	function widget( $args, $instance ) {
		$cache = wp_cache_get( 'chocolat_widget_new_entrys', 'widget' );

		if ( !is_array( $cache ) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();
		extract( $args );

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'New Entry', 'chocolat' );
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number )
		$number = 5;
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;
		$show_single = isset( $instance['show_single'] ) ? $instance['show_single'] : false;

		if ( $show_single ) {
			if ( is_home() || is_front_page() ) {
				return;
			}
		}

		$r = new WP_Query( array( 'posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true ) );
		if ( $r->have_posts() ) :
?>
		<?php echo $before_widget; ?>
		<?php if ( $title ) echo $before_title . $title . $after_title; ?>
		<ul>
		<?php while ( $r->have_posts() ) : $r->the_post(); ?>
			<li class="sidebar-thumbnail clearfix">
				<span class="thumbnail"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php chocolat_post_thumbnail(); ?></a></span>

				<div class="post-content">
					<a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>">
					<span class="post-title"><?php the_title_attribute( 'echo=0' ) ? the_title_attribute() : the_ID(); ?></span>
					<?php if ( $show_date ) : ?>
					<span class="post-date"><?php echo get_the_date(); ?></span>
					<?php endif; ?>
					</a>
				</div>
			</li>
		<?php endwhile; ?>
		</ul>
		<?php echo $after_widget; ?>
<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set( 'chocolat_widget_new_entrys', $cache, 'widget' );
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['number'] = (int) $new_instance['number'];
		$instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
		$instance['show_single'] = isset( $new_instance['show_single'] ) ? (bool) $new_instance['show_single'] : false;
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset( $alloptions['chocolat_widget_new_entrys'] ) )
			delete_option( 'chocolat_widget_new_entrys' );

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete( 'chocolat_widget_new_entrys', 'widget' );
	}

	function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		$show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
		$show_single = isset( $instance['show_single'] ) ? (bool) $instance['show_single'] : false;
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'chocolat' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:', 'chocolat' ); ?></label>
		<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

		<p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?', 'chocolat' ); ?></label></p>

		<p><input class="checkbox" type="checkbox" <?php checked( $show_single ); ?> id="<?php echo $this->get_field_id( 'show_single' ); ?>" name="<?php echo $this->get_field_name( 'show_single' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'show_single' ); ?>"><?php _e( 'Do not want to display the top page of the Web site.', 'chocolat' ); ?></label></p>
<?php
	}
}
add_action( 'widgets_init', create_function( '', 'return register_widget( "Chocolat_Widget_New_Entrys" );' ) );

/* ----------------------------------------------
 * 99.2 - Category Recent Posts Widget
 * --------------------------------------------*/

class Chocolat_Widget_Category_Recent_Posts extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'chocolat_recent_posts', 'description' => sprintf( __( 'It is a widget for the %s theme.', 'chocolat' ), esc_attr( wp_get_theme() ) ).__( 'In the single page, and view the latest posts in the same category.', 'chocolat' ) );
		parent::__construct( 'chocolat-recent-posts', esc_attr( wp_get_theme() ).' '.__( 'Related Entry', 'chocolat' ), $widget_ops );
		$this->alt_option_name = 'chocolat_recent_posts';

		add_action( 'save_post', array( $this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array( $this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array( $this, 'flush_widget_cache' ) );
	}

	function widget( $args, $instance ) {
		if ( is_single() ) {
			global $cat;
			$cache = wp_cache_get( 'chocolat_recent_posts', 'widget' );

			if ( !is_array( $cache ) )
				$cache = array();

			if ( ! isset( $args['widget_id'] ) )
				$args['widget_id'] = $this->id;

			if ( isset( $cache[ $args['widget_id'] ] ) ) {
				echo $cache[ $args['widget_id'] ];
				return;
			}

			ob_start();
			extract( $args );

			$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Related Entry', 'chocolat' );
			$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
			$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
			if ( ! $number )
			 $number = 5;
			$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

			$r = new WP_Query( array( 'posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'cat' => $cat ) );
			if ( $r->have_posts() ) :
?>
			<?php echo $before_widget; ?>
			<?php if ( $title ) echo $before_title . $title . $after_title; ?>
			<ul>
			<?php while ( $r->have_posts() ) : $r->the_post(); ?>
				<li class="sidebar-thumbnail clearfix">
					<span class="thumbnail"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php chocolat_post_thumbnail(); ?></a></span>

					<div class="post-content">
						<a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>">
						<span class="post-title"><?php the_title_attribute( 'echo=0' ) ? the_title_attribute() : the_ID(); ?></span>
						<?php if ( $show_date ) : ?>
						<span class="post-date"><?php echo get_the_date(); ?></span>
						<?php endif; ?>
						</a>
					</div>
				</li>
			<?php endwhile; ?>
			</ul>
			<?php echo $after_widget; ?>
<?php
			// Reset the global $the_post as this query will have stomped on it
			wp_reset_postdata();

			endif;

			$cache[$args['widget_id']] = ob_get_flush();
			wp_cache_set( 'chocolat_recent_posts', $cache, 'widget' );
		}
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['number'] = (int) $new_instance['number'];
		$instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset( $alloptions['chocolat_recent_posts'] ) )
			delete_option( 'chocolat_recent_posts' );

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete( 'chocolat_recent_posts', 'widget' );
	}

	function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		$show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'chocolat' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:', 'chocolat' ); ?></label>
		<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

		<p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?', 'chocolat' ); ?></label></p>
<?php
	}
}
add_action( 'widgets_init', create_function( '', 'return register_widget( "Chocolat_Widget_Category_Recent_Posts" );' ) );

/* ----------------------------------------------
 * 99.3 - PageNavi Widget
 * --------------------------------------------*/

class Chocolat_Widget_PageNavi extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'chocolat_widget_pagenavi', 'description' => sprintf( __( 'It is a widget for the %s theme.', 'chocolat' ), esc_attr( wp_get_theme() ) ).__( 'View navigation menu to a fixed page that have a parent-child page', 'chocolat' ) );
		parent::__construct( 'chocolat-page-navi', esc_attr( wp_get_theme() ).' '.__( 'Fixed Page Menu', 'chocolat' ), $widget_ops );
	}

	function widget( $args, $instance ) {
		if ( is_page() ) {
			extract( $args );

			$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Page Navi', 'chocolat' ) : $instance['title'], $instance, $this->id_base );
			$sortby = empty( $instance['sortby'] ) ? 'menu_order' : $instance['sortby'];
			if ( $sortby == 'menu_order' )
			$sortby = 'menu_order, post_title';

			global $post;
			$ancestors = get_post_ancestors( $post->ID );
			$ancestor = array_pop( $ancestors );

			if ( $ancestor ) {
				$parent = $ancestor;
			} else {
				$parent = $post->ID;
			}

			$children = wp_list_pages( array( 'title_li' => '', 'child_of' => $parent, 'echo' => 0, 'sort_column' => $sortby ) );

			if ( $children ) {
				echo $before_widget;
				if ( $title )
					echo $before_title . $title . $after_title;
				?>
				<ul>
					<li class="page_item page-item-<?php echo $parent; ?> parent-page"><a href="<?php echo get_permalink( $parent ); ?>"><?php echo esc_html( get_the_title( $parent ) ); ?></a>
						<ul class="children"><?php echo $children; ?></ul>
					</li>
				</ul>
				<?php
				echo $after_widget;
			}
		}
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		if ( in_array( $new_instance['sortby'], array( 'post_title', 'menu_order', 'ID' ) ) ) {
			$instance['sortby'] = $new_instance['sortby'];
		} else {
			$instance['sortby'] = 'menu_order';
		}
		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'sortby' => 'post_title', 'title' => '', 'exclude' => '') );
		$title = esc_attr( $instance['title'] );
		$exclude = esc_attr( $instance['exclude'] );
	?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'chocolat' ); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
		<p>
			<label for="<?php echo $this->get_field_id('sortby'); ?>"><?php _e( 'Sort by:', 'chocolat' ); ?></label>
			<select name="<?php echo $this->get_field_name('sortby'); ?>" id="<?php echo $this->get_field_id('sortby'); ?>" class="widefat">
				<option value="post_title"<?php selected( $instance['sortby'], 'post_title' ); ?>><?php _e( 'Page title', 'chocolat' ); ?></option>
				<option value="menu_order"<?php selected( $instance['sortby'], 'menu_order' ); ?>><?php _e( 'Page order', 'chocolat' ); ?></option>
				<option value="ID"<?php selected( $instance['sortby'], 'ID' ); ?>><?php _e( 'Page ID', 'chocolat' ); ?></option>
			</select>
		</p>
<?php
	}
}
add_action( 'widgets_init', create_function( '', 'return register_widget( "Chocolat_Widget_PageNavi" );' ) );