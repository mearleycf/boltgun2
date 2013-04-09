<?php
/**
 * Register the adverts post type
 */
add_action('init', 'ml_adverts_register_posttype');

/**
 * Create ML Advert post type
 */ 
function ml_adverts_register_posttype() {
	$labels = array(
		'name' 				=> _x( 'Adverts', 'post type general name' ),
		'singular_name'		=> _x( 'Advert', 'post type singular name' ),
		'add_new' 			=> __( 'Add New Advert' ),
		'add_new_item' 		=> __( 'Add New Advert' ),
		'edit_item' 		=> __( 'Edit Advert' ),
		'new_item' 			=> __( 'New Advert' ),
		'view_item' 		=> __( 'View Advert' ),
		'search_items' 		=> __( 'Search Adverts' ),
		'not_found' 		=> __( 'Advert' ),
		'not_found_in_trash'=> __( 'Advert' ),
		'parent_item_colon' => __( 'Advert' ),
		'menu_name'			=> __( 'ML Adverts' )
	);
	
	$taxonomies = array('ml-adverts-location');
	
	$supports = array('title');
	
	$post_type_args = array(
		'labels' 			=> $labels,
		'singular_label' 	=> __('Advert'),
		'public' 			=> false,
		'show_ui' 			=> true,
		'publicly_queryable'=> true,
		'query_var'			=> true,
		'capability_type' 	=> 'post',
		'has_archive' 		=> true,
		'hierarchical' 		=> false,
		'rewrite' 			=> array('slug' => '', 'with_front' => false ),
		'supports' 			=> $supports,
		'menu_position' 	=> 999999, // Where it is in the menu. Change to 6 and it's below posts. 11 and it's below media, etc.
		'menu_icon' 		=> MLA_ASSETS_URL . 'matchalabs.png',
		'taxonomies'		=> $taxonomies
	 );
	 register_post_type('ml-advert',$post_type_args);
}


/**
 *
 */
function ml_adverts_set_custom_advert_columns($columns) {
	if (isset($columns['date'])) unset($columns['date']);
	if (isset($columns['sticky'])) unset($columns['sticky']);

    return array_merge($columns, array(
    	'impressions' => __('Impressions'), 
        'clicks' => __('Clicks'),
        'start' => __('Start Date'),
        'end' => __('End Date'),
        'locations' => __('Locations'),
        'status' => __('Status')
    ));
}
add_filter( 'manage_edit-ml-advert_columns', 'ml_adverts_set_custom_advert_columns' );


/**
 *
 */
function ml_adverts_custom_advert_column( $column, $post_id ) {
   $advert = new ML_Adverts_Advert($post_id);

    switch ( $column ) {
      case 'impressions':
      	$count = $advert->get_impressions();
        echo $count == '' ? "0" : $count;
        break;
      case 'clicks':
        if ($advert->get_meta('type') == 'html') {
        	echo "N/A";
        } else {
	      	$count = $advert->get_clicks();
	        echo $count == '' ? "0" : $count;
        }
        break;
      case 'start':
      	$timestamp = $advert->get_meta('start_date');
      	echo $timestamp > 0 ? date_i18n(get_option('date_format') , $timestamp) : "Not set";
        break;
      case 'end':
      	$timestamp = $advert->get_meta('end_date');
      	echo $timestamp > 0 ? date_i18n(get_option('date_format') , $timestamp) : "Not set";
        break;
      case 'locations':
      	$locations = get_the_terms( $post_id, 'ml-adverts-location');

      	if (count($locations) > 0 && $locations) {
      		foreach ($locations as $location) {
      			echo $location->name . "<br />";
      		}
      	} else {
            echo "Not set";
        }
        break;
      case 'status':
          $errors = $advert->is_active();

          if (count($errors)) {
            echo "<strong>Inactive</strong><br /><ul style='font-size: 10px;'>";
            foreach ($errors as $error) {
              echo "<li>". $error . "</li>";
            }
            echo "</ul>";
          } else {
              echo "<strong>Active</strong>";
          }
        break;
    }
}
add_action( 'manage_ml-advert_posts_custom_column' , 'ml_adverts_custom_advert_column', 10, 2 );

/**
 *
 */
function ml_adverts_admin_notices() {
    if (ml_adverts_get_current_post_type() == 'ml-advert' ) {
    ?>
    <!--div style='width: 100%; text-align: center; padding-top: 15px;'><a href="http://www.matchalabs.com">Wordpress Experts</a></div-->
    <?php
    }    
}
add_action('all_admin_notices', 'ml_adverts_admin_notices');