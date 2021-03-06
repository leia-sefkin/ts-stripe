<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @since      1.0.0 *
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
	 * Attempts to create a charge with stripe using token data as passed in from the form. On result passes data to be stored in local DB and redirects appropriately (to failed or success page).
	 *
	 * @since    1.0.0
	 */
	public function ts_stripe_process_payment() {
		if(isset($_POST['action']) && $_POST['action'] == 'stripe' && wp_verify_nonce($_POST['stripe_nonce'], 'stripe-nonce')) {
 
			// data we'll be using in the charge call and storing
			$token = $_POST['stripe_token'];
			$last4 = $_POST['stripe_card_last4'];
			$name = $_POST['card_name'];
			$email = $_POST['donor_email'];
			//convert amount to cents
			$amount = $_POST['donation_amount'] * 100;

			// charge array passed to stripe
			$charge = array(
				'amount' => $amount,
				'currency' => 'usd',
				'card' => $token,
				'description' => $email
			);

			$options = $this->ts_stripe_options;

			// getting a descriptor if we have it
			if(isset($options['statement_descriptor']) && $options['statement_descriptor'] != '') {
				$charge['statement_descriptor'] = $options['statement_descriptor'];
			}

			// check if we are using test mode
			if(isset($options['test_mode']) && $options['test_mode']) {
				$secret_key = $options['test_secret'];
			} else {
				$secret_key = $options['live_secret'];
			}

			// attempt to charge the customer's card
			try {
				\Stripe\Stripe::setApiKey($secret_key);
				\Stripe\Charge::create($charge);

				// for database record 
				$success = 1;
				$message = 'successful payment';
				// redirect on successful payment
				$redirect = add_query_arg('payment', 'paid', $_POST['redirect']);
	 
			} catch (Exception $e) {
				// save error details for database record
    			$success = 0;
    			$message = $e->getMessage();

    			// redirect on failed payment
    			$redirect = add_query_arg('payment', 'failed', $_POST['redirect']);
    		}

    		//save record in the database 
    		self::ts_stripe_save_data(array(
				'name' => $name,
				'last4' => $last4,
				'amount' => $amount,
				'email' => $email,
				'success' => $success,
				'message' => $message
			));
	 
			// redirect back to our previous page with the added query variable
			wp_redirect($redirect); 
			exit;
		}
	}

	/**
	 * Store record in the database
	 *
	 * @since    1.0.0
	 *
	 * @param    array        $data    An array of data to be insterted into the database. Should contain the following fields:
	 * 
	 * name: varchar(255)
	 * last4: int(5)
	 * amount: int(10)
	 * email: varchar(255)
	 * success: tinyint(1)
	 * message: varchar(255)
	 *
	 * @return   boolean/int  $result  Result of insert to WPDB - false if it failed, otherwise number of rows affected (which will always be 1)
	 */
	public function ts_stripe_save_data($data) {
		// save donor name, card last4, donation amount, donor email
		// whether payment was successful or not
		global $wpdb;

		if ( empty( $data ) ) {
			return false;
		}

		$result = $wpdb->insert( "{$wpdb->prefix}ts_stripe", $data );
		return $result;
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

		wp_enqueue_script('stripe-processing', 'https://js.stripe.com/v3/');
		wp_localize_script('stripe-processing', 'stripe_vars', array('publishable_key' => $publishable,
			'minimum_amount' => $this->ts_stripe_options['minimum_amount']
		));


		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ts-stripe-public.js', array( 'jquery' ), $this->version, false );

	}


}
