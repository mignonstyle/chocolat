<?php
/**
 * The Sidebar template
 */
?>
<?php if ( chocolat_sidebar() ) : ?>
<?php $options = chocolat_get_option(); ?>
	<!-- sidebar -->
	<div id="sidebar" class="clearfix">
		<div id="sidebar-inner" class="clearfix">
		<?php
		if ( is_active_sidebar( 'ad_small' ) && ! is_404() ) {
			echo '<div class="widget-ad-top">';
			dynamic_sidebar( 'ad_small' );
			echo '</div>'."\n";
		}

		if ( is_active_sidebar( 'sidebar_widget' ) || ! empty( $options['show_links_side'] ) ) {
			$links_side = esc_attr( $options['links_side_select'] );
			echo '<div class="widget-inner clearfix">';

			if ( $links_side == 'links_side_top' ) {
				chocolat_contactlink_side();
			}

			dynamic_sidebar( 'sidebar_widget' );

			if ( $links_side == 'links_side_bottom' ) {
				chocolat_contactlink_side();
			}
			echo '</div>'."\n";
		}

		if ( is_active_sidebar( 'ad_banner' ) && ! is_404() ) {
			echo '<div class="widget-ad-bottom">';
			dynamic_sidebar( 'ad_banner' );
			echo '</div>'."\n";
		} 
		?>
		</div>
	</div><!-- /sidebar -->
<?php endif; ?>

</div><!-- /contents -->

<?php if ( is_active_sidebar( 'ad_large' ) && ! is_404() ) {
	if ( chocolat_is_mobile() ) {
		if ( is_active_sidebar( 'ad_small' ) ) {
			echo '<div id="widget-ad-large"><div class="content-adsense">';
			dynamic_sidebar( 'ad_small' );
			echo '</div></div>'."\n";
		}
	} else {
		echo '<div id="widget-ad-large"><div class="content-adsense">';
		dynamic_sidebar( 'ad_large' );
		echo '</div></div>'."\n";
	}
} ?>

<?php chocolat_ad_widget_medium_bottom( 'bottom' ); ?>

<?php chocolat_prevnext( 'footer' ); ?>

<?php if ( is_active_sidebar( 'footer_widget' ) ) : ?>
<!-- widget-footer -->
<div id="widget-footer">
	<div id="widget-footer-inner" class="clearfix">
		<div class="widget-inner">
			<?php dynamic_sidebar( 'footer_widget' ); ?>
		</div>
	</div>
</div><!-- /widget-footer -->
<?php endif; ?>