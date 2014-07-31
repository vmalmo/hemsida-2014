<?php
class VM14_Working_Group_Post_Type extends VM14_Post_Type {
    static $summary;
    static $contact_persons;
    static $show_share_buttons;

    static $meta_slug = 'arbetsgrupp';//TODO: add localization
    static $meta_groups;

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
VM14_Working_Group_Post_Type::$meta_groups = array(
    'social_fields' => array(
        'title' => __('Social share buttons'),
        'position' => 'side',
        'layout' => 'box',
    )
);

VM14_Working_Group_Post_Type::$show_share_buttons = new VM14_Post_Type_Field(array(
  'widget' => 'true_false',
  'default' => 1,
  'group' => 'social_fields'
));

VM14_Working_Group_Post_Type::$summary = new VM14_Post_Type_Field(array(
    'widget' => 'textarea'
));

VM14_Working_Group_Post_Type::$contact_persons = new VM14_Post_Type_Relationship('contact_person');

