			<footer class="footer" role="contentinfo">
        <a name="footer"></a>
				<div id="inner-footer" class="wrap clearfix">
					<div class="threecol first" >
            <div class="footer-logo">
              <img  src="<?php echo get_template_directory_uri(); ?>/library/images/logo.png" alt="vänsterpartiet" />
            </div>
						<?php echo get_bloginfo ( 'description' );  ?><br /> <br />

                        <?php if (get_theme_mod('vm14_footer_twitter_name')):?>
                        <a href="https://twitter.com/<?php echo get_theme_mod('vm14_footer_twitter_name');?>" class="twitter-follow-button" data-show-count="false" data-lang="en">Follow @<?php echo get_theme_mod('vm14_footer_twitter_name');?></a>
                        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                        <?php endif; ?>

                        <?php if (get_theme_mod('vm14_footer_fb_id')):?>
                        <div class="fb-like" data-href="http://facebook.com/<?php echo get_theme_mod('vm14_footer_fb_id');?>" data-width="240" data-layout="standard" data-action="like" data-show-faces="true" data-share="false"></div>
                        <?php endif;?>

                        <?php echo get_theme_mod('vm14_footer_contact'); ?>
					</div>
					<nav role="navigation" class="ninecol last">
							<?php bones_footer_links(); ?>
					</nav>
				</div>
			</footer>
		</div>
		<?php // all js scripts are loaded in library/bones.php ?>
		<?php wp_footer(); ?>
	</body>
</html>
