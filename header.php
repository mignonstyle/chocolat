<?php
/**
 * The Header template
 * @package   Chocolat
 * @copyright Copyright (c) 2014 Mignon Style
 * @license   GNU General Public License v2.0
 * @since     Chocolat 1.0
 */
?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php chocolat_sp_icon(); ?>
<?php chocolat_favicon(); ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
<![endif]-->
<?php wp_head(); ?>
</head>

<body id="top" <?php body_class(); ?>>
<!-- wrapper -->
<div id="wrapper" class="container">
<!-- header -->
<header id="header">
<!-- header-inner -->
<div id="header-inner">
	<div id="header-top" class="clearfix">
		<div class="header-title">
			<a class="home-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php esc_attr_e( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
				<h1 id="site-title"><?php chocolat_site_title(); ?></h1>
				<?php chocolat_site_description(); ?>
			</a>
		</div>
		<div class="header-links">
			<?php
			chocolat_contactlink( 'contactlink-top' );
			get_search_form(); ?>
		</div>
	</div><!-- /header-top -->

	<div id="header-center" class="clearfix">
		<?php chocolat_header_image(); ?>

		<!-- globalnav -->
		<div id="nav-control" class="close">
			<span class="icon-menu"></span>
		</div>
		<?php wp_nav_menu( array(
			'theme_location'  => 'globalnav',
			'container_class' => 'globalnav clearfix',
			'menu_class'      => 'globalnav clearfix',
		) ); ?>
	</div><!-- /header-center -->

	<div id="header-bottom" class="clearfix">
		<?php chocolat_breadcrumb(); ?>
	</div><!-- /header-bottom -->
</div><!-- /header-inner -->
</header><!-- /header -->

<!-- contents -->
<div id="contents" class="clearfix">