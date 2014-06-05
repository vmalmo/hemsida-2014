<?php
/*
Author: Eddie Machado
URL: htp://themble.com/bones/

This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images,
sidebars, comments, ect.
*/

/************* INCLUDE NEEDED FILES ***************/

/*
1. library/bones.php
	- head cleanup (remove rsd, uri links, junk css, ect)
	- enqueueing scripts & styles
	- theme support functions
	- custom menu output & fallbacks
	- related post function
	- page-navi function
	- removing <p> from around images
	- customizing the post excerpt
	- custom google+ integration
	- adding custom fields to user profiles
*/
require_once( 'library/bones.php' ); // if you remove this, bones will break
/*
3. library/admin.php
	- removing some default WordPress dashboard widgets
	- an example custom dashboard widget
	- adding custom login css
	- changing text in footer of admin
*/
// require_once( 'library/admin.php' ); // this comes turned off by default
/*
4. library/translation/translation.php
	- adding support for other languages
*/
// require_once( 'library/translation/translation.php' ); // this comes turned off by default

setlocale(LC_ALL, get_locale());

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size( 'vm14_small', 400, 300, true );
add_image_size( 'vm14_medium', 400, 230, true );
add_image_size( 'vm14_large', 1240, 698, true );
add_image_size( 'vm14_thumb', 50, 50, true);
add_image_size( 'vm14_post_header', 640, 280, true);
add_image_size( 'vm14_medium_width', 640, 480);
add_image_size( 'vm14_full_width', 2000, 1500);
add_image_size( 'bones-thumb-600', 600, 150, true );
/*
to add more sizes, simply copy a line from above
and change the dimensions & name. As long as you
upload a "featured image" as large as the biggest
set width or height, all the other sizes will be
auto-cropped.

To call a different size, simply change the text
inside the thumbnail function.

For example, to call the 300 x 300 sized image,
we would use the function:
<?php the_post_thumbnail( 'bones-thumb-300' ); ?>
for the 600 x 100 image:
<?php the_post_thumbnail( 'bones-thumb-600' ); ?>

You can change the names and dimensions to whatever
you like. Enjoy!
*/

/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function bones_register_sidebars() {
	register_sidebar(array(
		'id' => 'sidebar',
		'name' => __( 'Sidebar', 'bonestheme' ),
		'description' => __( 'Sidebar used at generics post/pages.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	register_sidebar(array(
		'id' => 'blurbs',
		'name' => __( 'Blurb area', 'bonestheme' ),
		'description' => __( 'Place add and arrange your blurb widgets.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	register_sidebar(array(
		'id' => 'front_widgets',
		'name' => __( 'Front Widgets', 'bonestheme' ),
		'description' => __( 'Place add and arrange your front page widgets.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	register_sidebar(array(
		'id' => 'section_entrace_content',
		'name' => __( 'Only for section entrance', 'bonestheme' ),
		'description' => __( 'Place add and arrange your section entrance widgets.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

} // don't remove this bracket!

/************* COMMENT LAYOUT *********************/

// Comment Layout
function bones_comments( $comment, $args, $depth ) {
   $GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?>>
		<article id="comment-<?php comment_ID(); ?>" class="clearfix">
			<header class="comment-author vcard">
				<?php
				/*
					this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
					echo get_avatar($comment,$size='32',$default='<path_to_url>' );
				*/
				?>
				<?php // custom gravatar call ?>
				<?php
					// create variable
					$bgauthemail = get_comment_author_email();
				?>
				<img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5( $bgauthemail ); ?>?s=32" class="load-gravatar avatar avatar-48 photo" height="32" width="32" src="<?php echo get_template_directory_uri(); ?>/library/images/nothing.gif" />
				<?php // end custom gravatar call ?>
				<?php printf(__( '<cite class="fn">%s</cite>', 'bonestheme' ), get_comment_author_link()) ?>
				<time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__( 'F jS, Y', 'bonestheme' )); ?> </a></time>
				<?php edit_comment_link(__( '(Edit)', 'bonestheme' ),'  ','') ?>
			</header>
			<?php if ($comment->comment_approved == '0') : ?>
				<div class="alert alert-info">
					<p><?php _e( 'Your comment is awaiting moderation.', 'bonestheme' ) ?></p>
				</div>
			<?php endif; ?>
			<section class="comment_content clearfix">
				<?php comment_text() ?>
			</section>
			<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
		</article>
	<?php // </li> is added by WordPress automatically ?>
<?php
} // don't remove this bracket!

/************* SEARCH FORM LAYOUT *****************/

// Search Form
function bones_wpsearch($form) {
	$form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
	<label class="screen-reader-text" for="s">' . __( 'Search for:', 'bonestheme' ) . '</label>
	<input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="' . esc_attr__( 'Search the Site...', 'bonestheme' ) . '" />
	<input type="submit" id="searchsubmit" value="' . esc_attr__( 'Search' ) .'" />
	</form>';
	return $form;
} // don't remove this bracket!


function vm14_breadcrumbs($id, $extra=null) {
    $ancestors = get_post_ancestors($id);

    if ($extra) {
        $extra_ancestors = get_post_ancestors($extra);
        array_splice($ancestors, 0, 0, $extra_ancestors);
        array_unshift($ancestors, $extra);
    }

    array_unshift($ancestors, $id);

    $links = array();
    array_push($links, sprintf('<a href="/"><img src="%s/library/images/home-icon.png" alt="Home"></a>',
        get_template_directory_uri()));

    for ($i=sizeof($ancestors)-1; $i>=0; $i--) {
        array_push($links, sprintf('<a href="%s">%s</a>',
            get_permalink($ancestors[$i]),
            get_the_title($ancestors[$i])));
    }

    echo '<div class="breadcrumbs">';
    echo implode('<span class="breadcrumbs-delimiter">»</span>', $links);
    echo '</div>';
}


function vm14_sub_menu($page) {
    if (is_numeric($page))
        $page = vm14_get_post($page);

    if (is_a($page, 'VM14_Page_Post_Type')) {
        $menu_id = $page->get_menu_id();
        if ($menu_id) {
            echo '<div class="first twelvecol undermenu">';
            echo '  <ul>';
            wp_nav_menu(array(
                'menu' => $menu_id
            ));
            echo '</ul></div>';
        }
    }
}


function vm14_customize_register($wpc) {

    $wpc->add_section('vm14_section_footer', array(
        'title' => __( 'Footer content', 'vm14' ),
        'priority' => 30,
    ));

    $wpc->add_setting('vm14_footer_fb_id');
    $wpc->add_control(new WP_Customize_Control($wpc, 'facebook_id', array(
        'label' => __('Facebook Page ID', 'vm14'),
        'section' => 'vm14_section_footer',
        'settings' => 'vm14_footer_fb_id'
    )));

    $wpc->add_setting('vm14_footer_twitter_name');
    $wpc->add_control(new WP_Customize_Control($wpc, 'twitter_name', array(
        'label' => __('Twitter Name', 'vm14'),
        'section' => 'vm14_section_footer',
        'settings' => 'vm14_footer_twitter_name'
    )));


    $wpc->add_section('vm14_section_pages', array(
        'title' => __('Special pages', 'vm14'),
        'priority' => 30,
    ));

    $wpc->add_setting('vm14_pages_reps');
    $wpc->add_control(new WP_Customize_Control($wpc, 'reps_page', array(
        'label' => __('Representatives page', 'vm14'),
        'section' => 'vm14_section_pages',
        'settings' => 'vm14_pages_reps',
        'type' => 'dropdown-pages'
    )));

    $wpc->add_setting('vm14_pages_groups');
    $wpc->add_control(new WP_Customize_Control($wpc, 'groups_page', array(
        'label' => __('Groups page', 'vm14'),
        'section' => 'vm14_section_pages',
        'settings' => 'vm14_pages_groups',
        'type' => 'dropdown-pages'
    )));

    $wpc->add_setting('vm14_pages_calendar');
    $wpc->add_control(new WP_Customize_Control($wpc, 'calendar_page', array(
        'label' => __('Calendar page', 'vm14'),
        'section' => 'vm14_section_pages',
        'settings' => 'vm14_pages_calendar',
        'type' => 'dropdown-pages'
    )));

    $wpc->add_setting('vm14_home_video');
    $wpc->add_control(new WP_Customize_Control($wpc, 'home_video', array(
        'label' => __('Home page video', 'vm14'),
        'section' => 'static_front_page',
        'settings' => 'vm14_home_video'
    )));
}
add_action('customize_register', 'vm14_customize_register');


/** ADDS google analytics to general settings in admin **/
$new_general_setting = new new_general_setting();

class new_general_setting {
  function new_general_setting( ) {
    add_filter( 'admin_init' , array( &$this , 'register_fields' ) );
  }
  function register_fields() {
    register_setting( 'general', 'vm14_google_analytics_id', 'esc_attr' );
    add_settings_field('vm14_google_analytics_id', '<label for="vm14_google_analytics_id">'.__('Google Analytics ID' , 'vm14' ).'</label>' , array(&$this, 'fields_html') , 'general' );
  }
  function fields_html() {
    $value = get_option( 'vm14_google_analytics_id', '' );
    echo '<input type="text" id="vm14_google_analytics_id" name="vm14_google_analytics_id" value="' . $value . '" />';
  }
}


function vm14_post_header($type = 'post'){
  $classes = array('page-header', 'clearfix');
  $end_header = '';
  $link = '#';

  if ($type == 'post' || $type == 'feed') {

    $large_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'vm14_full_width' ); 
    $medium_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'vm14_post_header' ); 
    if ($large_image) {
      array_push($classes, 'header-with-image');
      if ($type == 'post') {
        array_push($classes, 'responsive-image');
      }
      $end_header = sprintf('data-image-large="%s"  style="background-image: url(%s);"',
          $large_image[0],
          $medium_image[0]);
    }
    else {
      array_push($classes, 'no-image');
    }
  }
  if ($type == 'post' || $type == 'single') {
    $p = vm14_get_post($post->ID);
    $title = $p->title;
    $link = get_permalink($post->ID);
    $description = $p->summary;
    if (is_array($description) && count($description) > 0) {
      $description = $description[0];
    }
  }
  else if($type == 'feed') {
    $p = vm14_get_post($post->ID);
    $link = get_permalink($post->ID);
    $title = $p->title;
  }
  else if ($type == 'category') {
    array_push($classes, 'no-image');
    $title = single_cat_title("", false);
    $description = category_description();
  }
  if($type == 'single') {
    array_push($classes, 'no-image');
  }

  printf('
    <a href="%s">
      <header class="%s" %s>
        <div class="page-header-content">
            <div class="wrap">
                <h1 class="page-title eightcol first"> %s</h1>
                <div class="eightcol first">%s</div>
            </div>
        </div>
      </header>
    </a>',
    $link, 
    implode($classes, ' '),
    $end_header,
    $title,
    $description
  );

?>
<?php 
}


function vm14_post_list($posts) {
    if ($posts && is_array($posts) && sizeof($posts)>0) {
        echo '<ul class="post-list">';
        foreach ($posts as $post) {
            $html = $post->preview_html();
            echo '<li>'.$html.'</li>';
        }
        echo '</ul>';
    }
}
add_filter( 'the_content', 'remove_br_gallery', 11, 2);
function remove_br_gallery($output) {
  return preg_replace('/\<br[^\>]*\>/', '', $output);
}


?>
