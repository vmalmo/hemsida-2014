<?php
/*
Template Name: Kalender
*/
?>
<?php get_header(); ?>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php echo vm14_post_header(); ?>
          <?php $post = vm14_get_post($post->ID); ?>
            <div class="page-header-content">
                <div class="wrap">
                    <h1 class="page-title"><?php echo $post->title; ?></h1>
                    <?php echo $post->summary; ?>
                </div>
            </div>
        </header>
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
        <ul id="contact-list" class="first eightcol vm14-list">
            <?php
                $today = date('Ymd', strtotime("now"));
                $args = array(
                  'post_type' => 'calendar_event',
                  'post_per_page' => '100',
                  'orderby' => 'meta_value',
                  'meta_key' => 'calendar_event_start_date',
                  'meta_query' => array(
                    array(
                      'key' => 'calendar_event_end_date',
                      'value' => $today,
                      'type' => 'numeric',
                      'compare' => '>='
                    )
                  ),
                  'order'=>'ASC'
                );
                $posts = vm14_get_posts($args);
                $first_letter = null;
            ?>
            <?php for ($i = 0;$i < count($posts);$i++) {
                if (!strcasecmp($first_letter, $posts[$i]->last_name[0]) == 0) {
                  $first_letter = $posts[$i]->last_name[0];
                  echo '<li class="sub-header">'.$first_letter.'</li>';
                }?>
                <li class="filterable" data-tags="<?php echo vm14_get_tag_comma_separated($posts[$i]);?>">
                  <?php echo $posts[$i]->preview_html(); ?>
                </li>
            <?php } ?>
        </ul>
        <?php if ( is_active_sidebar( 'blurbs' ) ) : ?>
            <div id="blurbs">
                <?php dynamic_sidebar( 'blurbs' ); ?>
            </div>
        <?php endif; ?>
    </div><?php // ending  inner-content .wrap clearfix ?>
<?php get_footer(); ?>
