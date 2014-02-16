<?php
  /*
  Template Name: Företrädare lista
  */
?>
<?php get_header(); ?>
    <div id="inner-content" class="wrap clearfix">
        <div class="fourcol last clearfix">
            <h3>Sök:</h3>
            <input id="search" type="text">
            <br>
            <h3>Visa:</h3>
            <ul>
                <li>Styrelsen</li>
                <li>Styrelsen</li>
                <li>Styrelsen</li>
                <li>Styrelsen</li>
            </ul>
            <br><br>
            <div class="filter">

                <span> Jämställdhet</span>
                <span class="active">Kultur</span>
                <span>interndemokrati</span>
                <span>arbetsgrupp</span>
                <span class="active">Miljö</span>
                <span>Sjukvård</span>
            </div>
        </div> 	
        <ul class="first eightcol lista">
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
                <li class="filter" data-tags="<?php echo vm14_get_tag_comma_separated($posts[$i]);?>">
                  <?php echo $posts[$i]->preview_html(); ?>
                </li>
            <?php } ?>
        </ul>

        <?php if ( is_active_sidebar( 'blurbs' ) ) : ?>
            <div id="blurbs">
                <?php dynamic_sidebar( 'blurbs' ); ?>
            </div>
        <?php endif; ?>
    </div><?php // ending  inner-content .wrap clearfix ?>
<?php get_footer(); ?>
