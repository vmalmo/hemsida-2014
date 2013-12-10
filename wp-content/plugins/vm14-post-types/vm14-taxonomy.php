<?php
class VM14_Taxonomy {
  private $posttypes;
  function __construct($posttypes) {
    array_push($posttypes, 'page', 'post');
    $this->posttypes = $posttypes;
    add_action('init', array($this, 'register'));
  }
  function register() {
    register_taxonomy( 'vm14_catetories',
      $this->posttypes,
      array('hierarchical' => true,     /* if this is true, it acts like categories */
        'labels' => array(
          'name' => __( 'Political Categories', 'vm14' ), /* name of the custom taxonomy */
          'singular_name' => __( 'Political Category', 'vm14' ), /* single taxonomy name */
          'search_items' =>  __( 'Search Political Categories', 'vm14' ), /* search title for taxomony */
          'all_items' => __( 'All Political Categories', 'vm14' ), /* all title for taxonomies */
          'parent_item' => __( 'Parent Political Category', 'vm14' ), /* parent title for taxonomy */
          'parent_item_colon' => __( 'Parent Political Category:', 'vm14' ), /* parent taxonomy title */
          'edit_item' => __( 'Edit Political Category', 'vm14' ), /* edit custom taxonomy title */
          'update_item' => __( 'Update Political Category', 'vm14' ), /* update title for taxonomy */
          'add_new_item' => __( 'Add New Political Category', 'vm14' ), /* add new title for taxonomy */
          'new_item_name' => __( 'New Political Category Name', 'vm14' ) /* name title for taxonomy */
        ),
        'show_admin_column' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'political-category' ),
      )
    );
  }
}
