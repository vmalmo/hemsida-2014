<?php
class VM14_Working_Group_Post_Type extends VM14_Post_Type {
    static $summary;
    static $contact_persons;
    static $meta_slug = 'arbetsgrupp';//TODO: add localization

    public function events($limit = 3) {
        return vm14_get_posts(array(
            'post_type' => 'calendar_event',
            'posts_per_page' => $limit,
            'orderby' => 'meta_value',
            'meta_key' => 'calendar_event_start_date',
            'meta_query' => array(
                array(
                  'key' => 'calendar_event_end_date',
                  'value' => date('Ymd', strtotime($today. ' - 1 days')),
                  'type' => 'numeric',
                  'compare' => '>='
                ),
                array(
                    'key' => 'calendar_event_working_group',
                    'value' => '"'.$this->id.'"',
                    'compare' => 'LIKE'
                )
            ),
            'order' => 'ASC'
        ));
    }
}

VM14_Working_Group_Post_Type::$summary = new VM14_Post_Type_Field(array(
    'widget' => 'wysiwyg'
));

VM14_Working_Group_Post_Type::$contact_persons = new VM14_Post_Type_Relationship('contact_person');

