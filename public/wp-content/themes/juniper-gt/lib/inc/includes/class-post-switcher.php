<?php

class Post_Switcher {

    /**
     * Add Page Switcher 
     * 
     * 
     * @package    init()

     */
    public function init() {
        add_action('add_meta_boxes', 'page_switcher_func');

        /**
         * Generates the side panel in post pages
         */
        function page_switcher_func() {
            $screens = array('post', 'page', 'press', 'gallery', 'testimonials');
            foreach ($screens as $screen) {
                add_meta_box(
                        'edit-switcher', 'Post Switcher', 'page_content_switcher_post_func', $screens, 'advanced', 'high'
                );
            }
        }
        /**
         * Page Switcher Callback Function
         */
        function page_content_switcher_post_func($post) {
            $posttitle = $post->post_title;
            $posttype = $post->post_type;
            ?>
            <select style="width:100%;" class="page-switcher-select form-control" name="page-dropdown" onchange='document.location.href = this.options[this.selectedIndex].value;'> 
                <?php
                    if($posttype == "post"){
                    $posts = get_posts();
                    }elseif($posttype == "page"){
                        $posts = get_pages();
                    }else{
                    $posts = get_posts(array('post_type' => $posttype));
                    }
                    $selected_page = get_option('option_key');
                    $id = get_the_ID();
                    $siteurl = get_site_url('url');
                    foreach ($posts as $post) {
                        $option = '<option value="' . $siteurl . '/wp-admin/post.php?post=' . $post->ID . '&action=edit"';
                        $option .= ( $posttitle == $post->post_title ) ? 'selected="selected"' : '';
                        $option .= '>';
                        $option .= $post->post_title;
                        $option .= '</option>';
                        echo $option;
                    }
                echo '</select>';
            }

            add_action('edit_form_after_title', function() {
                global $post, $wp_meta_boxes;
                do_meta_boxes(get_current_screen(), 'advanced', $post);
                unset($wp_meta_boxes[get_post_type($post)]['advanced']);
            });
        }

    }
    ?>
