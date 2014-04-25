<?php

class VM14_Page_Post_Type extends VM14_Post_Type {
    static $menu;
    static $summary;
    static $feed_categories;

    static $meta_groups;

    static function register_type(&$meta) {
        // No need to register this type as it overrides the already
        // existing built-in page post type.
        register_taxonomy_for_object_type('category', $meta['id']);
        register_taxonomy_for_object_type('post_tag', $meta['id']);

        add_filter('acf/load_field/name=page_menu', array(VM14_Page_Post_Type, 'populate_menu_select'));
    }

    static function populate_menu_select($field) {
        $menus = get_registered_nav_menus();
        $menus = get_terms( 'nav_menu', array( 'hide_empty' => true ) );
        $field['choices'] = array(
            'parent' => __("(Parent's menu)")
        );

        for ($i=0; $i<count($menus); $i++) {
            $key = $menus[$i]->slug;
            $field['choices'][$key] = $menus[$i]->name;
        }

        return $field;
    }

    public function get_menu_id() {
        $menu_id = $this->menu;
        $ancestors = get_post_ancestors($this->id);
        for ($i=0; $i<count($ancestors); $i++) {
            $page = vm14_get_post($ancestors[$i]);
            if ($page->menu != 'parent') {
                $menu_id = $page->menu;
                break;
            }
        }

        return ($menu_id != 'parent')? $menu_id : null;
    }

    public function has_feed() {
        if ($this->feed_categories) {
            return true;
        }
        else {
            return false;
        }
    }

    public function get_feed($posts_per_page) {
        if (!is_numeric($posts_per_page))
            $posts_per_page = 30;

        if ($this->has_feed()) {
            $categories = implode(',', $this->feed_categories);
            return vm14_get_posts(array(
                'category' => $categories,
                'posts_per_page' => $posts_per_page
            ));
        }
    }
}

VM14_Page_Post_Type::$meta_groups = array(
    'misc' => array(
        'title' => __('Misc'),
        'position' => 'side',
        'layout' => 'box'
    )
);

VM14_Page_Post_Type::$menu = new VM14_Post_Type_Field(array(
    'widget' => 'select',
    'group' => 'misc'
));

VM14_Page_Post_Type::$summary = new VM14_Post_Type_Field(array(
    'widget' => 'wysiwyg'
));

VM14_Page_Post_Type::$feed_categories = new VM14_Post_Type_Taxonomy();

