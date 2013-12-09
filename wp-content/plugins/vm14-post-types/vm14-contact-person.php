<?php
class VM14_Contact_Person_Posttype extends VM14_Posttype {

  function __construct() {
    VM14_Posttype::__construct( 'contact_person', 'Contact Person',
      array( 'labels' => array(
          'all_items' => __( 'All Contact Persons', 'vm14' ), /* the all items menu item */
        ), /* end of arrays */
        'description' => __( 'Contact persons in Vänsterpartiet Malmö', 'vm14' ), /* Custom Type Description */
        'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */ 
        'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
        'rewrite'	=> array( 'slug' => 'generic', 'with_front' => false ), /* you can specify its url slug */
        'has_archive' => 'generics', /* you can rename the slug here */
      )
    );
  }
  function register_metaboxes() {
    $prefix = '_cmb_'; // Prefix for alertl fields
    //$this->metabox_without_borders[] = 'ingress_metabox';
    $meta_boxes[] = array(
      'id' => 'contact_person_metabox',
      'title' => __('Contact Person'),
      'pages' => array('page', $this->posttype), // post type
      'context' => 'side',
      'priority' => 'high',
      'cmb_styles' => true,
      'show_names' => true,
      'fields' => array(
        array(
          'name' => __('Firstname'),
          'id' => $prefix . 'firstname',
          'type' => 'text_small'
        ),
        array(
          'name' => __('Lastname'),
          'id' => $prefix . 'lastname',
          'type' => 'text_small'
        ),
        array(
          'name' => __('Visible on representative page'),
          'id' => $prefix . '_visible',
          'type' => 'checkbox'
        ),
        array(
          'name' => __('Video'),
          'desc' => __('Url to video'),
          'id' => $prefix . '_video',
          'type' => 'oembed'
        ),
      ),
    );
    $meta_boxes[] = array(
      'id' => 'contact_person_titles_metabox',
      'title' => __('Titles/Committments'),
      'pages' => array($this->posttype), // post type
      'context' => 'normal',
      'priority' => 'high',
      'cmb_styles' => true,
      'show_names' => false,
      'fields' => array(
        array(
          'name' => __('Titles/Committments'),
          'id' => $prefix . '_titles',
          'type' => 'wysiwyg',
        )
       ),
    );
    return $meta_boxes;
  }
}
