<?php
class VM14_Basic_Page_Posttype extends VM14_Posttype {
  function __construct() {
    VM14_Posttype::__construct( 'page', __('Page'), array());
  }
  function register() {
    // override parent class register becaue thie page type is 
    // include in wordpress from the start
    if(function_exists('register_field_group')) {
      $this->register_acf();
    }
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
