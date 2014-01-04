<?php

class VM14_Post_Post_Type extends VM14_Post_Type {
    static $summary;

    static function register_type(&$meta) {
        // No need to register this type as it overrides the already
        // existing built-in standard post type.
    }
}

VM14_Post_Post_Type::$summary = new VM14_Post_Type_Field(array(
    'widget' => 'wysiwyg'
));
