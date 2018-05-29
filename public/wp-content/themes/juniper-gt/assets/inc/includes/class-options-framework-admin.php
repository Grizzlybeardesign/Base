<?php
/**
 * @package   Options_Framework
 * @author    Devin Price <devin@wptheming.com>
 * @license   GPL-2.0+
 * @link      http://wptheming.com
 * @copyright 2010-2014 WP Theming
 */

class Options_Framework_Admin {

	/**
     * Page hook for the options screen
     *
     * @since 1.7.0
     * @type string
     */
    protected $options_screen = null;

    /**
     * Hook in the scripts and styles
     *
     * @since 1.7.0
     
     */
    public function init() {

		// Gets options to load
    	$options = & Options_Framework::_optionsframework_options();

		// Checks if options are available
    	if ( $options ) {

	
			// Settings need to be registered after admin_init
			add_action( 'admin_init', array( $this, 'settings_init' ) );

		

		}

    }

	/**
     * Registers the settings
     *
     * @since 1.7.0
     */
    function settings_init() {

		// Get the option name
		$options_framework = new Options_Framework;
	    $name = $options_framework->get_option_name();

		// Registers the settings fields and callback
		register_setting( 'optionsframework', $name, array ( $this, 'validate_options' ) );

		// Displays notice after options save
		add_action( 'optionsframework_after_validate', array( $this, 'save_options_notice' ) );

    }

	

	function of_admin_head() {
		// Hook to add custom scripts
		do_action( 'optionsframework_custom_scripts' );
	}



	/**
	 * Validate Options.
	 *
	 * This runs after the submit/reset button has been clicked and
	 * validates the inputs.
	 *
	 * @uses $_POST['reset'] to restore default options
	 */
	function validate_options( $input ) {

		/*
		 * Restore Defaults.
		 *
		 * In the event that the user clicked the "Restore Defaults"
		 * button, the options defined in the theme's options.php
		 * file will be added to the option for the active theme.
		 */

		if ( isset( $_POST['reset'] ) ) {
			add_settings_error( 'options-framework', 'restore_defaults', __( 'Default options restored.', 'theme-textdomain' ), 'updated fade' );
			return $this->get_default_values();
		}

		/*
		 * Update Settings
		 *
		 * This used to check for $_POST['update'], but has been updated
		 * to be compatible with the theme customizer introduced in WordPress 3.4
		 */

		$clean = array();
		$options = & Options_Framework::_optionsframework_options();
		foreach ( $options as $option ) {

			if ( ! isset( $option['id'] ) ) {
				continue;
			}

			if ( ! isset( $option['type'] ) ) {
				continue;
			}

			$id = preg_replace( '/[^a-zA-Z0-9._\-]/', '', strtolower( $option['id'] ) );

			// Set checkbox to false if it wasn't sent in the $_POST
			if ( 'checkbox' == $option['type'] && ! isset( $input[$id] ) ) {
				$input[$id] = false;
			}

			// Set each item in the multicheck to false if it wasn't sent in the $_POST
			if ( 'multicheck' == $option['type'] && ! isset( $input[$id] ) ) {
				foreach ( $option['options'] as $key => $value ) {
					$input[$id][$key] = false;
				}
			}

			// For a value to be submitted to database it must pass through a sanitization filter
			if ( has_filter( 'of_sanitize_' . $option['type'] ) ) {
				$clean[$id] = apply_filters( 'of_sanitize_' . $option['type'], $input[$id], $option );
			}
		}

		// Hook to run after validation
		do_action( 'optionsframework_after_validate', $clean );

		return $clean;
	}

	/**
	 * Display message when options have been saved
	 */

	function save_options_notice() {
		add_settings_error( 'options-framework', 'save_options', __( 'Theme options updated.', 'theme-textdomain' ), 'updated fade' );
	}

	/**
	 * Get the default values for all the theme options
	 *
	 * Get an array of all default values as set in
	 * options.php. The 'id','std' and 'type' keys need
	 * to be defined in the configuration array. In the
	 * event that these keys are not present the option
	 * will not be included in this function's output.
	 *
	 * @return array Re-keyed options configuration array.
	 *
	 */
	function get_default_values() {
		$output = array();
		$config = & Options_Framework::_optionsframework_options();
		foreach ( (array) $config as $option ) {
			if ( ! isset( $option['id'] ) ) {
				continue;
			}
			if ( ! isset( $option['std'] ) ) {
				continue;
			}
			if ( ! isset( $option['type'] ) ) {
				continue;
			}
			if ( has_filter( 'of_sanitize_' . $option['type'] ) ) {
				$output[$option['id']] = apply_filters( 'of_sanitize_' . $option['type'], $option['std'], $option );
			}
		}
		return $output;
	}

}