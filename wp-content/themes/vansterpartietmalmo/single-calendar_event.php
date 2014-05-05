<?php get_header(); ?>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php vm14_post_header('single'); ?>
        <?php echo vm14_sub_menu($post->ID); ?>
        <?php $p = vm14_get_post($post->ID);?>
        <div id="inner-content" class="wrap clearfix">
            <?php vm14_breadcrumbs($post->ID); ?>
            <div id="main" class="eightcol first clearfix" role="main">
                <article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
                    <section class="entry-content clearfix" itemprop="articleBody">
                        <?php the_content(); ?>
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
            <div id="sidebar1" class="sidebar fourcol last clearfix" role="complementary">
                <ul class="sidebar-presentation">
                    <?php if ($p->image_id): ?>
                        <li class="sidebar-presentation-image">
                            <img src="<?php echo $p->image_url('vm14_medium_width'); ?>" />
                        </li>
                    <?php endif; ?>
                    <?php if ($fb_url = $p->facebook_event_url()):?>
                        <li class="calendar-event-fb-link">
                          <a class="icon icon-angle-right" href="<?php echo $fb_url;?>" target="_blank">
<div class="icon icon-facebook-sign"></div>
Till eventet på Facebook</a>
                        </li>
                    <?php endif;?>
                    <?php if ($p->start_date) {?>
                        <li>
                            <div class="calendar-event-single-date">
                              <h5>Börjar:</h5>
                              <div class="icon icon-calendar">
                                <?php echo date('Y-m-d', strtotime($p->start_date)); ?>
                              </div>
                              <div class="icon icon-time">
                                <?php echo $p->start_time; ?>
                              </div>
                            </div>
                        </li>
                    <?php } ?>
                    <?php if ($p->end_date) {?>
                        <li>
                            <div class="calendar-event-single-date">
                              <h5>Slutar:</h5>
                              <div class="icon icon-calendar">
                                <?php echo date('Y-m-d', strtotime($p->end_date)); ?>
                              </div>
                              <div class="icon icon-time">
                                <?php echo $p->end_time; ?>
                              </div>
                            </div>
                        </li>
                    <?php } ?>
                    <?php if ($wg = $p->working_group_post()):?>
                        <li class="calendar-event-working-group">
                            <h5>Arrangeras av:</h5>
                            <?php echo $wg->preview_html();?>
                        </li>
                    <?php endif;?>
                    <li>


                  </ul>

                <?php if ( is_active_sidebar( 'sidebar' ) ) : ?>
                <?php dynamic_sidebar( 'sidebar' ); ?>
                <?php endif; ?>

				</div>
    <?php if ( is_active_sidebar( 'blurbs' ) ) : ?>
        <div id="blurbs">
            <?php dynamic_sidebar( 'blurbs' ); ?>
        </div>
    <?php endif; ?>
</div><?php // ending  inner-content .wrap clearfix ?>
<?php get_footer(); ?>
