<?php
  /*
  Template Name: Företrädare lista
  */
?>
<?php get_header(); ?>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php echo vm14_post_header(); ?>
          <?php $post = vm14_get_post($post->ID); ?>
            <div class="page-header-content">
                <div class="wrap">
                    <h1 class="page-title"><?php echo $post->title; ?></h1>
                    <?php echo $post->summary; ?>
                </div>
            </div>
        </header>
        <?php vm14_sub_menu($post->id);?>
        <div id="inner-content" class="wrap clearfix">
            <?php vm14_breadcrumbs($post->id);?>
    <?php endwhile; else : ?>
        <div id="inner-content" class="wrap clearfix">
    <?php endif; ?>
        <div id="widget-container" class="fourcol last clearfix">
        </div> 	
        <ul id="contact-list" class="first eightcol vm14-list">
            <?php
                $args = array(
                  'post_type' => 'contact_person',
                  'post_per_page' => '100',
                  'orderby'=>'meta_value',
                  'meta_key'=>'contact_person_last_name',
                  'order'=>'ASC'
                );
                $posts = vm14_get_posts($args);
                $first_letter = null;
            ?>
            <?php for ($i = 0;$i < count($posts);$i++) {
                if (!strcasecmp($first_letter, $posts[$i]->last_name[0]) == 0) {
                  $first_letter = $posts[$i]->last_name[0];
                  echo '<li class="sub-header">'.$first_letter.'</li>';
                }?>
                <li class="filterable" data-tags="<?php echo vm14_get_tag_comma_separated($posts[$i]);?>">
                  <?php echo $posts[$i]->preview_html(); ?>
                </li>
            <?php } ?>
        </ul>
        <script>
            var list, widget;

            list = document.getElementById('contact-list');
            widget = new vm14.FilterWidget(list);
            widget.enableSearch('Sök', [ 'h4', 'p' ]);
            widget.render(document.getElementById('widget-container'));
        </script>

        <?php if ( is_active_sidebar( 'blurbs' ) ) : ?>
            <div id="blurbs">
                <?php dynamic_sidebar( 'blurbs' ); ?>
            </div>
        <?php endif; ?>
    </div><?php // ending  inner-content .wrap clearfix ?>
<?php get_footer(); ?>
