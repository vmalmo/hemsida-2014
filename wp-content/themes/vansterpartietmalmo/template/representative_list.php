<?php
  /*
  Template Name: Representative List Template
  */
?>
<?php get_header(); ?>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php echo vm14_post_header(); ?>
        <?php vm14_sub_menu($post->ID);?>
        <div id="inner-content" class="wrap clearfix">
            <?php vm14_breadcrumbs($post->ID);?>
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
    <?php endif; ?>
        <div id="widget-container" class="fourcol last clearfix">
        </div> 	
        <ul id="contact-list" class="first eightcol vm14-list">
            <?php
                $args = array(
                  'post_type' => 'contact_person',
                  'posts_per_page' => '200',
                  'orderby'=>'meta_value',
                  'meta_key'=>'contact_person_last_name',
                  'order'=>'ASC'
                );
                $posts = vm14_get_posts($args);
                $first_letter = null;
            ?>
            <?php for ($i = 0;$i < count($posts);$i++) {
                if (!strcasecmp($first_letter, mb_substr($posts[$i]->last_name, 0, 1)) == 0) {
                  $first_letter = mb_substr($posts[$i]->last_name, 0, 1);
                  echo '<li class="sub-header">'.$first_letter.'</li>';
                }?>
                <li class="filterable" data-tags="<?php echo $posts[$i]->tags_as_string(); ?>" data-categories="<?php echo $posts[$i]->categories_as_string(); ?>">
                  <?php echo $posts[$i]->preview_html(); ?>
                </li>
            <?php } ?>
        </ul>
        <script>
            var list, widget;

            list = document.getElementById('contact-list');
            widget = new vm14.FilterWidget(list);
            widget.enableSearch('Sök', [ 'h4', 'p', 'span' ]);
            widget.addFilter('Taggar', 'tags', vm14.FilterWidget.TAG_CLOUD, true);
            widget.render(document.getElementById('widget-container'));
        </script>

        <?php get_sidebar(); ?>
        <?php if ( is_active_sidebar( 'blurbs' ) ) : ?>
            <div id="blurbs">
                <?php dynamic_sidebar( 'blurbs' ); ?>
            </div>
        <?php endif; ?>
    </div><?php // ending  inner-content .wrap clearfix ?>
<?php get_footer(); ?>
