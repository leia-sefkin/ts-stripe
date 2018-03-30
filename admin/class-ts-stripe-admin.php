<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/leia-sefkin
 * @since      1.0.0
 *
 * @package    TS_Stripe
 * @subpackage TS_Stripe/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    TS_Stripe
 * @subpackage TS_Stripe/admin
 * @author     Leia Sefkin <leia.sefkin@gmail.com>
 */
class TS_Stripe_Admin {

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
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ts-stripe-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ts-stripe-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {

	    /**
	     * Add a settings page for this plugin to the Settings menu.
	     *
	     */
	    add_options_page( 'Stripe Settings', 'Stripe Settings', 'manage_options', $this->plugin_name, array( $this, 'display_plugin_setup_page' ) );
	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */
	public function add_action_links( $links ) {

	   $settings_link = array(
	    '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',
	   );
	   return array_merge( $settings_link, $links );

	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_setup_page() {
	    include_once( 'partials/ts-stripe-admin-display.php' );
	}

	/**
	 * Register settings 
	 *
	 * @since    1.0.0
	 */
	public function options_update() {
    	register_setting($this->plugin_name, $this->plugin_name, array($this, 'validate'));
 	}

 	/**
 	 * Limit input length
 	 * 
 	 * @since    1.0.0
	 */
 	private function limit_input_length($input, $limit) {
 		if ( strlen ($input) > $limit) {
 			$input = substr($input, 0, $limit);
 		}

 		return $input;
 	}

	/**
	 * Validate inputs on settings page
	 *
	 * @since    1.0.0
	 */
	public function validate($input) {
	    // All inputs        
	    $valid = array();

	    $valid['test_mode'] = (isset($input['test_mode']) && !empty($input['test_mode'])) ? 1 : 0;

	    //limiting length of inputs here manually in addition to front end
	    $valid['live_secret'] = $this->limit_input_length($input['live_secret'], 50);
	    $valid['live_publishable']= $this->limit_input_length($input['live_publishable'], 50);
	    $valid['test_secret'] = $this->limit_input_length($input['test_secret'], 50);
	    $valid['test_publishable'] = $this->limit_input_length($input['test_publishable'], 50);
	    $valid['statement_descriptor'] = $this->limit_input_length($input['statement_descriptor'], 50);

	    return $valid;
 	}

}
