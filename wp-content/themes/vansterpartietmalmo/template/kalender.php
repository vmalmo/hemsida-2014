<?php
/*
Template Name: Kalender
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
        <?php vm14_sub_menu($post->id);?>

        <div id="inner-content" class="wrap clearfix">
            <?php vm14_breadcrumbs($post->id);?>
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
                    <p><?php _e( 'This is the error message in the page-custom.php template.', 'bonestheme' ); ?></p>
                </footer>
            </article>

    <?php endif; ?>
        <div class="first eightcol lista">
            <div class="sortera">
                Sortera efter:
                <span role="link" >Förnamn</span>
                <span role="link" >Efternamn</span> 
            </div>
            <div class="alfabet">Idag</div>
            <ul>
                <li>
                    <img src="http://placehold.it/200x100">
                    <h3>Lorem</h3>
                    <span>ipsum dolor sit amet</span>
                </li>
                <li>
                    <img src="http://placehold.it/200x100">
                    <h3>Lorem</h3>
                    <span>ipsum dolor sit amet</span>
                </li>
                <li>
                    <img src="http://placehold.it/200x100">
                    <h3>Lorem</h3>
                    <span>ipsum dolor sit amet</span>
                </li>
                <li>
                    <img src="http://placehold.it/200x100">
                    <h3>Lorem</h3>
                    <span>ipsum dolor sit amet</span>
                </li>
                <li>
                    <img src="http://placehold.it/200x100">
                    <h3>Lorem</h3>
                    <span>ipsum dolor sit amet</span>
                </li>
            </ul>
            <div class="alfabet">Denna vecka</div>
            <ul>
                <li>
                    <img src="http://placehold.it/200x100">
                    <h3>Lorem</h3>
                    <span>ipsum dolor sit amet</span>
                </li>
                <li>
                    <img src="http://placehold.it/200x100">
                    <h3>Lorem</h3>
                    <span>ipsum dolor sit amet</span>
                </li>
                <li>
                    <img src="http://placehold.it/200x100">
                    <h3>Lorem</h3>
                    <span>ipsum dolor sit amet</span>
                </li>
                <li>
                    <img src="http://placehold.it/200x100">
                    <h3>Lorem</h3>
                    <span>ipsum dolor sit amet</span>
                </li>
                <li>
                    <img src="http://placehold.it/200x100">
                    <h3>Lorem</h3>
                    <span>ipsum dolor sit amet</span>
                </li>
            </ul>
        </div>
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
    </div><?php // ending  inner-content .wrap clearfix ?>
<?php get_footer(); ?>
