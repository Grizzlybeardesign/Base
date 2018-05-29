<?php
/**
 * Grizzly Base Theme functions and definitions
 *
 * @package Grizzly_Base_Theme
 * @since Grizzly_Base_Theme 1.0
 * 
 */
error_reporting(1);

define('OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/lib/inc/');
define('THEME_DIRECTORY', get_template_directory_uri());



require_once dirname(__FILE__) . '/lib/inc/options-framework.php';
require_once dirname(__FILE__) . '/lib/inc/functions/custom-functions.php';
require_once dirname(__FILE__) . '/lib/inc/functions/plugin-recommendations.php';

$optionsfile = locate_template('lib/inc/options.php');
load_template($optionsfile);

require_once('lib/theme-updater.php');

/* * ********************
  Clean WordPress Additionals
 * ******************** */

require_once('lib/clean.php');


/* * ********************
  Enqueue CSS Stylesheets
 * ******************** */

require_once('lib/enqueue-style.php');

/* * ********************
  Enquire Javascript Scripts
 * ******************** */

require_once('lib/enqueue-scripts.php');

/* * ********************
  Custom Post Types
 * ******************** */

require_once('lib/custom-post-types.php');

/* * ********************
  Simple Custom Post Types Order
 * ******************** */
include_once('lib/simple-custom-post-order/simple-custom-post-order.php');

/* * ********************
  Pagination
 * ******************** */

require_once('lib/pagination.php');

/* * ********************
  Entry Meta
 * ******************** */

require_once('lib/entry-meta.php');

/* * ********************
  Custom Widget Areas
 * ******************** */

require_once('lib/widget-areas.php');

/* * ********************
  Navigation
 * ******************** */

require_once('lib/nav.php');
require_once('lib/navigation.php');
require_once('lib/custom-nav.php');

/* * ********************
  Simple HTML DOM
 * ******************** */

require_once('lib/simple_html_dom.php');



// Drag and drop interface for post types
include_once('lib/simple-custom-post-order/simple-custom-post-order.php');

/**
 * Customizer additions.
 */
require get_template_directory() . '/lib/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
    require get_template_directory() . '/lib/inc/jetpack.php';
}

/* * ********************
  Custom Widget Areas
 * ******************** */

require_once('lib/theme-support.php');

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function grizzlytheme_body_classes($classes) {
    // Adds a class of hfeed to non-singular pages.
    $classes[] = "antialiased";
    if (gt_get_option('site_full_width') == 'yes') {
        $classes[] = "full-width";
    }
    if (!is_singular()) {
        $classes[] = 'hfeed';
    }

    return $classes;
}

add_filter('body_class', 'grizzlytheme_body_classes');

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function grizzlytheme_pingback_header() {
    if (is_singular() && pings_open()) {
        echo '<link rel="pingback" href="', esc_url(get_bloginfo('pingback_url')), '">';
    }
}

add_action('wp_head', 'grizzlytheme_pingback_header');

// create widget areas: sidebar, footer
// return entry meta information for posts, used by multiple loops, you can override this function by defining them first in your child theme's functions.php file
if (!function_exists('grizzlytheme_entry_meta')) {

    function grizzlytheme_entry_meta() {
        echo '<time class="updated" datetime="' . get_the_time('c') . '" pubdate>' . get_the_time('jS M Y') . '</time>';
    }

};

function grizzlytheme_isotope_pagination($galleries) {
    if ($galleries->max_num_pages > 1) :
        ?>
        <nav id="portfolio-nav" class="navigation" role="navigation">
            <?php previous_posts_link('â‰ª Previous', $galleries->max_num_pages); ?>
            <?php next_posts_link('More â‰«', $galleries->max_num_pages); ?>
        </nav><!-- #page-nav .navigation -->
        <?php
    endif;
}

add_filter('gform_submit_button', 'form_submit_button', 10, 2);

function form_submit_button($button, $form) {
    return "<div class='button-wrapper'><button class='button' id='gform_submit_button_{$form['id']}'><span>Send</span></button></div>";
}


function gt_filter_wp_title($title) {
    $blog_page_title = gt_get_option('blog_page_title', 'Welcome to the blog');
    $category_page_title = gt_get_option('category_page_title');
    $tags_page_title = gt_get_option('tags_page_title');
    $author_page_title = gt_get_option('author_page_title');
    $search_page_title = gt_get_option('search_page_title');
    $daily_archive_page_title = gt_get_option('daily_archive_page_title');
    $monthly_archive_page_title = gt_get_option('monthly_archive_page_title');
    $yearly_archive_page_title = gt_get_option('yearly_archive_page_title');
    $gallery_page_title = gt_get_option('gallery_page_title');
    $other_custom_post_type_archive_page_title = gt_get_option('other_custom_post_type_archive_page_title');
    $other_archives_page_title = gt_get_option('other_archives_page_title');

    if (is_home() && $blog_page_title) {
        // Blog Page
        return $blog_page_title;
    } else if (is_category() && $category_page_title) {
        // Category Page
        $category = get_the_category();
        $category_page_title = str_replace("%", $category[0]->name, $category_page_title);
        return $category_page_title;
    } else if (is_tag() && $tags_page_title) {
        // Tags Page
        $replace = single_tag_title("", false);
        $tags_page_title = str_replace("%", $replace, $tags_page_title);
        return $tags_page_title;
    } else if (is_author() && $author_page_title) {
        // Author Page
        $replace = get_the_author();
        $author_page_title = str_replace("%", $replace, $author_page_title);
        return $author_page_title;
    } else if (is_search() && $search_page_title) {
        // Search Page
        $replace = get_search_query();
        $search_page_title = str_replace("%", $replace, $search_page_title);
        return $search_page_title;
    } else if (is_day() && $daily_archive_page_title) {
        // Day Page
        $replace = get_the_time('F j, Y');
        $daily_archive_page_title = str_replace("%", $replace, $daily_archive_page_title);
        return $daily_archive_page_title;
    } else if (is_month() && $monthly_archive_page_title) {
        // Month Page
        $replace = get_the_time('F Y');
        $monthly_archive_page_title = str_replace("%", $replace, $monthly_archive_page_title);
        return $monthly_archive_page_title;
    } else if (is_year() && $yearly_archive_page_title) {
        // Year Page
        $replace = get_the_time('Y');
        $yearly_archive_page_title = str_replace("%", $replace, $yearly_archive_page_title);
        return $yearly_archive_page_title;
    } else if (is_post_type_archive()) {
        $postType = get_queried_object();
        $other_custom_post_type_archive_page_title = str_replace("%", $postType->labels->singular_name, $other_custom_post_type_archive_page_title);
        return $other_custom_post_type_archive_page_title;
    } else if (is_archive()) {
        return $other_archives_page_title;
    } else if (is_singular('gallery') && $gallery_page_title) {
        // Gallery Page
        return $gallery_page_title;
    }
    return $title;
}

add_filter('wp_title', 'gt_filter_wp_title');

function typo($typo, $tag) {
    $str = "";

    if (is_array($typo)) {
        foreach ($typo as $key => $tp) {
            $typo[$key] = trim($tp);
        }
        if (isset($typo['background']) && strlen($typo['background'])) {
            $str .= "background :" . $typo['background'] . ";";
        }
        if (isset($typo['color']) && strlen($typo['color'])) {
            $str .= "color :" . $typo['color'] . ";";
        }
        if (isset($typo['face']) && strlen($typo['face'])) {
            $str .= "font-family :" . $typo['face'] . ";";
        }
        if (isset($typo['size']) && strlen($typo['size'])) {
            $str .= "font-size :" . $typo['size'] . ";";
        }
        if (isset($typo['style']) && strlen($typo['style'])) {
            $str .= "font-style :" . $typo['style'] . ";";
        }
        if (isset($typo['border-bottom-color']) && strlen($typo['border-bottom-color'])) {
            $str .= "border-bottom-color :" . $typo['border-bottom-color'] . ";";
        }
    }

    if (strlen($str)) {
        return $tag . "{" . $str . "}";
    } else {
        return $str;
    }
}

add_action('wp_head', function () {

    $body_text = gt_get_option('typography_body_text');
    $background_image = gt_get_option('background_image');
    $background_color = gt_get_option('background_color');
    $background_pattern = gt_get_option('background_pattern');

    $background = "";

    if (!empty($background_color)) {
        $background = $background_color . " ";
    }
    if (!empty($background_image)) {
        $background .= "url(" . $background_image . ")";
    } else if (!empty($background_pattern)) {
        $background .= "url(" . $background_pattern . ") repeat";
    }



    $h1_text = gt_get_option('typography_h1');
    $h2_text = gt_get_option('typography_h2');
    $h3_text = gt_get_option('typography_h3');
    $h4_text = gt_get_option('typography_h4');
    $h5_text = gt_get_option('typography_h5');
    $h6_text = gt_get_option('typography_h6');

    $buttons_background_color = gt_get_option('buttons_background_color');
    $buttons_text_color = gt_get_option('buttons_text_color', '#FFFFFF');
    $buttons_background_hover_color = gt_get_option('buttons_background_hover_color');
    $buttons_text_hover_color = gt_get_option('buttons_text_hover_color', '#FFFFFF');
    $menu_links_color = gt_get_option('menu_links_color', '#FFFFFF');
    $main_menu_link_hover_color = gt_get_option('main_menu_link_hover_color', '#FFFFFF');
    $main_menu_link_active_color = gt_get_option('main_menu_link_active_color');
    $main_menu_link_bg_active_color = gt_get_option('main_menu_link_bg_active_color');
    $menu_bg_color = gt_get_option('menu_bg_color');
    $sub_menu_link_color = gt_get_option('sub_menu_link_color');
    $sub_menu_bg_color = gt_get_option('sub_menu_bg_color');
    $sub_menu_link_hover_color = gt_get_option('sub_menu_link_hover_color');
    $footer_bg_color = gt_get_option('footer_bg_color');
    $footer_widget_title_color = gt_get_option('footer_widget_title_color');
    $footer_text_color = gt_get_option('footer_text_color');
    $footer_link_hover_color = gt_get_option('footer_link_hover_color');
    $footer_copyright_bg_color = gt_get_option('footer_copyright_bg_color');
    $links_color = gt_get_option('links_color');
    $links_hover_color = gt_get_option('links_hover_color');
    $preloader_color = gt_get_option('preloader_color');
    $preloader_bg_color = gt_get_option('preloader_bg_color', '#FFFFFF');

    $slides_navigation_arrows_color = gt_get_option('slides_navigation_arrows_color');

    $style = "<style>";

    $style .= typo($body_text, "body");
    $style .= typo($h1_text, "h1");
    $style .= typo($h2_text, "h2");
    $style .= typo($h3_text, "h3");
    $style .= typo($h4_text, "h4");
    $style .= typo($h5_text, "h5");
    $style .= typo($h6_text, "h6");

    $style .= typo(array('background' => $background), 'body');

    $style .= typo(array('background' => $buttons_background_color, 'color' => $buttons_text_color), '.button-2');


    $style .= typo(array('background' => $buttons_background_hover_color, 'color' => $buttons_text_hover_color), '.button-2:hover');





    $style .= typo(array('color' => $menu_links_color, 'background' => $menu_bg_color), 'header#header #primary-navigation .menu-main-menu-container ul li a, header#header #primary-navigation .left-main-menu-container ul li a, header#header #primary-navigation .right-main-menu-container ul li a');

    $style .= typo(array('color' => $main_menu_link_hover_color), 'header#header #primary-navigation .menu-main-menu-container ul li a:hover, header#header #primary-navigation .left-main-menu-container ul li a:hover, 
    header#header #primary-navigation .right-main-menu-container ul li a:hover');

    $style .= typo(array('color' => $main_menu_link_active_color, 'background' => $main_menu_link_bg_active_color), 'header#header #primary-navigation .menu-main-menu-container ul li.active a, header#header #primary-navigation .left-main-menu-container ul li.active a, header#header #primary-navigation .right-main-menu-container ul li.active a');

    $style .= typo(array('color' => $main_menu_link_hover_color), '.top-bar-menu>li>a:hover');

    $style .= typo(array('color' => $sub_menu_link_color, 'background' => $sub_menu_bg_color), 'header#header #primary-navigation ul#menu-top-navigation>li>ul,header#header #primary-navigation ul#menu-top-navigation>li>ul>li>a');

    $style .= typo(array('color' => $sub_menu_link_hover_color), 'header#header #primary-navigation ul#menu-top-navigation>li>ul>li>a:hover');

    $style .= typo(array('color' => $footer_text_color), '#footer *');

    $style .= typo(array('background' => $footer_bg_color), '#footer');
#copyright
    $style .= typo(array('color' => $footer_link_hover_color), '#footer a:hover');

    $style .= typo(array('color' => $footer_widget_title_color), '#footer .footer_widget_title');

    $style .= typo(array('background' => $footer_copyright_bg_color), '#copyright');


    $style .= typo(array('color' => $links_color), 'a');

    $style .= typo(array('color' => $links_hover_color), 'a:hover');

    $style .= typo(array('color' => $slides_navigation_arrows_color), '.slider .nav');
    //echo "AAA".$preloader_color;
    $style .= typo(array('background' => $preloader_bg_color), '.pace .pace-progress');

    $style .= typo(array('border-bottom-color' => $preloader_color), '.pace');

    $style .= "</style>";

    echo $style;

    $hover_effect = gt_get_option('image_hover_effects');

    $script = "<script>";

    $script .= " hover_effect = '$hover_effect'; ";

    $script .= "</script>";

    echo $script;
});


add_image_size('portfolio-thumbnail', 360, 240, true);

function format_wp_content($content) {

    if (strlen(trim($content))) {

        $array = explode("\n", $content);

        $page_content = array();

        $i = 0;

        $page_content[$i] = "";

        foreach ($array as $each_line) {
            $content = str_get_html($each_line);
            /*
              Is Image
             */
            $image_node = $content->find('img', 0);
            $attrs = $image_node->attr;


            $link_node = $content->find('a', 0);

            $link_attr = $link_node->attr;
            $link_text = $link_node->innertext;

            if (is_array($attrs)) {

                if (strlen(trim($page_content[$i]))) {
                    $page_content[$i] .= "</p>";
                    $i++;
                }


                $img = "<img ";

                foreach ($attrs as $attr => $value) {
                    $img .= $attr . "='" . $value . "' ";
                }

                $img .= " />";

                $page_content[$i] = $img;

                $i++;

                $page_content[$i] = "";
            } else if (is_array($link_attr)) {

                if (strlen(trim($page_content[$i]))) {
                    $page_content[$i] .= "</p>";
                }


                $link_html = "<p><a class='button' ";
                foreach ($link_attr as $attr => $value) {
                    $link_html .= $attr . "='" . $value . "' ";
                }

                $link_html .= " >";

                $link_html .= $link_text;

                $link_html .= "</a></p>";

                $page_content[$i] .= $link_html;
            } else {

                $head_text = $content->find('h1,h2,h3,h4,h5,h6', 0);

                //var_dump($head_text);

                if ($head_text->attr['class'] == "blank") {
                    if (strlen(trim($page_content[$i]))) {
                        $page_content[$i] .= "</p>";
                        $i++;
                    }

                    $page_content[$i] = 'blank';

                    $i++;

                    $page_content[$i] = "";
                } else if ($head_text) {

                    if (strlen(trim($page_content[$i]))) {
                        $page_content[$i] .= "</p>";
                    }

                    $page_content[$i] .= $each_line;

                    $page_content[$i] .= "<p>";
                } else {
                    if (!strlen(trim($page_content[$i]))) {
                        $page_content[$i] .= "<p>";
                    }

                    $page_content[$i] .= $each_line;
                }
            }
        }

        $html = "<div class='row'>";
        foreach ($page_content as $key => $content_block) {
            if ($content_block != "blank") {
                $html .= "<div class='col-md-6'>";
                $html .= $content_block;
                $html .= "</div>";
            } else {
                $html .= "<div class='col-md-6'></div>";
            }
            if (($key + 1) % 2 == 0) {
                $html .= "</div>";
                if (isset($page_content[$key + 1])) {
                    $html .= "<div class='row'>";
                }
            }
        }
        $html .= "</div>";
        echo $html;
    }
}

function add_custombutton_plugin($plugin_array) {
    $plugin_array['custom_button'] = get_template_directory_uri() . '/js/custom.js'; // CHANGE THE BUTTON SCRIPT HERE
    return $plugin_array;
}

add_filter("mce_external_plugins", "add_custombutton_plugin");

function myplugin_tinymce_buttons($buttons) {
    array_push($buttons, "custom_button");
    return $buttons;
}

add_filter('mce_buttons', 'myplugin_tinymce_buttons');

function create_grizzlytheme_menu() {
    /*
      For adding menu
     */
    // Check if the menu exists
    $menu_name = 'Grizzlybear Menu';
    $menu_exists = wp_get_nav_menu_object($menu_name);

    // If it doesn't exist, let's create it.
    if (!$menu_exists) {

        $menu_id = wp_create_nav_menu($menu_name);

        // Set up default menu items
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => __('Home'),
            'menu-item-url' => home_url('/'),
            'menu-item-status' => 'publish'));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => __('About'),
            'menu-item-url' => home_url('/about/'),
            'menu-item-status' => 'publish'));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => __('Gallery'),
            'menu-item-url' => home_url('/gallery/'),
            'menu-item-status' => 'publish'));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => __('Blog'),
            'menu-item-url' => home_url('/blog/'),
            'menu-item-status' => 'publish'));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => __('Contact'),
            'menu-item-url' => home_url('/contact/'),
            'menu-item-status' => 'publish'));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => __('Press'),
            'menu-item-url' => home_url('/press/'),
            'menu-item-status' => 'publish'));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => __('Testimonials'),
            'menu-item-url' => home_url('/testimonials/'),
            'menu-item-status' => 'publish'));

        $locations['top-bar'] = $menu_id;
        set_theme_mod('nav_menu_locations', $locations);
    }
}

add_action("after_switch_theme", "create_grizzlytheme_menu");

function gallery_column_layout() {

    $gallery_layout = gt_get_option('layout');
    if ($gallery_layout == 'gallery_style_1') {
        return "col-md-6";
    } else if ($gallery_layout == 'gallery_style_2') {
        return "col-md-4";
    } else if ($gallery_layout == 'gallery_style_3') {
        return "col-md-3";
    }
}

define('GALLERY_PER_PAGE', 4);

function posts_per_page($query) {
    if ($query->query_vars['post_type'] == 'gallery')
        $query->query_vars['posts_per_page'] = GALLERY_PER_PAGE;
    return $query;
}

if (!is_admin())
    add_filter('pre_get_posts', 'posts_per_page');

/* function grizzly_gallery_metabox_generate(){

  $post_ID = get_the_ID();
  $post_meta = get_post_meta($post_ID, 'gallery_post_id', true);
  $select = "<select name='gallery_post_id' class='form-control'>";
  global $wpdb;
  $results = $wpdb->get_results("SELECT ID,post_title FROM wp_posts WHERE post_type = 'gallery' ");

  foreach ($results as $key => $result) {
  $id = $result->ID;
  $title = $result->post_title;

  $selected = "";

  if( $post_meta == $id )
  {
  $selected = 'selected';
  }

  $select .= '<option value="'.$id .'" '.$selected.' >';
  $select .= $title;
  $select .= '</option>';
  }

  $select .= '</select>';

  $select .= '<input type="hidden" name="gallery_post_id_hidden" value="'.$post_meta.'" />';

  echo $select;
  } */



//add_meta_box('grizzly_gallery_metabox', 'Gallery', 'grizzly_gallery_metabox_generate');



/* function wpdocs_register_meta_boxes() {
  add_meta_box( 'grizzly_gallery_metabox', __( 'Gallery', 'gallery' ), 'grizzly_gallery_metabox_generate', 'page' );
  } */


//add_action( 'add_meta_boxes', 'wpdocs_register_meta_boxes' );

add_action('save_post', 'grizzlytheme_page_saved', 15, 3);

function grizzlytheme_page_saved($post_ID, $post, $update) {
    if (wp_is_post_revision($post_ID))
        return;
    // - Update the post's metadata.
    //echo $post_ID;
    $post_meta = get_post_meta($post_ID, 'gallery_post_id');
    $sanitize = sanitize_text_field($_POST['gallery_post_id_hidden']);
    if (strlen($sanitize)) {
        if ($post_meta) {
            update_post_meta((int) $post_ID, 'gallery_post_id', $sanitize);
        } else {
            add_post_meta($post_ID, 'gallery_post_id', $sanitize);
        }
    }
}

add_action('admin_print_styles-post.php', 'grizzlytheme_add_styles_and_scripts');
add_action('admin_print_styles-post-new.php', 'grizzlytheme_add_styles_and_scripts');

function grizzlytheme_add_styles_and_scripts() {
    wp_enqueue_script('grizzlytheme_gallery_metabox', get_template_directory_uri() . '/js/meta-box.js');
}

add_filter('sidebars_widgets', 'grizzlytheme_sidebars_widgets');

function grizzlytheme_sidebars_widgets($sidebars_widgets) {
    if (is_page()) {
        $widget_count = gt_get_option('widget_count');
        $i = 0;
        foreach ($sidebars_widgets['footer'] as $i => $widget) {
            if ($i > ($widget_count - 1)) {
                unset($sidebars_widgets['footer'][$i]);
            }
            $i++;
        }
    }
    return $sidebars_widgets;
}
