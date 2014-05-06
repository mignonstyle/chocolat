<?php
/**
 *  The Content-top template
 */
?>
<?php if ( is_search() || is_archive() ) : ?>
<header id="content-header">
	<div id="content-top">
		<h1 class="page-title">
		<?php
		if ( is_search() ) {
			printf( __( 'Search Results of "%s"', 'chocolat' ), '<span class="search-str">' . get_search_query() . '</span>' );
		} elseif ( is_category() ) {
			printf( __( 'Category : %s', 'chocolat' ), single_cat_title( '' , false ) );
		} elseif ( is_tag() ) {
			printf( __( 'Tag : %s', 'chocolat' ), single_tag_title( '' , false ) );
		} elseif ( is_year() ) {
			the_time( __( 'Y', 'chocolat' ) );
		} elseif ( is_month() ) {
			the_time( __( 'F Y', 'chocolat' ) );
		} elseif ( is_day() ) {
			the_time( __( 'F j, Y', 'chocolat' ) );
		} elseif ( is_author() ) {
			printf( __( 'Author : %s', 'chocolat' ), get_the_author() );
		} else {
			_e( 'Archives', 'chocolat' );
		}
		?>
		</h1>
		<p><?php printf( __( '%d posts', 'chocolat' ), absint( $wp_query->found_posts ) ); ?></p>
	</div><!-- /content-top -->
</header><!-- /content-header -->
<?php endif; ?>