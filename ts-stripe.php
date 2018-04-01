<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/leia-sefkin/ts-stripe
 * @since             1.0.0
 * @package           TS_Stripe
 *
 * @wordpress-plugin
 * Plugin Name:       ThinkShout Stripe
 * Plugin URI:        https://github.com/leia-sefkin/ts-stripe
 * Description:       A custom Stripe plugin for WordPress
 * Version:           1.0.0
 * Author:            Leia Sefkin
 * Author URI:        https://github.com/leia-sefkin
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ts-stripe
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Current plugin version.
 */
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ts-stripe-activator.php
 */
function activate_ts_stripe() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ts-stripe-activator.php';
	TS_Stripe_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ts-stripe-deactivator.php
 */
function deactivate_ts_stripe() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ts-stripe-deactivator.php';
	TS_Stripe_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_ts_stripe' );
register_deactivation_hook( __FILE__, 'deactivate_ts_stripe' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ts-stripe.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_ts_stripe() {

	$plugin = new TS_Stripe();
	$plugin->run();

}
run_ts_stripe();
