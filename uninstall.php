<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * @link       https://github.com/leia-sefkin/ts-stripe
 * @since      1.0.0
 *
 * @package    TS_Stripe
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

$options = get_option( 'ts-stripe' );

// check that settings exist before deleting
if ($options) {
	delete_option('ts-stripe');
}

//remove database tables
global $wpdb;
$table_name = $wpdb->prefix . 'ts_stripe';
$sql = "DROP TABLE IF EXISTS $table_name;";
$wpdb->query($sql);

