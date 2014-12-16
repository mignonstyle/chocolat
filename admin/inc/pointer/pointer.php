<?php
/**
 * Pointers
 * @package   Chocolat
 * @copyright Copyright (c) 2014 Mignon Style
 * @license   GNU General Public License v2.0
 * @since     Chocolat 1.1.8
 */

/**
 * ------------------------------------------------------------
 * 1.0 - pointer name
 * ------------------------------------------------------------
 */

define( 'CHOCOLAT_POINTER_ID', 'chocolat-pointer-sns' );

/**
 * ------------------------------------------------------------
 * 1.1 - Read css and javascript file
 * ------------------------------------------------------------
 */

function chocolat_pointer_init() {
	global $plugin_page;

	if ( $plugin_page != 'theme_options' ) {
		return false;
	}

	// Do not show when the pointer is hidden.
	$dismissed = explode( ',', get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );
	if ( false === array_search( CHOCOLAT_POINTER_ID, $dismissed ) ) {
		add_action( 'admin_enqueue_scripts', 'chocolat_pointer_style' );
		add_action( 'admin_print_scripts', 'chocolat_pointer_scripts' );
	}
}
add_action( 'admin_init', 'chocolat_pointer_init' );

/**
 * ------------------------------------------------------------
 * 1.2 - css function
 * ------------------------------------------------------------
 */

function chocolat_pointer_style() {
	wp_enqueue_style( 'wp-pointer' );
}

/**
 * ------------------------------------------------------------
 * 1.3.1 - javascript function
 * ------------------------------------------------------------
 */

function chocolat_pointer_scripts(){
	// add pointer.js
	wp_enqueue_script( 'chocolat-pointer', get_template_directory_uri().'/admin/inc/pointer/pointer.js', array( 'jquery', 'wp-pointer' ), null, true );

	// Set wp_localize_script of pointer.js
	$content  = '<h3>' . __( 'How to use Social Links', 'chocolat' ) . '</h3>';
	$content .= chocolat_pointer_content();

	if ( is_rtl() ) {
		$position = array( 'edge' => 'top', 'align' => 'center', 'my' => 'right-20 top+60', 'at' => 'right top' );
	} else {
		$position = array( 'edge' => 'top', 'align' => 'center', 'my' => 'left+20 top+60', 'at' => 'left top' );
	}

	$pointer_width = ( strtoupper( get_locale() ) == 'JA' ) ? 400 : 330;

	$pointer_array = array(
		'target'       => '#option-sociallink th',
		'content'      => $content,
		'position'     => $position,
		'pointerWidth' => $pointer_width,
		'handler'      => CHOCOLAT_POINTER_ID,
	);
	wp_localize_script( 'chocolat-pointer', 'chocolat_pointer', $pointer_array );
}

/**
 * ------------------------------------------------------------
 * 1.3.2 - pointer sns array
 * ------------------------------------------------------------
 */

function chocolat_pointer_content_sns(){
	$content_array = array(
		'1' => array(
			'text' => __( 'Click Appearance > Menus > "Edit Menus" tab.', 'chocolat' ),
		),
		'2' => array(
			'text' => __( 'Select a menu to edit or create a new menu.', 'chocolat' ),
		),
		'3' => array(
			'text' => __( 'Setting of the "link".', 'chocolat' ),
			'br01' => __( 'URL', 'chocolat' ) . __( ':', 'chocolat' ) . ' ' . __( 'Url of the social link', 'chocolat' ),
			'br02' => __( 'Link Text', 'chocolat' ) . __( ':', 'chocolat' ) . ' ' . __( 'Name of the social link', 'chocolat' ),
			'br03' => __( 'Click "Add to Menu" button.', 'chocolat' ) ,
		),
		'4' => array(
			'text' => __( 'Setting of "Theme locations" of "Menu Settings".', 'chocolat' ),
			'br01' => __( 'Please check the check box of "social links".', 'chocolat' ),
		),
	);

	return $content_array;
}

/**
 * ------------------------------------------------------------
 * 1.3.3 - localize_script content
 * ------------------------------------------------------------
 */

function chocolat_pointer_content(){
	$content_array = chocolat_pointer_content_sns();

	$content = '<ol>';

	foreach( $content_array as $array_value ) {
		$array_count = count( $array_value );
		$content .= '<li>' . $array_value['text'];

		if ( $array_count > 1 ) {
			for ( $i = 1; $i < $array_count ; $i++ ) {
				$br = 'br0' . $i;
				$content .= ( array_key_exists( $br, $array_value ) ) ? '<br />' . $array_value[$br] : '';
			}
		}
		$content .= '</li>';
	}

	$content .= '</ol>';

	return $content;
}