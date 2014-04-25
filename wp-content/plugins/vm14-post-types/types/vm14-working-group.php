<?php
class VM14_Working_Group_Post_Type extends VM14_Post_Type {
    static $summary;
    static $contact_person;
    static $meta_slug = 'arbetsgrupp';//TODO: add localization
}

VM14_Working_Group_Post_Type::$summary = new VM14_Post_Type_Field(array(
    'widget' => 'wysiwyg'
));

VM14_Working_Group_Post_Type::$contact_person = new VM14_Post_Type_Relationship('contact_person');

