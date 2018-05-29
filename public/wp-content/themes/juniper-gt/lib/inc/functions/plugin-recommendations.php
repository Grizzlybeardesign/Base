<?php
require_once get_template_directory(). '/lib/inc/includes/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'my_theme_register_required_plugins' );

	function my_theme_register_required_plugins() {
		
		$plugins = array(

			array(
				'name'     				=> 'Yoast SEO', 
				'slug'     				=> 'wordpress-seo', 
				'source'   				=> 'https://downloads.wordpress.org/plugin/wordpress-seo.2.3.2.zip', 
				'required' 				=> false, 
				'version' 				=> '2.3.2', 
				'force_activation' 		=> false, 
				'force_deactivation' 	=> false, 
				'external_url' 			=> '', 
			),
			array(
				'name'     				=> 'Google Analytics Dashboard for WP', 
				'slug'     				=> 'google-analytics-dashboard-for-wp', 
				'source'   				=> 'https://downloads.wordpress.org/plugin/google-analytics-dashboard-for-wp.4.8.1.2.zip', 
				'required' 				=> false, 
				'version' 				=> '4.8.1.2', 
				'force_activation' 		=> false, 
				'force_deactivation' 	=> false, 
				'external_url' 			=> '', 
			),
			array(
				'name'     				=> 'Force Regenerate Thumbnails', 
				'slug'     				=> 'force-regenerate-thumbnails', 
				'source'   				=> 'https://downloads.wordpress.org/plugin/force-regenerate-thumbnails.zip', 
				'required' 				=> false, 
				'version' 				=> '4.8.1.2', 
				'force_activation' 		=> false, 
				'force_deactivation' 	=> false, 
				'external_url' 			=> '', 
			)
		);
	
		$config = array(
			'domain'       		=> 'grizzlythemes',         	
			'default_path' 		=> '',                         	
			'parent_menu_slug' 	=> 'themes.php', 				
			'parent_url_slug' 	=> 'themes.php', 				
			'menu'         		=> 'install-required-plugins', 	
			'has_notices'      	=> true,                       	
			'is_automatic'    	=> false,					   	
			'message' 			=> '',							
			'strings'      		=> array(
				'page_title'                       			=> __( 'Install Required Plugins', 'grizzlythemes' ),
				'menu_title'                       			=> __( 'Install Plugins', 'grizzlythemes' ),
				'installing'                       			=> __( 'Installing Plugin: %s', 'grizzlythemes' ), // %1$s = plugin name
				'oops'                             			=> __( 'Something went wrong with the plugin API.', 'grizzlythemes' ),
				'notice_can_install_required'     			=> _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), 
				'notice_can_install_recommended'			=> _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), 
				'notice_cannot_install'  				=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), 
				'notice_can_activate_required'    			=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), 
				'notice_can_activate_recommended'			=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), 
				'notice_cannot_activate' 				=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), 
				'notice_ask_to_update' 					=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), 
				'notice_cannot_update' 					=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), 
				'install_link' 			  			=> _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
				'activate_link' 		  			=> _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
				'return'                           			=> __( 'Return to Required Plugins Installer', 'grizzlythemes' ),
				'plugin_activated'                 			=> __( 'Plugin activated successfully.', 'grizzlythemes' ),
				'complete' 						=> __( 'All plugins installed and activated successfully. %s', 'grizzlythemes' ), 
				'nag_type'                              		=> 'updated' 
			)
		);

		tgmpa( $plugins, $config );

	}
	?>