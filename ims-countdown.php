<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/amanwebexp/
 * @since             1.0.0
 * @package           Ims_Countdown
 *
 * @wordpress-plugin
 * Plugin Name:       IMS Countdown
 * Plugin URI:        https://wordpress.org/plugins/ims-countdown/
 * Description:       IMS countdown allows you to display a countdown on your post or page. It help you to stay user in your site..
 * Version:           1.3.8
 * Author:            Aman
 * Author URI:        https://github.com/amanwebexp/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ims-countdown
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'IMS_COUNTDOWN_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ims-countdown-activator.php
 */
function activate_ims_countdown() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ims-countdown-activator.php';
	Ims_Countdown_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ims-countdown-deactivator.php
 */
function deactivate_ims_countdown() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ims-countdown-deactivator.php';
	Ims_Countdown_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_ims_countdown' );
register_deactivation_hook( __FILE__, 'deactivate_ims_countdown' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ims-countdown.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_ims_countdown() {

	$plugin = new Ims_Countdown();
	$plugin->run();

}
run_ims_countdown();
