<?php
/*
Template Name: Start
*/
?>

<?php get_header(); ?>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php $large_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'vm14_full_width' ); ?>
        <?php $medium_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'vm14_medium_width' ); ?>
        <div id="home-video" class="videoplayer responsive-image" data-youtube-id="<?php echo get_theme_mod('vm14_home_video');?>" data-height-ratio="0.75" data-image-large="<?php echo $large_image[0] ?>"  style="background-image: url('<?php echo $medium_image[0] ?>');">
        </div>
        <div id="content">
            <div id="inner-content" class="wrap clearfix">
                <div id="home-intro">
                    <h1><?php the_title();?></h1>
                    <?php the_content();?>
                </div>
                <div id="home-news-marquee">
                    <h2>SENASTE NYTT:</h2>
                    <ul class="cycling-marquee">
                    <?php
                        $news = vm14_get_posts(array(
                            'post_type' => 'post'
                        ));
                    ?>
                    <?php foreach ($news as $item): ?>
                        <li>
                            <a href="<?php echo get_permalink($item->id);?>">
                                <span class="date"><?php echo $item->date('M\<\b\r\>j');?></span>
                                <?php echo $item->title;?>
                                <small><?php echo $item->get_excerpt(50);?></small></a></li>
                    <?php endforeach;?>
                    </ul>
                </div>
                <?php if ( is_active_sidebar( 'blurbs' ) ) : ?>
                    <div id="blurbs">
                        <?php dynamic_sidebar( 'blurbs' ); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endwhile; endif; ?>

<?php get_footer(); ?>
