<?php
/**
 * Plugin Name: Link widgets (vm14)
 * Description: Widgets for linking between pieces of content.
 * Version: 1.0
 * Author: Richard Olsson
*/


/**
 * Static link widget. Used to create static hard link to single page.
*/
class VM14_Static_Link_Widget extends WP_Widget {
	function __construct() {
		$widget_ops = array('description' => __('Use this widget to create a static link to another page.', 'vm14_link_widgets'));
		parent::__construct('vm14_statlink', __('Static link', 'vm14_link_widgets'), $widget_ops);
	}

	function widget($args, $instance) {
		extract($args);
		$post = get_post($instance['page_id']);

		echo $before_widget;
		printf('<a href="%s">%s</a>',
			get_permalink($instance['page_id']),
			$post->post_title);
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$old_instance['page_id'] = strip_tags($new_instance['page_id']);
		return $old_instance;
	}

	function form($instance) {
		$pages = get_pages();
?>
		<select class="widefat" id="<?php echo $this->get_field_id('page_id'); ?>" name="<?php echo $this->get_field_name('page_id'); ?>">
		<?php
		foreach ($pages as $page) {
			printf('<option value="%s" %s>%s</option>', 
				intval($page->ID),
				selected($instance['page_id'], $page->ID, false),
				$page->post_title);
		}
		?>
		</select>
<?php
	}
}

function vm14_link_widgets_init() {
	register_widget('VM14_Static_Link_Widget');
}

add_action('widgets_init', 'vm14_link_widgets_init');

