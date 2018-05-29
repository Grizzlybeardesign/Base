<?php

if (!function_exists('gt_enqueue_style')) {
    function gt_enqueue_style() {
        wp_enqueue_style('gt-stylesheet', get_stylesheet_directory_uri() . '/css/app.css', array(), '');
        wp_enqueue_style('gt-custom', get_stylesheet_directory_uri() . '/css/custom.css', array(), '');        
    }
}
add_action('wp_enqueue_scripts', 'gt_enqueue_style');
?>
