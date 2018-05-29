<?php
/**
 * Grizzly Base Theme clean up
 *
 * @package Grizzly_Base_Theme
 * @since Grizzly_Base_Theme 1.0
 * 
 */

/* * *******************
  Start all the functions
  at once for Grizzly Bear Base Theme.
 * ******************* */

// start all the functions
add_action('after_setup_theme', 'grizzlytheme_startup');

if (!function_exists('grizzlytheme_startup ')) {

    function grizzlytheme_startup() {

        // launching operation cleanup
        add_action('init', 'grizzlytheme_head_cleanup');
        // remove WP version from RSS
        add_filter('the_generator', 'grizzlytheme_rss_version');
        // remove pesky injected css for recent comments widget
        add_filter('wp_head', 'grizzlytheme_remove_wp_widget_recent_comments_style', 1);
        // clean up comment styles in the head
        add_action('wp_head', 'grizzlytheme_remove_recent_comments_style', 1);
        // clean up gallery output in wp
        add_filter('gallery_style', 'grizzlytheme_gallery_style');

        // enqueue base scripts and styles
        add_action('wp_enqueue_scripts', 'grizzlytheme_scripts_and_styles', 999);
        // ie conditional wrapper
        add_filter('style_loader_tag', 'grizzlytheme_ie_conditional', 10, 2);

        // additional post related cleaning
        add_filter('img_caption_shortcode', 'grizzlytheme_cleaner_caption', 10, 3);
        add_filter('get_image_tag_class', 'grizzlytheme_image_tag_class', 0, 4);
        add_filter('get_image_tag', 'grizzlytheme_image_editor', 0, 4);
        add_filter('the_content', 'grizzlytheme_img_unautop', 30);
    }

    /* end grizzlytheme_startup */
}


/* * ********************
  WP_HEAD GOODNESS
  The default WordPress head is
  a mess. Let's clean it up.

  Thanks for Bones
  http://themble.com/bones/
 * ******************** */

if (!function_exists('grizzlytheme_head_cleanup ')) {

    function grizzlytheme_head_cleanup() {
        // category feeds
        // remove_action( 'wp_head', 'feed_links_extra', 3 );
        // post and comment feeds
        // remove_action( 'wp_head', 'feed_links', 2 );
        // EditURI link
        remove_action('wp_head', 'rsd_link');
        // windows live writer
        remove_action('wp_head', 'wlwmanifest_link');
        // index link
        remove_action('wp_head', 'index_rel_link');
        // previous link
        remove_action('wp_head', 'parent_post_rel_link', 10, 0);
        // start link
        remove_action('wp_head', 'start_post_rel_link', 10, 0);
        // links for adjacent posts
        remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
        // WP version
        remove_action('wp_head', 'wp_generator');
        // remove WP version from css
        add_filter('style_loader_src', 'grizzlytheme_remove_wp_ver_css_js', 9999);
        // remove Wp version from scripts
        add_filter('script_loader_src', 'grizzlytheme_remove_wp_ver_css_js', 9999);
    }

    /* end head cleanup */
}

// remove WP version from RSS
if (!function_exists('grizzlytheme_rss_version ')) {
    function grizzlytheme_rss_version() {
        return '';
    }
}

// remove WP version from scripts
if (!function_exists('grizzlytheme_remove_wp_ver_css_js ')) {
    function grizzlytheme_remove_wp_ver_css_js($src) {
        if (strpos($src, 'ver='))
            $src = remove_query_arg('ver', $src);
        return $src;
    }
}

// remove injected CSS for recent comments widget
if (!function_exists('grizzlytheme_remove_wp_widget_recent_comments_style ')) {

    function grizzlytheme_remove_wp_widget_recent_comments_style() {
        if (has_filter('wp_head', 'wp_widget_recent_comments_style')) {
            remove_filter('wp_head', 'wp_widget_recent_comments_style');
        }
    }

}

// remove injected CSS from recent comments widget
if (!function_exists('grizzlytheme_remove_recent_comments_style ')) {

    function grizzlytheme_remove_recent_comments_style() {
        global $wp_widget_factory;
        if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
            remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
        }
    }

}

// remove injected CSS from gallery
if (!function_exists('grizzlytheme_gallery_style ')) {
    function grizzlytheme_gallery_style($css) {
        return preg_replace("!<style type='text/css'>(.*?)</style>!s", '', $css);
    }
}

/* * ********************
  Enqueue CSS and Scripts
 * ******************** */

// loading modernizr and jquery, and reply script
if (!function_exists('grizzlytheme_scripts_and_styles ')) {

    function grizzlytheme_scripts_and_styles() {
        if (!is_admin()) {

            // modernizr (without media query polyfill)
            wp_enqueue_script('modernizr', get_template_directory_uri() . '/js/modernizr.js', array(), '2.6.2', false);
          
            // ie-only style sheet
            wp_register_style('ie-only', get_template_directory_uri() . '/css/ie.css', array(), '');

            // comment reply script for threaded comments
        	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

            // adding Foundation scripts file in the footer
            wp_register_script('grizzlytheme-js', get_template_directory_uri() . '/js/foundation.min.js', array('jquery'), '', true);

            global $is_IE;
            if ($is_IE) {
                wp_register_script('html5shiv', "http://html5shiv.googlecode.com/svn/trunk/html5.js", false, true);
            }

            // enqueue styles and scripts

            wp_enqueue_style('ie-only');
            /*
              I recommend using a plugin to call jQuery
              using the google cdn. That way it stays cached
              and your site will load faster.
             */

            wp_enqueue_script('grizzlytheme-js');
            wp_enqueue_script('html5shiv');
        }
    }

}

// adding the conditional wrapper around ie stylesheet
// source: http://code.garyjones.co.uk/ie-conditional-style-sheets-wordpress/
if (!function_exists('grizzlytheme_ie_conditional ')) {

    function grizzlytheme_ie_conditional($tag, $handle) {
        if ('ie-only' == $handle)
            $tag = '<!--[if lt IE 9]>' . "\n" . $tag . '<![endif]-->' . "\n";
        return $tag;
    }

}

/* * *******************
  Post related cleaning
 * ******************* */
/* Customized the output of caption, you can remove the filter to restore back to the WP default output. Courtesy of DevPress. http://devpress.com/blog/captions-in-wordpress/ */
if (!function_exists('grizzlytheme_cleaner_caption ')) {
    function grizzlytheme_cleaner_caption($output, $attr, $content) {
        /* We're not worried abut captions in feeds, so just return the output here. */
        if (is_feed())
            return $output;

        /* Set up the default arguments. */
        $defaults = array(
            'id' => '',
            'align' => 'alignnone',
            'width' => '',
            'caption' => ''
        );

        /* Merge the defaults with user input. */
        $attr = shortcode_atts($defaults, $attr);

        /* If the width is less than 1 or there is no caption, return the content wrapped between the [caption]< tags. */
        if (1 > $attr['width'] || empty($attr['caption']))
            return $content;

        /* Set up the attributes for the caption <div>. */
        $attributes = ' class="figure ' . esc_attr($attr['align']) . '"';

        /* Open the caption <div>. */
        $output = '<figure' . $attributes . '>';

        /* Allow shortcodes for the content the caption was created for. */
        $output .= do_shortcode($content);

        /* Append the caption text. */
        $output .= '<figcaption>' . $attr['caption'] . '</figcaption>';

        /* Close the caption </div>. */
        $output .= '</figure>';

        /* Return the formatted, clean caption. */
        return $output;
    }

    /* end grizzlytheme_cleaner_caption */
}

// Clean the output of attributes of images in editor. Courtesy of SitePoint. http://www.sitepoint.com/wordpress-change-img-tag-html/
if (!function_exists('grizzlytheme_image_tag_class ')) {

    function grizzlytheme_image_tag_class($class, $id, $align, $size) {
        $align = 'align' . esc_attr($align);
        return $align;
    }

    /* end grizzlytheme_image_tag_class */
}

// Remove width and height in editor, for a better responsive world.
if (!function_exists('grizzlytheme_image_editor ')) {

    function grizzlytheme_image_editor($html, $id, $alt, $title) {
        return preg_replace(array(
            '/\s+width="\d+"/i',
            '/\s+height="\d+"/i',
            '/alt=""/i'
                ), array(
            '',
            '',
            '',
            'alt="' . $title . '"'
                ), $html);
    }

    /* end grizzlytheme_image_editor */
}

// Wrap images with figure tag. Courtesy of Interconnectit http://interconnectit.com/2175/how-to-remove-p-tags-from-images-in-wordpress/
if (!function_exists('grizzlytheme_img_unautop ')) {

    function grizzlytheme_img_unautop($pee) {
        $pee = preg_replace('/<p>\\s*?(<a .*?><img.*?><\\/a>|<img.*?>)?\\s*<\\/p>/s', '<figure>$1</figure>', $pee);
        return $pee;
    }

    /* end grizzlytheme_img_unautop */
}
if (!function_exists('append_editor_css')) {
    function append_editor_css($wp) {
        $wp .= ',' . get_bloginfo('template_directory') . '/style-editor.css';
        return $wp;
    }
}

add_filter('mce_css', 'append_editor_css');
// Change excerpt to say "Read More>"
//function new_excerpt_more($more) {
//    return ' <a class="read-more" href="' . get_permalink(get_the_ID()) . '">' . __('Read More>', 'your-text-domain') . '</a>';
//}
// add_filter('excerpt_more', 'new_excerpt_more');
	// sanitize the file names that contain non ascii characters
  	function grizzlytheme_sanitize_filename_on_upload($filename) {
  		$filename_exploded = explode('.',$filename);
		$ext = end($filename_exploded);
		// Replace all weird characters
		$sanitized = preg_replace('/[^a-zA-Z0-9-_.]/','_', substr($filename, 0, -(strlen($ext)+1)));
		// Replace dots inside filename
		$sanitized = str_replace('.','-', $sanitized);
		return strtolower($sanitized.'.'.$ext);
	}

	add_filter('sanitize_file_name', 'grizzlytheme_sanitize_filename_on_upload', 10);  
?>