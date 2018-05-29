<?php
/**
 * @package GT Custom Post Types
 */
/*
 * Plugin Name:       GT Custom Post Types
 * Plugin URI:        http://grizzlybeardesign.co.uk/plugin
 * Description:       A simple plugin to create custom post types for Grizzly Themes framework
 * Version:           1.0.0
 * Author:            Grizzly Bear Design
 * Author URI:        http://grizzlybeardesign.co.uk/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       gt_cpt 
* Domain Path:       /languages
 * 
 * @link              http://grizzlybeardesign.co.uk/
 * @since             1.0.0
 * @package           GT_CPT
 */
/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2005-2015 Automattic, Inc.
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

define( 'GT_CPT_VERSION', '1.0.0' );
define( 'GT_CPT__MINIMUM_WP_VERSION', '4.0' );
define( 'GT_CPT__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'GT_DELETE_LIMIT', 100000 );
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-gbd-cust-activator.php
 */
register_activation_hook( __FILE__, array( 'GT_CPT', 'plugin_activation' ) );
register_deactivation_hook( __FILE__, array( 'GT_CPT', 'plugin_deactivation' ) );

require_once( GT_CPT__PLUGIN_DIR . 'class-gt-cpt.php' );
//echo constant(GT_CPT_PLUGIN_DIR);

add_action( 'init', array( 'GT_CPT', 'init' ) );

if ( is_admin()) {
	require_once( GT_CPT__PLUGIN_DIR . 'class-gt-cpt-admin.php' );
	add_action( 'init', array( 'GT_CPT_Admin', 'init' ) );
}