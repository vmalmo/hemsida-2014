<?php
class VM14_Section_Entrance_Posttype extends VM14_Posttype {
  function __construct() {
    VM14_Posttype::__construct( 'section_entrance', __('Section Entrance'),
      array( 'labels' => array(
          'all_items' => __( 'All Section entrances', 'vm14' ), /* the all items menu item */
        ), /* end of arrays */
        'description' => __( 'Section entrances is the landingn page for on of the big menu points on the front page', 'vm14' ), /* Custom Type Description */
        'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */ 
        'rewrite'	=> array( 'slug' => '/', 'with_front' => true ), /* you can specify its url slug */
        'has_archive' => __('sections'), /* you can rename the slug here */
      )
    );
  }

  function register_acf() {
    register_field_group(array (
      'id' => 'acf_normal_'. $this->posttype,
      'title' => __($this->posttype_name),
      'fields' => array (
        array (
          'key' => $this->posttype.'_ingress_key',
          'label' => __('Ingress'),
          'name' => $this->posttype.'_ingress',
          'type' => 'wysiwyg',
          'media_upload' => false,
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
        'layout' => 'no_box',
        'hide_on_screen' => array (
        ),
      ),
      'menu_order' => 0,
    ));
  }
}
