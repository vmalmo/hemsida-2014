<?php 
/*
  Plugin Name: Post Types (vm14)
  Plugin URI: 
  Description: Sets up content types and metaboxes/field for the site structure
  Author: Vänsterpartiet Malmö tech
  Version: 0.1
  Author URI: http://malmo.vansterpartiet.se/
 */

require_once('vm14-post-type-base.php');

require_once('types/vm14-contact-person.php');
require_once('types/vm14-calendar-event.php');
require_once('types/vm14-working-group.php');
require_once('types/vm14-section-entrance.php');
require_once('types/vm14-basic-page.php');

add_action('init', function() {
    VM14_Section_Entrance_Post_Type::register();
    VM14_Calendar_Event_Post_Type::register();
    VM14_Contact_Person_Post_Type::register();
    VM14_Working_Group_Post_Type::register();
    VM14_Page_Post_Type::register();
});

