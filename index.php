<?php
/**
 * The Index template
 * @package   Chocolat
 * @copyright Copyright (c) 2014 Mignon Style
 * @license   GNU General Public License v2.0
 * @since     Chocolat 1.0
 */
?>
<?php get_header(); ?>

<div id= "main-content" class="clearfix">
	<article id="content-inner" class="clearfix">
		<?php
		if ( ! is_404() && have_posts() ) {
			$options = chocolat_get_option();
			if ( ! empty( $options['show_archives_posts'] ) ) {
				get_template_part( 'content', 'top' );
			}
			while ( have_posts() ) {
				the_post();
				get_template_part( 'content' );
			}
			chocolat_pagination();
		} else {
			get_template_part( 'content', 'none' );
		} ?>
	</article><!-- /content-inner -->
</div><!-- /main-content -->

<?php get_footer(); ?>