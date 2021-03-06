<?php
define( 'ACF_LITE' , true );
include_once('acf/acf.php' );

class VM14_Post_Type_Field {
    private $widget = 'text';
    private $group = 'default';
    private $params;
    private $media_upload = false;

    function __construct(array $params = null) {
        if ($params) {
            $this->params = $params;
            $this->widget = $this->param('widget', 'text');

            if (isset($params['group']))
                $this->group = $params['group'];
        }
        else {
            $this->params = array();
        }
    }

    function get_config($prefix, $id) {
        $meta = $this->prepare_meta($id, $this->params);

        return array(
            'key' => sprintf('%s_%s_key', $prefix, $id),
            'label' => __($meta['name']),
            'name' => sprintf('%s_%s', $prefix, $id),
            'type' => $this->widget,
            'default_value' => $this->param('default', ''),
            'media_upload' => $this->media_upload
        );
    }

    function get_group_id() {
        return $this->group;
    }

    protected function param($key, $def) {
        return isset($this->params[$key])?
            $this->params[$key] : $def;
    }

    private function prepare_meta($id, $params) {
        $meta = array();
        $meta['id'] = $id;

        self::meta($params, 'name', $meta, function(&$meta) {
            $words = explode('_', $meta['id']);
            for ($i=0; $i<sizeof($words); $i++) {
                $words[$i] = ucfirst($words[$i]);
            }

            return implode(' ', $words);
        });

        self::meta($params, 'name_plural', $meta, function(&$meta) {
            return $meta['name'].'s';
        });

        return $meta;
    }

    static private function meta($signature, $name, &$meta, $lambda) {
        $key_name = 'meta_'.$name;
        if (array_key_exists($key_name, $signature)) {
            $meta[$name] = $signature[$key_name];
        }
        else {
            $meta[$name] = $lambda($meta);
        }
    }
}

class VM14_Post_Type_Relationship extends VM14_Post_Type_Field {
    private $other;

    function __construct($other, array $params = null) {
        parent::__construct($params);

        $this->other = $other;
    }

    function get_config($prefix, $id) {
        $config = parent::get_config($prefix, $id);
        $config['type'] = 'relationship';
        $config['max'] = $this->param('max', -1);
        $config['return_format'] = 'object';
        $config['post_type'] = array($this->other);
        $config['taxonomy'] = array('all');
        $config['result_elements'] = array('post_type', 'post_title');

        return $config;
    }
}

class VM14_Post_Type_Taxonomy extends VM14_Post_Type_Field {
    function get_config($prefix, $id) {
        $config = parent::get_config($prefix, $id);
        $config['type'] = 'taxonomy';

        return $config;
    }
}

abstract class VM14_Post_Type {
    protected $post;
    protected $post_data;

    private static $default_options = array(
        'public' => true,
        'show_ui' => true,
        'query_var' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'show_in_nav_menus' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
    );

    function __construct($post) {
        $this->post = $post;

        if ($this->post) {
            // Transfer fields to a separate array to be used for dynamic look-up
            $this->post_data = array();
            $this->post_data['id'] = $post->ID;
            $this->post_data['title'] = $post->post_title;
            $this->post_data['excerpt'] = $post->post_excerpt;
            $this->post_data['content'] = $post->post_content;
            $this->post_data['image_id'] = get_post_thumbnail_id($post->ID);
            $this->post_data['image_url'] = wp_get_attachment_url(get_post_thumbnail_id($post->ID));

            // TODO: Probably a performance hog, delay until necessary?
            $class = get_called_class();
            $signature = get_class_vars($class);
            $custom_data = get_post_custom($post->ID);

            // Transfer custom fields from special array to the post_data array,
            // so that they can be retrieved using normal field look-up.
            $prefix = $post->post_type;
            foreach ($signature as $name => $field) {
                if (is_a($field, VM14_Post_Type_Field)) {
                    $key_name = $prefix.'_'.$name;
                    if (array_key_exists($key_name, $custom_data)) {
                        $value = $custom_data[$key_name];
                        if (is_array($value) && count($value)==1) {
                            $value = $value[0];
                        }

                        if (($value == serialize(false) || @unserialize($value) !== false)) {
                            $value = unserialize($value);
                        }

                        $this->post_data[$name] = $value;
                    }
                }
            }
        }
    }


    function __get($name) {
        if (array_key_exists($name, $this->post_data))
            return $this->post_data[$name];
    }

    function image_url($size = 'medium') {
      $src = wp_get_attachment_image_src($this->post_data['image_id'], $size);
      return $src[0];
    }

    function get_excerpt($len) {
        $excerpt = $this->excerpt;
        if (!strlen($excerpt)) {
            $excerpt = strip_tags($this->summary);
        }
        if (!strlen($excerpt)) {
            $excerpt = strip_tags($this->content);
        }

        if ($len == 0) {
            $excerpt = '';
        }
        else if (strlen($excerpt)>$len) {
            $last_ws = strrpos(substr($excerpt, 0, $len), ' ');
            $excerpt = substr($excerpt, 0, $last_ws);
            $excerpt .= '...';
        }

        return $excerpt;
    }

    function permalink() {
        return get_permalink($this->id);
    }

    function preview_html($len = 300) {
        $excerpt = $this->get_excerpt($len);

        $html  = sprintf('<a href="%s">', get_permalink($this->id));
        $html .= sprintf('<h4>%s</h4>', $this->title);
        $html .= get_the_post_thumbnail($this->id);
        $html .= sprintf('<p>%s</p>', $excerpt);
        $html .= '</a>';

        return $html;
    }

    function date($format) {
        return get_the_time($format, $this->id);
    }
    function categories_as_string() {
      $categories = get_the_category($this->id);
      $category_names = array();
      for ($i = 0; $i < count($categories); $i++) {
          array_push($category_names, str_replace(',', '\,',$categories[$i]->name));
      }
      return implode(',', $category_names);
    }

    function tags_as_string() {
      $raw_tags = wp_get_post_tags($this->id);
      $tags = array();
      for ($i = 0; $i < count($raw_tags); $i++) {
          array_push($tags, str_replace(',', '\,',$raw_tags[$i]->name));
      }
      return implode(',', $tags);
    }

    static function register() {
        $class = get_called_class();
        $signature = get_class_vars($class);

        $meta = self::prepare_meta($class, $signature);

        static::register_type($meta);
        static::register_fields($meta, $signature);
    }

    static function register_type(&$meta) {
        $options = array();
        $options['labels'] = array(
            'name' => __($meta['name'], 'vm14'),
            'singular_name' => __($meta['name'], 'vm14'),
            'all_items' => __('All '.$meta['name_plural'], 'vm14'),
            'add_new' => __('Add New', 'vm14'),
            'add_new_item' => __('Add New '.$meta['name'], 'vm14'),
            'edit_item' => __('Edit '.$meta['name'], 'vm14'),
            'new_item' => __('New '.$meta['name'], 'vm14'),
            'view_item' => __('View '.$meta['name'], 'vm14'),
            'search_items' => __('Search '.$meta['name_plural']),
            'parent_item_colon' => '',
            'edit' => __('Edit', 'vm14'),
            'not_found' =>  __('Nothing found in the Database.', 'vm14'),
            'not_found_in_trash' => __('Nothing found in Trash', 'vm14'),
        );

        $options['description'] = 'Hej';
        $options['menu_position'] = 4;

        $options['rewrite'] = array(
            'slug' => __($meta['slug'], 'vm14'),
            'with_front' => false,
        );

        $options['has_archive'] = __($meta['slug_plural'], 'vm14');

        $options = array_merge(self::$default_options, $options);
        register_post_type($meta['id'], $options);
        register_taxonomy_for_object_type('category', $meta['id']);
        register_taxonomy_for_object_type('post_tag', $meta['id']);
    }

    static function register_fields(&$meta, &$signature) {
        $groups = array();

        // Configure user-defined groups
        foreach ($meta['groups'] as $name => $group) {
            // Defaults
            if (!isset($group['title']))
                $group['title'] = $name;
            if (!isset($group['position']))
                $group['position'] = 'normal';
            if (!isset($group['layout']))
                $group['layout'] = 'no_box';

            $groups[$name] = array(
                'id' => sprintf('acf_%s_%s_%s', $group['position'], $meta['id'], $name),
                'title' => $group['title'],
                'fields' => array(),
                'location' => array (
                  array (
                    array (
                      'param' => 'post_type',
                      'operator' => '==',
                      'value' => $meta['id'],
                      'order_no' => 0,
                      'group_no' => 0,
                    ),
                  ),
                ),
                'options' => array (
                  'position' => $group['position'],
                  'layout' => $group['layout'],
                  'hide_on_screen' => array (
                  ),
                ),
                'menu_order' => 0,
            );
        }

        // Default group
        if (!isset($groups['default'])) {
            $groups['default'] = array(
                'id' => 'acf_normal_'.$meta['id'],
                'title' => __($meta['name']),
                'fields' => array(),
                'location' => array (
                  array (
                    array (
                      'param' => 'post_type',
                      'operator' => '==',
                      'value' => $meta['id'],
                      'order_no' => 0,
                      'group_no' => 0,
                    ),
                  ),
                ),
                'options' => array (
                  'position' => 'normal',
                  'layout' => 'no_box',
                  'hide_on_screen' => array (
                  ),
                ),
                'menu_order' => 0,
            );
        }

        // Add fields to the correct groups
        foreach ($signature as $name => $field) {
            if (is_a($field, VM14_Post_Type_Field)) {
                $fields = &$groups[$field->get_group_id()]['fields'];
                array_push($fields, $field->get_config($meta['id'], $name));
            }
        }

        foreach ($groups as $group) {
            register_field_group($group);
        }
    }

    static private function prepare_meta($class, $signature) {
        $meta = array();

        self::meta($signature, 'id', $meta, function() use ($class) {
            return strtolower(substr($class, 5, strlen($class) - 15));
        });

        self::meta($signature, 'name', $meta, function(&$meta) {
            $words = explode('_', $meta['id']);
            for ($i=0; $i<sizeof($words); $i++) {
                $words[$i] = ucfirst($words[$i]);
            }

            return implode(' ', $words);
        });

        self::meta($signature, 'name_plural', $meta, function(&$meta) {
            return $meta['name'].'s';
        });

        self::meta($signature, 'slug', $meta, function(&$meta) {
            return $meta['id'];
        });

        self::meta($signature, 'slug_plural', $meta, function(&$meta) {
            return $meta['id'].'s';
        });

        self::meta($signature, 'groups', $meta, function(&$meta) {
            return array();
        });

        return $meta;
    }

    static private function meta($signature, $name, &$meta, $lambda) {
        $key_name = 'meta_'.$name;
        if (array_key_exists($key_name, $signature)) {
            $meta[$name] = $signature[$key_name];
        }
        else {
            $meta[$name] = $lambda($meta);
        }
    }
}

