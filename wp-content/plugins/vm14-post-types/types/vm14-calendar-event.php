<?php

class VM14_Calendar_Event_Post_Type extends VM14_Post_Type {
    static $summary;
    static $start_date;
    static $end_date;
    static $location;

    static $meta_groups;
}

VM14_Calendar_Event_Post_Type::$meta_groups = array(
    'date' => array(
        'title' => __('Calendar event dates'),
        'position' => 'side',
        'layout' => 'box',
    )
);

VM14_Calendar_Event_Post_Type::$summary = new VM14_Post_Type_Field(array(
    'widget' => 'wysiwyg',
));

VM14_Calendar_Event_Post_Type::$start_date = new VM14_Post_Type_Field(array(
    'widget' => 'date_picker',
    'group' => 'date',
));

VM14_Calendar_Event_Post_Type::$end_date = new VM14_Post_Type_Field(array(
    'widget' => 'date_picker',
    'group' => 'date',
));

VM14_Calendar_Event_Post_Type::$location = new VM14_Post_Type_Field(array(
    'widget' => 'google_map',
));

