<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Don't load if optionsframework_init is already defined
if (is_admin() && ! function_exists( 'optionsframework_init' ) ) :

function optionsframework_init() {

	//  If user can't edit theme options, exit
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	// Loads the required Options Framework classes.
	require plugin_dir_path( __FILE__ ) . 'includes/class-options-framework.php';
	require plugin_dir_path( __FILE__ ) . 'includes/class-options-framework-admin.php';
	require plugin_dir_path( __FILE__ ) . 'includes/class-options-interface.php';
	require plugin_dir_path( __FILE__ ) . 'includes/class-options-media-uploader.php';
	require plugin_dir_path( __FILE__ ) . 'includes/class-options-sanitization.php';

	require_once  plugin_dir_path( __FILE__ ) . 'includes/class-post-switcher.php';
	require_once  plugin_dir_path( __FILE__ ) . 'includes/class-post-override-meta.php';
	require_once  plugin_dir_path( __FILE__ ) . 'includes/class-plugin-recommendations.php';

	require_once  plugin_dir_path( __FILE__ ) . 'includes/class-custom-post-type.php';

	// Instantiate the options page.
	$options_framework_admin = new Options_Framework_Admin;
	$options_framework_admin->init();

	// Instantiate the media uploader class
	$options_framework_media_uploader = new Options_Framework_Media_Uploader;
	$options_framework_media_uploader->init();

	$pageswitcher = new Post_Switcher();
	$pageswitcher->init();

	$post_override_meta = new Post_Override_Meta();

	$plugin_recommendation = new Plugin_Recommendations();

	$custom_post_type = new Custom_Post_Type();
}

add_action( 'init', 'optionsframework_init', 20 );

endif;


/**
 * Helper function to return the theme option value.
 * If no value has been saved, it returns $default.
 * Needed because options are saved as serialized strings.
 *
 * Not in a class to support backwards compatibility in themes.
 */
if ( ! function_exists( 'gt_get_option' ) ) :
function gt_get_option( $name, $default = false ) {

	$option_name = '';

	$option_groups = of_get_option_groups();

	// Get option settings from database
	foreach($option_groups as $option_name){
		$options = get_option( $option_name );

		// Return specific option
		if ( isset( $options[$name] ) && !empty ( $options[$name] ) ) {
			return $options[$name];
		}	
	}


	return $default;
}
endif;

if ( ! function_exists( 'of_get_option_groups' ) ) :
	function of_get_option_groups(){
		$groups[] = 'grizzly_settings_general';
		$groups[] = 'grizzly_settings_layout';
		$groups[] = 'grizzly_settings_seo';
		$groups[] = 'grizzly_settings_typography';
		$groups[] = 'grizzly_settings_styling';
		$groups[] = 'grizzly_settings_post_and_pages';
		$groups[] = 'grizzly_settings_footer';
		$groups[] = 'grizzly_settings_galleries';
		$groups[] = 'grizzly_settings_testimonials';
		$groups[] = 'grizzly_settings_contact_and_social';
		$groups[] = 'grizzly_settings_custom_css';
		$groups[] = 'grizzly_settings_import_and_export';
		$groups[] = 'grizzly_settings_slider';

		return $groups;
	}
endif;