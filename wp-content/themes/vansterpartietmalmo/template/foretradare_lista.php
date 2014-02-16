<?php
  /*
  Template Name: Företrädare lista
  */
?>
<?php get_header(); ?>
    <div id="inner-content" class="wrap clearfix">
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
                  echo '<li class="alfabet">'.$first_letter.'</li>';
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
