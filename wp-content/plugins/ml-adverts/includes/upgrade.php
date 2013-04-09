<?php

/**
 * Handle plugin upgrade
 */
function ml_adverts_upgrade() {
   if (get_option("ml_adverts_db_version") < 1) {
   		ml_adverts_update_to_version_1();
   }

   if (get_option("ml_adverts_db_version") < 2) {
   		ml_adverts_update_to_version_2();
   }
}

/**
 * DB Version 1: Create ml_advert_stats table
 */
function ml_adverts_update_to_version_1() {
	global $wpdb;

	$table_name = $wpdb->prefix . "ml_adverts_stats";

	$sql = "CREATE TABLE IF NOT EXISTS $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		advert_id mediumint(9) NOT NULL,
		type char(10),
		user_agent text,
		UNIQUE KEY id (id),
		KEY advert_id (advert_id),
		KEY type (type)
	);";

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

	dbDelta($sql);

	add_option("ml_adverts_db_version", 1);
}

/**
 * DB Version 2: Create impressions table and copy existing impressions into it.
 * (Impressions are now stored in a single row for each day)
 */
function ml_adverts_update_to_version_2() {
	global $wpdb;

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

	$table_impressions = $wpdb->prefix . "ml_adverts_impressions";
	$table_stats = $wpdb->prefix . "ml_adverts_stats";
	$table_clicks = $wpdb->prefix . "ml_adverts_clicks";

	// create impressions table
	$wpdb->query("CREATE TABLE IF NOT EXISTS " . $table_impressions . " (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		time int NOT NULL,
		advert_id mediumint(9) NOT NULL,
		impressions mediumint(9) NOT NULL,
		UNIQUE KEY id (id)
	)");

	// copy impressions from _stats into _impressions
	$wpdb->query("INSERT INTO " . $table_impressions . " (impressions, advert_id, time)
			SELECT count(id), advert_id, UNIX_TIMESTAMP(DATE_FORMAT(time ,'%Y-%m-%d')) 
			FROM " . $table_stats . " WHERE type = 'impression' 
			GROUP BY DAY(time), MONTH(time), YEAR(time), advert_id");

	// delete the impressions from the _stats table
	$wpdb->query("DELETE FROM " . $table_stats . " WHERE type = 'impression'");

	// rename the _stats table to _clicks
	$wpdb->query("RENAME TABLE " . $table_stats . " TO " . $table_clicks);

	// drop the 'type' field from _clicks
	$wpdb->query("ALTER TABLE " . $table_clicks . " DROP COLUMN type");

	update_option("ml_adverts_db_version", 2);
}