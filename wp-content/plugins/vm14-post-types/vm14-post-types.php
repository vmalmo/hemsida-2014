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
require_once('vm14-contact-person.php');
require_once('vm14-calendar-event.php');
require_once('vm14-working-group.php');

$vm14_contact_person_posttype = new VM14_Contact_Person_Posttype();
$vm14_calendar_event_posttype = new VM14_Calendar_Event_Posttype();

