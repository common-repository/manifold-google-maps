<?php

/**
 * The plugin main file
 *
 *
 * @link              https://www.itpathsolutions.com/
 * @since             1.0.0
 * @package           Manifold_Google_Maps
 *
 * @wordpress-plugin
 * Plugin Name:       Manifold Google Maps
 * Plugin URI:        https://wordpress.org/plugins/manifold-google-maps/
 * Description:       The most effortless, valuable and effective google map plugin! Effectively make a boundless number of Google Maps and markers.
 * Version:           1.3
 * Author:            IT Path Solutions
 * Author URI:        https://www.itpathsolutions.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       manifold-google-maps
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
define( 'MANIFOLD_GOOGLE_MAPS_VERSION', '1.3' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-manifold-google-maps-activator.php
 */
function activate_manifold_google_maps() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-manifold-google-maps-activator.php';
	Manifold_Google_Maps_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-manifold-google-maps-deactivator.php
 */
function deactivate_manifold_google_maps() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-manifold-google-maps-deactivator.php';
	Manifold_Google_Maps_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_manifold_google_maps' );
register_deactivation_hook( __FILE__, 'deactivate_manifold_google_maps' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-manifold-google-maps.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_manifold_google_maps() {

	$plugin = new Manifold_Google_Maps();
	$plugin->run();

}
run_manifold_google_maps();
