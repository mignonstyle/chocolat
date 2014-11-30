<?php
/**
 * The Content-single template
 * @package   Chocolat
 * @copyright Copyright (c) 2014 Mignon Style
 * @license   GNU General Public License v2.0
 * @since     Chocolat 1.0
 */
?>
<section id="<?php echo esc_attr( $post -> post_name ); ?>" <?php post_class( 'post-section clearfix' ); ?>>
	<div class="section-top clearfix">
		<div class="entry-edit clearfix">
			<?php edit_post_link( __( 'Edit', 'chocolat' ), '<span class="post-edit">', '</span>' ); ?>
		</div>

		<?php chocolat_entry_dates(); ?>

		<div class="entry-title">
			<h1 class="post-title"><?php the_title_attribute(); ?></h1>
		</div>
	</div><!-- /section-top -->

	<div class="section-center clearfix">
		<?php chocolat_last_update(); ?>
		<?php chocolat_entry_meta(); ?>

		<?php if ( has_post_thumbnail() ) : ?>
		<div class="entry-thumbnail thumbnail clearfix">
			<?php the_post_thumbnail( 'single-post-thumbnail' ); ?>
		</div>
		<?php endif; ?>

		<div class="post-content clearfix">
			<div class="entry-content clearfix">
			<?php if ( is_attachment() && wp_attachment_is_image( $post->id ) ) {
				$att_image = wp_get_attachment_image_src( $post->id, "full-size" );
				$att_excerpt = $post->post_excerpt;

				echo '<div class="attachment-image">'."\n";
				echo '<img src="'.esc_url( $att_image[0] ).'" width="'.intval( $att_image[1] ).'" height="'.intval( $att_image[2] ).'" class="attachment-full-size" alt="'.esc_attr( $att_excerpt ).'" />'."\n";
				if ( ! empty( $att_excerpt ) ) {
					echo '<p class="attachment-text">'.esc_attr( $att_excerpt ).'</p>'."\n";
				} 
				echo '</div>'."\n";
			} else {
				the_content();
			} ?>
			</div><!-- /entry-content -->

			<?php if ( wp_link_pages( 'echo=0' ) ) : ?>
			<div class="post-pagination clearfix">
				<?php wp_link_pages( array(
					'before'         => '<div class="post-numbers">',
					'after'          => '</div>',
					'next_or_number' => 'number',
					'pagelink'       => '<span class="numbers">%</span>'
				) ); ?>
			</div>
			<?php endif; ?>

			<?php chocolat_ad_widget_medium(); ?>
		</div><!-- /post-content -->
	</div><!-- /section-center -->

	<div class="section-bottom clearfix">
		<div class="section-bottom-inner clearfix">
		</div>
	</div><!-- /section-bottom -->
</section><!-- /section -->

<?php
	if ( ! is_attachment() ) {
		chocolat_related_post_list( 'related' );
		chocolat_new_post_list( 'new' );
		chocolat_ad_widget_medium_bottom( 'center' );
		comments_template();
	}
?>