<?php
/**
 * Register widget areas
 *
 * @package Grizzly_Base_Theme
 * @since Grizzly_Base_Theme 1.0
 * 
 */
if ( ! function_exists( 'grizzlytheme_widgets_init' ) ) :
    function grizzlytheme_widgets_init() {
    register_sidebar(array(
        'name'=> 'Sidebar',
    	'id' => 'Sidebar',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>'
    ));
    
    register_sidebar(array(
        'name'=> 'Footer Left',
    	'id' => 'footer-left',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>'
    ));
    
    register_sidebar(array(
        'name'=> 'Footer Middle',
    	'id' => 'footer-middle',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>'
    ));
    
    register_sidebar(array(
        'name'=> 'Footer Right',
    	'id' => 'footer-right',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>'
    ));
}
endif;
add_action( 'widgets_init', 'grizzlytheme_widgets_init' );
