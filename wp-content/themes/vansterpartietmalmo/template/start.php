<?php
/*
Template Name: Start
*/
?>

<?php get_header(); ?>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php $large_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' ); ?>
        <?php $medium_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' ); ?>
        <div class="videoplayer responsive-image" data-height-ratio="0.85" data-image-large="<?php echo $large_image[0] ?>"  style="background-image: url('<?php echo $medium_image[0] ?>');"> </div>
        <div id="content">
            <div id="inner-content" class="wrap clearfix">
                <?php if ( is_active_sidebar( 'frontpage_blurbs' ) ) : ?>
                    <ul id="frontpage-blurbs">
                        <?php dynamic_sidebar( 'frontpage_blurbs' ); ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    <?php endwhile; endif; ?>

<?php get_footer(); ?>
