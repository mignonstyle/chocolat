<?php
/**
 * The Content template
 */
?>
<section id="<?php echo esc_attr( $post -> post_name ); ?>" <?php post_class( 'post-section clearfix' ); ?>>
	<div class="section-top clearfix">
		<div class="entry-edit clearfix">
			<?php edit_post_link( __( 'Edit', 'chocolat' ), '<span class="post-edit">', '</span>' ); ?>
		</div>

		<?php chocolat_entry_dates(); ?>

		<div class="entry-title">
			<?php if ( ! is_page() ) : ?><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php endif; ?>
				<h1 class="post-title"><?php the_title_attribute(); ?></h1>
			<?php if ( ! is_page() ) : ?></a><?php endif; ?>
		</div>
	</div><!-- /section-top -->

	<div class="section-center clearfix">
		<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
		<div class="entry-thumbnail thumbnail clearfix">
			<a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>">
				<?php the_post_thumbnail( 'post_thumbnail' ); ?>
			</a>
		</div>
		<?php endif; /* /has_post_thumbnail() && ! post_password_required() */ ?>

		<div class="post-content">
		<?php if ( is_page() ) : ?>
			<div class="entry-content">
				<?php the_content(); ?>
			</div><!-- /entry-content -->
		<?php else : ?>
			<?php chocolat_excerpt_content(); ?>
		<?php endif; /* /post_password_required() || get_post_format() */ ?>

		<?php if ( wp_link_pages( 'echo=0' ) ) : ?>
		<div class="post-pagination clearfix">
			<?php wp_link_pages( array(
				'before'         => '<div class="post-numbers">',
				'after'          => '</div>',
				'next_or_number' => 'number',
				'pagelink'       => '<span class="numbers">%</span>'
			)); ?>
		</div>
		<?php endif; /* /wp_link_pages() */ ?>

		</div><!-- /post-content -->
	</div><!-- /section-center -->

	<div class="section-bottom clearfix">
		<div class="section-bottom-inner clearfix">
			<?php chocolat_entry_meta(); ?>
		</div>
	</div><!-- /section-bottom -->
</section><!-- /section -->

<?php comments_template(); ?>