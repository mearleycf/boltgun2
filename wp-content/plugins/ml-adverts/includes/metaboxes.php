<?php
/**
 * Add metaboxes to ML Advert post type
 */
function ml_adverts_metaboxes( $meta_boxes ) {
	$prefix = 'ml_advert_'; // Prefix for all fields

	// pages
	$pages = get_pages(); 
	$all_pages = array('all' => 'All Pages', 'search' => 'Search Results', 'latest_posts' => 'Latest Posts');
	foreach ( $pages as $page ) {
		$all_pages[$page->ID] = $page->post_title;
	}

	// posts
	$post_types = get_post_types(array('public' => true), 'objects');
	$all_post_types = array('all' => 'All Post Types');
	foreach ($post_types as $post_type => $object) {
		if (!in_array($post_type, array('attachment', 'page'))) {
			$all_post_types[$post_type] = $object->labels->name;			
		}
	}

	// tags
	$tags = get_tags();
	$all_tags = array('all' => 'All Tags');
	foreach ($tags as $tag) {
		$all_tags[$tag->term_id] = $tag->name;
	}

	$meta_boxes[] = array(
		'id' => $prefix . 'custom_metaboxes_main',
		'title' => 'Advert',
		'pages' => array('ml-advert'),
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true,
		'fields' => array(
			array(
				'name' => 'Type *',
				'id' => $prefix . 'type',
				'type' => 'radio_inline',
				'options' => array(
					array('name' => 'Image', 'value' => 'image'),
					array('name' => 'HTML', 'value' => 'html')
				)
			),
			array(
				'name' => 'Image *',
				'desc' => 'Upload an image or enter a URL.',
				'id' => $prefix . 'image',
				'type' => 'file',
				'save_id' => false,
				'allow' => array( 'url', 'attachment' ) //
			),
			array(
				'name' => 'URL *',
				'id' => $prefix . 'url',
				'type' => 'text',	
			),
			array(
				'name' => 'URL Mask',
				'id' => $prefix . 'url_mask',
				'desc' => 'URL to display in the browser status bar.',
				'type' => 'text',	
			),
			array(
				'name' => 'HTML *',
				'id' => $prefix . 'html',
				'desc' => 'Ad code.',
				'type' => 'textarea_small',	
			)
		),
	);

	$meta_boxes[] = array(
		'id' => $prefix . 'custom_metaboxes_dates',
		'title' => 'Dates',
		'pages' => array('ml-advert'),
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true,
		'fields' => array(
			array(
				'name' => 'Start Date *',
				'id' => $prefix . 'start_date',
				'type' => 'text_date_timestamp'
			),
			array(
				'name' => 'End Date *',
				'id' => $prefix . 'end_date',
				'type' => 'text_date_timestamp'
			)
		),
	);

	$meta_boxes[] = array(
		'id' => $prefix . 'custom_metaboxes_location',
		'title' => 'Locations',
		'pages' => array('ml-advert'),
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true,
		'fields' => array(
			array(
				'name' => 'Advert Location *',
				'desc' => 'Select location for advert',
				'id' => $prefix . 'area',
				'taxonomy' => 'ml-adverts-location',
				'type' => 'taxonomy_multicheck',	
			)
		),
	);

	$meta_boxes[] = array(
		'id' => $prefix . 'custom_metaboxes_restrictions',
		'title' => 'Display Restrictions (Advanced)',
		'pages' => array('ml-advert'),
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true,
		'fields' => array(
			array(
				'name' => 'Pages *',
				'desc' => 'Select pages on which to display advert',
				'id' => $prefix . 'pages',
				'type' => 'multicheck',
				'options' => $all_pages
			),
			array(
				'name' => 'Post Types *',
				'desc' => 'Select post types on which to display advert',
				'id' => $prefix . 'post_types',
				'type' => 'multicheck',
				'options' => $all_post_types
			),
			array(
				'name' => 'Tag Archives *',
				'desc' => 'Select tag types on which to display advert',
				'id' => $prefix . 'tags',
				'type' => 'multicheck',
				'options' => $all_tags
			)
		),
	);

	return $meta_boxes;
}
add_filter( 'cmb_meta_boxes', 'ml_adverts_metaboxes' );