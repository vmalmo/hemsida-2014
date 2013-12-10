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

require_once('vm14-taxonomy.php');

$vm14_calendar_event_posttype = new VM14_Calendar_Event_Posttype();
$vm14_contact_person_posttype = new VM14_Contact_Person_Posttype();
$vm14_working_group_posttype = new VM14_Working_Group_Posttype();
$vm14_section_entrance_posttype = new VM14_Section_Entrance_Posttype();

$posttypes = array(
  $vm14_working_group_posttype->posttype,
  $vm14_contact_person_posttype->posttype,
  $vm14_calendar_event_posttype->posttype,
  $vm14_section_entrance_posttype->posttype
);

$vm14_taxonomy = new VM14_Taxonomy($posttypes);
