<?php
abstract class VM14_Posttype {
  protected $posttype;
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
    add_filter( 'cmb_meta_boxes', array($this, 'register_metaboxes' ));
  }

  function register() {
    if ( !class_exists( 'cmb_Meta_Boxx' ) ) {
      require_once( 'metabox/init.php' );
    }
    $this->posttype_data['labels'] = array_merge($this->default_labels, $this->posttype_data['labels']);
    $this->posttype_data = array_merge($this->default_properties, $this->posttype_data);
    register_post_type($this->posttype, $this->posttype_data);
  }

}
