<?php get_header(); ?>
			<div id="content" class="wrap toppad clearfix">
                <?php vm14_breadcrumbs($post->ID, get_theme_mod('vm14_pages_groups'));?> 
				<div id="main" class="eightcol first clearfix" role="main">

					<?php if (have_posts()) : while (have_posts()) : the_post(); $p = vm14_get_post($post->ID); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

						<header>
							<h1 class="page-title"><?php the_title(); ?></h1>
                            <?php echo $p->summary;?>
						</header>

						<section class="entry-content clearfix" itemprop="articleBody">
							<?php the_content(); ?>
						</section>


					</article>

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
					
				</div>
				<div id="sidebar1" class="sidebar fourcol last clearfix" role="complementary">
              <ul class="sidebar-presentation">
                  <?php
                    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'vm14_medium_width' ); 
                  if ($image):?>
                        <li>
                          <img class="sidebar-presentation-image" src="<?php echo $image[0];?>">
                        </li>
                  <?php endif;?>

                  <?php if ($p->contact_persons):?>
                      <li>
                          <h5>Kontakt</h5>
                          <ul class="working-group-contact-list">
                          <?php foreach ($p->contact_persons as $pid):?>
                              <?php $person = vm14_get_post($pid);?>
                              <li>
                                    <a href="<?php echo $person->permalink();?>">
<img src="<?php echo $person->image_url('vm14_thumb'); ?>" /><?php printf('%s %s', $person->first_name, $person->last_name);?></a>
</li>
                          <?php endforeach;?>
                      </li>
                  </ul>
                  <?php endif;?>

                  <?php
                      $events = $p->events();
                      if (count($events)>0):?>
                          <li>
                            <h5>Kommande arrangemang</h5>
                            <ul>
                            <?php foreach ($events as $event):?>
                                <li><?php echo $event->preview_html();?></li>
                            <?php endforeach;?>
                            </ul>
                          </li>
                  <?php endif;?>
                  <?php if ($p->show_share_buttons) : ?>
                    <li>
                        <h5>Dela</h5>
                        <div class="social-share-buttons">
                            <a href="https://twitter.com/share" class="twitter-share-button" data-lang="sv">Tweeta</a>
                            <div class="fb-like" data-layout="button_count" data-action="recommend" data-show-faces="false" data-share="false"></div>
                        </div>
                    </li>
                  <?php endif; ?>
                </ul>

					<?php if ( is_active_sidebar( 'sidebar' ) ) : ?>

						<?php dynamic_sidebar( 'sidebar' ); ?>

					<?php endif; ?>

				</div>
        <?php if ( is_active_sidebar( 'blurbs' ) ) : ?>
            <div id="blurbs">
                <?php dynamic_sidebar( 'blurbs' ); ?>
            </div>
        <?php endif; ?>

			</div>

<?php get_footer(); ?>
