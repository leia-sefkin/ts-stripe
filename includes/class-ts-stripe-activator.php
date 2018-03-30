<?php

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/leia-sefkin
 * @since      1.0.0
 *
 * @package    TS_Stripe
 * @subpackage TS_Stripe/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    TS_Stripe
 * @subpackage TS_Stripe/includes
 * @author     Leia Sefkin <leia.sefkin@gmail.com>
 */
class TS_Stripe_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		do_action( 'ts_stripe_activated' );
	}

}
