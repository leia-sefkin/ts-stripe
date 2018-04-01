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
	 * Basic activation
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		self::ts_stripe_db_install();
		do_action( 'ts_stripe_activated' );
	}


	/**
	 * Create database tables.
	 * These store basic information around donations.
	 * Time donation was made, name, email, amount, card last 4.
	 * 
	 * @since    1.0.0
	 */
	public static function ts_stripe_db_install() {
		global $wpdb;
		global $ts_stripe_db_version;

		$ts_stripe_install = '1.0';
		$table_name = $wpdb->prefix . 'ts_stripe';
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE IF NOT EXISTS $table_name (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
		  time datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
		  name varchar(255) DEFAULT '' NOT NULL,
		  email varchar(255) DEFAULT '' NOT NULL,
		  last4 int(5) NOT NULL,
		  amount int(10) NOT NULL,
		  PRIMARY KEY  (id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		// TODO: remove this 
		echo $wpdb->last_error;

		add_option( 'ts_stripe_db_version', $ts_stripe_db_version );

	}

}
