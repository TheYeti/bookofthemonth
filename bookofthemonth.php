<?php
/*
Plugin Name: BookOfTheMonth
Plugin URI: http://theyeticave.net
Description: Add in a sidebar widget to display a book of the month.
Author: Matt 'The Yeti' Burnett
Author URI: http://www.yeticavestudio.com
Version: 1.0.0
*/

class BotM_Widget extends WP_Widget {
    /*
     * Register Widget
     */
    public function __construct()
    {
        parent::__construct(
            'botm_widget',
            __( 'Book of the Month', 'text_domain'),
            array('description' => __('A Book of the Month Widget', 'text_domain'), )
        );
    }

    /*
     * Front-end widget display
     *
     * @param array $args   Widget arguments
     * @param array $instance   Saved values from db
     */
    public function widget($args, $instance)
    {
        echo $args['before_widget'];

        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        if (!empty($instance['isbn'])) {
            echo __('ISBN: ' . $instance['isbn'], 'text_domain');
        } else
            echo __('No Book Info Set', 'text_domain');
        echo $args['after_widget'];
    }

    /*
     * Back-end widget form
     *
     * @param array $instance Previously saved db values
     */
    public function form($instance)
    {
        $title = !empty($instance['title']) ? $instance['title'] : __('New Title', 'text_domain');
        $isbn = !empty($instance['isbn']) ? $instance['isbn'] : __('Enter ISBN', 'text_domain');
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">
                <?php _e('Title: '); ?>
            </label>
            <input class="widgetfat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('isbn'); ?>">
                <?php _e('ISBN: '); ?>
            </label>
            <input class="widgetfat" id="<?php echo $this->get_field_id('isbn'); ?>" name="<?php echo $this->get_field_name('isbn'); ?>" type="text" value="<?php echo esc_attr($isbn); ?>">
        </p>
        <?php
    }

    /*
     * Sanitize widget values as they are saved
     *
     * @param array $new_instance   Values to be saved
     * @param array $old_instance   Previously saved db values
     *
     * @return array    Updated safe values to be saved
     */
    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['isbn'] = (!empty($new_instance['isbn'])) ? strip_tags($new_instance['isbn']) : '';

        return $instance;
    }
}

function botm_header() {
    wp_enqueue_script('gapi', '//apis.google.com/js/client.js');
    wp_enqueue_script('botm', plugins_url('js/wowpress.js', __FILE__));
}

function register_botm_widget() {
    register_widget('BotM_Widget');
}

add_action('widgets_init', 'register_botm_widget');
add_action('wp_head', 'botm_header');
add_action('wp_enqueue_scripts', 'botm_header');