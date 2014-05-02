<?php

class VM14_Calendar_Event_Post_Type extends VM14_Post_Type {
    static $summary;
    static $start_date;
    static $start_time;
    static $end_date;
    static $end_time;
    static $location;

    static $meta_groups;
    static $meta_slug = 'kalender';//TODO: add localization

    function preview_html() {
        $excerpt = $this->get_excerpt(300);
        $html  = sprintf('<a href="%s">', get_permalink($this->id));
        $html .= get_the_post_thumbnail($this->id);
        $html .= '<div class="date-outer-holder">';
        $html .= '<div class="date-holder">';
        //$html .= sprintf('<span>%s:</span>', __('Start'));
        $html .= sprintf('<p class="date icon icon-calendar">%s</p>', date('d F', strtotime($this->start_date)));
        if (strlen($this->start_time) > 0) {
          $html .= sprintf('<p class="date icon icon-time">%s</p>', $this->start_time);
        }
        $html .= '</div>';
        $html .= '<div class="date-holder">';
        //$html .= sprintf('<span>%s:</span>', __('End'));
        $html .= sprintf('<p class="date icon icon-calendar">%s</p>', date('d F', strtotime($this->end_date)));
        if (strlen($this->end_time) > 0) {
          $html .= sprintf('<p class="date icon icon-time">%s</p>', $this->end_time);
        }
        $html .= '</div>';
        $html .= '</div>';
        $html .= sprintf('<h4>%s</h4>', $this->title);
        $html .= sprintf('<p>%s</p>', $excerpt);
        $html .= '</a>';
        return $html;
    }

    public function start_datetime($format) {
        $time = preg_split('[^0-9]', $this->start_time);
        if (count($time)<2)
            $time = array(0,0,0); // TODO: Move default to save?

        $date = new DateTime($this->start_date);
        $date->setTime((int)$time[0], (int)$time[1]);
        return $date->format($format);
    }

    public function end_datetime($format) {
        $time = preg_split('[^0-9]', $this->end_time);
        if (count($time)<2)
            $time = array(23,59,0); // TODO: Move default to save?

        $date = new DateTime($this->end_date);
        $date->setTime((int)$time[0], (int)$time[1]);
        return $date->format($format);
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

VM14_Calendar_Event_Post_Type::$start_time = new VM14_Post_Type_Field(array(
    'widget' => 'text',
    'group' => 'date',
));

VM14_Calendar_Event_Post_Type::$end_date = new VM14_Post_Type_Field(array(
    'widget' => 'date_picker',
    'group' => 'date',
));

VM14_Calendar_Event_Post_Type::$end_time = new VM14_Post_Type_Field(array(
    'widget' => 'text',
    'group' => 'date',
));

VM14_Calendar_Event_Post_Type::$location = new VM14_Post_Type_Field(array(
    'widget' => 'google_map',
));

