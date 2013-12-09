<?php 
/*
  Plugin Name: Vänsterpartiet Malmö Post Types
  Plugin URI: 
  Description: Sets up content types and metaboxes/field for the site structure
  Author: Vänsterpartiet Malmö tech
  Version: 0.1
  Author URI: http://malmo.vansterpartiet.se/
 */

require_once('vm14-post-type-base.php');
require_once('vm14-contact-person.php');

$vm14_conact_person_posttype = new VM14_Contact_Person_Posttype();

