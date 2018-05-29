<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://grizzlybeardesign.co.uk/
 * @since      1.0.0
 *
 * @package    GT_CPT
 * @subpackage GT_CPT/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    GT_CPT
 * @subpackage GT_CPT/admin
 * @author     Grizzly Bear Design <studio@grizzlybeardesign.co.uk>
 */
class GT_CPT_Admin {

    private static $initiated = false;

    public static function init() {
        if (!self::$initiated) {
            self::init_hooks();
        }
    }

    public static function init_hooks() {

        self::$initiated = true;

        add_action('admin_init', array('GT_CPT_Admin', 'admin_init'));
        add_action('admin_menu', array('GT_CPT_Admin', 'admin_menu'), 5); # Priority 5, so it's called before Jetpack's admin_menu.
        add_action('admin_notices', array('GT_CPT_Admin', 'display_notice'));
        add_action('admin_enqueue_scripts', array('GT_CPT_Admin', 'gt_enqueue_styles'));

//        add_filter('plugin_action_links', array('GT_CPT_Admin', 'plugin_action_links'), 10, 3);
//
//        add_filter('plugin_action_links_' . plugin_basename(plugin_dir_path(__FILE__) . 'gt-custom-post-types.php'), array('GT_CPT_Admin', 'admin_plugin_settings_link'));

        add_filter('all_plugins', array('GT_CPT_Admin', 'modify_plugin_description'));
    }

    public static function admin_init() {
        load_plugin_textdomain('gt-cpt');
    }

    public static function admin_menu() {
        self::register_settings_page();
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public static function gt_enqueue_styles() {

        wp_enqueue_style(GT_CPT::get_plugin_name(), plugin_dir_url(__FILE__) . 'css/gt-cpt-admin.css', array(), GT_CPT::get_version(), 'all');
    }

    public static function register_settings_page() {
        // Create our settings page as a submenu page.
        add_submenu_page(
                'options-general.php', // parent slug
                __('Grizzly Themes Plugin ', 'gt-cpt'), // page title
                __('GT Settings', 'gt-cpt'), // menu title
                'manage_options', // capability
                'gt-cpt', // menu_slug
                array('GT_CPT_Admin', 'display_settings_page')  // callable function
        );
    }

    public static function display_page() {
        self::display_start_page();
    }

    public static function display_settings_page() {

        GT_CPT::view( 'start' );
    }

    public static function register_settings() {

        // Here we are going to register our setting.
        register_setting(
                GT_CPT::get_plugin_name() . '-settings', GT_CPT::get_plugin_name() . '-settings', array('GT_CPT_Admin', 'sandbox_register_setting')
        );

        // Here we are going to add a section for our setting.
        add_settings_section(
                GT_CPT::get_plugin_name() . '-settings-section', __('Add Custom Post Types', 'gbd-cust'), array('GT_CPT_Admin', 'sandbox_add_settings_section'), GT_CPT::get_plugin_name() . '-settings'
        );

        // Here we are going to add fields to our section.
        add_settings_field(
                'testimonials', __('Testimonials', 'gt-cpt'), array('GT_CPT_Admin', 'sandbox_add_settings_field_single_checkbox'), GT_CPT::get_plugin_name() . '-settings', GT_CPT::get_plugin_name() . '-settings-section', array(
            'label_for' => 'testimonials',
            'description' => __('Check to activate Testimonials. ', 'gbd-cust')
                )
        );

        add_settings_field(
                'gallery', __('Gallery', 'gt-cpt'), array('GT_CPT_Admin', 'sandbox_add_settings_field_single_checkbox'), GT_CPT::get_plugin_name() . '-settings', GT_CPT::get_plugin_name() . '-settings-section', array(
            'label_for' => 'gallery',
            'description' => __('Check to activate Gallery. ', 'gt-cpt')
                )
        );

        add_settings_field(
                'badges', __('Badges', 'gt-cpt'), array('GT_CPT_Admin', 'sandbox_add_settings_field_single_checkbox'), GT_CPT::get_plugin_name() . '-settings', GT_CPT::get_plugin_name() . '-settings-section', array(
            'label_for' => 'badges',
            'description' => __('Check to activate Badges. ', 'gt-cpt')
                )
        );
    }

    /**
     * Sandbox our settings.
     *
     * @since    1.0.0
     */
    public static function sandbox_register_setting($input) {

        $new_input = array();

        if (isset($input)) {
            // Loop trough each input and sanitize the value if the input id isn't post-types
            foreach ($input as $key => $value) {
                if ($key == 'post-types') {
                    $new_input[$key] = $value;
                } else {
                    $new_input[$key] = sanitize_text_field($value);
                }
            }
        }

        return $new_input;
    }

    /**
     * Sandbox our section for the settings.
     *
     * @since    1.0.0
     */
    public function sandbox_add_settings_section() {

        return;
    }

    /**
     * Sandbox our single checkboxes.
     *
     * @since    1.0.0
     */
    public function sandbox_add_settings_field_single_checkbox($args) {

        $field_id = $args['label_for'];
        $field_description = $args['description'];

        $options = get_option(GT_CPT::get_plugin_name() . '-settings');
        $option = 0;

        if (!empty($options[$field_id])) {

            $option = $options[$field_id];
        }
        ?>

        <label for="<?php echo GT_CPT::get_plugin_name() . '-settings[' . $field_id . ']'; ?>">
            <input type="checkbox" name="<?php echo GT_CPT::get_plugin_name() . '-settings[' . $field_id . ']'; ?>" id="<?php echo GT_CPT::get_plugin_name() . '-settings[' . $field_id . ']'; ?>" <?php checked($option, true, 1); ?> value="1" />
            <span class="description"><?php echo esc_html($field_description); ?></span>
        </label>

        <?php
    }

    /**
     * Sandbox our multiple checkboxes
     *
     * @since    1.0.0
     */
    public function sandbox_add_settings_field_multiple_checkbox($args) {

        $field_id = $args['label_for'];
        $field_description = $args['description'];

        $options = get_option(GT_CPT::get_plugin_name() . '-settings');
        $option = array();

        if (!empty($options[$field_id])) {
            $option = $options[$field_id];
        }

        if ($field_id == 'post-types') {

            $args = array(
                'public' => true
            );
            $post_types = get_post_types($args, 'objects');

            foreach ($post_types as $post_type) {

                if ($post_type->name != 'attachment') {

                    if (in_array($post_type->name, $option)) {
                        $checked = 'checked="checked"';
                    } else {
                        $checked = '';
                    }
                    ?>

                    <fieldset>
                        <label for="<?php echo GT_CPT::get_plugin_name() . '-settings[' . $field_id . '][' . $post_type->name . ']'; ?>">
                            <input type="checkbox" name="<?php echo GT_CPT::get_plugin_name() . '-settings[' . $field_id . '][]'; ?>" id="<?php echo GT_CPT::get_plugin_name() . '-settings[' . $field_id . '][' . $post_type->name . ']'; ?>" value="<?php echo esc_attr($post_type->name); ?>" <?php echo $checked; ?> />
                            <span class="description"><?php echo esc_html($post_type->label); ?></span>
                        </label>
                    </fieldset>

                    <?php
                }
            }
        } else {

            $field_args = $args['options'];

            foreach ($field_args as $field_arg_key => $field_arg_value) {

                if (in_array($field_arg_key, $option)) {
                    $checked = 'checked="checked"';
                } else {
                    $checked = '';
                }
                ?>

                <fieldset>
                    <label for="<?php echo GT_CPT::get_plugin_name() . '-settings[' . $field_id . '][' . $field_arg_key . ']'; ?>">
                        <input type="checkbox" name="<?php echo GT_CPT::get_plugin_name() . '-settings[' . $field_id . '][]'; ?>" id="<?php echo GT_CPT::get_plugin_name() . '-settings[' . $field_id . '][' . $field_arg_key . ']'; ?>" value="<?php echo esc_attr($field_arg_key); ?>" <?php echo $checked; ?> />
                        <span class="description"><?php echo esc_html($field_arg_value); ?></span>
                    </label>
                </fieldset>

                <?php
            }
        }
        ?>

        <p class="description"><?php echo esc_html($field_description); ?></p>

        <?php
    }

    /**
     * Sandbox our inputs with text
     *
     * @since    1.0.0
     */
    public function sandbox_add_settings_field_input_text($args) {

        $field_id = $args['label_for'];
        $field_default = $args['default'];

        $options = get_option(GT_CPT::get_plugin_name() . '-settings');
        $option = $field_default;

        if (!empty($options[$field_id])) {
            $option = $options[$field_id];
        }
        ?>
        <input type="text" name="<?php echo GT_CPT::get_plugin_name() . '-settings[' . $field_id . ']'; ?>" id="<?php echo GT_CPT::get_plugin_name() . '-settings[' . $field_id . ']'; ?>" value="<?php echo esc_attr($option); ?>" class="regular-text" />
        <?php
    }

    public static function display_alert() {
//        GT_CPT::view('notice', array(
//            'type' => 'alert',
//            'code' => (int) get_option('gt_cpt_alert_code'),
//            'msg' => get_option('gt_cpt_alert_msg')
//        ));
    }

    public static function plugin_action_links($links, $file) {
        if ($file == plugin_basename(plugin_dir_url(__FILE__) . '/gt-custom-post-types.php')) {
            $links[] = '<a href="' . esc_url(self::get_page_url()) . '">' . esc_html__('Settings', 'gt-cpt') . '</a>';
        }

        return $links;
    }

    public static function modify_plugin_description($all_plugins) {
        if (isset($all_plugins['gt-custom-post-types/gt_custom_post_types.php'])) {
            $all_plugins['gt-custom-post-types/gt_custom_post_types.php']['Description'] = __('A simple plugin to register post types for use with Grizzly Themes.', 'gt-cpt');
        }

        return $all_plugins;
    }

    public static function display_notice() {
        global $hook_suffix;


//		if ( $hook_suffix == 'plugins.php' && !Akismet::get_api_key() ) {
//			self::display_api_key_warning();
//		}
    }

}
