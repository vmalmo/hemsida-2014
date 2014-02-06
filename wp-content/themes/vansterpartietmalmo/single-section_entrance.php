<?php get_header(); ?>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php $large_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' ); ?>
        <?php $medium_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' ); ?>
        <header class="article-header clearfix responsive-image" data-image-large="<?php echo $image[0]; ?>"  style="background-image: url('<?php echo $medium_image[0]; ?>');">
            <div class="article-header-content">
                <div class="wrap">
                    <h1 class="page-title"><?php the_title(); ?></h1>
                    <?php the_content(); ?>
                </div>
            </div>
        </header>
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
    <div id="content">
        <div id="inner-content" class="wrap clearfix">
            <?php if ( is_active_sidebar( 'section_entrace_content' ) ) : ?>
                <div id="section-entrance-content-widgets" class="eightcol first">
                    <?php dynamic_sidebar( 'section_entrace_content' ); ?>
                </div>
            <?php endif; ?>
            <?php get_sidebar(); ?>
        </div>
    </div>
</div><?php // ending  inner-content .wrap clearfix ?>
<?php get_footer(); ?>