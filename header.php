<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>"/>
    <meta name="viewport" content="width=device-width"/>
    <?php wp_head(); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri()?>\animate.css">
    <link rel="stylesheet" type="text/css" href="slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="slick/slick-theme.css"/>
</head>
<body <?php body_class(); ?>>
<div id="wrapper" class="hfeed">
    <div class="overtop-nav"><i class="fas fa-phone"></i> &nbsp;<a href="tel:0648571963">06-48-571-963</a>,<a href="tel:06703685006">06-70-368-5006</a></div>
    <header id="header">
        <div class="nav-wrapper nav-active">
            <nav id="menu">
                <a class="logo" href="<?php echo get_home_url()?>">
                    <img class="logo" src="http://keketelbar.vertesipatrik.com/wp-content/uploads/2021/03/logo_blue_resize-1.png";>
                </a>
                <?php wp_nav_menu(array('theme_location' => 'main-menu')); ?>
                <div class="hamburger-menu">
                    <div class="line line-1"></div>
                    <div class="line line-2"></div>
                    <div class="line line-3"></div>
                </div>
            </nav>
        </div>
    </header>
    <div id="container">
