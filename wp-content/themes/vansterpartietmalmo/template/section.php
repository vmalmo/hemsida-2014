<?php
/*
Template Name: Section Template
*/
?>
<?php get_header(); ?>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php echo vm14_post_header(); ?>
        <?php $p = vm14_get_post($post->ID); ?>
    <?php endwhile; else : ?>
            <article id="post-not-found" class="hentry clearfix">
                    <header class="page-header">
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
    <div class="content">
        <?php echo vm14_sub_menu($post->ID);?>
        <div id="inner-content" class="wrap clearfix">
            <?php echo vm14_breadcrumbs($post->ID);?>
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
            <?php get_sidebar(); ?>
            <?php if ( is_active_sidebar( 'blurbs' ) ) : ?>
                <div id="blurbs">
                    <?php dynamic_sidebar( 'blurbs' ); ?>
                </div>
            <?php endif; ?>
         </div>
    </div>

<?php get_footer(); ?>
