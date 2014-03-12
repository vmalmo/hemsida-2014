<?php

class VM14_Calendar_Event_Post_Type extends VM14_Post_Type {
    static $summary;
    static $start_date;
    static $end_date;
    static $location;

    static $meta_groups;

    function preview_html() {
        $excerpt = $this->get_excerpt(300);
        $html  = sprintf('<a href="%s">', get_permalink($this->id));
        $html .= get_the_post_thumbnail($this->id);
        $html .= sprintf('<p class="date">%s</p>', date('d M', strtotime($this->start_date)) . ' - ' . date('d M', strtotime($this->end_date)));
        $html .= sprintf('<h4>%s</h4>', $this->title);
        $html .= sprintf('<p>%s</p>', $excerpt);
        $html .= '</a>';
        return $html;
    }
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

