<?php

class GT_CPT {

    private static $plugin_name = 'gt-cpt';
    private static $version = '1.0.0';
    private static $initiated = false;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public static function init() {

        if (!self::$initiated) {
            self::init_extras();
            self::init_hooks();
        }
    }

    public static function init_extras() {
        self::load_dependencies();
        self::define_admin_hooks();
        self::define_public_hooks();
    }

    /**
     * Initializes WordPress hooks
     */
    private static function init_hooks() {
        self::$initiated = true;

        add_action( 'init' , 'gt_cpt_create_post_types' );
        add_action('admin_menu', array('GT_CPT', 'gbd_hide_menu'));
    }

    public static function is_test_mode() {
        return defined('GT_CPT_TEST_MODE') && GT_CPT_TEST_MODE;
    }

//    public static function load_form_js() {
//        wp_register_script('gt-cpt-form', plugin_dir_url(__FILE__) . '_inc/form.js', array(), GT_CPT_VERSION, true);
//        wp_enqueue_script('gt-cpt-form');
//    }

    public static function view($name, array $args = array()) {
        $args = apply_filters('gt_cpt_view_arguments', $args, $name);

        foreach ($args AS $key => $val) {
            $$key = $val;
        }

        load_plugin_textdomain('gt-cpt');

        $file = GT_CPT__PLUGIN_DIR . 'views/' . $name . '.php';

        include( $file );
    }

    public static function plugin_activation() {
        if (version_compare($GLOBALS['wp_version'], GT_CPT__MINIMUM_WP_VERSION, '<')) {
            load_plugin_textdomain(
                    'gt_cpt', false, dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
            );

            $message = '<strong>' . sprintf(esc_html__('Grizzly Themes Custom Post Types %s requires WordPress %s or higher.', 'gt_cpt'), AGT_CPT_VERSION, GT_CPT__MINIMUM_WP_VERSION) . '</strong> ' . sprintf(__('Please <a href="%1$s">upgrade WordPress</a> to a current version.', 'gt_cpt'), 'https://codex.wordpress.org/Upgrading_WordPress', 'https://store.grizzlybeardesign.co.uk/download/');

            GT_CPT::bail_on_activation($message);
        }
    }

    /**
     * Removes all connection options
     * @static
     */
    public static function plugin_deactivation() {
        
    }

    /**
     * Log debugging info to the error log.
     *
     * Enabled when WP_DEBUG_LOG is enabled (and WP_DEBUG, since according to
     * core, "WP_DEBUG_DISPLAY and WP_DEBUG_LOG perform no function unless
     * WP_DEBUG is true), but can be disabled via the gt_cpt_debug_log filter.
     *
     * @param mixed $gt_cpt_debug The data to log.
     */
//    public static function log($gt_cpt_debug) {
//        if (apply_filters('gt_cpt_debug_log', defined('WP_DEBUG') && WP_DEBUG && defined('WP_DEBUG_LOG') && WP_DEBUG_LOG && defined('GT_CPT_DEBUG') && GT_CPT_DEBUG)) {
//            error_log(print_r(compact('gt_cpt_debug'), true));
//        }
//    }

    function gt_cpt_create_post_types() {
        $post_types = array(
            'Badges' => array(
                'rewrite' => array('slug' => 'badges'),
                'description' => __('Custom Badges', 'gbd_plugin'),
                'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
                'taxonomies' => array('category'),
                'hierarchical' => false,
                'public' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'menu_position' => 10,
                'menu_icon' => 'dashicons-awards',
                'show_in_admin_bar' => true,
                'show_in_nav_menus' => true,
                'can_export' => true,
                'has_archive' => true,
                'exclude_from_search' => false,
                'publicly_queryable' => true,
                'capability_type' => 'page',
            ),
            'Galleries' => array(
                'rewrite' => array('slug' => 'gallery'),
                'description' => 'Bookmarks',
                'supports' => array('title', 'thumbnail',),
                'menu_icon' => 'dashicons-awards',
                'hierarchical' => false,
                'public' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'menu_position' => 10,
                'show_in_admin_bar' => true,
                'show_in_nav_menus' => true,
                'can_export' => true,
                'has_archive' => true,
                'exclude_from_search' => false,
                'publicly_queryable' => true,
                'capability_type' => 'page',
            ),
            'Testimonials' => array(
                'rewrite' => array('slug' => 'testimonials'),
                'description' => 'Bookmarks',
                'supports' => array('title', 'thumbnail',),
                'menu_icon' => 'dashicons-awards',
                'hierarchical' => false,
                'public' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'menu_position' => 10,
                'show_in_admin_bar' => true,
                'show_in_nav_menus' => true,
                'can_export' => true,
                'has_archive' => true,
                'exclude_from_search' => false,
                'publicly_queryable' => true,
                'capability_type' => 'page',
            ),
        );
        foreach ($post_types as $title => $args) {
            gt_register_post_type($title, $args);
        }
    }

    /**
     * Registers a post type with default values which can be overridden as needed.
     *
     * @uses sanitize_title() WordPress function that formats text for use as a slug
     * @uses wp_parse_args() WordPress function that merges two arrays and parses the values to override defaults
     * @uses register_post_type() WordPress function for registering a new post type
     *
     * @param string $title title of the post type. This will be automatically converted for plural and slug use
     * @param array $args overrides the defaults
     * @param string $prefix prefix string
     */
    function gt_cpt_register_post_type($title, $args = array()) {
        $prefix = 'gt_';
        $sanitized_title = sanitize_title($title);
        $plural_title = isset($args['plural_title']) ? $args['plural_title'] : "";
        unset($args['plural_title']);

        $defaults = array(
            'labels' => gt_cpt_post_type_labels($title, $plural_title),
            '_builtin' => false,
            'description' => $title . __(' Custom Post Type', 'child-translate-domain'),
            'menu_position' => 6, // WP default: null (below comments ~ 25)
            'menu_icon' => "", // WP default: null
            'public' => true, // WP default: true
            'publicly_queryable' => true, // WP default: value of 'public'
            'show_ui' => true, // WP default: value of 'public'
            'show_in_nav_menus' => true, // WP default: value of 'public'
            'show_in_menu' => true, // WP default: null; 'show_ui' must be true
            'has_archive' => true, // WP default: false
            'capability_type' => 'post', // WP default: post; defines 'capabilities' as well
            'map_meta_cap' => false, // WP default: false
            'hierarchical' => false,
            'taxonomies' => array(),
            'rewrite' => array('slug' => $sanitized_title),
            'query_var' => true,
            'can_export' => true,
            'supports' => array('title', 'editor', 'excerpt', 'author', 'comments', 'custom-fields', 'revisions', 'thumbnail', 'genesis-seo', 'genesis-layouts', 'genesis-simple-sidebars'),
        );

        $args = wp_parse_args($args, $defaults);

// Correct show_in_menu arg
        if (false === $args['show_ui'] && true === $args['show_in_menu'])
            $args['show_in_menu'] = false;

        $post_type = isset($args['post_type']) ? $args['post_type'] : $prefix . str_replace('-', '_', $sanitized_title) . 's';

        register_post_type($post_type, $args);
    }

    /**
     * A helper function for generating localizable labels
     *
     * @author Travis Smith
     * @uses _x() WordPress function that retrieves translated string with gettext context
     * @uses __() WordPress function that retrieves the translated string from the translate()
     *
     * @param string $singular Singular Title/Label
     * @param string $plural Plural Title/Label (optional)
     */
    function gt_cpt_post_type_labels($singular, $plural = "") {
        if ($plural == "")
            $plural = $singular . 's';

        return array(
            'name' => _x($plural, 'post type general name', 'child-translate-domain'),
            'singular_name' => _x($singular, 'post type singular name', 'child-translate-domain'),
            'add_new' => __('Add New', 'child-translate-domain'),
            'add_new_item' => __('Add New ' . $singular, 'child-translate-domain'),
            'edit_item' => __('Edit ' . $singular, 'child-translate-domain'),
            'new_item' => __('New ' . $singular, 'child-translate-domain'),
            'view_item' => __('View ' . $singular, 'child-translate-domain'),
            'search_items' => __('Search ' . $plural, 'child-translate-domain'),
            'not_found' => __('No ' . $plural . ' found', 'child-translate-domain'),
            'not_found_in_trash' => __('No ' . $plural . ' found in Trash', 'child-translate-domain'),
            'parent_item_colon' => ""
        );
    }

    public function deregister_post_types() {
        unregister_post_type($post_type);
    }

    /*
     * CREATE CUSTOM POST TYPE FOR GALLERY
     * install on activating the plugin 
     */

    function pluginprefix_install() {
        gt_cpt_create_post_types();
        flush_rewrite_rules();
    }

    /*
     * REMOVE CREATED MENU
     */

    public static function gbd_hide_menu() {

        $options = get_option(self::get_plugin_name() . '-settings');

        if (!$options['badges']) {
            remove_menu_page('edit.php?post_type=gbd_badge');
        }
        if (!$options['gallery']) {
            remove_menu_page('edit.php?post_type=gbd_gallery');
        }
        if (!$options['testimonials']) {
            remove_menu_page('edit.php?post_type=gbd_testimonials');
        }
    }

    private static function load_dependencies() {

        require_once GT_CPT__PLUGIN_DIR . 'class-gt-cpt-admin.php';

    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    public static function define_admin_hooks() {

        $plugin_admin = new GT_CPT_Admin(self::get_plugin_name(), self::get_version());

        add_action('admin_menu', array ('GT_CPT_Admin', 'register_settings_page') );
        add_action('admin_init', array('GT_CPT_Admin', 'register_settings') );

        add_action('admin_enqueue_scripts', array('GT_CPT_Admin', 'gt_enqueue_styles') );
    }

    public static function define_public_hooks() {

        add_action('admin_menu', array ('GT_CPT_Admin', 'register_settings_page') );
        add_action('wp_enqueue_scripts', array('GT_CPT', 'gt_enqueue_styles') );
    }

    public static function get_plugin_name() {
        return self::$plugin_name;
    }

    public static function get_version() {
        return self::$version;
    }
    
    private static function bail_on_activation( $message, $deactivate = true ) {
?>
<!doctype html>
<html>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<style>
* {
	text-align: center;
	margin: 0;
	padding: 0;
	font-family: "Lucida Grande",Verdana,Arial,"Bitstream Vera Sans",sans-serif;
}
p {
	margin-top: 1em;
	font-size: 18px;
}
</style>
<body>
<p><?php echo esc_html( $message ); ?></p>
</body>
</html>
<?php
		if ( $deactivate ) {
			$plugins = get_option( 'active_plugins' );
			$gtcpt = plugin_basename( GT_CPT__PLUGIN_DIR . 'gt-custom-post-types.php' );
			$update  = false;
			foreach ( $plugins as $i => $plugin ) {
				if ( $plugin === $gtcpt ) {
					$plugins[$i] = false;
					$update = true;
				}
			}

			if ( $update ) {
				update_option( 'active_plugins', array_filter( $plugins ) );
			}
		}
		exit;
	}

}
