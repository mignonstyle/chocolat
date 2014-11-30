<?php
/**
 * The Single template
 * @package   Chocolat
 * @copyright Copyright (c) 2014 Mignon Style
 * @license   GNU General Public License v2.0
 * @since     Chocolat 1.0
 */
?>
<?php get_header(); ?>

<div id= "main-content" class="clearfix">
	<article id="content-inner" class="clearfix">
		<?php if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();
				get_template_part( 'content', 'single' );
			}
			chocolat_pagination();
		} else {
			get_template_part( 'content', 'none' );
		} ?>
	</article><!-- /content-inner -->
	<?php chocolat_prevnext(); ?>
</div><!-- /main-content -->

<?php get_footer(); ?>