<?php
/**
 * Plugin Name: Home extras (vm14)
 * Description: Widgets and other special features for the home page.
 * Version: 1.0
*/


class VM14_Custom_Blurb_Widget extends WP_Widget {
    function __construct() {
        $widget_ops = array('description' => __('Use this widget to create photo/title blurbs on the home page.', 'vm14_home_extras'));
        parent::__construct('vm14_custblurb', __('Custom blurb', 'vm14_home_extras'), $widget_ops);
    }

    function widget($args, $instance) {
        $src = wp_get_attachment_image_src($instance['media_id'], 'vm14_medium'); // TODO: Use correct size
        printf('<a href="%s"><div class="blurb-img-holder"><img src="%s"></div><p>%s</p></a>',
            $instance['href'], $src[0], $instance['caption']);
    }

    function update($new_instance, $old_instance) {
        $old_instance['media_id'] = $new_instance['media_id'];
        $old_instance['caption'] = $new_instance['caption'];
        $old_instance['href'] = $new_instance['href'];
        return $old_instance;
    }

    function form($instance) {
        $media_id = null;
        $media_src = '';

        if (is_numeric($instance['media_id'])) {
            $attachment = get_post($instance['media_id']);
            if ($attachment) {
                $src = wp_get_attachment_image_src($instance['media_id'], 'thumb');
                if ($src) {
                    $media_id = $instance['media_id'];
                    $media_src = $src[0];
                }
            }
        }

        printf('<a href="#" class="vm14_custom_blurb_media_link">Select image</a><br>');
        printf('<img src="%s" class="vm14_custom_blurb_media_img" style="width:220px; height:auto;">', $media_src);
        printf('<input type="hidden" class="vm14_custom_blurb_media_id" id="%s" name="%s" value="%s">',
            $this->get_field_id('media_id'),
            $this->get_field_name('media_id'),
            $media_id);

        printf('<textarea id="%s" name="%s" style="width:220px; height:60px;">%s</textarea><br>',
            $this->get_field_id('caption'),
            $this->get_field_name('caption'),
            $instance['caption']);

        printf('<label for="%s">%s:</label> ',
            $this->get_field_id('href'),
            __('Link URL', 'vm14_home_extras'));

        printf('<input type="url" id="%s" name="%s" value="%s">',
            $this->get_field_id('href'),
            $this->get_field_name('href'),
            $instance['href']);
    }

    static function setup_head() {
        if (did_action('wp_enqueue_media')===0)
            wp_enqueue_media();

        $plugin_url = WP_PLUGIN_URL.'/'.basename(dirname(__FILE__));

        wp_register_script('vm14_custom_blurb_admin_js', $plugin_url.'/js/admin.js', array('jquery', 'media-upload', 'media-views'));
        wp_enqueue_script('vm14_custom_blurb_admin_js');
    }
}



class VM14_News_Widget extends WP_Widget {
    function __construct() {
        $widget_ops = array('description' => __('News widget (half-width) for home page.', 'vm14_home_extras'));
        parent::__construct('vm14_newswidget', __('News widget', 'vm14_home_extras'), $widget_ops);
    }

    function widget($args, $instance) {
        $items = vm14_get_posts();
        include('news_widget.html');
    }

    function update($new_instance, $old_instance) {
        $old_instance['header'] = $new_instance['header'];
        return $old_instance;
    }

    function form($instance) {
        printf('<label for="%s">%s:</label> ',
            $this->get_field_id('header'),
            __('Header text', 'vm14_home_extras'));
        
        printf('<input type="text" id="%s" name="%s" value="%s">',
            $this->get_field_id('header'),
            $this->get_field_name('header'),
            $instance['header']);
    }
}


function vm14_home_extras_widgets() {
    register_widget('VM14_Custom_Blurb_Widget');
    register_widget('VM14_News_Widget');
}

add_action('admin_head', array('VM14_Custom_Blurb_Widget', 'setup_head'));
add_action('widgets_init', 'vm14_home_extras_widgets');
