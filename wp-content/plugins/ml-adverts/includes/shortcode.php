<?php
/*
 * ML Advert shortcode.
 */
function ml_adverts_shortcode_func( $atts ) {
    global $post;

    extract( shortcode_atts( array(
        'location' => null
    ), $atts ) );

    if ($location != null) {
        $ml_location = new ML_Adverts_Location($location);

        $list = "<ul style='margin: 0; padding: 0;' class='ml-adverts-" . $location . "'>";

        foreach ($ml_location->get_adverts() as $advert) {
            $advert->record_impression();

            $list .= "<li style='margin: 0; padding: 0;' class='" . $advert->get_css_class() . "'>" . $advert->get_code() . "</li>";
        }

        $list .= "</ul>";

        return $list;
    }

    return false;
}
add_shortcode( 'ml-adverts', 'ml_adverts_shortcode_func' );