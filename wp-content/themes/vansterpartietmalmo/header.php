<!doctype html>
<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

	<head>
		<meta charset="utf-8">

		<?php // Google Chrome Frame for IE ?>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title><?php echo get_bloginfo('name'); ?> - <?php wp_title(''); ?></title>

		<?php // mobile meta (hooray!) ?>
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

		<?php // icons & favicons (for more: http://www.jonathantneal.com/blog/understand-the-favicon/) ?>
		<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-icon-touch.png">
		<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png">
		<!--[if IE]>
			<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
		<![endif]-->
		<?php // or, set /favicon.ico for IE10 win ?>
		<meta name="msapplication-TileColor" content="#f01d4f">
		<meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/library/images/win8-tile-icon.png">

		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

		<?php // wordpress head functions ?>
		<?php wp_head(); ?>
		<?php // end of wordpress head ?>

		<?php // drop Google Analytics Here ?>
		<?php // end analytics ?>

	</head>

	<body <?php body_class(); ?>>
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1";
            fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>
        <header class="header" role="banner">
            <a id="logo" href="<?php echo home_url(); ?>" rel="nofollow">
              <img src="<?php echo get_template_directory_uri(); ?>/library/images/logo.png" alt="vänsterpartiet" />
              <span>
                <?php bloginfo('name'); ?>
              </span>
            </a>
            <div class="mobile-menu">meny</div>
            <?php if ( is_front_page() ) { ?>
                <nav role="navigation" class="home-navigation">
                    <?php bones_main_nav(); ?>
                </nav>
            <?php } else {?>
                <nav role="navigation" class="allpage">
                    <?php bones_main_nav(); ?>
                </nav>
            <?php } ?>
            <div class="right corner">
                <?php if (is_front_page()) : ?>
                    <?php bones_top_corner(); ?>
                <?php endif; ?>
                <form action="/" class="header-search-form">
                    <button type="submit" class="icon-holder">
                       <i class="icon-search"></i>
                    </button> 
                    <div class="search-holder">
                        <div class="search-inner-holder">
                            <input class="search-input" name="s" type="search" placeholder="Sök.." />
                        </div>
                    </div>
                </form>
                <a class="top-more" href="#footer"><?php _e('More') ?></a>
            </div>
        </header>
		<div id="container">
