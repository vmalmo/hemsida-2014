<?php
class VM14_Section_Entrance_Posttype extends VM14_Posttype {
  function __construct() {
    VM14_Posttype::__construct( 'section_entrance', __('Section Entrance'),
      array( 'labels' => array(
          'all_items' => __( 'All Section entrances', 'vm14' ), /* the all items menu item */
        ), /* end of arrays */
        'description' => __( 'Section entrances is the landingn page for on of the big menu points on the front page', 'vm14' ), /* Custom Type Description */
        'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */ 
        'rewrite'	=> array( 'slug' => 'section', 'with_front' => false ), /* you can specify its url slug */
        'has_archive' => 'sections', /* you can rename the slug here */
      )
    );
  }
}
