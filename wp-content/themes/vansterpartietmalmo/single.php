<?php get_header(); ?>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php vm14_post_header(); ?>
        <?php echo vm14_sub_menu($post->ID); ?>
        <?php $p = vm14_get_post($post->ID);?>
        <div id="inner-content" class="wrap clearfix">
            <?php vm14_breadcrumbs($post->ID); ?>
            <div id="main" class="eightcol first clearfix" role="main">
                <article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
                    <section class="entry-content clearfix" itemprop="articleBody">
                        <?php the_content(); ?>
                        <div class="post-date">
                          <?php the_time('l, F jS, Y') ?> <?php _e('by'); ?> <?php the_author(); ?>
                        </div>


                      <?php if ($p->show_share_buttons) : ?>
                          <div class="social-share-buttons">
                              <a href="https://twitter.com/share" class="twitter-share-button" data-lang="sv">Tweeta</a>
                                  <div class="fb-like" data-layout="button_count" data-action="recommend" data-show-faces="false" data-share="false"></div>
                          </div>
                      <?php endif; ?>
                    </section>
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
                        <p><?php _e( 'This is the error message in the page.php template.', 'bonestheme' ); ?></p>
                </footer>
            </article>
    <?php endif; ?>
    <?php get_sidebar(); ?>
    <?php if ( is_active_sidebar( 'blurbs' ) ) : ?>
        <div id="blurbs">
            <?php dynamic_sidebar( 'blurbs' ); ?>
        </div>
    <?php endif; ?>
</div><?php // ending  inner-content .wrap clearfix ?>
<?php get_footer(); ?>
