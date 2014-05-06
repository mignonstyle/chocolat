<?php
/**
 *  The Single template
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