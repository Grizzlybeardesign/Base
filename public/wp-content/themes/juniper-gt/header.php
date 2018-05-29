<?php
/**
 * The header for our theme
 *
 * @package Grizzly_Base_Theme
 * @since Grizzly_Base_Theme 1.0
 * 
 */
?>
<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" <?php language_attributes(); ?> > <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" <?php language_attributes(); ?> > <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" <?php language_attributes(); ?> "> <![endif]-->
<!-- Consider adding an manifest.appcache: h5bp.com/d/Offline -->
<html>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <title><?php wp_title('|', true, 'right'); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta content="author" name="Grizzly Themes">
        <?php echo get_template_part('parts/head', 'favicons'); ?>
        <!-- [if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js" type="text/javascript"></script><![endif] -->
      <!-- <script type="text/javascript">
    !function(o,c){var n=c.documentElement,t=" w-mod-";n.className+=t+"js",("ontouchstart"in o||o.DocumentTouch&&c instanceof DocumentTouch)&&(n.className+=t+"touch")}(window,document);
  </script> -->
        <?php wp_head(); ?>
    </head>
    <?php
    


    ?>
    <body <?php body_class(); ?>>
        <?php 
        $header_class = gt_get_option( 'logos_and_navigation' );
        
        if ( gt_get_option( 'enable_sticky_menu' ) == 'yes' ){
            $header_class .= " sticky-menu ";
        }
        ?>
<!--         <?php if ( is_page_template('templates/home.php') ):?>
                <div id="preload">
            <img src="<?php echo get_template_directory_uri(); ?>/img/png/contact-link-hover-500.png" width="1" height="1" alt="Image 01" />
            <img src="<?php echo get_template_directory_uri(); ?>/img/png/Alexis-Call-To-Action-Hover-01-p-500.png" width="1" height="1" alt="Image 02" />
            <img src="<?php echo get_template_directory_uri(); ?>/img/png/Blog-Links-orange.png" width="1" height="1" alt="Image 02" />
         </div>-->
           
            <!--<div class="pacehelper"></div>-->
        <?php endif; ?>
        <header id="header" class="<?php echo $header_class ?>">
            <!-- conditional to change from the default parts header navbar or the part/header-navbar-above -->
            <?php echo get_template_part('parts/header', 'navbar_1'); ?>
        </header>
        <!-- If is fullwidth need conditional to enable/disable this section -->
            <div class="container">
        <div class="row">