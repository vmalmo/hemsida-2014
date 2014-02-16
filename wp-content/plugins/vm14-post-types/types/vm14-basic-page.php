<?php

class VM14_Page_Post_Type extends VM14_Post_Type {
    static $summary;
    static $content_category;

    static function register_type(&$meta) {
        // No need to register this type as it overrides the already
        // existing built-in page post type.
        register_taxonomy_for_object_type('category', $meta['id']);
        register_taxonomy_for_object_type('post_tag', $meta['id']);
    }
}

VM14_Page_Post_Type::$summary = new VM14_Post_Type_Field(array(
    'widget' => 'wysiwyg'
));

VM14_Page_Post_Type::$content_category = new VM14_Post_Type_Taxonomy();

