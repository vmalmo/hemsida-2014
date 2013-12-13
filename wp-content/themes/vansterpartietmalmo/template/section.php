<?php
/*
Template Name: Section
*/
?>
<?php get_header(); ?>

			<div id="content">
				<div id="main" class="twelvecol section-b first clearfix" role="main">

					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

					<article class="wrap" id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

						<header class="article-header">

							<h1 class="page-title"><?php the_title(); ?></h1>
							


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

						

						<div class="first eightcol lista">
							<h2>Lista namn</h2>
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
						<?php get_sidebar(); ?>

				</div>

			</div>

<?php get_footer(); ?>
