<?php
/*
 * Class represting single Advert
 */
class ML_Adverts_Advert
{
	private $advert_id;

	/**
	 * Construct
	 */
	function __construct($advert_id) {
		$this->set_advert_id($advert_id);
	}

	/**
	 * Return the advert ID
	 */
	public function get_advert_id() {
		return $this->advert_id;
	}

	/**
	 * Set the advert ID
	 */
	public function set_advert_id($id) {
		$this->advert_id = $id;
	}

	/**
	 * Get metadata for advert
	 */
	public function get_meta($key) {
		return get_post_meta($this->get_advert_id(), 'ml_advert_' . $key, true);
	}

	/**
	 * Find and return the banner HTML or Image
	 */
	public function get_code() {
        if ($this->get_meta('type') == 'html') {
            $ret_val = $this->get_html();
        } else {
            $ret_val = $this->get_image();
        }

        return $ret_val;
	}

	/**
	 * Return css class string
	 */
	public function get_css_class() {
		return "ml-adverts-" . $this->get_advert_id();
	}

	/**
	 * Return the advert image markup
	 */
	private function get_image() {
	    $url_mask = $this->get_meta('url_mask');

	    if ($url_mask == '') {
	        $url_mask = $this->get_meta('url');
	    }

	    $ret_val = "<a" .
	                   " href='" . MLA_BASE_URL . "out.php?id=" . $this->get_advert_id() . "'" . 
	                   " onmouseover='maskLink(this,event,\"" . $url_mask . "\")'" .
	                   " onclick='maskLink(this,event,\"" . $url_mask . "\")'" . 
	                   " onmouseout='maskLink(this,event,\"" . $url_mask . "\")'" .
	                   " rel='nofollow'" .
	                   " nopin='nopin'" .
	                   " target='_blank' />";

	    $ret_val .= "<img src='" . $this->get_meta('image') . "' />";
	    $ret_val .= "</a>";

	    return $ret_val;
	}


	/**
	 * Return the advert HTML
	 */
	private function get_html() {
	    return html_entity_decode($this->get_meta('html'));
	}

	/**
	 * Determine if the advert is active
	 */
	public function is_active() {
      	$location = get_the_terms( $this->get_advert_id(), 'ml-adverts-location');

      	$errors = array();

      	if (count($location) == 0 || !$location) {
      		$errors[] = "Not tagged to location";
      	}

      	if ($this->get_meta('pages') == '' && $this->get_meta('post_types') == '') {
      		$errors[] = "Not set to display on any posts or pages";
      	}

      	if ($this->get_meta('start_date') == '') {
      		$errors[] = "Start date not set";
      	} else if ($this->get_meta('start_date') > time()) {
      		$errors[] = "Start date is in the future";
      	}

      	if ($this->get_meta('end_date') == '') {
      		$errors[] = "End date not set";
      	} else if ($this->get_meta('end_date') < time()) {
      		$errors[] = "End date has passed (banner expired)";
      	}

      	if (get_post_status($this->get_advert_id()) != 'publish') {
      		$errors[] = "Advert is not published";
      	}

      	return $errors;
	}

	/**
	 * Return total number of clicks
	 */
	public function get_clicks() {
		global $wpdb;

		$wpdb->get_results( 
			"SELECT id FROM " . $wpdb->prefix . "ml_adverts_clicks
			WHERE advert_id = " . $this->get_advert_id()
		);

		$num_rows = $wpdb->num_rows;

		wp_reset_query();
		
		return $num_rows;
	}

	/**
	 * Return total number of impressions
	 */
	public function get_impressions() {
		global $wpdb;

		$impressions = $wpdb->get_var( 
			"SELECT SUM(impressions) FROM " . $wpdb->prefix . "ml_adverts_impressions
			WHERE advert_id = " . $this->get_advert_id()
		);

		wp_reset_query();
		
		return $impressions;
	}

	/**
	 * Record an impression against an advert
	 */
	public function record_impression() {
		global $wpdb;

		$today = strtotime('today');

		$impressionsToday = $wpdb->get_var( 
			"SELECT impressions FROM " . $wpdb->prefix . "ml_adverts_impressions
			WHERE time = '" . $today . "' AND advert_id = " . $this->get_advert_id()
		);

		if ($impressionsToday >= 1) {
			$impressionsToday++;

			$sql = "UPDATE " . $wpdb->prefix . "ml_adverts_impressions 
					SET impressions = " . $impressionsToday  . "
					WHERE time = '" . $today . "'
					AND advert_id = " . $this->get_advert_id();
    		
    		$wpdb->query($sql);
		} else {
			$wpdb->insert( 
				$wpdb->prefix . 'ml_adverts_impressions', array( 
					'advert_id' => $this->get_advert_id(),
					'impressions' => '1',
					'time' => $today
				)
			);
		}

		wp_reset_query();
	}

	/**
	 * Record a click against an advert
	 */
	public function record_click() {
		global $wpdb;

		$user_agent = mysql_real_escape_string($_SERVER["HTTP_USER_AGENT"]);

		$wpdb->insert( 
			$wpdb->prefix . 'ml_adverts_clicks', array( 
				'advert_id' => $this->get_advert_id(),
				'user_agent' => $user_agent,
				'time' => current_time('mysql')
			)
		);
	}
}