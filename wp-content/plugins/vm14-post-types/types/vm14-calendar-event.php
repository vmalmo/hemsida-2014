<?php
class VM14_Calendar_Event_Posttype extends VM14_Posttype {
  function __construct() {
    VM14_Posttype::__construct( 'calendar_event', __('Calendar Event'),
      array( 'labels' => array(
          'all_items' => __( 'All Events', 'vm14' ), /* the all items menu item */
        ), /* end of arrays */
        'description' => __( 'Calendar events in Vänsterpartiet Malmö', 'vm14' ), /* Custom Type Description */
        'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */ 
        'rewrite'	=> array( 'slug' => __('event'), 'with_front' => false ), /* you can specify its url slug */
        'has_archive' => __('events'), /* you can rename the slug here */
      )
    );
  }

  function register_acf() {
    register_field_group(array (
      'id' => 'acf_side_'. $this->posttype,
      'title' => __($this->posttype_name) . ' Info',
      'fields' => array (
        array (
          'key' => $this->posttype.'_start_date_key',
          'label' => __('Start Date'),
          'name' => $this->posttype.'_start_date',
          'type' => 'date_picker',
        ),
        array (
          'key' => $this->posttype.'_end_date_key',
          'label' => __('End Date'),
          'name' => $this->posttype.'_end_date',
          'type' => 'date_picker',
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
        'hide_on_screen' => array (
        ),
      ),
      'menu_order' => 0,
    ));

    register_field_group(array (
      'id' => 'acf_'. $this->posttype,
      'title' => __($this->posttype_name),
      'fields' => array (
        array (
          'key' => $this->posttype.'_location_key',
          'label' => __('Location'),
          'name' => $this->posttype.'_location',
          'type' => 'google_map',
          'center_lat' => '',
          'center_lng' => '',
          'zoom' => '',
          'height' => '',
        ),
        array (
          'key' => $this->posttype.'_working_group_key',
          'label' => __('Working group'),
          'name' => $this->posttype.'_working_group',
          'instructions' => __('(Optional)'),
          'type' => 'relationship',
          'return_format' => 'object',
          'post_type' => array (
            0 => 'working_group',
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
        'layout' => 'no_box',
        'hide_on_screen' => array (
        ),
      ),
      'menu_order' => 0,
    ));
  }
}
