<?php
/**
 * Plugin installation and activation for WordPress themes.
 *
 * @package   TGM-Plugin-Activation
 * @version   2.3.6
 * @author    Thomas Griffin <thomas@thomasgriffinmedia.com>
 * @author    Gary Jones <gamajo@gamajo.com>
 * @copyright Copyright (c) 2012, Thomas Griffin
 * @license   http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link      https://github.com/thomasgriffin/TGM-Plugin-Activation
 */

/*
    Copyright 2012  Thomas Griffin  (email : thomas@thomasgriffinmedia.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 3, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if ( ! class_exists( 'TGM_Plugin_Activation' ) ) {
	
	class TGM_Plugin_Activation {

		
		static $instance;
		
		public $plugins = array();
		
		public $parent_menu_slug = 'themes.php';
		
		public $parent_url_slug = 'themes.php';
		
		public $menu = 'install-required-plugins';
		
		public $domain = 'grizzlythemes';
		
		public $default_path = '';
		
		public $has_notices = true;
		
		public $is_automatic = false;

		public $message = '';
		
		public $strings = array();

		public function __construct() {

			self::$instance =& $this;

			$this->strings = array(
				'page_title'                      => __( 'Install Required Plugins', 'grizzlythemes' ),
				'menu_title'                      => __( 'Install Plugins', 'grizzlythemes' ),
				'installing'                      => __( 'Installing Plugin: %s', 'grizzlythemes' ),
				'oops'                            => __( 'Something went wrong.', 'grizzlythemes' ),
				'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ),
				'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ),
				'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ),
				'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ),
				'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ),
				'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ),
				'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ),
				'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ),
				'install_link' 					  => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
				'activate_link' 				  => _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
				'return'                          => __( 'Return to Required Plugins Installer', 'grizzlythemes' ),
				'plugin_activated'                => __( 'Plugin activated successfully.', 'grizzlythemes' ),
				'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'grizzlythemes' ),
			);

			/** Annouce that the class is ready, and pass the object (for advanced use) */
			do_action_ref_array( 'tgmpa_init', array( &$this ) );

			/** When the rest of WP has loaded, kick-start the rest of the class */
			add_action( 'init', array( &$this, 'init' ) );

		}

		
		public function init() {

			do_action( 'tgmpa_register' );
			/** After this point, the plugins should be registered and the configuration set */

			/** Proceed only if we have plugins to handle */
			if ( $this->plugins ) {
				$sorted = array(); // Prepare variable for sorting

				foreach ( $this->plugins as $plugin )
					$sorted[] = $plugin['name'];

				array_multisort( $sorted, SORT_ASC, $this->plugins ); // Sort plugins alphabetically by name

				add_action( 'admin_menu', array( &$this, 'admin_menu' ) );
				add_action( 'admin_head', array( &$this, 'dismiss' ) );
				add_filter( 'install_plugin_complete_actions', array( &$this, 'actions' ) );

				/** Load admin bar in the header to remove flash when installing plugins */
				if ( $this->is_tgmpa_page() ) {
					remove_action( 'wp_footer', 'wp_admin_bar_render', 1000 );
					remove_action( 'admin_footer', 'wp_admin_bar_render', 1000 );
					add_action( 'wp_head', 'wp_admin_bar_render', 1000 );
					add_action( 'admin_head', 'wp_admin_bar_render', 1000 );
				}

				if ( $this->has_notices ) {
					add_action( 'admin_notices', array( &$this, 'notices' ) );
					add_action( 'admin_init', array( &$this, 'admin_init' ), 1 );
					add_action( 'admin_enqueue_scripts', array( &$this, 'thickbox' ) );
					add_action( 'switch_theme', array( &$this, 'update_dismiss' ) );
				}

				/** Setup the force activation hook */
				foreach ( $this->plugins as $plugin ) {
					if ( isset( $plugin['force_activation'] ) && true === $plugin['force_activation'] ) {
						add_action( 'admin_init', array( &$this, 'force_activation' ) );
						break;
					}
				}

				/** Setup the force deactivation hook */
				foreach ( $this->plugins as $plugin ) {
					if ( isset( $plugin['force_deactivation'] ) && true === $plugin['force_deactivation'] ) {
						add_action( 'switch_theme', array( &$this, 'force_deactivation' ) );
						break;
					}
				}
			}

		}

		
		public function admin_init() {

			if ( ! $this->is_tgmpa_page() )
				return;

			if ( isset( $_REQUEST['tab'] ) && 'plugin-information' == $_REQUEST['tab'] ) {
				require_once ABSPATH . 'wp-admin/includes/plugin-install.php'; // Need for install_plugin_information()

				wp_enqueue_style( 'plugin-install' );

				global $tab, $body_id;
				$body_id = $tab = 'plugin-information';

				install_plugin_information();

				exit;
			}

		}

		
		public function thickbox() {

			if ( ! get_user_meta( get_current_user_id(), 'tgmpa_dismissed_notice', true ) )
				add_thickbox();

		}

		
		public function admin_menu() {

			// Make sure privileges are correct to see the page
			if ( ! current_user_can( 'install_plugins' ) )
				return;

			$this->populate_file_path();

			foreach ( $this->plugins as $plugin ) {
				if ( ! is_plugin_active( $plugin['file_path'] ) ) {
					add_submenu_page(
						$this->parent_menu_slug,				// Parent menu slug
						$this->strings['page_title'],           // Page title
						$this->strings['menu_title'],           // Menu title
						'edit_theme_options',                   // Capability
						$this->menu,                            // Menu slug
						array( &$this, 'install_plugins_page' ) // Callback
					);
				break;
				}
			}

		}

		
		public function install_plugins_page() {

			/** Store new instance of plugin table in object */
			$plugin_table = new TGMPA_List_Table;

			/** Return early if processing a plugin installation action */
			if ( isset( $_POST[sanitize_key( 'action' )] ) && 'tgmpa-bulk-install' == $_POST[sanitize_key( 'action' )] && $plugin_table->process_bulk_actions() || $this->do_plugin_install() )
				return;

			?>
			<div class="tgmpa wrap">

				<?php screen_icon( apply_filters( 'tgmpa_default_screen_icon', 'themes' ) ); ?>
				<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
				<?php $plugin_table->prepare_items(); ?>

				<?php if ( isset( $this->message ) ) _e( wp_kses_post( $this->message ), 'grizzlythemes' ); ?>

				<form id="tgmpa-plugins" action="" method="post">
            		<input type="hidden" name="tgmpa-page" value="<?php echo $this->menu; ?>" />
            		<?php $plugin_table->display(); ?>
        		</form>

			</div>
			<?php

		}

		
		protected function do_plugin_install() {

			/** All plugin information will be stored in an array for processing */
			$plugin = array();

			/** Checks for actions from hover links to process the installation */
			if ( isset( $_GET[sanitize_key( 'plugin' )] ) && ( isset( $_GET[sanitize_key( 'tgmpa-install' )] ) && 'install-plugin' == $_GET[sanitize_key( 'tgmpa-install' )] ) ) {
				check_admin_referer( 'tgmpa-install' );

				$plugin['name']   = $_GET[sanitize_key( 'plugin_name' )]; // Plugin name
				$plugin['slug']   = $_GET[sanitize_key( 'plugin' )]; // Plugin slug
				$plugin['source'] = $_GET[sanitize_key( 'plugin_source' )]; // Plugin source

				/** Pass all necessary information via URL if WP_Filesystem is needed */
				$url = wp_nonce_url(
					add_query_arg(
						array(
							'page'          => $this->menu,
							'plugin'        => $plugin['slug'],
							'plugin_name'   => $plugin['name'],
							'plugin_source' => $plugin['source'],
							'tgmpa-install' => 'install-plugin',
						),
						admin_url( $this->parent_url_slug )
					),
					'tgmpa-install'
				);
				$method = ''; // Leave blank so WP_Filesystem can populate it as necessary
				$fields = array( sanitize_key( 'tgmpa-install' ) ); // Extra fields to pass to WP_Filesystem

				if ( false === ( $creds = request_filesystem_credentials( $url, $method, false, false, $fields ) ) )
					return true;

				if ( ! WP_Filesystem( $creds ) ) {
					request_filesystem_credentials( $url, $method, true, false, $fields ); // Setup WP_Filesystem
					return true;
				}

				require_once ABSPATH . 'wp-admin/includes/plugin-install.php'; // Need for plugins_api
				require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php'; // Need for upgrade classes

				/** Set plugin source to WordPress API link if available */
				if ( isset( $plugin['source'] ) && 'repo' == $plugin['source'] ) {
					$api = plugins_api( 'plugin_information', array( 'slug' => $plugin['slug'], 'fields' => array( 'sections' => false ) ) );
					
					if ( is_wp_error( $api ) )
						wp_die( $this->strings['oops'] . var_dump( $api ) );
						
					if ( isset( $api->download_link ) )
						$plugin['source'] = $api->download_link;
				}

				/** Set type, based on whether the source starts with http:// or https:// */
				$type = preg_match( '|^http(s)?://|', $plugin['source'] ) ? 'web' : 'upload';

				/** Prep variables for Plugin_Installer_Skin class */
				$title = sprintf( $this->strings['installing'], $plugin['name'] );
				$url   = add_query_arg( array( 'action' => 'install-plugin', 'plugin' => $plugin['slug'] ), 'update.php' );
				if ( isset( $_GET['from'] ) )
					$url .= add_query_arg( 'from', urlencode( stripslashes( $_GET['from'] ) ), $url );

				$nonce = 'install-plugin_' . $plugin['slug'];

				/** Prefix a default path to pre-packaged plugins */
				$source = ( 'upload' == $type ) ? $this->default_path . $plugin['source'] : $plugin['source'];

				/** Create a new instance of Plugin_Upgrader */
				$upgrader = new Plugin_Upgrader( $skin = new Plugin_Installer_Skin( compact( 'type', 'title', 'url', 'nonce', 'plugin', 'api' ) ) );

				/** Perform the action and install the plugin from the $source urldecode() */
				$upgrader->install( $source );

				/** Flush plugins cache so we can make sure that the installed plugins list is always up to date */
				wp_cache_flush();

				/** Only activate plugins if the config option is set to true */
				if ( $this->is_automatic ) {
					$plugin_activate = $upgrader->plugin_info(); // Grab the plugin info from the Plugin_Upgrader method
					$activate = activate_plugin( $plugin_activate ); // Activate the plugin
					$this->populate_file_path(); // Re-populate the file path now that the plugin has been installed and activated

					if ( is_wp_error( $activate ) ) {
						echo '<div id="message" class="error"><p>' . $activate->get_error_message() . '</p></div>';
						echo '<p><a href="' . add_query_arg( 'page', $this->menu, admin_url( $this->parent_url_slug ) ) . '" title="' . esc_attr( $this->strings['return'] ) . '" target="_parent">' . __( 'Return to Required Plugins Installer', 'grizzlythemes' ) . '</a></p>';
						return true; // End it here if there is an error with automatic activation
					}
					else {
						echo '<p>' . $this->strings['plugin_activated'] . '</p>';
					}
				}

				/** Display message based on if all plugins are now active or not */
				$complete = array();
				foreach ( $this->plugins as $plugin ) {
					if ( ! is_plugin_active( $plugin['file_path'] ) ) {
						echo '<p><a href="' . add_query_arg( 'page', $this->menu, admin_url( $this->parent_url_slug ) ) . '" title="' . esc_attr( $this->strings['return'] ) . '" target="_parent">' . __( $this->strings['return'], 'grizzlythemes' ) . '</a></p>';
						$complete[] = $plugin;
						break;
					}
					/** Nothing to store */
					else {
						$complete[] = '';
					}
				}

				/** Filter out any empty entries */
				$complete = array_filter( $complete );

				/** All plugins are active, so we display the complete string and hide the plugin menu */
				if ( empty( $complete ) ) {
					echo '<p>' .  sprintf( $this->strings['complete'], '<a href="' . admin_url() . '" title="' . __( 'Return to the Dashboard', 'grizzlythemes' ) . '">' . __( 'Return to the Dashboard', 'grizzlythemes' ) . '</a>' ) . '</p>';
					echo '<style type="text/css">#adminmenu .wp-submenu li.current { display: none !important; }</style>';
				}

				return true;
			}
			/** Checks for actions from hover links to process the activation */
			elseif ( isset( $_GET[sanitize_key( 'plugin' )] ) && ( isset( $_GET[sanitize_key( 'tgmpa-activate' )] ) && 'activate-plugin' == $_GET[sanitize_key( 'tgmpa-activate' )] ) ) {
				check_admin_referer( 'tgmpa-activate', 'tgmpa-activate-nonce' );

				/** Populate $plugin array with necessary information */
				$plugin['name']   = $_GET[sanitize_key( 'plugin_name' )];
				$plugin['slug']   = $_GET[sanitize_key( 'plugin' )];
				$plugin['source'] = $_GET[sanitize_key( 'plugin_source' )];

				$plugin_data = get_plugins( '/' . $plugin['slug'] ); // Retrieve all plugins
				$plugin_file = array_keys( $plugin_data ); // Retrieve all plugin files from installed plugins
				$plugin_to_activate = $plugin['slug'] . '/' . $plugin_file[0]; // Match plugin slug with appropriate plugin file
				$activate = activate_plugin( $plugin_to_activate ); // Activate the plugin

				if ( is_wp_error( $activate ) ) {
					echo '<div id="message" class="error"><p>' . $activate->get_error_message() . '</p></div>';
					echo '<p><a href="' . add_query_arg( 'page', $this->menu, admin_url( $this->parent_url_slug ) ) . '" title="' . esc_attr( $this->strings['return'] ) . '" target="_parent">' . __( $this->strings['return'], 'grizzlythemes' ) . '</a></p>';
					return true; // End it here if there is an error with activation
				}
				else {
					/** Make sure message doesn't display again if bulk activation is performed immediately after a single activation */
					if ( ! isset( $_POST[sanitize_key( 'action' )] ) ) {
						$msg = sprintf( __( 'The following plugin was activated successfully: %s.', 'grizzlythemes' ), '<strong>' . $plugin['name'] . '</strong>' );
						echo '<div id="message" class="updated"><p>' . $msg . '</p></div>';
					}
				}
			}

			return false;

		}

		
		public function notices() {

			global $current_screen;

			/** Remove nag on the install page */
			if ( $this->is_tgmpa_page() )
				return;

			$installed_plugins = get_plugins(); // Retrieve a list of all the plugins
			$this->populate_file_path();

			$message              = array(); // Store the messages in an array to be outputted after plugins have looped through
			$install_link         = false; // Set to false, change to true in loop if conditions exist, used for action link 'install'
			$install_link_count   = 0; // Used to determine plurality of install action link text
			$activate_link        = false; // Set to false, change to true in loop if conditions exist, used for action link 'activate'
			$activate_link_count  = 0; // Used to determine plurality of activate action link text

			foreach ( $this->plugins as $plugin ) {
				/** If the plugin is installed and active, check for minimum version argument before moving forward */
				if ( is_plugin_active( $plugin['file_path'] ) ) {
					/** A minimum version has been specified */
					if ( isset( $plugin['version'] ) ) {
						if ( isset( $installed_plugins[$plugin['file_path']]['Version'] ) ) {
							/** If the current version is less than the minimum required version, we display a message */
							if ( version_compare( $installed_plugins[$plugin['file_path']]['Version'], $plugin['version'], '<' ) ) {
								if ( current_user_can( 'install_plugins' ) )
									$message['notice_ask_to_update'][] = $plugin['name'];
								else
									$message['notice_cannot_update'][] = $plugin['name'];
							}
						}
						/** Can't find the plugin, so iterate to the next condition */
						else {
							continue;
						}
					}
					/** No minimum version specified, so iterate over the plugin */
					else {
						continue;
					}
				}

				/** Not installed */
				if ( ! isset( $installed_plugins[$plugin['file_path']] ) ) {
					$install_link = true; // We need to display the 'install' action link
					$install_link_count++; // Increment the install link count
					if ( current_user_can( 'install_plugins' ) ) {
						if ( $plugin['required'] )
							$message['notice_can_install_required'][] = $plugin['name'];
						/** This plugin is only recommended */
						else
							$message['notice_can_install_recommended'][] = $plugin['name'];
					}
					/** Need higher privileges to install the plugin */
					else {
						$message['notice_cannot_install'][] = $plugin['name'];
					}
				}
				/** Installed but not active */
				elseif ( is_plugin_inactive( $plugin['file_path'] ) ) {
					$activate_link = true; // We need to display the 'activate' action link
					$activate_link_count++; // Increment the activate link count
					if ( current_user_can( 'activate_plugins' ) ) {
						if ( ( isset( $plugin['required'] ) ) && ( $plugin['required'] ) )
							$message['notice_can_activate_required'][] = $plugin['name'];
						/** This plugin is only recommended */
						else {
							$message['notice_can_activate_recommended'][] = $plugin['name'];
						}
					}
					/** Need higher privileges to activate the plugin */
					else {
						$message['notice_cannot_activate'][] = $plugin['name'];
					}
				}
			}

			/** Only process the nag messages if the user has not dismissed them already */
			if ( ! get_user_meta( get_current_user_id(), 'tgmpa_dismissed_notice', true ) ) {
				/** If we have notices to display, we move forward */
				if ( ! empty( $message ) ) {
					krsort( $message ); // Sort messages
					$rendered = ''; // Display all nag messages as strings

					/** Grab all plugin names */
					foreach ( $message as $type => $plugin_groups ) {
						$linked_plugin_groups = array();

						/** Count number of plugins in each message group to calculate singular/plural message */
						$count = count( $plugin_groups );

						/** Loop through the plugin names to make the ones pulled from the .org repo linked */
						foreach ( $plugin_groups as $plugin_group_single_name ) {
							$external_url = $this->_get_plugin_data_from_name( $plugin_group_single_name, 'external_url' );
							$source = $this->_get_plugin_data_from_name( $plugin_group_single_name, 'source' );

							if ( $external_url && preg_match( '|^http(s)?://|', $external_url ) ) {
								$linked_plugin_groups[] = '<a href="' . esc_url( $external_url ) . '" title="' . $plugin_group_single_name . '" target="_blank">' . $plugin_group_single_name . '</a>';
							}
							elseif ( ! $source || preg_match( '|^http://wordpress.org/extend/plugins/|', $source ) ) {
								$url = add_query_arg(
									array(
										'tab'       => 'plugin-information',
										'plugin'    => $this->_get_plugin_data_from_name( $plugin_group_single_name ),
										'TB_iframe' => 'true',
										'width'     => '640',
										'height'    => '500',
									),
									admin_url( 'plugin-install.php' )
								);

								$linked_plugin_groups[] = '<a href="' . esc_url( $url ) . '" class="thickbox" title="' . $plugin_group_single_name . '">' . $plugin_group_single_name . '</a>';
							}
							else {
								$linked_plugin_groups[] = $plugin_group_single_name; // No hyperlink
							}

							if ( isset( $linked_plugin_groups ) && (array) $linked_plugin_groups )
								$plugin_groups = $linked_plugin_groups;
						}

						$last_plugin = array_pop( $plugin_groups ); // Pop off last name to prep for readability
						$imploded    = empty( $plugin_groups ) ? '<em>' . $last_plugin . '</em>' : '<em>' . ( implode( ', ', $plugin_groups ) . '</em> and <em>' . $last_plugin . '</em>' );

						$rendered .= '<p>' . sprintf( translate_nooped_plural( $this->strings[$type], $count, 'grizzlythemes' ), $imploded, $count ) . '</p>'; // All messages now stored
					}

					/** Setup variables to determine if action links are needed */
					$show_install_link  = $install_link ? '<a href="' . add_query_arg( 'page', $this->menu, admin_url( $this->parent_url_slug ) ) . '">' . translate_nooped_plural( $this->strings['install_link'], $install_link_count, 'grizzlythemes' ) . '</a>' : '';
					$show_activate_link = $activate_link ? '<a href="' . admin_url( 'plugins.php' ) . '">' . translate_nooped_plural( $this->strings['activate_link'], $activate_link_count, 'grizzlythemes' ) . '</a>'  : '';

					/** Define all of the action links */
					$action_links = apply_filters(
						'tgmpa_notice_action_links',
						array(
							'install'  => ( current_user_can( 'install_plugins' ) ) ? $show_install_link : '',
							'activate' => ( current_user_can( 'activate_plugins' ) ) ? $show_activate_link : '',
							'dismiss'  => '<a class="dismiss-notice" href="' . add_query_arg( 'tgmpa-dismiss', 'dismiss_admin_notices' ) . '" target="_parent">' . __( 'Dismiss this notice', 'grizzlythemes' ) . '</a>',
						)
					);

					$action_links = array_filter( $action_links ); // Remove any empty array items
					if ( $action_links )
						$rendered .= '<p>' . implode( ' | ', $action_links ) . '</p>';

					/** Register the nag messages and prepare them to be processed */
               		if ( isset( $this->strings['nag_type'] ) )
						add_settings_error( 'tgmpa', 'tgmpa', $rendered, sanitize_html_class( strtolower( $this->strings['nag_type'] ), 'updated' ) );
					else
						add_settings_error( 'tgmpa', 'tgmpa', $rendered, 'updated' );
				}
			}

			/** Admin options pages already output settings_errors, so this is to avoid duplication */
			if ( 'options-general' !== $current_screen->parent_base )
				settings_errors( 'tgmpa' );

		}

		
		public function dismiss() {

			if ( isset( $_GET[sanitize_key( 'tgmpa-dismiss' )] ) )
				update_user_meta( get_current_user_id(), 'tgmpa_dismissed_notice', 1 );

		}

		
		public function register( $plugin ) {

			if ( ! isset( $plugin['slug'] ) || ! isset( $plugin['name'] ) )
				return;

			$this->plugins[] = $plugin;

		}

		
		public function config( $config ) {

			$keys = array( 'default_path', 'parent_menu_slug', 'parent_url_slug', 'domain', 'has_notices', 'menu', 'is_automatic', 'message', 'strings' );

			foreach ( $keys as $key ) {
				if ( isset( $config[$key] ) ) {
					if ( is_array( $config[$key] ) ) {
						foreach ( $config[$key] as $subkey => $value )
							$this->{$key}[$subkey] = $value;
					} else {
						$this->$key = $config[$key];
					}
				}
			}

		}

		
		public function actions( $install_actions ) {

			/** Remove action links on the TGMPA install page */
			if ( $this->is_tgmpa_page() )
				return false;

			return $install_actions;

		}

		
		public function populate_file_path() {

			/** Add file_path key for all plugins */
			foreach ( $this->plugins as $plugin => $values )
				$this->plugins[$plugin]['file_path'] = $this->_get_plugin_basename_from_slug( $values['slug'] );

		}

		
		protected function _get_plugin_basename_from_slug( $slug ) {

			$keys = array_keys( get_plugins() );

			foreach ( $keys as $key ) {
				if ( preg_match( '|^' . $slug .'|', $key ) )
					return $key;
			}

			return $slug;

		}

		
		protected function _get_plugin_data_from_name( $name, $data = 'slug' ) {

			foreach ( $this->plugins as $plugin => $values ) {
				if ( $name == $values['name'] && isset( $values[$data] ) )
					return $values[$data];
			}

			return false;

		}

		
		protected function is_tgmpa_page() {

			global $current_screen;

			if ( ! is_null( $current_screen ) && $this->parent_menu_slug == $current_screen->parent_file && isset( $_GET['page'] ) && $this->menu === $_GET['page'] )
				return true;

			if ( isset( $_GET['page'] ) && $this->menu === $_GET['page'] )
				return true;

			return false;

		}

		public function update_dismiss() {

			delete_user_meta( get_current_user_id(), 'tgmpa_dismissed_notice' );

		}

		
		public function force_activation() {

			/** Set file_path parameter for any installed plugins */
			$this->populate_file_path();
			
			$installed_plugins = get_plugins();

			foreach ( $this->plugins as $plugin ) {
				/** Oops, plugin isn't there so iterate to next condition */
				if ( isset( $plugin['force_activation'] ) && $plugin['force_activation'] && ! isset( $installed_plugins[$plugin['file_path']] ) )
					continue;
				/** There we go, activate the plugin */
				elseif ( isset( $plugin['force_activation'] ) && $plugin['force_activation'] && is_plugin_inactive( $plugin['file_path'] ) )
					activate_plugin( $plugin['file_path'] );
			}

		}

		
		public function force_deactivation() {

			/** Set file_path parameter for any installed plugins */
			$this->populate_file_path();

			foreach ( $this->plugins as $plugin ) {
				/** Only proceed forward if the paramter is set to true and plugin is active */
				if ( isset( $plugin['force_deactivation'] ) && $plugin['force_deactivation'] && is_plugin_active( $plugin['file_path'] ) )
					deactivate_plugins( $plugin['file_path'] );
			}

		}

	}
}

/** Create a new instance of the class */
new TGM_Plugin_Activation;

if ( ! function_exists( 'tgmpa' ) ) {
	/**
	 * Helper function to register a collection of required plugins.
	 *
	 * @since 2.0.0
	 * @api
	 *
	 * @param array $plugins An array of plugin arrays
	 * @param array $config Optional. An array of configuration values
	 */
	function tgmpa( $plugins, $config = array() ) {

		foreach ( $plugins as $plugin )
			TGM_Plugin_Activation::$instance->register( $plugin );

		if ( $config )
			TGM_Plugin_Activation::$instance->config( $config );

	}
}


if ( ! class_exists( 'WP_List_Table' ) )
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );

if ( ! class_exists( 'TGMPA_List_Table' ) ) {
	
	class TGMPA_List_Table extends WP_List_Table {

		/**
		 * References parent constructor and sets defaults for class.
		 *
		 * The constructor also grabs a copy of $instance from the TGMPA class
		 * and stores it in the global object TGM_Plugin_Activation::$instance.
		 *
		 * @since 2.2.0
		 *
		 * @global unknown $status
		 * @global string $page
		 */
		public function __construct() {

			global $status, $page;

			parent::__construct(
				array(
					'singular' => 'plugin',
					'plural'   => 'plugins',
					'ajax'     => false,
				)
			);

		}

		
		protected function _gather_plugin_data() {

			/** Load thickbox for plugin links */
			TGM_Plugin_Activation::$instance->admin_init();
			TGM_Plugin_Activation::$instance->thickbox();

			/** Prep variables for use and grab list of all installed plugins */
			$table_data = array();
			$i = 0;
			$installed_plugins = get_plugins();

			foreach ( TGM_Plugin_Activation::$instance->plugins as $plugin ) {
				if ( is_plugin_active( $plugin['file_path'] ) )
					continue; // No need to display plugins if they are installed and activated

				$table_data[$i]['sanitized_plugin'] = $plugin['name'];
				$table_data[$i]['slug'] = $this->_get_plugin_data_from_name( $plugin['name'] );

				$external_url = $this->_get_plugin_data_from_name( $plugin['name'], 'external_url' );
				$source = $this->_get_plugin_data_from_name( $plugin['name'], 'source' );

				if ( $external_url && preg_match( '|^http(s)?://|', $external_url ) ) {
					$table_data[$i]['plugin'] = '<strong><a href="' . esc_url( $external_url ) . '" title="' . $plugin['name'] . '" target="_blank">' . $plugin['name'] . '</a></strong>';
				}
				elseif ( ! $source || preg_match( '|^http://wordpress.org/extend/plugins/|', $source ) ) {
					$url = add_query_arg(
						array(
							'tab'       => 'plugin-information',
							'plugin'    => $this->_get_plugin_data_from_name( $plugin['name'] ),
							'TB_iframe' => 'true',
							'width'     => '640',
							'height'    => '500',
						),
						admin_url( 'plugin-install.php' )
					);

					$table_data[$i]['plugin'] = '<strong><a href="' . esc_url( $url ) . '" class="thickbox" title="' . $plugin['name'] . '">' . $plugin['name'] . '</a></strong>';
				}
				else {
					$table_data[$i]['plugin'] = '<strong>' . $plugin['name'] . '</strong>'; // No hyperlink
				}

				if ( isset( $table_data[$i]['plugin'] ) && (array) $table_data[$i]['plugin'] )
					$plugin['name'] = $table_data[$i]['plugin'];

				if ( isset( $plugin['external_url'] ) ) {
					/** The plugin is linked to an external source */
					$table_data[$i]['source'] = __( 'External Link', TGM_Plugin_Activation::$instance->domain );
				}
				elseif ( isset( $plugin['source'] ) ) {
					/** The plugin must be from a private repository */
					if ( preg_match( '|^http(s)?://|', $plugin['source'] ) )
						$table_data[$i]['source'] = __( 'Private Repository', TGM_Plugin_Activation::$instance->domain );
					/** The plugin is pre-packaged with the theme */
					else
						$table_data[$i]['source'] = __( 'Pre-Packaged', TGM_Plugin_Activation::$instance->domain );
				}
				/** The plugin is from the WordPress repository */
				else {
					$table_data[$i]['source'] = __( 'WordPress Repository', TGM_Plugin_Activation::$instance->domain );
				}

				$table_data[$i]['type'] = $plugin['required'] ? __( 'Required', TGM_Plugin_Activation::$instance->domain ) : __( 'Recommended', TGM_Plugin_Activation::$instance->domain );

				if ( ! isset( $installed_plugins[$plugin['file_path']] ) )
					$table_data[$i]['status'] = sprintf( '%1$s', __( 'Not Installed', TGM_Plugin_Activation::$instance->domain ) );
				elseif ( is_plugin_inactive( $plugin['file_path'] ) )
					$table_data[$i]['status'] = sprintf( '%1$s', __( 'Installed But Not Activated', TGM_Plugin_Activation::$instance->domain ) );

				$table_data[$i]['file_path'] = $plugin['file_path'];
				$table_data[$i]['url'] = isset( $plugin['source'] ) ? $plugin['source'] : 'repo';

				$i++;
			}
			
			
			$resort = array();
			$req = array();
			$rec = array();
			
			/** Grab all the plugin types */
			foreach ( $table_data as $plugin )
				$resort[] = $plugin['type'];
			
			/** Sort each plugin by type */
			foreach ( $resort as $type )
				if ( 'Required' == $type )
					$req[] = $type;
				else
					$rec[] = $type;
			
			
			sort( $req );
			sort( $rec );
			array_merge( $resort, $req, $rec );
			array_multisort( $resort, SORT_DESC, $table_data );

			return $table_data;

		}

		
		protected function _get_plugin_data_from_name( $name, $data = 'slug' ) {

			foreach ( TGM_Plugin_Activation::$instance->plugins as $plugin => $values ) {
				if ( $name == $values['name'] && isset( $values[$data] ) )
					return $values[$data];
			}

			return false;

		}

		
		public function column_default( $item, $column_name ) {

			switch ( $column_name ) {
				case 'source':
				case 'type':
				case 'status':
					return $item[$column_name];
			}

		}

		
		public function column_plugin( $item ) {

			$installed_plugins = get_plugins();

			/** No need to display any hover links */
			if ( is_plugin_active( $item['file_path'] ) )
				$actions = array();

			/** We need to display the 'Install' hover link */
			if ( ! isset( $installed_plugins[$item['file_path']] ) ) {
				$actions = array(
					'install' => sprintf(
						'<a href="%1$s" title="Install %2$s">Install</a>',
						wp_nonce_url(
							add_query_arg(
								array(
									'page'          => TGM_Plugin_Activation::$instance->menu,
									'plugin'        => $item['slug'],
									'plugin_name'   => $item['sanitized_plugin'],
									'plugin_source' => $item['url'],
									'tgmpa-install' => 'install-plugin',
								),
								admin_url( TGM_Plugin_Activation::$instance->parent_url_slug )
							),
							'tgmpa-install'
						),
						$item['sanitized_plugin']
					),
				);
			}
			/** We need to display the 'Activate' hover link */
			elseif ( is_plugin_inactive( $item['file_path'] ) ) {
				$actions = array(
					'activate' => sprintf(
						'<a href="%1$s" title="Activate %2$s">Activate</a>',
						add_query_arg(
							array(
								'page'                 => TGM_Plugin_Activation::$instance->menu,
								'plugin'               => $item['slug'],
								'plugin_name'          => $item['sanitized_plugin'],
								'plugin_source'        => $item['url'],
								'tgmpa-activate'       => 'activate-plugin',
								'tgmpa-activate-nonce' => wp_create_nonce( 'tgmpa-activate' ),
							),
							admin_url( TGM_Plugin_Activation::$instance->parent_url_slug )
						),
						$item['sanitized_plugin']
					),
				);
			}

			return sprintf( '%1$s %2$s', $item['plugin'], $this->row_actions( $actions ) );

		}

		
		public function column_cb( $item ) {

			$value = $item['file_path'] . ',' . $item['url'] . ',' . $item['sanitized_plugin'];
			return sprintf( '<input type="checkbox" name="%1$s[]" value="%2$s" id="%3$s" />', $this->_args['singular'], $value, $item['sanitized_plugin'] );

		}

		
		public function no_items() {

			printf( __( 'No plugins to install or activate. <a href="%1$s" title="Return to the Dashboard">Return to the Dashboard</a>', TGM_Plugin_Activation::$instance->domain ), admin_url() );
			echo '<style type="text/css">#adminmenu .wp-submenu li.current { display: none !important; }</style>';

		}

		
		public function get_columns() {

			$columns = array(
				'cb'     => '<input type="checkbox" />',
				'plugin' => __( 'Plugin', TGM_Plugin_Activation::$instance->domain ),
				'source' => __( 'Source', TGM_Plugin_Activation::$instance->domain ),
				'type'   => __( 'Type', TGM_Plugin_Activation::$instance->domain ),
				'status' => __( 'Status', TGM_Plugin_Activation::$instance->domain )
			);

			return $columns;

		}

		
		public function get_bulk_actions() {

			$actions = array(
				'tgmpa-bulk-install'  => __( 'Install', TGM_Plugin_Activation::$instance->domain ),
				'tgmpa-bulk-activate' => __( 'Activate', TGM_Plugin_Activation::$instance->domain ),
			);

			return $actions;

		}

		
		public function process_bulk_actions() {

			
			if ( 'tgmpa-bulk-install' === $this->current_action() ) {
				check_admin_referer( 'bulk-' . $this->_args['plural'] );

			
				$plugins_to_install = array();
				$plugin_installs    = array();
				$plugin_path        = array();
				$plugin_name        = array();

				
				if ( isset( $_GET[sanitize_key( 'plugins' )] ) )
					$plugins = explode( ',', stripslashes( $_GET[sanitize_key( 'plugins' )] ) );
				
				elseif ( isset( $_POST[sanitize_key( 'plugin' )] ) )
					$plugins = (array) $_POST[sanitize_key( 'plugin' )];
				
				else
					$plugins = array();

				$a = 0; 

				
				if ( isset( $_POST[sanitize_key( 'plugin' )] ) ) {
					foreach ( $plugins as $plugin_data )
						$plugins_to_install[] = explode( ',', $plugin_data );

					foreach ( $plugins_to_install as $plugin_data ) {
						$plugin_installs[] = $plugin_data[0];
						$plugin_path[]     = $plugin_data[1];
						$plugin_name[]     = $plugin_data[2];
					}
				}
				
				else {
					foreach ( $plugins as $key => $value ) {
						/** Grab plugin slug for each plugin */
						if ( 0 == $key % 3 || 0 == $key ) {
							$plugins_to_install[] = $value;
							$plugin_installs[]    = $value;
						}
						$a++;
					}
				}

				
				if ( isset( $_GET[sanitize_key( 'plugin_paths' )] ) )
					$plugin_paths = explode( ',', stripslashes( $_GET[sanitize_key( 'plugin_paths' )] ) );
				
				elseif ( isset( $_POST[sanitize_key( 'plugin' )] ) )
					$plugin_paths = (array) $plugin_path;
				
				else
					$plugin_paths = array();

				
				if ( isset( $_GET[sanitize_key( 'plugin_names' )] ) )
					$plugin_names = explode( ',', stripslashes( $_GET[sanitize_key( 'plugin_names' )] ) );
				
				elseif ( isset( $_POST[sanitize_key( 'plugin' )] ) )
					$plugin_names = (array) $plugin_name;
				
				else
					$plugin_names = array();

				$b = 0; 

				
				foreach ( $plugin_installs as $key => $plugin ) {
					if ( preg_match( '|.php$|', $plugin ) ) {
						unset( $plugin_installs[$key] );

						
						if ( ! isset( $_GET[sanitize_key( 'plugin_paths' )] ) )
							unset( $plugin_paths[$b] );

						
						if ( ! isset( $_GET[sanitize_key( 'plugin_names' )] ) )
							unset( $plugin_names[$b] );
					}
					$b++;
				}

				
				if ( empty( $plugin_installs ) )
					return false;

				
				$plugin_installs = array_values( $plugin_installs );
				$plugin_paths    = array_values( $plugin_paths );
				$plugin_names    = array_values( $plugin_names );

				
				$plugin_installs = array_map( 'urldecode', $plugin_installs );
				$plugin_paths    = array_map( 'urldecode', $plugin_paths );
				$plugin_names    = array_map( 'urldecode', $plugin_names );

				
				$url = wp_nonce_url(
					add_query_arg(
						array(
							'page' 			=> TGM_Plugin_Activation::$instance->menu,
							'tgmpa-action' 	=> 'install-selected',
							'plugins' 		=> urlencode( implode( ',', $plugins ) ),
							'plugin_paths' 	=> urlencode( implode( ',', $plugin_paths ) ),
							'plugin_names' 	=> urlencode( implode( ',', $plugin_names ) ),
						),
						admin_url( TGM_Plugin_Activation::$instance->parent_url_slug )
					),
					'bulk-plugins'
				);
				$method = ''; 
				$fields = array( sanitize_key( 'action' ), sanitize_key( '_wp_http_referer' ), sanitize_key( '_wpnonce' ) ); 

				if ( false === ( $creds = request_filesystem_credentials( $url, $method, false, false, $fields ) ) )
					return true;

				if ( ! WP_Filesystem( $creds ) ) {
					request_filesystem_credentials( $url, $method, true, false, $fields ); 
					return true;
				}

				require_once ABSPATH . 'wp-admin/includes/plugin-install.php'; 
				require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php'; 

				
				$api          = array();
				$sources      = array();
				$install_path = array();

				$c = 0; 
				foreach ( $plugin_installs as $plugin ) {
					$api[$c] = plugins_api( 'plugin_information', array( 'slug' => $plugin, 'fields' => array( 'sections' => false ) ) ) ? plugins_api( 'plugin_information', array( 'slug' => $plugin, 'fields' => array( 'sections' => false ) ) ) : (object) $api[$c] = 'tgmpa-empty';
					$c++;
				}

				if ( is_wp_error( $api ) )
					wp_die( TGM_Plugin_Activation::$instance->strings['oops'] . var_dump( $api ) );

				$d = 0;	
				
				foreach ( $api as $object ) {
					$sources[$d] = isset( $object->download_link ) && 'repo' == $plugin_paths[$d] ? $object->download_link : $plugin_paths[$d];
					$d++;
				}

				
				$url   = add_query_arg( array( 'page' => TGM_Plugin_Activation::$instance->menu ), admin_url( TGM_Plugin_Activation::$instance->parent_url_slug ) );
				$nonce = 'bulk-plugins';
				$names = $plugin_names;

				
				$installer = new TGM_Bulk_Installer( $skin = new TGM_Bulk_Installer_Skin( compact( 'url', 'nonce', 'names' ) ) );

				
				echo '<div class="tgmpa wrap">';
					screen_icon( apply_filters( 'tgmpa_default_screen_icon', 'themes' ) );
					echo '<h2>' . esc_html( get_admin_page_title() ) . '</h2>';
					
					$installer->bulk_install( $sources );
				echo '</div>';

				return true;
			}

			
			if ( 'tgmpa-bulk-activate' === $this->current_action() ) {
				check_admin_referer( 'bulk-' . $this->_args['plural'] );

				/** Grab plugin data from $_POST */
				$plugins             = isset( $_POST[sanitize_key( 'plugin' )] ) ? (array) $_POST[sanitize_key( 'plugin' )] : array();
				$plugins_to_activate = array();

				
				foreach ( $plugins as $i => $plugin )
					$plugins_to_activate[] = explode( ',', $plugin );

				foreach ( $plugins_to_activate as $i => $array ) {
					if ( ! preg_match( '|.php$|', $array[0] ) ) 
						unset( $plugins_to_activate[$i] );
				}

				
				if ( empty( $plugins_to_activate ) )
					return;

				$plugins      = array();
				$plugin_names = array();

				foreach ( $plugins_to_activate as $plugin_string ) {
					$plugins[] = $plugin_string[0];
					$plugin_names[] = $plugin_string[2];
				}

				$count = count( $plugin_names ); 
				$last_plugin = array_pop( $plugin_names ); 
				$imploded    = empty( $plugin_names ) ? '<strong>' . $last_plugin . '</strong>' : '<strong>' . ( implode( ', ', $plugin_names ) . '</strong> and <strong>' . $last_plugin . '</strong>.' );

				
				$activate = activate_plugins( $plugins );

				if ( is_wp_error( $activate ) )
					echo '<div id="message" class="error"><p>' . $activate->get_error_message() . '</p></div>';
				else
					printf( '<div id="message" class="updated"><p>%1$s %2$s</p></div>', _n( 'The following plugin was activated successfully:', 'The following plugins were activated successfully:', $count, TGM_Plugin_Activation::$instance->domain ), $imploded );

 				
				$recent = (array) get_option( 'recently_activated' );

				foreach ( $plugins as $plugin => $time )
					if ( isset( $recent[$plugin] ) )
						unset( $recent[$plugin] );

				update_option( 'recently_activated', $recent );

				unset( $_POST ); 
			}
		}

		
		public function prepare_items() {

			$per_page              = 100; 
			$columns               = $this->get_columns(); 
			$hidden                = array(); 
			$sortable              = array(); 
			$this->_column_headers = array( $columns, $hidden, $sortable ); 

			
			$this->process_bulk_actions();

			
			$this->items = $this->_gather_plugin_data();

		}

	}
}


if ( ! class_exists( 'WP_Upgrader' ) && ( isset( $_GET[sanitize_key( 'page' )] ) && TGM_Plugin_Activation::$instance->menu = $_GET[sanitize_key( 'page' )] ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';

	if ( ! class_exists( 'TGM_Bulk_Installer' ) ) {
		
		class TGM_Bulk_Installer extends WP_Upgrader {

			
			public $bulk = false;

			public function bulk_install( $packages ) {

				
				$this->init();
				$this->bulk = true;

				
				$this->install_strings();
				if ( TGM_Plugin_Activation::$instance->is_automatic )
					$this->activate_strings();

				
				$this->skin->header();

			
				$res = $this->fs_connect( array( WP_CONTENT_DIR, WP_PLUGIN_DIR ) );
				if ( ! $res ) {
					$this->skin->footer();
					return false;
				}

				
				$this->skin->bulk_header();
				$results = array();

				
				$this->update_count   = count( $packages );
				$this->update_current = 0;

				
				foreach ( $packages as $plugin ) {
					$this->update_current++; 

				
					$result = $this->run(
						array(
							'package'           => $plugin, 
							'destination'       => WP_PLUGIN_DIR, 
							'clear_destination' => false, 
							'clear_working'     => true, 
							'is_multi'          => true, 
							'hook_extra'        => array( 'plugin' => $plugin, ), 
						)
					);

				
					$results[$plugin] = $this->result;

					
					if ( false === $result )
						break;
				}

				
				$this->skin->bulk_footer();
				$this->skin->footer();

				
				return $results;

			}

			
			public function run( $options ) {

				/** Default config options */
				$defaults = array(
					'package'           => '',
					'destination'       => '',
					'clear_destination' => false,
					'clear_working'     => true,
					'is_multi'          => false,
					'hook_extra'        => array(),
				);

				
				$options = wp_parse_args( $options, $defaults );
				extract( $options );

				
				$res = $this->fs_connect( array( WP_CONTENT_DIR, $destination ) );
				if ( ! $res )
					return false;

				
				if ( is_wp_error( $res ) ) {
					$this->skin->error( $res );
					return $res;
				}

	
				if ( ! $is_multi )
					$this->skin->header();

		
				$this->skin->before();

				
				$download = $this->download_package( $package );
				if ( is_wp_error( $download ) ) {
					$this->skin->error( $download );
					$this->skin->after();
					return $download;
				}

				
				$delete_package = ( $download != $package );

				
				$working_dir = $this->unpack_package( $download, $delete_package );
				if ( is_wp_error( $working_dir ) ) {
					$this->skin->error( $working_dir );
					$this->skin->after();
					return $working_dir;
				}

				
				$result = $this->install_package(
					array(
						'source'            => $working_dir,
						'destination'       => $destination,
						'clear_destination' => $clear_destination,
						'clear_working'     => $clear_working,
						'hook_extra'        => $hook_extra,
					)
				);

	
				$this->skin->set_result( $result );

			
				if ( is_wp_error( $result ) ) {
					$this->skin->error( $result );
					$this->skin->feedback( 'process_failed' );
				}
				
				else {
					$this->skin->feedback( 'process_success' );
				}

				
				if ( TGM_Plugin_Activation::$instance->is_automatic ) {
					
					wp_cache_flush();

					
					$plugin_info = $this->plugin_info( $package );
					$activate    = activate_plugin( $plugin_info );

					
					TGM_Plugin_Activation::$instance->populate_file_path();

					
					if ( is_wp_error( $activate ) ) {
						$this->skin->error( $activate );
						$this->skin->feedback( 'activation_failed' );
					}
					
					else {
						$this->skin->feedback( 'activation_success' );
					}
				}

				
				wp_cache_flush();

				
				$this->skin->after();
				if ( ! $is_multi )
					$this->skin->footer();

				return $result;

			}

			
			public function install_strings() {

				$this->strings['no_package']          = __( 'Install package not available.', TGM_Plugin_Activation::$instance->domain );
				$this->strings['downloading_package'] = __( 'Downloading install package from <span class="code">%s</span>&#8230;', TGM_Plugin_Activation::$instance->domain );
				$this->strings['unpack_package']      = __( 'Unpacking the package&#8230;', TGM_Plugin_Activation::$instance->domain );
				$this->strings['installing_package']  = __( 'Installing the plugin&#8230;', TGM_Plugin_Activation::$instance->domain );
				$this->strings['process_failed']      = __( 'Plugin install failed.', TGM_Plugin_Activation::$instance->domain );
				$this->strings['process_success']     = __( 'Plugin installed successfully.', TGM_Plugin_Activation::$instance->domain );

			}

			
			public function activate_strings() {

				$this->strings['activation_failed']  = __( 'Plugin activation failed.', TGM_Plugin_Activation::$instance->domain );
				$this->strings['activation_success'] = __( 'Plugin activated successfully.', TGM_Plugin_Activation::$instance->domain );

			}

			
			public function plugin_info() {

				/** Return false if installation result isn't an array or the destination name isn't set */
				if ( ! is_array( $this->result ) )
					return false;
				if ( empty( $this->result['destination_name'] ) )
					return false;

		
				$plugin = get_plugins( '/' . $this->result['destination_name'] );
				if ( empty( $plugin ) )
					return false;

				$pluginfiles = array_keys( $plugin );

				return $this->result['destination_name'] . '/' . $pluginfiles[0];

			}

		}
	}

	if ( ! class_exists( 'TGM_Bulk_Installer_Skin' ) ) {
		
		class TGM_Bulk_Installer_Skin extends Bulk_Upgrader_Skin {

			
			public $plugin_info = array();
			
			public $plugin_names = array();

			
			public $i = 0;

			
			public function __construct( $args = array() ) {
				
				$defaults = array( 'url' => '', 'nonce' => '', 'names' => array() );
				$args = wp_parse_args( $args, $defaults );
			
				$this->plugin_names = $args['names'];
				
				parent::__construct( $args );

			}

			
			public function add_strings() {

				if ( TGM_Plugin_Activation::$instance->is_automatic ) {
					$this->upgrader->strings['skin_upgrade_start']        = __( 'The installation and activation process is starting. This process may take a while on some hosts, so please be patient.', TGM_Plugin_Activation::$instance->domain );
					$this->upgrader->strings['skin_update_successful']    = __( '%1$s installed and activated successfully.', TGM_Plugin_Activation::$instance->domain ) . ' <a onclick="%2$s" href="#" class="hide-if-no-js"><span>' . __( 'Show Details', TGM_Plugin_Activation::$instance->domain ) . '</span><span class="hidden">' . __( 'Hide Details', TGM_Plugin_Activation::$instance->domain ) . '</span>.</a>';
					$this->upgrader->strings['skin_upgrade_end']          = __( 'All installations and activations have been completed.', TGM_Plugin_Activation::$instance->domain );
					$this->upgrader->strings['skin_before_update_header'] = __( 'Installing and Activating Plugin %1$s (%2$d/%3$d)', TGM_Plugin_Activation::$instance->domain );
				}
			
				else {
					$this->upgrader->strings['skin_upgrade_start']        = __( 'The installation process is starting. This process may take a while on some hosts, so please be patient.', TGM_Plugin_Activation::$instance->domain );
					$this->upgrader->strings['skin_update_failed_error']  = __( 'An error occurred while installing %1$s: <strong>%2$s</strong>.', TGM_Plugin_Activation::$instance->domain );
					$this->upgrader->strings['skin_update_failed']        = __( 'The installation of %1$s failed.', TGM_Plugin_Activation::$instance->domain );
					$this->upgrader->strings['skin_update_successful']    = __( '%1$s installed successfully.', TGM_Plugin_Activation::$instance->domain ) . ' <a onclick="%2$s" href="#" class="hide-if-no-js"><span>' . __( 'Show Details', TGM_Plugin_Activation::$instance->domain ) . '</span><span class="hidden">' . __( 'Hide Details', TGM_Plugin_Activation::$instance->domain ) . '</span>.</a>';
					$this->upgrader->strings['skin_upgrade_end']          = __( 'All installations have been completed.', TGM_Plugin_Activation::$instance->domain );
					$this->upgrader->strings['skin_before_update_header'] = __( 'Installing Plugin %1$s (%2$d/%3$d)', TGM_Plugin_Activation::$instance->domain );
				}

			}

			
			public function before( $title = '') {

				
				$this->in_loop = true;

				printf( '<h4>' . $this->upgrader->strings['skin_before_update_header'] . ' <img alt="" src="' . admin_url( 'images/wpspin_light.gif' ) . '" class="hidden waiting-' . $this->upgrader->update_current . '" style="vertical-align:middle;" /></h4>', $this->plugin_names[$this->i], $this->upgrader->update_current, $this->upgrader->update_count );
				echo '<script type="text/javascript">jQuery(\'.waiting-' . esc_js( $this->upgrader->update_current ) . '\').show();</script>';
				echo '<div class="update-messages hide-if-js" id="progress-' . esc_attr( $this->upgrader->update_current ) . '"><p>';

				/** Flush header output buffer */
				$this->before_flush_output();

			}

			
			public function after( $title = '' ) {

				
				echo '</p></div>';

				
				if ( $this->error || ! $this->result ) {
					if ( $this->error )
						echo '<div class="error"><p>' . sprintf( $this->upgrader->strings['skin_update_failed_error'], $this->plugin_names[$this->i], $this->error ) . '</p></div>';
					else
						echo '<div class="error"><p>' . sprintf( $this->upgrader->strings['skin_update_failed'], $this->plugin_names[$this->i] ) . '</p></div>';

					echo '<script type="text/javascript">jQuery(\'#progress-' . esc_js( $this->upgrader->update_current ) . '\').show();</script>';
				}

				
				if ( ! empty( $this->result ) && ! is_wp_error( $this->result ) ) {
					echo '<div class="updated"><p>' . sprintf( $this->upgrader->strings['skin_update_successful'], $this->plugin_names[$this->i], 'jQuery(\'#progress-' . esc_js( $this->upgrader->update_current ) . '\').toggle();jQuery(\'span\', this).toggle(); return false;' ) . '</p></div>';
					echo '<script type="text/javascript">jQuery(\'.waiting-' . esc_js( $this->upgrader->update_current ) . '\').hide();</script>';
				}

				
				$this->reset();
				$this->after_flush_output();

			}

			
			public function bulk_footer() {
				
				parent::bulk_footer();
				
				wp_cache_flush();

				
				$complete = array();
				foreach ( TGM_Plugin_Activation::$instance->plugins as $plugin ) {
					if ( ! is_plugin_active( $plugin['file_path'] ) ) {
						echo '<p><a href="' . add_query_arg( 'page', TGM_Plugin_Activation::$instance->menu, admin_url( TGM_Plugin_Activation::$instance->parent_url_slug ) ) . '" title="' . esc_attr( TGM_Plugin_Activation::$instance->strings['return'] ) . '" target="_parent">' . __( TGM_Plugin_Activation::$instance->strings['return'], TGM_Plugin_Activation::$instance->domain ) . '</a></p>';
						$complete[] = $plugin;
						break;
					}
					
					else {
						$complete[] = '';
					}
				}

				
				$complete = array_filter( $complete );

				
				if ( empty( $complete ) ) {
					echo '<p>' .  sprintf( TGM_Plugin_Activation::$instance->strings['complete'], '<a href="' . admin_url() . '" title="' . __( 'Return to the Dashboard', TGM_Plugin_Activation::$instance->domain ) . '">' . __( 'Return to the Dashboard', TGM_Plugin_Activation::$instance->domain ) . '</a>' ) . '</p>';
					echo '<style type="text/css">#adminmenu .wp-submenu li.current { display: none !important; }</style>';
				}

			}

			public function before_flush_output() {

				wp_ob_end_flush_all();
				flush();

			}
		
			public function after_flush_output() {

				wp_ob_end_flush_all();
				flush();
				$this->i++;

			}

		}
	}
}