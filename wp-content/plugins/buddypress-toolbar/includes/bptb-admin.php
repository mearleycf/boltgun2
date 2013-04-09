<?php
/**
 * Helper functions for the admin - plugin links and help tabs.
 *
 * @package    BuddyPress Toolbar
 * @subpackage Admin
 * @author     David Decker - DECKERWEB
 * @copyright  Copyright 2012, David Decker - DECKERWEB
 * @license    http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link       http://genesisthemes.de/en/wp-plugins/buddypress-toolbar/
 * @link       http://twitter.com/deckerweb
 *
 * @since 1.0.0
 * @version 1.1
 */

/**
 * Setting internal plugin helper links constants
 *
 * @since 1.3.0
 * @version 1.1
 */
define( 'BPTB_URL_TRANSLATE',		'http://translate.wpautobahn.com/projects/wordpress-plugins-deckerweb/buddypress-toolbar' );
define( 'BPTB_URL_WPORG_FAQ',		'http://wordpress.org/extend/plugins/buddypress-toolbar/faq/' );
define( 'BPTB_URL_WPORG_FORUM',		'http://wordpress.org/support/plugin/buddypress-toolbar' );
define( 'BPTB_URL_WPORG_PROFILE',	'http://profiles.wordpress.org/daveshine/' );
define( 'BPTB_URL_SUGGESTIONS',		'http://twitter.com/deckerweb' );
define( 'BPTB_URL_SNIPPETS',		'https://gist.github.com/2643807' );
define( 'BPTB_PLUGIN_LICENSE', 		'GPLv2+' );
if ( get_locale() == 'de_DE' || get_locale() == 'de_AT' || get_locale() == 'de_CH' || get_locale() == 'de_LU' ) {
	define( 'BPTB_URL_DONATE', 	'http://genesisthemes.de/spenden/' );
	define( 'BPTB_URL_PLUGIN',	'http://genesisthemes.de/plugins/buddypress-toolbar/' );
} else {
	define( 'BPTB_URL_DONATE', 	'http://genesisthemes.de/en/donate/' );
	define( 'BPTB_URL_PLUGIN',	'http://genesisthemes.de/en/wp-plugins/buddypress-toolbar/' );
}


add_filter( 'plugin_row_meta', 'ddw_bptb_plugin_links', 10, 2 );
/**
 * Add various support links to plugin page
 *
 * @since 1.0.0
 * @version 1.1
 *
 * @param  $bptb_links
 * @param  $bptb_file
 * @return strings plugin links
 */
function ddw_bptb_plugin_links( $bptb_links, $bptb_file ) {

	if ( ! current_user_can( 'install_plugins' ) ) {
		return $bptb_links;
	}

	if ( $bptb_file == BPTB_PLUGIN_BASEDIR . '/buddypress-toolbar.php' ) {
		$bptb_links[] = '<a href="' . esc_url_raw( BPTB_URL_WPORG_FAQ ) . '" target="_new" title="' . __( 'FAQ', 'buddypress-toolbar' ) . '">' . __( 'FAQ', 'buddypress-toolbar' ) . '</a>';
		$bptb_links[] = '<a href="' . esc_url_raw( BPTB_URL_WPORG_FORUM ) . '" target="_new" title="' . __( 'Support', 'buddypress-toolbar' ) . '">' . __( 'Support', 'buddypress-toolbar' ) . '</a>';
		$bptb_links[] = '<a href="' . esc_url_raw( BPTB_URL_TRANSLATE ) . '" target="_new" title="' . __( 'Translations', 'buddypress-toolbar' ) . '">' . __( 'Translations', 'buddypress-toolbar' ) . '</a>';
		$bptb_links[] = '<a href="' . esc_url_raw( BPTB_URL_DONATE ) . '" target="_new" title="' . __( 'Donate', 'buddypress-toolbar' ) . '">' . __( 'Donate', 'buddypress-toolbar' ) . '</a>';
	}

	return $bptb_links;

}  // end of function ddw_bptb_plugin_links


add_action( 'load-settings_page_bp-components', 'ddw_bptb_buddypress_help', 15 );
add_action( 'load-settings_page_bp-page-settings', 'ddw_bptb_buddypress_help', 15 );
add_action( 'load-settings_page_bp-settings', 'ddw_bptb_buddypress_help', 15 );
add_action( 'load-toplevel_page_bp-activity', 'ddw_bptb_buddypress_help', 15 );
add_action( 'load-toplevel_page_bp-general-settings', 'ddw_bptb_buddypress_help', 15 );
add_action( 'load-users_page_bp-profile-setup', 'ddw_bptb_buddypress_help', 15 );
/**
 * Load plugin help tab on BuddyPress Forums admin page.
 *
 * @since 1.4.0
 *
 * @global mixed $bptb_buddypress_screen, $pagenow
 */
function ddw_bptb_buddypress_help() {

	global $bptb_buddypress_screen, $pagenow;

	$bptb_buddypress_screen = get_current_screen();

	/** Display help tabs only for WordPress 3.3 or higher */
	if( ! class_exists( 'WP_Screen' ) || ! $bptb_buddypress_screen || ! BPTB_DISPLAY )
		return;

	/** Add the help tab */
	$bptb_buddypress_screen->add_help_tab( array(
		'id'       => 'bptb-buddypress-help',
		'title'    => __( 'BuddyPress Toolbar', 'buddypress-toolbar' ),
		'callback' => 'ddw_bptb_help_tab_content',
	) );

	/** Add help sidebar */
	if ( 'bp-activity' != $_GET['page'] ) {
		$bptb_buddypress_screen->set_help_sidebar(
			'<p><strong>' . __( 'More about the plugin author', 'buddypress-toolbar' ) . '</strong></p>' .
			'<p>' . __( 'Social:', 'buddypress-toolbar' ) . '<br /><a href="http://twitter.com/deckerweb" target="_blank" title="@ Twitter">Twitter</a> | <a href="http://www.facebook.com/deckerweb.service" target="_blank" title="@ Facebook">Facebook</a> | <a href="http://deckerweb.de/gplus" target="_blank" title="@ Google+">Google+</a></p>' .
			'<p><a href="' . esc_url_raw( BPTB_URL_WPORG_PROFILE ) . '" target="_blank" title="@ WordPress.org">@ WordPress.org</a></p>'
		);
	}  // end-if page hook check

}  // end of function ddw_bptb_buddypress_help


/**
 * Create and display plugin help tab content
 *
 * @since 1.4.0
 */
function ddw_bptb_help_tab_content() {

	echo '<h3>' . __( 'Plugin', 'buddypress-toolbar' ) . ': ' . __( 'BuddyPress Toolbar', 'buddypress-toolbar' ) . ' <small>v' . esc_attr( ddw_bptb_plugin_get_data( 'Version' ) ) . '</small></h3>' .		
		'<ul>' . 
			'<li><a href="' . esc_url_raw( BPTB_URL_SUGGESTIONS ) . '" target="_new" title="' . __( 'Suggest new resource items, themes or plugins for support', 'buddypress-toolbar' ) . '">' . __( 'Suggest new resource items, themes or plugins for support', 'buddypress-toolbar' ) . '</a></li>' .
			'<li><a href="' . esc_url_raw( BPTB_URL_SNIPPETS ) . '" target="_new" title="' . __( 'Code snippets for customizing &amp; branding', 'buddypress-toolbar' ) . '">' . __( 'Code snippets for customizing &amp; branding', 'buddypress-toolbar' ) . '</a></li>';

		/** Optional: recommended plugins */
		if ( ! function_exists( 'bp_extended_settings_init' ) || ! defined( 'BPPS_VERSION' ) || ! function_exists( 'bpgd_load' ) || ! defined( 'BP_CHECKINS_PLUGIN_VERSION' ) || ! class_exists( 'BPSP_Courses' ) ) {

			echo '<li><em>' . __( 'Other, recommended BuddyPress plugins', 'buddypress-toolbar' ) . '</em>:';

			if ( ! function_exists( 'bp_extended_settings_init' ) ) {

				echo '<br />&raquo; <a href="http://wordpress.org/extend/plugins/buddypress-extended-settings/" target="_new" title="BP Extended Settings">BP Extended Settings</a> &mdash; ' . __( 'extra configuration settings for BuddyPress Admins', 'buddypress-toolbar' );

			}  // end-if plugin check

			if ( ! defined( 'BPPS_VERSION' ) ) {

				echo '<br />&raquo; <a href="http://ddwb.me/72" target="_new" title="BuddyPress Profiles Statistics (Premium)">BuddyPress Profiles Statistics (Premium)</a> &mdash; ' . __( 'analyze member profiles, registration times etc.', 'buddypress-toolbar' );

			}  // end-if plugin check

			if ( ! function_exists( 'bpgd_load' ) ) {

				echo '<br />&raquo; <a href="http://ddwb.me/71" target="_new" title="BP Extended Groups Description (Premium)">BP Extended Groups Description (Premium)</a> &mdash; ' . __( 'an elegant extension for better groups descriptions', 'buddypress-toolbar' );

			}  // end-if plugin check

			if ( ! defined( 'BP_CHECKINS_PLUGIN_VERSION' ) ) {

				echo '<br />&raquo; <a href="http://wordpress.org/extend/plugins/bp-checkins/" target="_new" title="BP Checkins">BP Checkins</a> &mdash; ' . __( 'uses HTML5 Geolocation API to publish checkins or places', 'buddypress-toolbar' );

			}  // end-if plugin check

			if ( ! class_exists( 'BPSP_Courses' ) ) {

				echo '<br />&raquo; <a href="http://wordpress.org/extend/plugins/buddypress-courseware/" target="_new" title="BuddyPress ScholarPress Courseware">BuddyPress ScholarPress Courseware</a> &mdash; ' . __( 'a Learning Management System (LMS) for BuddyPress', 'buddypress-toolbar' );

			}  // end-if plugin check

			echo '</li>';

		}  // end-if plugins check

	echo '</ul>' .
		'<p><strong>' . __( 'Important plugin links:', 'buddypress-toolbar' ) . '</strong>' . 
		'<br /><a href="' . esc_url_raw( BPTB_URL_PLUGIN ) . '" target="_new" title="' . __( 'Plugin Website', 'buddypress-toolbar' ) . '">' . __( 'Plugin Website', 'buddypress-toolbar' ) . '</a> | <a href="' . esc_url_raw( BPTB_URL_WPORG_FAQ ) . '" target="_new" title="' . __( 'FAQ', 'buddypress-toolbar' ) . '">' . __( 'FAQ', 'buddypress-toolbar' ) . '</a> | <a href="' . esc_url_raw( BPTB_URL_WPORG_FORUM ) . '" target="_new" title="' . __( 'Support', 'buddypress-toolbar' ) . '">' . __( 'Support', 'buddypress-toolbar' ) . '</a> | <a href="' . esc_url_raw( BPTB_URL_TRANSLATE ) . '" target="_new" title="' . __( 'Translations', 'buddypress-toolbar' ) . '">' . __( 'Translations', 'buddypress-toolbar' ) . '</a> | <a href="' . esc_url_raw( BPTB_URL_DONATE ) . '" target="_new" title="' . __( 'Donate', 'buddypress-toolbar' ) . '">' . __( 'Donate', 'buddypress-toolbar' ) . '</a></p>' .
		'<p><a href="http://www.opensource.org/licenses/gpl-license.php" target="_new" title="' . esc_attr( BPTB_PLUGIN_LICENSE ). '">' . esc_attr( BPTB_PLUGIN_LICENSE ). '</a> &copy; ' . date( 'Y' ) . ' <a href="' . esc_url_raw( ddw_bptb_plugin_get_data( 'AuthorURI' ) ) . '" target="_new" title="' . esc_attr__( ddw_bptb_plugin_get_data( 'Author' ) ) . '">' . esc_attr__( ddw_bptb_plugin_get_data( 'Author' ) ) . '</a></p>';

}  // end of function ddw_bptb_help_tab_content
