<?php
class VM14_Contact_Person_Post_Type extends VM14_Post_Type {
    static $summary;
    static $first_name;
    static $last_name;
    static $email;
    static $phone;
    static $titles;
    static $visible_as_representative;

    static $meta_groups;
    static $meta_slug = 'kontaktperson'; //TODO: add localization

    function preview_html() {
        $excerpt = $this->get_excerpt(300);
        $html  = sprintf('<a href="%s">', get_permalink($this->id));
        $html .= sprintf('<h4>%s</h4>', $this->first_name . ' ' .$this->last_name);
        $html .= get_the_post_thumbnail($this->id);
        $html .= sprintf('<p>%s</p>', $excerpt);
        $html .= '</a>';

        return $html;
    }
}

VM14_Contact_Person_Post_Type::$meta_groups = array(
    'contact' => array(
        'title' => __('Contact information'),
        'position' => 'side',
        'layout' => 'box'
    )
);

VM14_Contact_Person_Post_Type::$summary = new VM14_Post_Type_Field(array(
    'widget' => 'wysiwyg'
));

VM14_Contact_Person_Post_Type::$first_name = new VM14_Post_Type_Field(array(
    'group' => 'contact'
));

VM14_Contact_Person_Post_Type::$last_name = new VM14_Post_Type_Field(array(
    'group' => 'contact'
));

VM14_Contact_Person_Post_Type::$email = new VM14_Post_Type_Field(array(
    'group' => 'contact'
));

VM14_Contact_Person_Post_Type::$phone = new VM14_Post_Type_Field(array(
    'group' => 'contact'
));

VM14_Contact_Person_Post_Type::$titles = new VM14_Post_Type_Field(array(
    'widget' => 'textarea'
));

VM14_Contact_Person_Post_Type::$visible_as_representative = new VM14_Post_Type_Field(array(
    'widget' => 'true_false',
    'default' => 1,
    'group' => 'contact'
));

