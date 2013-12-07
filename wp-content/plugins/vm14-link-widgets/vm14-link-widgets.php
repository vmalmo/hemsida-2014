<?php
/**
 * Plugin Name: Link widgets (vm14)
 * Description: Widgets for linking between pieces of content.
 * Version: 1.0
 * Author: Richard Olsson
*/


/**
 * Base class for single-link widgets.
*/
class VM14_Link_Widget extends WP_Widget {
	function print_link($post) {
		printf('<a href="%s">', get_permalink($post->ID));
		printf('<h4 class="widgettitle">%s</h4>', $post->post_title);
		printf($post->post_excerpt); // TODO: Replace with custom field?
		printf(get_the_post_thumbnail($post->ID));
		printf('</a>');
	}
}

/**
 * Static link widget. Used to create static hard link to single page.
*/
class VM14_Static_Link_Widget extends VM14_Link_Widget {
	function __construct() {
		$widget_ops = array('description' => __('Use this widget to create a static link to another page.', 'vm14_link_widgets'));
		parent::__construct('vm14_statlink', __('Static link', 'vm14_link_widgets'), $widget_ops);
	}

	function widget($args, $instance) {
		extract($args);
		$post = get_post($instance['page_id']);

		echo $before_widget;
		$this->print_link($post);
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$old_instance['page_id'] = strip_tags($new_instance['page_id']);
		return $old_instance;
	}

	function form($instance) {
		$pages = get_pages();
		
		printf('<select class="widefat" id="%s" name="%s">',
			$this->get_field_id('page_id'),
			$this->get_field_name('page_id'));

		foreach ($pages as $page) {
			printf('<option value="%s" %s>%s</option>', 
				intval($page->ID),
				selected($instance['page_id'], $page->ID, false),
				$page->post_title);
		}

		printf('</select>');
	}
}


/**
 * Dynamic link widget. Used to create a link to a single page which is
 * chosen dynamically at render-time from a set of criteria.
*/
class VM14_Dynamic_Link_Widget extends VM14_Link_Widget {
	function __construct() {
		$widget_ops = array('description' => __('Use this widget to create a dynamic link to another page, chosen from a set a criteria.', 'vm14_link_widgets'));
		parent::__construct('vm14_dynlink', __('Dynamic link', 'vm14_link_widgets'), $widget_ops);
	}

	function widget($args, $instance) {
		extract($args);

		$query = array(
			'posts_per_page' => 1,
			'category' => $instance['category_id']
		);

		switch ($instance['criterion']) {
			case 'recent':
				$query['orderby'] = 'post_date';
				$query['order'] = 'DESC';
				break;
		}

		$posts = get_posts($query);
		if (sizeof($posts)==1) {
			$post = $posts[0];

			echo $before_widget;
			$this->print_link($post);
			echo $after_widget;
		}
	}

	function update($new_instance, $old_instance) {
		$old_instance['criterion'] = $new_instance['criterion'];
		$old_instance['category_id'] = $new_instance['category_id'];
		return $old_instance;
	}

	function form($instance) {
		$categories = get_categories(array('hide_empty' => false));
		$criteria = array(
			'recent' => __('Most recently published', 'vm14_link_widgets')
		);
		

		// Criterion select box
		printf('<label for="%s">%s:</label>',
			$this->get_field_id('criterion'),
			__('Criterion', 'vm14_link_widgets'));

		printf('<select class="widefat" id="%s" name="%s">',
			$this->get_field_id('criterion'),
			$this->get_field_name('criterion'));

		foreach ($criteria as $criterion => $name) {
			printf('<option value="%s" %s>%s</option>',
				$criterion,
				selected($instance['criterion'], $criterion, false),
				$name);
		}

		printf('</select>');


		// Category select widget
		printf('<label for="%s">%s:</label>',
			$this->get_field_id('category_id'),
			__('From category', 'vm14_link_widgets'));

		printf('<select id="%s" name="%s">',
			$this->get_field_id('category_id'),
			$this->get_field_name('category_id'));

		foreach ($categories as $category) {
			printf('<option value="%s" %s>%s</option>',
				intval($category->cat_ID),
				selected($instance['category_id'], $category->cat_ID, false),
				$category->name);
		}

		printf('</select>');
	}
}


function vm14_link_widgets_init() {
	register_widget('VM14_Static_Link_Widget');
	register_widget('VM14_Dynamic_Link_Widget');
}

add_action('widgets_init', 'vm14_link_widgets_init');

