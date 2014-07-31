<?php
class VM14_Section_Entrance_Post_Type extends VM14_Post_Type {
    static $summary;
}

VM14_Section_Entrance_Post_Type::$summary = new VM14_Post_Type_Field(array(
    'widget' => 'textarea'
));
