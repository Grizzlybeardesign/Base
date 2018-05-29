<?php

function create_galleries() {
    $labels = array(
        'name' => _x('Gallery', 'post type general name'),
        'singular_name' => _x('Gallery', 'post type singular name'),
        'add_new' => _x('Add New', 'Gallery'),
        'add_new_item' => __('Add New Gallery'),
        'edit_item' => __('Edit Gallery'),
        'new_item' => __('New Gallery'),
        'view_item' => __('View Gallery'),
        'search_items' => __('Search Galleries'),
        'not_found' => __('No Galleries found'),
        'not_found_in_trash' => __('No Galleries found in Trash'),
        'parent_item_colon' => ''
    );
    $args = array(
            'labels' => $labels,
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'gallery'),
            'taxonomies'  => array('category'),
            'supports' => array('title','thumbnail')
        );
    register_post_type('gallery', $args);
}

add_action('init', 'create_galleries');

function testimonials()
    {
      $labels = array(
        'name' => _x('Testimonials', 'post type general name'),
        'singular_name' => _x('Testimonials', 'post type singular name'),
        'add_new' => _x('Add New', 'Testimonial'),
        'add_new_item' => __('Add New Testimonial'),
        'edit_item' => __('Edit Testimonial'),
        'new_item' => __('New Testimonial'),
        'view_item' => __('View Testimonial'),
        'search_items' => __('Search Testimonials'),
        'not_found' =>  __('No Testimonials found'),
        'not_found_in_trash' => __('No Testimonials found in Trash'),
        'parent_item_colon' => ''
      );
      $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
       // 'publicly_queryable' => true,
      //  'show_ui' => true,
      //  'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => 6,
        'supports' => array('title','editor','excerpt','thumbnail')
      );
      register_post_type('testimonials',$args);

    }
add_action('init', 'testimonials');


function press()
{
register_post_type( 'press',
        array(
            'labels' => array(
                'name' => __( 'Press' ),
                'singular_name' => __( 'Press' )
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'press'),
        )
    );  
}

add_action('init', 'press');