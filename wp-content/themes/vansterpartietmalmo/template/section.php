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
                    <?php the_content(); ?>
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
        <div class="first twelvecol undermenu">
                <ul>
                <?php 
                    $pageid = get_queried_object_id();
                    $args = array('child_of' =>$pageid,'title_li'=> __('')); 
                    wp_list_pages($args); 
                ?>
                </ul>
        </div>
        <div id="inner-content" class="wrap clearfix">
                <?php get_sidebar(); ?>
         </div>
    </div>

<?php get_footer(); ?>
