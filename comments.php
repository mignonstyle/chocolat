<?php
/**
 * The Comments template
 */
if ( post_password_required() )
	return;
?>
<?php if ( have_comments() || comments_open() || pings_open() ) : ?>
<div id="comments" class="comments-area">
	<?php
	$comments_number = chocolat_get_comments_only_number();
	if ( $comments_number > 0 ) : ?>
	<div class="comments-inner common-contents clearfix">
		<h3 id="comments-title" class="common-title"><?php printf( __( '%d Comments', 'chocolat' ), absint( $comments_number ) ); ?></h3>
		<ol class="comment-list">
			<?php wp_list_comments( array(
				'type'              => 'comment',
				'callback'          => 'chocolat_theme_comment',
			) ); ?>
		</ol><!-- /comment-list -->
	</div><!-- /comments-inner -->

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
	<div class="pagination clearfix">
		<?php paginate_comments_links( array(
			'prev_text' => '&lsaquo;',
			'next_text' => '&rsaquo;',
			'type'      => 'list',
		) ); ?>
	</div><!-- /pagination -->
	<?php endif; endif;  /* chocolat_get_comments_only_number */ ?>

	<?php if ( chocolat_get_pings_only_number() > 0 ) : ?>
	<?php chocolat_theme_ping(); ?>
	<?php endif; /* chocolat_get_pings_only_number */ ?>

	<?php if ( comments_open() ) {
		comment_form();
	} else {
		chocolat_no_comment();
	} ?>

	<?php if ( pings_open() ) : ?>
	<div class="trackback-url common-contents clearfix">
		<h3 id="trackback-title" class="common-title"><?php _e( 'TrackBack URL', 'chocolat' ); ?></h3>
		<p><?php trackback_url(); ?></p>
	</div>
	<?php endif; ?>
</div><!-- /comments -->
<?php else : ?>
	<?php if ( ! comments_open() ) {
		chocolat_no_comment();
	} ?>
<?php endif; ?>