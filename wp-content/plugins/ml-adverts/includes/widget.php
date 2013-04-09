<?php
/*
 * Widget for displaying ML Advert locations
 */
class MLAdvertsWidget extends WP_Widget {
 
    /** construct */
    function MLAdvertsWidget() {
        parent::WP_Widget(false, $name = 'ML Adverts');    
    }
 
    /** @see WP_Widget::widget */
    function widget($args, $instance) { 
        extract( $args );
        $location = $instance['location']; 
        echo $before_widget; 
        echo do_shortcode("[ml-adverts location=$location]");
        echo $after_widget;
    }
 
    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {     
        $instance = $old_instance;
        $instance['location'] = strip_tags($new_instance['location']);

        return $instance;
    }
 
    /** @see WP_Widget::form */
    function form($instance) {  
        $location = esc_attr($instance['location']);
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('select'); ?>"><?php _e('Advert location'); ?></label>
                <?php
                     $terms = get_terms("ml-adverts-location");
                     $count = count($terms);
                     if ( $count > 0 ) {
                        ?> <select name="<?php echo $this->get_field_name('location'); ?>" id="<?php echo $this->get_field_id('select'); ?>" class="widefat"> <?php

                        foreach ( $terms as $option ) {
                            echo '<option value="' . $option->slug . '" id="' . $this->get_field_id('location') . '"', $location == $option->slug ? ' selected="selected"' : '', '>', $option->name, '</option>';
                        }

                        ?> </select> <?php
                     } else {
                        echo 'No locations found';
                     }
                ?>
            </select>
        </p>
        <?php 
    }
 
 
} // end class MLAdvertsWidget
add_action('widgets_init', create_function('', 'return register_widget("MLAdvertsWidget");'));
?>
