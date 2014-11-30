<?php
/**
 * The Footer template
 * @package   Chocolat
 * @copyright Copyright (c) 2014 Mignon Style
 * @license   GNU General Public License v2.0
 * @since     Chocolat 1.0
 */
?>
<?php get_sidebar(); ?>
<?php
	$contents_class ='';

	if ( is_active_sidebar( 'footer_widget' ) ) {
		$contents_class = 'active-widget-footer';
	} else {
		$contents_class = '';
		if ( is_active_sidebar( 'ad_large' ) || chocolat_sidebar() ) {
			$contents_class = 'no-widget-footer';
		}
	}
?>
<!-- footer -->
<footer id="footer" class="<?php echo esc_attr( $contents_class ); ?>">
	<div id="footer-inner">
		<div id="footer-top">
			<?php chocolat_contactlink( 'contactlink-bottom' ); ?>
			<h3 class="footer-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h3>
			<?php chocolat_footer_description(); ?>
		</div>

		<div id="footer-bottom">
		<p id="copyright"><?php chocolat_footer_copyright(); ?></p>
		</div>
	</div>
</footer><!-- /footer -->

<?php if ( ! chocolat_is_mobile() ) : ?>
<!-- pagetop -->
<div id="pagetop" class="rollover">
	<a href="#top" class="pagetop-btn"><span class="icon-up"></span><?php _e( 'PAGE TOP', 'chocolat' ); ?></a>
</div><!-- /pagetop -->
<?php endif; ?>

</div><!-- /#wrapper -->
<?php wp_footer(); ?>
</body>
</html>