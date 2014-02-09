<?php
/*
Template Name: Section
*/
?>
<?php get_header(); ?>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php $post = vm14_get_post($post->ID); ?>
        <header class="article-header clearfix responsive-image" data-image-large="<?php echo $post->image_url('large') ?>"  style="background-image: url('<?php echo $post->image_url('medium') ?>');">
            <div class="article-header-content">
                <div class="wrap">
                    <h1 class="page-title"><?php echo $post->title; ?></h1>
                    <?php echo $post->summary; ?>
                </div>
            </div>
        </header>
    <?php endwhile; else : ?>
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
    <div class="content">
        <?php echo vm14_sub_menu($post->id);?>
        <div id="inner-content" class="wrap clearfix">
            <?php echo vm14_breadcrumbs($post->id);?>
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
                <ul id="blurbs">
                    <?php dynamic_sidebar( 'blurbs' ); ?>
                </ul>
            <?php endif; ?>
         </div>
    </div>

<?php get_footer(); ?>
