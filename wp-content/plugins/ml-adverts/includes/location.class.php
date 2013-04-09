<?php
/**
 * Class respresenting an advert location. An advert location can contain
 * a single or multiple adverts.
 */
class ML_Adverts_Location
{
	private $location;

	/**
	 * Construct
	 */
	function __construct($location) {
		$this->set_location($location);
	}

	/**
	 * Get location slug
	 */
	public function get_location() {
		return $this->location;
	}

	/**
	 * Set location slug
	 */
	public function set_location($location) {
		$this->location = $location;
	}

	/**
	 * Return the number of adverts to display in this location
	 */
	public function get_number_of_adverts_to_display() {
	    // put the term ID into a variable
	    $term = get_term_by( 'slug', $this->get_location(), 'ml-adverts-location' );

	    $t_id = $term->term_id;

	    // retrieve the existing value(s) for this meta field. This returns an array
	    $term_meta = get_option( "taxonomy_$t_id" ); 

        $number_of_adverts_to_display = esc_attr( $term_meta['number_of_adverts'] ) ? esc_attr( $term_meta['number_of_adverts'] ) : '1';

        if ($number_of_adverts_to_display == -1) {
        	$number_of_adverts_to_display = 9999; //unlimited
        } 

		return $number_of_adverts_to_display;
	}

	/**
	 * Return adverts for location
	 */
	public function get_adverts() {
		$advert_query = $this->get_query();
		$advert_collection = array();

        while( $advert_query->have_posts() ) {
            $advert_query->next_post();
            $id = $advert_query->post->ID;

            $advert_collection[] = new ML_Adverts_Advert($id);
        }

		wp_reset_query();
		wp_reset_postdata();

        return $advert_collection;
	}

	/**
	 * Construct the query to collect adverts for this location
	 */
	private function get_query() {
	    global $post;

	    wp_reset_query();

	    $args['post_type'] = 'ml-advert';
	    $args['orderby'] = 'rand';
	    $args['posts_per_page'] = $this->get_number_of_adverts_to_display();

	    if ($location = $this->get_location()) {
		    $args['tax_query'] = array(
		        array(
		            'taxonomy' => 'ml-adverts-location',
		            'field' => 'slug',
		            'terms' => $location
		        )
		    );
	    }

	    if (is_page()) {
	        $args['meta_query'][] = array(
	            'key' => 'ml_advert_pages',
	            'value' => array('all' , $post->ID),
	            'compare' => 'IN'
	        );
	    }

	    if (is_search()) {
	        $args['meta_query'][] = array(
	            'key' => 'ml_advert_pages',
	            'value' => array('all' , 'search'),
	            'compare' => 'IN'
	        );
	    }

	    if (is_home()) {
	        $args['meta_query'][] = array(
	            'key' => 'ml_advert_pages',
	            'value' => array('all' , 'latest_posts'),
	            'compare' => 'IN'
	        );
	    }

	    if (is_single()) {
	        $args['meta_query'][] = array(
	            'key' => 'ml_advert_post_types',
	            'value' => array('all' , get_post_type($post->ID)),
	            'compare' => 'IN'
	        );
	    }

	    if (is_tag()) {
	    	$tag_id = (int)get_query_var('tag_id');

	        $args['meta_query'][] = array(
	            'key' => 'ml_advert_tags',
	            'value' => array('all' , $tag_id),
	            'compare' => 'IN'
	        );
	    }

	    $args['meta_query'][] = array(
	        'key' => 'ml_advert_start_date',
	        'value' => time(),
	        'compare' => '<'
	    );

	    $args['meta_query'][] = array(
	        'key' => 'ml_advert_end_date',
	        'value' => time(),
	        'compare' => '>'
	    );

	    return new WP_Query( $args );
	}
}