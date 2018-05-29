<?php

/**
 * Override post meta
 *
 *
 * @package WordPress
 * @subpackage Grizzly theme
 */
Class Post_Override_Meta Extends Post_Meta_Inputs {

    var $option_name;
    var $meta_prefix;

    /**
     * Construct functions
     */
    public function __construct() {
        $this->option_name = 'grizzly_custom_post_meta';
        $this->meta_prefix = '_custom_post_meta_';
        $this->init();
    }

    /**
     * initialize functions
     */
    private function init() {

        add_action('add_meta_boxes', array($this, 'grizzly_register_meta_boxes'));
        add_action('added_post_meta', array($this, 'grizzly_after_post_meta'), 10, 4);
        add_action('updated_post_meta', array($this, 'grizzly_after_post_meta'), 10, 4);
    }

    /**
     * register meta boxes
     */
    function grizzly_register_meta_boxes() {
        add_meta_box('meta-box-id', __('Page Settings', 'textdomain'), array($this, 'grizzly_post_meta_display_callback'), 'page', 'side');
        add_meta_box('meta-box-id', __('Post Settings', 'textdomain'), array($this, 'grizzly_post_meta_display_callback'), 'post', 'side');
        add_meta_box('meta-box-id', __('Gallery Settings', 'textdomain'), array($this, 'grizzly_gallery_meta_display_callback'), 'gallery', 'normal');
    }

    /**
     * after the post meta
     */
    function grizzly_after_post_meta($meta_id, $post_id, $meta_key, $meta_value) {
        if (isset($_POST['grizzly_custom_post_meta'])) {
            $custom_post_meta = $_POST['grizzly_custom_post_meta'];
            foreach ($custom_post_meta as $key => $value) {
                $field_key = $this->meta_prefix . $key;
                update_post_meta($post_id, $field_key, maybe_serialize($value));
            }
        }
    }

    /**
     * display post type
     */
    function grizzly_post_meta_display_callback($post) {
        global $allowedtags;
        $post_id = $post->ID;
        $options = array();

        $show_page_title = array(
            'yes' => __('Yes', 'grizzlytheme'),
            'no' => __('No', 'grizzlytheme'),
        );

        $options[] = array(
            'name' => __('Show page title', 'grizzlytheme'),
            'id' => 'show_page_title',
            'std' => 'no',
            'type' => 'radio',
            'class' => 'mini',
            'options' => $show_page_title
        );


        $social_sharing = array(
            'yes' => __('Yes', 'grizzlytheme'),
            'no' => __('No', 'grizzlytheme'),
        );

        $options[] = array(
            'name' => __('Enable Social Sharing For Page', 'grizzlytheme'),
            'id' => 'enable_social_sharing_for_page',
            'std' => 'no',
            'type' => 'radio',
            'class' => 'mini',
            'options' => $social_sharing
        );

        $options_framework = '';
        $settings = array();
        $option_name = $this->option_name;
        $show_page_title = get_post_meta($post_id, $this->meta_prefix . 'show_page_title');
        $enable_social_sharing_for_page = get_post_meta($post_id, $this->meta_prefix . 'enable_social_sharing_for_page');
        if (isset($enable_social_sharing_for_page[0])) {
            $settings['enable_social_sharing_for_page'] = $enable_social_sharing_for_page[0];
        }
        if (isset($show_page_title[0])) {
            $settings['show_page_title'] = $show_page_title[0];
        }
        $counter = 0;
        $menu = '';
        $this->grizzly_input_fields($options, $options_framework, $option_name, $settings, $counter, $menu, $allowedtags);
    }

    function grizzly_gallery_meta_display_callback($post) {
        global $allowedtags;
        $post_id = $post->ID;
        $options = array();
        $imagepath = get_template_directory_uri() . '/lib/inc/images/';

        $options[] = array(
            'name' => "Layout",
            'desc' => 'Choose your gallery display style.',
            'id' => "layout",
            'std' => "gallery_style_3",
            'type' => "images",
            'options' => array(
                'gallery_style_1' => $imagepath . 'gallery_grid_1.jpg',
                'gallery_style_2' => $imagepath . 'gallery_grid_2.jpg',
                'gallery_style_3' => $imagepath . 'gallery_grid_3.jpg',
            )
        );
        $options[] = array(
            'name' => __('Related Galleries', 'grizzlytheme'),
            'id' => 'related_galleries',
            'std' => '0',
            'type' => 'checkbox'
        );



        $options_framework = '';
        $settings = array();
        $option_name = $this->option_name;
        $gallery_layout = get_post_meta($post_id, $this->meta_prefix . 'layout');
        $related_galleries = get_post_meta($post_id, $this->meta_prefix . 'related_galleries');
        if (isset($related_galleries[0])) {
            $settings['related_galleries'] = $related_galleries[0];
        }
        if (isset($gallery_layout[0])) {
            $settings['layout'] = $gallery_layout[0];
        }
        $counter = 0;
        $menu = '';
        $this->grizzly_input_fields($options, $options_framework, $option_name, $settings, $counter, $menu, $allowedtags);
    }

}
