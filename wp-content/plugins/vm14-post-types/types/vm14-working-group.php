<?php
class VM14_Working_Group_Posttype extends VM14_Posttype {
  function __construct() {
    VM14_Posttype::__construct( 'working_group', __('Working group'),
      array( 'labels' => array(
          'all_items' => __( 'All working groups', 'vm14' ), /* the all items menu item */
        ), /* end of arrays */
        'description' => __( 'Working groups in Vänsterpartiet Malmö', 'vm14' ), /* Custom Type Description */
        'menu_position' => 7, /* this is what order you want it to appear in on the left hand side menu */ 
        'rewrite'	=> array( 'slug' => __('working_group'), 'with_front' => false ), /* you can specify its url slug */
        'has_archive' => __('working_groups'), /* you can rename the slug here */
      )
    );
  }
  function register_acf() {
    register_field_group(array (
      'id' => 'acf_normal_'. $this->posttype,
      'title' => __($this->posttype_name).'s contact person',
      'fields' => array (
        array (
          'key' => $this->posttype.'_ingress_key',
          'label' => __('Ingress'),
          'name' => $this->posttype.'_ingress',
          'type' => 'wysiwyg',
          'media_upload' => false,
        ),
        array (
          'key' => $this->posttype.'_contact_person_key',
          'label' => '',
          'name' => '',
          'type' => 'relationship',
          'return_format' => 'object',
          'post_type' => array (
            0 => 'contact_person',
          ),
          'taxonomy' => array (
            0 => 'all',
          ),
          'filters' => array (
            0 => 'search',
          ),
          'result_elements' => array (
            0 => 'post_type',
            1 => 'post_title',
          ),
          'max' => '',
        ),
      ),
      'location' => array (
        array (
          array (
            'param' => 'post_type',
            'operator' => '==',
            'value' => $this->posttype,
            'order_no' => 0,
            'group_no' => 0,
          ),
        ),
      ),
      'options' => array (
        'position' => 'normal',
        'hide_on_screen' => array (
        ),
      ),
      'menu_order' => 0,
    ));
  }
}
