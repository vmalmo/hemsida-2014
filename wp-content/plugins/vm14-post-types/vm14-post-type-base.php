<?php
define( 'ACF_LITE' , true );
include_once('acf/acf.php' );

class VM14_Post_Type_Field {
    private $widget;
    private $media_upload = false;

    function __construct(array $params) {
        $this->widget = $params['widget'];
    }

    function get_config($prefix, $name) {
        return array(
            'key' => sprintf('%s_%s_key', $prefix, $name),
            'label' => __($name), # TODO: Use field meta
            'name' => sprintf('%s_%s', $prefix, $name),
            'type' => $this->widget,
            'media_upload' => $this->media_upload
        );
    }
}

abstract class VM14_Post_Type {
    protected $post_data;

    function __construct($data) {
        $this->post_data = $data;
    }

    static function register() {
        $class = get_called_class();
        $signature = get_class_vars($class);

        $meta = self::prepare_meta($class, $signature);
        $fields = array();

        foreach ($signature as $name => $field) {
            if (get_class($field) == VM14_Post_Type_Field) {
                array_push($fields, $field->get_config($meta['id'], $name));
            }
            else if (get_class($field) == VM14_Post_Type_Group) {
                $field->register();
            }
        }

        register_field_group(array(
            'id' => 'acf_normal_'.$meta['id'],
            'title' => __($meta['title']),
            'fields' => $fields,
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
        ));
    }

    static private function prepare_meta($class, $signature) {
        $meta = array();

        self::meta($signature, 'id', $meta, function() use ($class) {
            return strtolower(substr($class, 5, strlen($class) - 15));
        });

        self::meta($signature, 'title', $meta, function($meta) {
            return $meta['id'];
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

abstract class VM14_Posttype {
  public $posttype;
  protected $show_in_nav_menu = false;
  protected $registration_data;
  protected $posttype_data;
  protected $default_properties = array(
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

  function __construct() {
    $this->registration_data = func_get_args();
    $this->posttype = $this->registration_data[0];
    $this->posttype_name = $this->registration_data[1];
    $this->posttype_data = $this->registration_data[2];
    $this->default_labels = array(
      'name' => __( $this->posttype_name, 'vm14' ), 
      'singular_name' => __( $this->posttype_name. ' Post', 'vm14' ), /* This is the individual type */
      'all_items' => __( 'All '.$this->posttype_name .' Posts', 'vm14' ), /* the all items menu item */
      'add_new' => __( 'Add New', 'vm14' ), /* The add new menu item */
      'add_new_item' => __( 'Add New '.$this->posttype_name, 'vm14' ), /* Add New Display Title */
      'edit_item' => __( 'Edit '.$this->posttype_name, 'vm14' ), /* Edit Display Title */
      'new_item' => __( 'New '.$this->posttype_name, 'vm14' ), /* New Display Title */
      'view_item' => __( 'View '.$this->posttype_name, 'vm14' ), /* View Display Title */
      'search_items' => __( 'Search '.$this->posttype_name, 'vm14' ), /* Search Generic Type Title */ 
      'parent_item_colon' => '',
      'edit' => __( 'Edit', 'vm14' ), /* Edit Dialog */
      'not_found' =>  __('Nothing found in the Database.', 'vm14'),
      'not_found_in_trash' => __('Nothing found in Trash', 'vm14'),
    );
    add_action('init', array($this, 'register'));
  }

  function register() {
    $this->posttype_data['labels'] = array_merge($this->default_labels, $this->posttype_data['labels']);
    $this->posttype_data = array_merge($this->default_properties, $this->posttype_data);
    register_post_type($this->posttype, $this->posttype_data);
    register_taxonomy_for_object_type( 'category', $this->posttype);
    register_taxonomy_for_object_type( 'post_tag', $this->posttype);
    if(function_exists('register_field_group')) {
      $this->register_acf();
    }
  }
  function register_acf(){}
}
