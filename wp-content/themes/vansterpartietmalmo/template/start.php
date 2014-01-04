<?php
/*
Template Name: Start
*/
?>

<?php get_header(); ?>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php $post = new VM14_Page_Post_Type(get_post()); ?>
            <div class="videoplayer responsive-image" data-image-large="<?php echo $post->image_url('large') ?>"  style="background-image: url('<?php echo $post->image_url('medium') ?>');"> </div>
			<div id="content">
				<div id="inner-content" class="wrap clearfix">
                    <?php get_sidebar('sidebarHome'); ?>
				</div>
			</div>
    <?php endwhile; endif; ?>
<?php get_footer(); ?>
