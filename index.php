<?php
/**
 *  The Index template
 */
?>
<?php get_header(); ?>

<div id= "main-content" class="clearfix">
	<article id="content-inner" class="clearfix">
		<?php
		if ( ! is_404() && have_posts() ) {
			get_template_part( 'content', 'top' );
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