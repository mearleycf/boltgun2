<?php
/**
 *
 */

/**
 * Include public JS
 */
function ml_adverts_public_js() {
	wp_enqueue_script( 'ml_adverts_public_js', MLA_JS_URL . 'public.js', array( 'jquery' ), MLA_VERSION );
}
add_action( 'wp_print_scripts', 'ml_adverts_public_js' );


/**
 * Include admin JS
 */
function ml_adverts_admin_js() {
	if ("ml-advert" == ml_adverts_get_current_post_type()) {
    	wp_enqueue_script( 'ml_adverts_admin_js', MLA_JS_URL .  'admin.js', array( 'jquery'), MLA_VERSION );
	}
}
add_action( 'admin_enqueue_scripts', 'ml_adverts_admin_js' );