<?php
/*
Template Name: Företrädare lista
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
				<div id="inner-content" class="wrap clearfix">

						

						<div class="first eightcol lista">
							<div class="sortera">
								Sortera efter:
								<span role="link" >Förnamn</span>
								<span role="link" >Efternamn</span> 
							</div>
							<div class="alfabet">A</div>
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
							<div class="alfabet">B</div>
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

				</div>

			</div>

<?php get_footer(); ?>
