<?php

add_action('manage_calendar_event_posts_custom_column', 'vm14_calendar_event_custom_column', 10, 2);
add_filter('manage_calendar_event_posts_columns', 'vm14_calendar_event_columns');
add_filter("manage_edit-calendar_event_sortable_columns", 'vm14_calendar_event_sortable_columns');
add_filter('request', 'vm14_calendar_event_orderby');

function vm14_calendar_event_columns($columns) {
    $columns['start_date'] = 'Start date';
    return $columns;
}

function vm14_calendar_event_sortable_columns($columns) {
    $columns['start_date'] = 'calendar_event_start_date';
    return $columns;
}

function vm14_calendar_event_custom_column($column, $post_id) {
    switch ($column) {
        case 'start_date':
            echo get_field('calendar_event_start_date', $post_id);
            break;
    }
}

function vm14_calendar_event_orderby($vars) {
    if (isset($vars['post_type']) && $vars['post_type']=='calendar_event' && isset($vars['orderby'])) {
        switch ($vars['orderby']) {
            case 'calendar_event_start_date':
                $vars = array_merge($vars, array(
                    'meta_key' => 'calendar_event_start_date',
                    'orderby' => 'meta_value'
                ));
                break;
        }
    }
    
    return $vars;
}

class VM14_Calendar_Event_Post_Type extends VM14_Post_Type {
    static $summary;
    static $start_date;
    static $start_time;
    static $end_date;
    static $end_time;
    static $location;
    static $facebook_event;
    static $working_group;
    static $public;
    static $show_share_buttons;

    static $meta_groups;
    static $meta_slug = 'kalender';//TODO: add localization

    function __construct($post) {

        parent::__construct($post);
        if (is_array($this->post_data['start_date'])) {
          $this->post_data['start_date'] = $this->post_data['start_date'][0];
        }
        if (is_array($this->post_data['end_date'])) {
          $this->post_data['end_date'] = $this->post_data['end_date'][0];
        }
    }

    function date_str() {
        $same_year = false;
        $times = array();

        if ($this->start_datetime('%Y')==date('Y')) {
            $same_year = true;
            $times[0] = $this->start_datetime('%e %B');
        }
        else {
            $times[0] = $this->start_datetime('%e %B %Y');
        }

        if ($this->start_date != $this->end_date) {
            if ($same_year) {
                $times[1] .= $this->end_datetime('%e %B');
            }
            else {
                $times[1] .= $this->end_datetime('%e %B %Y');
            }
        }

        if ($this->start_time && $this->end_time) {
            $times[0] .= ' '.$this->start_time;
            $times[1] .= ' '.$this->end_time;
        }

        return strtolower(implode(' - ', $times));
    }

    function preview_html($len = 300) {
        $excerpt = $this->get_excerpt($len);
        $html  = sprintf('<a href="%s">', get_permalink($this->id));

        if (has_post_thumbnail($this->id)) {
            $html .= get_the_post_thumbnail($this->id);
        }
        elseif (is_array($this->working_group)) {
            $html .= get_the_post_thumbnail($this->working_group[0]);
        }

        $html .= sprintf('<h4>%s</h4>', $this->title);
        $html .= '<div class="date-outer-holder">';
        $html .= '<div class="date-holder">';
        //$html .= sprintf('<span>%s:</span>', __('Start'));
        $html .= sprintf('<p class="date icon icon-calendar">%s</p>', $this->date_str());
        $html .= '</div>';
        $html .= '</div>';
        $html .= sprintf('<p>%s</p>', $excerpt);
        $html .= '</a>';
        return $html;
    }

    public function start_datetime($format, $utc=false) {
        $time = preg_split('/[^0-9]/', $this->start_time);
        if (count($time)<2)
            $time = array(0,0,0); // TODO: Move default to save?

        $date = new DateTime($this->start_date);
        $date->setTime((int)$time[0], (int)$time[1]);

        if ($utc) {
            $date->setTimeZone(new DateTimeZone('UTC'));
        }

        return strftime($format, $date->getTimestamp());
    }

    public function end_datetime($format, $utc=false) {
        $time = preg_split('/[^0-9]/', $this->end_time);
        if (count($time)<2)
            $time = array(23,59,0); // TODO: Move default to save?

        $date = new DateTime($this->end_date);
        $date->setTime((int)$time[0], (int)$time[1]);

        if ($utc) {
            $date->setTimeZone(new DateTimeZone('UTC'));
        }
            
        return strftime($format, $date->getTimestamp());
    }

    public function is_all_day() {
        return (($this->start_time=='' || $this->start_time=='00.00') && ($this->end_time=='' || $this->end_time=='00.00'));
    }

    public function has_working_group() {
        return ($this->working_group && count($this->working_group)>0);
    }

    public function working_group_post() {
        if ($this->has_working_group()) {
            return vm14_get_post($this->working_group[0]);
        }
        else {
            return null;
        }
    }

    public function facebook_event_url() {
        return $this->facebook_event;
    }
}

VM14_Calendar_Event_Post_Type::$meta_groups = array(
    'misc' => array(
        'title' => __('Calendar event misc'),
        'position' => 'side',
        'layout' => 'box',
    ),
    'social_fields' => array(
        'title' => __('Social share buttons'),
        'position' => 'side',
        'layout' => 'box',
    )
);

VM14_Calendar_Event_Post_Type::$summary = new VM14_Post_Type_Field(array(
    'widget' => 'textarea',
));

VM14_Calendar_Event_Post_Type::$start_date = new VM14_Post_Type_Field(array(
    'widget' => 'date_picker',
    'group' => 'misc',
));

VM14_Calendar_Event_Post_Type::$start_time = new VM14_Post_Type_Field(array(
    'widget' => 'text',
    'group' => 'misc',
));

VM14_Calendar_Event_Post_Type::$end_date = new VM14_Post_Type_Field(array(
    'widget' => 'date_picker',
    'group' => 'misc',
));

VM14_Calendar_Event_Post_Type::$end_time = new VM14_Post_Type_Field(array(
    'widget' => 'text',
    'group' => 'misc',
));

VM14_Calendar_Event_Post_Type::$location = new VM14_Post_Type_Field(array(
    'widget' => 'google_map',
));

VM14_Calendar_Event_Post_Type::$facebook_event = new VM14_Post_Type_Field(array(
    'widget' => 'text',
    'group' => 'misc'
));

VM14_Calendar_Event_Post_Type::$working_group = new VM14_Post_Type_Relationship('working_group', array(
    'max' => 1
));

VM14_Calendar_Event_Post_Type::$public = new VM14_Post_Type_Field(array(
    'widget' => 'true_false',
    'default' => '1',
    'group' => 'misc'
));

VM14_Calendar_Event_Post_Type::$show_share_buttons = new VM14_Post_Type_Field(array(
  'widget' => 'true_false',
  'default' => 1,
  'group' => 'social_fields'
));
