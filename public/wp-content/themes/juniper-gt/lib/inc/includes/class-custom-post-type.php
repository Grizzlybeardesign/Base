<?php

/**
 * create custom post type
 *
 *
 * @package WordPress
 * @subpackage Grizzly theme
 */
class Custom_Post_Type {

    /**
     * constructor
     */
    public function __construct() {
        $this->init();
        add_theme_support('post-thumbnails', array('post', 'testimonials'));
        add_action('add_meta_boxes', array($this, 'gallery_meta_box'));
        add_action('updated_post_meta', array($this, 'update_gallery_images'), 10, 4);
    }

    /**
     * initialize the class
     */
    protected function init() {
        $this->create_posttype();
    }

    /**
     * create custom post type
     */
    private function create_posttype() {

        register_post_type('gallery', array(
            'labels' => array(
                'name' => __('Gallery'),
                'singular_name' => __('Gallery')
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'gallery'),
            'taxonomies' => array('category'),
            'supports' => array('title')
                )
        );
        register_post_type('badges', array(
            'labels' => array(
                'name' => __('Badges'),
                'singular_name' => __('Badge')
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'badges'),
                )
        );
        register_post_type('testimonials', array(
            'labels' => array(
                'name' => __('Testimonials'),
                'singular_name' => __('Testimonial')
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'testimonial'),
            'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments')
                )
        );
        register_post_type('press', array(
            'labels' => array(
                'name' => __('Press'),
                'singular_name' => __('Press')
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'press'),
                )
        );
    }

    public function gallery_meta_box() {

        add_meta_box(
                'gallery-images', __('Gallery', 'sitepoint'), array($this, 'gallery_meta_box_callback'), array('gallery', 'page'), 'normal', 'default'
        );
    }

    public function gallery_meta_box_callback($post) {
        wp_enqueue_media();
        $saved_images_data = get_post_meta($post->ID, '_grizzly_gallery_image_list');
        $image_list = array();
        if (isset($saved_images_data[0])) {
            $image_list = maybe_unserialize($saved_images_data[0]);
        }
        ?><ul class='image-preview-wrapper gallery-images sortable'>
            <li class="image" >	<img  src='' width='126' height='126' style='max-height: 126px; width: 126px;'>
                <a href="javascript:void(0)" class="btn-gellery-remove" >Remove</a>
                <input type="hidden" name="_grizzly_gallery_image_list[]" value="null">
            </li>
        <?php
        foreach ($image_list as $attacment_id) {
            $attachment_url = wp_get_attachment_image_src($attacment_id, 'thumbnail');
            ?>
                <li class="image" >	<img  src='<?php echo $attachment_url[0]; ?>' width='126' height='126' style='max-height: 126px; width: 126px;'>
                    <a href="javascript:void(0)" class="btn-gellery-remove" >Remove</a>
                    <input type="hidden" name="_grizzly_gallery_image_list[]" value="<?php echo $attacment_id; ?>">
                </li>
                <?php
            }
            ?>
        </ul>
        <input id="upload_image_button" type="button" class="button" value="<?php _e('Add to Gallery'); ?>" />
            <?php
        }

        /**
         * add or update gallery images
         */
        public function update_gallery_images($meta_id, $post_id, $meta_key, $meta_value) {


            if (isset($_POST['_grizzly_gallery_image_list'])) {
                if (count($_POST['_grizzly_gallery_image_list']) > 1) {
                    $image_data = array();
                    $i = 0;
                    foreach ($_POST['_grizzly_gallery_image_list'] as $key => $value) {
                        if ($value != 'null') {
                            $image_data[$i] = $value;
                            $i++;
                        }
                    }
                    update_post_meta($post_id, '_grizzly_gallery_image_list', maybe_serialize($image_data));
                }
            }
        }

    }

    /**
     * Initialize the custom post type class
     */
    add_action('init', 'theme_init_post_type');

    /**
     * Init function
     */
    function theme_init_post_type() {
        $custom_post_type = new Custom_Post_Type();
    }
    