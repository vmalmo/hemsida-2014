<?php
/*
Template Name: Kalender
*/
  $today = date('Ymd', strtotime("now"));
  $today  = date('Ymd', strtotime($today. ' + 1 days'));
  $header_rules = array(
    array(
      'rule' => $today,
      'name' => __('Today')
    ),
    array(
      'rule' => date('Ymd', strtotime($today. ' + 1 days')),
      'name' => __('Tomorrow')
    ),
    array(
      'rule' => date('Ymd', strtotime('Sunday this week')),
      'name' => __('This week')
    ),
    array(
      'rule' => date('Ymd', strtotime('Sunday next week')),
      'name' => __('Next week')
    ),
    array(
      'rule' => date('Ymd', strtotime('Sunday next week')),
      'name' => __('Future')
    ),
  );
  
?>
<?php get_header(); ?>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php echo vm14_post_header(); ?>
        <?php $post = vm14_get_post($post->ID); ?>
        <?php vm14_sub_menu($post->id);?>

        <div id="inner-content" class="wrap clearfix">
            <?php vm14_breadcrumbs($post->id);?>
            <div id="main" class="eightcol first clearfix" role="main">
                <article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
                    <section class="entry-content clearfix" itemprop="articleBody">
                        <?php the_content(); ?>
                    </section>
                    <footer class="article-footer">
                        <?php the_tags( '<span class="tags">' . __( 'Tags:', 'bonestheme' ) . '</span> ', ', ', '' ); ?>
                    </footer>
                </article>
            </div>
    <?php endwhile; else : ?>
        <div id="inner-content" class="wrap clearfix">
            <article id="post-not-found" class="hentry clearfix">
                <header class="article-header">
                    <h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
                </header>
                <section class="entry-content">
                    <p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
                </section>
                <footer class="article-footer">
                    <p><?php _e( 'This is the error message in the page-custom.php template.', 'bonestheme' ); ?></p>
                </footer>
            </article>

    <?php endif; ?>

        <div id="widget-container" class="fourcol last clearfix">
        </div> 	
        <ul id="calendar-list" class="first eightcol vm14-list">
            <?php
                $args = array(
                  'post_type' => 'calendar_event',
                  'posts_per_page' => '200',
                  'orderby' => 'meta_value',
                  'meta_key' => 'calendar_event_start_date',
                  'meta_query' => array(
                    array(
                      'key' => 'calendar_event_end_date',
                      'value' => date('Ymd', strtotime($today. ' - 1 days')),
                      'type' => 'numeric',
                      'compare' => '>='
                    )
                  ),
                  'order'=>'ASC'
                );
                $posts = vm14_get_posts($args);
                $first_letter = null;
            ?>
            <?php $current_rule_index = -1; ?>
            <?php for ($j = 0;$j < count($header_rules); $j++) { ?>
                <?php if ($header_rules[$j]['rule'] >= $posts[0]->start_date) { ?>
                    <?php // bah I fix an better solution tomorrow...
                      $current_rule_index = $j;
                      break;
                    ?>
                <?php } ?>
                <?php $current_rule_index = count($header_rules)-1; ?>
            <?php } ?>

            <li class="sub-header"><?php echo $header_rules[$current_rule_index]['name']; ?></li>
            <?php for ($i = 0;$i < count($posts);$i++) { ?>
                <?php if ($header_rules[$current_rule_index]['rule'] <= $posts[$i]->start_date && $current_rule_index < count($header_rules)) { ?>
                    <?php for ($j = $current_rule_index; $j < count($header_rules); $j++) { // loop through rules to find the one for this day ?>
                        <?php if ($header_rules[$j]['rule'] > $posts[$i]->start_date) { ?>
                            <?php $current_rule_index = $j; ?>
                            <li class="sub-header"><?php echo $header_rules[$current_rule_index]['name']; ?></li>
                            <?php break; ?>
                        <?php }?>
                    <?php }?>
                    <?php if ($j === count($header_rules)) { // if loop when throu the we at last step ?>
                        <?php $current_rule_index = count($header_rules) + 1; ?>
                        <li class="sub-header"><?php echo $header_rules[count($header_rules)-1]['name']; ?></li>
                    <?php } ?>
                <?php } ?>
                <li class="filterable" data-tags="<?php echo $posts[$i]->tags_as_string(); ?>" data-categories="<?php echo $posts[$i]->categories_as_string(); ?>">
                    <?php echo $posts[$i]->preview_html(); ?>
                </li>
            <?php } ?>
        </ul>

        <script>
            var list, widget;

            list = document.getElementById('calendar-list');
            widget = new vm14.FilterWidget(list);
            widget.enableSearch('Sök', [ 'h4', 'p' ]);
            widget.addFilter('Taggar', 'tags', vm14.FilterWidget.TAG_CLOUD, true);
            widget.render(document.getElementById('widget-container'));
        </script>

        <?php if ( is_active_sidebar( 'blurbs' ) ) : ?>
            <div id="blurbs">
                <?php dynamic_sidebar( 'blurbs' ); ?>
            </div>
        <?php endif; ?>
    </div><?php // ending  inner-content .wrap clearfix ?>
<?php get_footer(); ?>
