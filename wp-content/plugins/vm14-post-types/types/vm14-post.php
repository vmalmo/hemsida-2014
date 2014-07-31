<?php

class VM14_Post_Post_Type extends VM14_Post_Type {
    static $summary;
    static $show_share_buttons;

    static $meta_groups;

    static function register_type(&$meta) {
        // No need to register this type as it overrides the already
        // existing built-in standard post type.
    }
}

VM14_Post_Post_Type::$meta_groups = array(
    'social_fields' => array(
        'title' => __('Social share buttons'),
        'position' => 'side',
        'layout' => 'box',
    )
);

VM14_Post_Post_Type::$summary = new VM14_Post_Type_Field(array(
    'widget' => 'textarea'
));
VM14_Post_Post_Type::$show_share_buttons = new VM14_Post_Type_Field(array(
  'widget' => 'true_false',
  'default' => 1,
  'group' => 'social_fields'
));
