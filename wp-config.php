<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('WP_CACHE', true); //Added by WP-Cache Manager
define( 'WPCACHEHOME', '/home/chainsword/boltgunshq.com/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager
define('DB_NAME', 'boltgunshq_com');

/** MySQL database username */
define('DB_USER', 'boltgunshqcom');

/** MySQL database password */
define('DB_PASSWORD', 'DvQ-sMe6');

/** MySQL hostname */
define('DB_HOST', 'mysql.boltgunshq.com');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'Y@7^56RFCCf^WDW|3HF&q9g#U#Aa$X8wb0gMX:Gf%zQp;(UBWBUJrRVu#jXYRife');
define('SECURE_AUTH_KEY',  '^U`zz`owZ69DMc3P6d89X!$#EoOoUN@I/;4:b4(aqs|m@uNC$AqDN_S^0Hw%Pd9R');
define('LOGGED_IN_KEY',    't`fjv`y+Ud_izZA+mcvh_$Q_#"3q8n(aF76S80ZrOA!;$|@w(YWX@3$b|Hd/%YO4');
define('NONCE_KEY',        '2~LpyI4grv$4:(r7X9^zGvTc"wJi;BKTA#^!yrQ$?jO4cPN98I3ZDS&j+79miCx@');
define('AUTH_SALT',        'F)b*mn/?UjXq3udW9Sga`(vJ*BJqt?!BZaD&93$b2#B`DF_~#rokOERcVDX&DN#|');
define('SECURE_AUTH_SALT', '+MS`CSUwpZVBy`??;IMZT"O;%vPW0hIf+a!OS`6IMO8)~5@+%NSTe7Zh_ZkX4iKl');
define('LOGGED_IN_SALT',   'nxXGgN9H_5CS0xEi:yP_N#?CdC1Hhy3gy;1TS2pKXxCu#BCmQXCLpU:ivDW?`~ZU');
define('NONCE_SALT',       '$m!2mQsNb|/kRy@5"z?)AqN?GJ??I:/q%+`84CLOz_YLWl8_Wo`+Hn("O5*XwQ11');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_z7xsjc_';

/**
 * Limits total Post Revisions saved per Post/Page.
 * Change or comment this line out if you would like to increase or remove the limit.
 */
define('WP_POST_REVISIONS',  10);

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

