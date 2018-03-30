<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * @link       https://github.com/leia-sefkin
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