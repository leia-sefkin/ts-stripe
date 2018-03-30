<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://github.com/leia-sefkin
 * @since      1.0.0
 *
 * @package    TS_Stripe
 * @subpackage TS_Stripe/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    TS_Stripe
 * @subpackage TS_Stripe/includes
 * @author     Leia Sefkin <leia.sefkin@gmail.com>
 */
class TS_Stripe_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		do_action( 'ts_stripe_deactivated' );
	}

}
