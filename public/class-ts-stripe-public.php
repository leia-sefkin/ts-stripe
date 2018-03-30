<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/leia-sefkin
 * @since      1.0.0
 *
 * @package    TS_Stripe
 * @subpackage TS_Stripe/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * @package    TS_Stripe
 * @subpackage TS_Stripe/public
 * @author     Leia Sefkin <leia.sefkin@gmail.com>
 */
class TS_Stripe_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since      1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->ts_stripe_options = get_option($this->plugin_name);

		//TODO - shortcodes or another method to load? doesn't quite flow with rest of structure
		/**
		 * So we can use shortcodes to add forms
		 */
		require_once plugin_dir_path( dirname( __FILE__) ) . 'includes/shortcodes.php';
		$this->ts_stripe_shortcodes = new Shortcodes();

		// load the stripe libraries
		require_once plugin_dir_path( dirname( __FILE__) ) . '/vendor/stripe-php/init.php';
	}

	/**
	 * Process Stripe Payments
	 *
	 * @since    1.0.0
	 */
	public function ts_stripe_process_payment() {
		if(isset($_POST['action']) && $_POST['action'] == 'stripe' && wp_verify_nonce($_POST['stripe_nonce'], 'stripe-nonce')) {
 
			// retrieve the token generated by stripe.js
			$token = $_POST['stripe_token'];
	 
			// check if we are using test mode
			if(isset($this->ts_stripe_options['test_mode']) && $this->ts_stripe_options['test_mode']) {
				$secret_key = $this->ts_stripe_options['test_secret'];
			} else {
				$secret_key = $this->ts_stripe_options['live_secret'];
			}

			// convert amont to cents
			if(isset($_POST['donation_amount'])) {
				$amount = $_POST['donation_amount'] * 100;
	 
				// attempt to charge the customer's card
				try {
					\Stripe\Stripe::setApiKey($secret_key);
					$charge = \Stripe\Charge::create(array(
							'amount' => $amount, 
							'currency' => 'usd',
							'card' => $token,
							// what appears on customer's account
  							'statement_descriptor' => $this->ts_stripe_options['statement_descriptor']
						)
					);
	 
					// redirect on successful payment
					$redirect = add_query_arg('payment', 'paid', $_POST['redirect']);
	 
				} catch (Exception $e) {
					// redirect on failed payment
					$redirect = add_query_arg('payment', 'failed', $_POST['redirect']);
				}
			}

			else {
				$redirect = add_query_arg('payment', 'failed', $_POST['redirect']);
			}
	 
			// redirect back to our previous page with the added query variable
			wp_redirect($redirect); 
			exit;
		}
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ts-stripe-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		// check to see if we are in test mode
		if(isset($this->ts_stripe_options['test_mode']) && $this->ts_stripe_options['test_mode']) {
			$publishable = $this->ts_stripe_options['test_publishable'];
		} 

		else {
			$publishable = $this->ts_stripe_options['live_publishable'];
		}

		//TODO handle case where publishable isn't set 
		wp_enqueue_script('stripe-processing', 'https://js.stripe.com/v3/');
		wp_localize_script('stripe-processing', 'stripe_vars', array('publishable_key' => $publishable));
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ts-stripe-public.js', array( 'jquery' ), $this->version, false );

	}


}
