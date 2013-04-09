<?php
/**
 * Compatibility settings and functions for Jetpack from Automattic
 * See jetpack.me
 *
 * @package Next Saturday
 */


/**
 * Add theme support for infinity scroll
 */
function next_saturday_infinite_scroll_init() {
	add_theme_support( 'infinite-scroll', array(
		'container'      => 'content',
		'footer_widgets' => array( 'sidebar-3', 'sidebar-4', 'sidebar-5' ),
		'footer'         => 'wrapper',
	) );
}
add_action( 'init', 'next_saturday_infinite_scroll_init' );