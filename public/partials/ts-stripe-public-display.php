<?php

/**
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://github.com/leia-sefkin
 * @since      1.0.0
 *
 * @package    TS_Stripe
 * @subpackage TS_Stripe/public/partials
 */

	if(isset($_GET['payment']) && $_GET['payment'] == 'paid') {
		echo '<p class="success">' . __('Thank you for your generous donation!', 'thinkshout_stripe') . '</p>';
	}

	if(isset($_GET['payment']) && $_GET['payment'] == 'failed') {
		echo '<p class="failed">' . __('Something went wrong with your payment. Please check that all of your information is correct and try again. If you continue to experinece issues please contact the site administrator.', 'thinkshout_stripe') . '</p>';
	} ?>

		<form action="" method="post" id="stripe_payment_form">
			<div class="form-row">
		  		<label>
              		<span><?php esc_attr_e( 'Name' ) ?></span>
              		<input type="text" id="card_name", name="card_name" class="regular-text" required />
            	</label>
            </div>
            <div>
            	<label>
              		<span><?php esc_attr_e( 'Email' )?></span>
              		<input id="donor_email" name="donor_email" type="email" class="regular-text" required />
              		<!-- Errors related to email entered are displayed here. -->
              		<div id="email_error"></div>
            	</label>
            </div>
            <div class="form-row">
		  		<label>
              		<span><?php esc_attr_e( 'Donation Amount' )?></span>
              		<div class="flex">
	              		<span class="currency"><?php esc_attr_e( '$' )?></span>
	            		<input id="amount" name="donation_amount" class="amount" type="number" step="0.01" required/>
	            	</div>
	            	<!-- Errors related to amount entered are displayed here. -->
	            	<div id="amount_error"></div>
            	</label>
            </div>
            <div class="form-row">
			    <label for="card_element">
			      <?php esc_attr_e( 'Credit or Debit Card' )?>
			    
				    <div class="ts_stripe_card" id="card_element">
				      <!-- A Stripe Element will be inserted here. -->
				    </div>

				    <!-- Used to display form errors. -->
				    <div id="card_errors" role="alert"></div>
				</label>
			</div>
		  
			<input type="hidden" name="action" value="stripe"/>
			<input type="hidden" name="redirect" value="<?php echo get_permalink(); ?>"/>
			<input type="hidden" name="stripe_nonce" value="<?php echo wp_create_nonce('stripe-nonce'); ?>"/>
			<button type="submit" id="stripe_donate"><?php esc_attr_e( 'Donate' )?></button>
		</form>