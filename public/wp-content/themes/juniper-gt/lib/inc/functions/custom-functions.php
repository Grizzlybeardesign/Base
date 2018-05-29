<?php
if (!function_exists('hex2rgb')) {

    function hex2rgb($hex) {
        $hex = str_replace("#", "", $hex);

        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        //$rgb = array($r, $g, $b);
        $rgb = $r . ',' . $g . ',' . $b . ', ';

        //return implode(",", $rgb); // returns the rgb values separated by commas
        return $rgb; // returns an array with the rgb values
    }
}
if (!function_exists('gt_get_categ_tax')) {

    function gt_get_categ_tax($post_id) {

        $current_post_type = get_post_type($post_id);

        // category taxonomy array for each post type
        $categ_taxonomies = array('post' => 'category',
            'testimonial' => 'testimonial-category',
            'gallery' => 'gallery-category'
        );
        if (isset($categ_taxonomies[$current_post_type])) {
            return $categ_taxonomies[$current_post_type];
        } else {
            return '';
        }
    }

}
if (!function_exists('gt_post_nav')) :

    /**
     * Displays navigation to next/previous post when applicable.
     *
     *
     * @return void
     */
    function gt_post_nav() {
        global $post;

        // Don't print empty markup if there's nowhere to navigate.
        $previous = ( is_attachment() ) ? get_post($post->post_parent) : get_adjacent_post(false, '', true);
        $next = get_adjacent_post(false, '', false);

        if (!$next && !$previous)
            return;
        ?>
        <nav class="navigation post-navigation" role="navigation">
            <div class="nav-links">

                <?php
                if ($previous) {
                    previous_post_link('%link', _x('<span class="meta-nav icon-glyph-18"></span> <span class="the-text">Previous</span>', 'Previous post link', 'gttheme'));
                } else {
                    echo '<a href="#" rel="prev"><span></span></a>';
                }
                ?>

        <?php next_post_link('%link', _x('<span class="the-text">Next</span> <span class="meta-nav icon-glyph-17"></span>', 'Next post link', 'gttheme')); ?>

            </div><!-- .nav-links -->
        </nav><!-- .navigation -->
        <?php
    }

endif;
//if (!function_exists('wpforce_featured')) {
//    /* if a post does not have featured image, then we set the first attached image as feat img */
//
//    function wpforce_featured() {
//        if (options::logic('blog_post', 'auto_feat_img')) {
//            global $post;
//
//            $post_types_to_work_with = array('post', 'gallery'); // add more posts here if you want.
//
//            if (isset($post->ID)) {
//                $the_post_format = get_post_type($post->ID);
//            } else {
//                $the_post_format = 'unknown';
//            }
//
//
//
//
//            if (in_array($the_post_format, $post_types_to_work_with)) {
//                $already_has_thumb = has_post_thumbnail($post->ID);
//                if (!$already_has_thumb) {
//                    $attached_image = get_children("post_parent=$post->ID&post_type=attachment&post_mime_type=image&numberposts=1");
//                    if ($attached_image) {
//                        foreach ($attached_image as $attachment_id => $attachment) {
//                            set_post_thumbnail($post->ID, $attachment_id);
//                        }
//                    }
//                }
//            }
//        }
//    }
//
////end function
//}

//add_action('the_post', 'wpforce_featured');
//add_action('save_post', 'wpforce_featured');
//add_action('draft_to_publish', 'wpforce_featured');
//add_action('new_to_publish', 'wpforce_featured');
//add_action('pending_to_publish', 'wpforce_featured');
//add_action('future_to_publish', 'wpforce_featured');
function footer_widgets_init() {

	$widget_count = gt_get_option('widget_count',1);


	for($i = 1; $i <= $widget_count; $i++)
	{
		register_sidebar( array(
			'name'          => 'Footer '.$i,
			'id'            => 'footer'.$i,
			'before_widget' => '<div id="%1$s" class="%2$s widget-area">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4>',
			'after_title'   => '</h4>',
		) );
	}

}
add_action( 'widgets_init', 'footer_widgets_init' );

function footer_widgets_display(){
    $widget_count = gt_get_option('widget_count',1);
          switch($widget_count):
            case "1":
                $footercol = "col-md-12";
                break;
            case "2":
                $footercol = "col-md-6";
                break;
            case "3":
                $footercol = "col-md-4";
                break;
            case "4":
                $footercol = "col-md-3";
                break;
            case "5":
                $footercol = "col-md-2";
                break;            
        endswitch;
                    $widget_count = gt_get_option('widget_count', 1);

            for($i = 1; $i <= $widget_count; $i++)
            {   
                echo "<div class='" . $footercol . "'>";
                dynamic_sidebar('footer'.$i);   
                echo "</div>";
            } 
};
function grizzly_copyright(){
$copyright_text = gt_get_option('copyright_text','NA');
        if($copyright_text != "NA" ) {  
            $year = date("Y");
                    $copyright_text = str_replace("%year%", $year , $copyright_text);
                    echo $copyright_text;
                } 
                else{
                echo "Copyright &copy;'" . bloginfo('name') . the_date('Y') . "'";
                }
}
function grizzly_affiliation(){
                    echo '<p class="right">WordPress theme by <a href="http://grizzlybeardesign.co.uk/">Grizzly Bear Design</a></p>';

}
add_action('wp_ajax_import_grizzly_theme_settings', 'import_grizzly_theme_settings_callback');
function import_grizzly_theme_settings_callback(){
	$import = new Option_Import_And_Export();
	$import->import_grizzly_theme_settings_callback();
	die;
}
?>