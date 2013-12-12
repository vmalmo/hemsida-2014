<?php
class VM14_Contact_Person_Posttype extends VM14_Posttype {
  function __construct() {
    VM14_Posttype::__construct( 'contact_person', __('Contact Person'),
      array( 'labels' => array(
          'all_items' => __( 'All Contact Persons', 'vm14' ), /* the all items menu item */
        ), /* end of arrays */
        'description' => __( 'Contact persons in Vänsterpartiet Malmö', 'vm14' ), /* Custom Type Description */
        'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */ 
        'rewrite'	=> array( 'slug' => __('kontaktperson'), 'with_front' => false ), /* you can specify its url slug */
        'has_archive' => __('kontaktpersoner'), /* you can rename the slug here */
      )
    );
  }
  function register_acf() {
    register_field_group(array (
      'id' => 'acf_normal_'. $this->posttype,
      'title' => __($this->posttype_name),
      'fields' => array (
        array (
          'key' => $this->posttype.'_titles_and_commitments',
          'label' => __('Title and Commitments'),
          'name' => $this->posttype.'_titles_and_commitments',
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
    register_field_group(array (
      'id' => 'acf_side_'. $this->posttype,
      'title' => __($this->posttype_name),
      'fields' => array (
        array (
          'key' => $this->posttype.'_firstname_key',
          'label' => __('Firstname'),
          'name' => $this->posttype.'_firstname',
          'type' => 'text',
        ),
        array (
          'key' => $this->posttype.'_lastname_key',
          'label' => __('Lastname'),
          'name' => $this->posttype.'_lastname',
          'type' => 'text',
        ),
        array (
          'key' => $this->posttype.'_video_key',
          'label' => __('Video'),
          'instructions' => __('paste the url to the video'),
          'placeholder' => 'https://www.youtube.com/watch?v=',
          'name' => $this->posttype.'_video',
          'type' => 'text',
        ),
        array (
          'key' => $this->posttype.'_visible_on_page',
          'label' => __('Visible on the representative page'),
          'name' => $this->posttype.'_visible_on_page',
          'type' => 'true_false',
          'default_value' => 0,
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
        'position' => 'side',
        'layout' => '',
        'hide_on_screen' => array (
        ),
      ),
      'menu_order' => 0,
    ));
  }
}
