<?php

define('WP_USE_THEMES', false);
require('../../../wp-blog-header.php');

if(isset($_GET['id']) && (int)$_GET['id'] > 0) {
	$advert_id = (int)$_GET['id'];

	$advert = new ML_Adverts_Advert($advert_id);
	$advert->record_click();

	if ($url = $advert->get_meta('url')) {
		wp_redirect(htmlspecialchars_decode($url), 302);
		exit();
	}else {
		echo "Invalid ID";
	}
} else {
	echo "Invalid ID";
}

exit();