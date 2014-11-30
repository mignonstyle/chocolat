<?php
/**
 * The Content-none template
 * @package   Chocolat
 * @copyright Copyright (c) 2014 Mignon Style
 * @license   GNU General Public License v2.0
 * @since     Chocolat 1.0
 */
?>
<?php
$home_url = '<a href="'.esc_url( home_url( '/' ) ).'">Home</a>';

if ( chocolat_is_mobile() ) {
	$br = '';
} else {
	$br = '<br />';
}
?>
<header id="content-header" class="results-none">
	<div id="content-top">
		<h1 class="page-title"><?php
		if ( is_404() ) {
			_e( '404 Not found', 'chocolat' );
		} else {
			_e( 'Nothing Found', 'chocolat' );
		} ?></h1>
	</div><!-- /content-top -->

	<div id="content-center">
		<?php if ( is_404() ) : ?>
		<p><?php _e( "The page you're looking for can't be found.", 'chocolat' ); ?><br />
		<?php printf( __( 'Try retyping the URL.%2$sOr use the search box, or going back to %1$s.', 'chocolat' ), $home_url, $br ); ?></p>

		<?php elseif ( is_search() ) : ?>
		<p><?php printf( __( 'We found no results for "%s".', 'chocolat' ), '<span class="search-str">' . get_search_query() . '</span>' ); ?><br />
		<?php printf( __( 'Try different search words, or going back to %s.', 'chocolat' ), $home_url ); ?></p>

		<?php else : ?>
		<p><?php _e( "The info you're looking for can't be found.", 'chocolat' ); ?><br />
		<?php printf( __( 'Enter a keywords in the search field, or going back to %s.', 'chocolat' ), $home_url ); ?></p>
		<?php endif; ?>
	</div><!-- /content-center -->

</header><!-- /content-header -->