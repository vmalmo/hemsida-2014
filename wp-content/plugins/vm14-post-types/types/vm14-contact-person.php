<?php
class VM14_Contact_Person_Post_Type extends VM14_Post_Type {
    static $summary;
    static $first_name;
    static $last_name;
    static $video;
    static $titles;
    static $visible_as_representative;
}

VM14_Contact_Person_Post_Type::$summary = new VM14_Post_Type_Field(array(
    'widget' => 'wysiwyg'
));

VM14_Contact_Person_Post_Type::$first_name = new VM14_Post_Type_Field();
VM14_Contact_Person_Post_Type::$last_name = new VM14_Post_Type_Field();
VM14_Contact_Person_Post_Type::$video = new VM14_Post_Type_Field();

VM14_Contact_Person_Post_Type::$titles = new VM14_Post_Type_Field(array(
    'widget' => 'wysiwyg'
));

VM14_Contact_Person_Post_Type::$visible_as_representative = new VM14_Post_Type_Field(array(
    'widget' => 'true_false'
));

