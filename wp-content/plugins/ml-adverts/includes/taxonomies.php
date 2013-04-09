<?php
/*
 * Taxonomy used to tag adverts to areas
 */
function ml_adverts_register_location_taxonomies() {
    $labels = array(
        'name' => __('Advert Locations'),
        'singular_name' => __('Location'),
        'search_items' => __('Search category'),
        'all_items' => __('All Advert Locations'),
        'edit_item' => __('Edit location'),
        'update_item' => __('Update location'),
        'add_new_item' => __('Add New Location'),
        'new_item_name' => __('New location name')
    ); 

    register_taxonomy(
        'ml-adverts-location',
        'ml-advert',
        array(
            'hierarchical' => true,
            'labels' => $labels,
            'query_var' => false,
            'rewrite' => false,
            'show_ui' => true,
            'show_in_nav_menus' => true
        )
    );
}
add_action('init', 'ml_adverts_register_location_taxonomies', 0);


/**
 * remove from edit page, but show in menu
 */
function ml_adverts_remove_location_meta() {
    remove_meta_box( 'ml-adverts-locationdiv', 'ml-advert', 'side' );
}
add_action( 'admin_menu' , 'ml_adverts_remove_location_meta' );

/**
 * 
 */
function ml_adverts_theme_columns($theme_columns) {
    $new_columns = array(
        'cb' => '<input type="checkbox" />',
        'name' => __('Location'),
        'shortcode' => __('Shortcode'),
        'posts' => __('Adverts'),
        'num_adverts' => __('Adverts to display')
        );
    return $new_columns;
}
add_filter("manage_edit-ml-adverts-location_columns", 'ml_adverts_theme_columns'); 


/**
 * 
 */
function ml_manage_theme_columns($out, $column_name, $theme_id) {
    $theme = get_term($theme_id, 'ml-adverts-location');
    switch ($column_name) {
        case 'shortcode': 
            $data = maybe_unserialize($theme->slug);
            $out .= '[ml-adverts location=' . $data . ']'; 
            break;
        case 'num_adverts': 
            $term_meta = get_option( "taxonomy_$theme_id" ); 
            $selected = esc_attr( $term_meta['number_of_adverts'] ) ? esc_attr( $term_meta['number_of_adverts'] ) : '1';
            $out .= $selected;
            break;
        default:
            break;
    }
    return $out;    
}
add_filter("manage_ml-adverts-location_custom_column", 'ml_manage_theme_columns', 10, 3);


/**
 *
 */
function ml_adverts_taxonomy_add_new_meta_field() {
    // this will add the custom meta field to the add new term page
    ?>
    <div class="form-field">
        <label for="term_meta[number_of_adverts]">Number of adverts</label>
        <select name="term_meta[number_of_adverts]" id="term_meta[number_of_adverts]">
            <option value='-1'>Unlimited</option>
            <option value='1' selected='selected'>1</option>
            <option value='2'>2</option>
            <option value='3'>3</option>
            <option value='4'>4</option>
            <option value='5'>5</option>
            <option value='6'>6</option>
            <option value='7'>7</option>
            <option value='8'>8</option>
            <option value='9'>9</option>
            <option value='10'>10</option>
        </select>
        <p class="description">Number of randomly selected adverts to display in this location.</p>
    </div>
<?php
}
add_action( 'ml-adverts-location_add_form_fields', 'ml_adverts_taxonomy_add_new_meta_field', 10, 2 );


/**
 *
 */
function ml_adverts_taxonomy_edit_meta_field($term) {
 
    // put the term ID into a variable
    $t_id = $term->term_id;

    // retrieve the existing value(s) for this meta field. This returns an array
    $term_meta = get_option( "taxonomy_$t_id" ); 

    $selected = esc_attr( $term_meta['number_of_adverts'] ) ? esc_attr( $term_meta['number_of_adverts'] ) : '1';

    ?>
    <tr class="form-field">
    <th scope="row" valign="top"><label for="term_meta[number_of_adverts]">Number of adverts</label></th>
        <td>
            <select name="term_meta[number_of_adverts]" id="term_meta[number_of_adverts]">
                <option value='-1'>Unlimited</option>
                <option value='1' <?php if($selected == 1) echo "selected='selected'"?>>1</option>
                <option value='2' <?php if($selected == 2) echo "selected='selected'"?>>2</option>
                <option value='3' <?php if($selected == 3) echo "selected='selected'"?>>3</option>
                <option value='4' <?php if($selected == 4) echo "selected='selected'"?>>4</option>
                <option value='5' <?php if($selected == 5) echo "selected='selected'"?>>5</option>
                <option value='6' <?php if($selected == 6) echo "selected='selected'"?>>6</option>
                <option value='7' <?php if($selected == 7) echo "selected='selected'"?>>7</option>
                <option value='8' <?php if($selected == 8) echo "selected='selected'"?>>8</option>
                <option value='9' <?php if($selected == 9) echo "selected='selected'"?>>9</option>
                <option value='10' <?php if($selected == 10) echo "selected='selected'"?>>10</option>
            </select>
            <p class="description">Number of randomly selected adverts to display in this location.</p>
        </td>
    </tr>
<?php
}
add_action( 'ml-adverts-location_edit_form_fields', 'ml_adverts_taxonomy_edit_meta_field', 10, 2 );

/**
 *
 */
// Save extra taxonomy fields callback function.
function ml_adverts_save_taxonomy_custom_meta( $term_id ) {
    if ( isset( $_POST['term_meta'] ) ) {
        $t_id = $term_id;
        $term_meta = get_option( "taxonomy_$t_id" );
        $cat_keys = array_keys( $_POST['term_meta'] );
        foreach ( $cat_keys as $key ) {
            if ( isset ( $_POST['term_meta'][$key] ) ) {
                $term_meta[$key] = $_POST['term_meta'][$key];
            }
        }
        // Save the option array.
        update_option( "taxonomy_$t_id", $term_meta );
    }
}  
add_action( 'edited_ml-adverts-location', 'ml_adverts_save_taxonomy_custom_meta', 10, 2 );  
add_action( 'create_ml-adverts-location', 'ml_adverts_save_taxonomy_custom_meta', 10, 2 );
