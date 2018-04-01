<?php

/**
 * Fired during plugin deactivation
 *
 * @since      1.0.0
 * @package    TS_Stripe
 * @subpackage TS_Stripe/includes
 * @author     Leia Sefkin <leia.sefkin@gmail.com>
 */
class TS_Stripe_Deactivator {

	/**
	 * Basic Deactivator
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		do_action( 'ts_stripe_deactivated' );
	}

}
