<?php

/**
 * Core Shortcodes Class
 *
 * Register and handle custom shortcodes.
 */
class Shortcodes {

	/**
	 * Constructor
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		// Add shortcodes.
		add_action( 'init', array( $this, 'register_shortcodes' ) );
	}

	/**
	 * Register shortcodes.
	 *
	 * @since    1.0.0
	 */
	public function register_shortcodes() {

		add_shortcode( 'ts-stripe-payment-form', array( $this, 'payment_form_setup_page' ) );
		do_action( 'ts-stripe_add_shortcodes' );
	}


	/**
	 * Render the payment form.
	 *
	 * @since    1.0.0
	 */
	public function payment_form_setup_page() {
	    include_once plugin_dir_path( __DIR__ ) . 'public/partials/ts-stripe-public-display.php';
	}

}
