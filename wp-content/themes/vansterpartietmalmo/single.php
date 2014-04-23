<?php get_header(); ?>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php $p = vm14_get_post($post->ID);?>
        <?php $large_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' ); ?>
        <?php $medium_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' ); ?>
        <header class="article-header clearfix responsive-image" data-image-large="<?php echo $image[0]; ?>"  style="background-image: url('<?php echo $medium_image[0]; ?>');">
            <div class="article-header-content">
                <div class="wrap">
                    <h1 class="page-title"><?php the_title(); ?></h1>
                    <?php echo $p->summary;?>
                </div>
            </div>
        </header>
        <div id="inner-content" class="wrap clearfix">
            <?php if ($p->start_date) {?>
              <div class="icon icon-calendar">
                <?php echo date('Y-m-d', strtotime($p->start_date)); ?><?php echo $p->start_time; ?>
              </div>
            <?php } ?>
            <?php if ($p->end_date) {?>
              <div class="icon icon-calendar">
                <?php echo date('Y-m-d', strtotime($p->end_date)); ?> <?php echo $p->end_time; ?>
              </div>
            <?php } ?>
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
