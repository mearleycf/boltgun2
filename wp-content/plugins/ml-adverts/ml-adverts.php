<?php
/*
 * Plugin Name: ML Adverts
 * Plugin URI: http://www.matchalabs.com
 * Description: Lightweight Banner Management System
 * Version: 1.0.1
 * Author: Matcha Labs
 * Author URI: http://www.matchalabs.com
 * License: GPL
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
*/

define( 'MLA_VERSION', '1.0.1' );
define( 'MLA_BASE_NAME', plugin_basename( __FILE__ ) );	    // ml-adverts/ml-adverts.php
define( 'MLA_BASE_DIR_SHORT', dirname( MLA_BASE_NAME ) );	// ml-adverts
define( 'MLA_BASE_DIR_LONG', dirname( __FILE__ ) );			// ../wp-content/plugins/ml-adverts (physical file path)
define( 'MLA_INC_DIR', MLA_BASE_DIR_LONG . '/includes/' );	// ../wp-content/plugins/ml-adverts/includes/  (physical file path)
define( 'MLA_LIB_DIR', MLA_BASE_DIR_LONG . '/lib/' );		// ../wp-content/plugins/ml-adverts/lib/  (physical file path)
define( 'MLA_BASE_URL', plugin_dir_url( __FILE__ ) );		// http://mysite.com/wp-content/plugins/ml-adverts/
define( 'MLA_ASSETS_URL', MLA_BASE_URL . 'assets/' );		// http://mysite.com/wp-content/plugins/ml-adverts/assets/
define( 'MLA_CSS_URL', MLA_BASE_URL . 'css/' );
define( 'MLA_JS_URL', MLA_BASE_URL . 'js/' );

require_once( MLA_INC_DIR . 'functions.php' );
require_once( MLA_INC_DIR . 'upgrade.php' );
require_once( MLA_INC_DIR . 'load-js.php' );
require_once( MLA_INC_DIR . 'post-type.php' );
require_once( MLA_INC_DIR . 'metaboxes.php' );
require_once( MLA_INC_DIR . 'taxonomies.php' );
require_once( MLA_INC_DIR . 'advert.class.php' );
require_once( MLA_INC_DIR . 'location.class.php' );
require_once( MLA_INC_DIR . 'shortcode.php' );
require_once( MLA_INC_DIR . 'widget.php' );

/**
 * Load required files
 */
function ml_adverts_initialize() {
	if (!class_exists('cmb_Meta_Box')) {
		require_once(MLA_INC_DIR . 'metabox/init.php');
	}
}
add_action( 'init', 'ml_adverts_initialize', 9999 );

/**
 * Install/upgrade
 */
register_activation_hook(__FILE__,'ml_adverts_upgrade');
add_action('admin_init', 'ml_adverts_upgrade');