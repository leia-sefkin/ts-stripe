<?php

/**
 * TODO: should live keys be masked somehow? 
 * 
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/leia-sefkin
 * @since      1.0.0
 *
 * @package    TS_Stripe
 * @subpackage TS_Stripe/admin/partials
 */
?>

<div class="wrap">

    <h2><?php echo esc_html(get_admin_page_title()); ?></h2>

    <form method="post" name="stripe_settings" action="options.php">

    <?php
        //Grab all options
        $options = get_option($this->plugin_name);

        // Stripe Settings
        $test_mode = $options['test_mode'];
        $live_secret = $options['live_secret'];
        $live_publishable = $options['live_publishable'];
        $test_secret = $options['test_secret'];
        $test_publishable = $options['test_publishable'];
        $statement_descriptor = $options['statement_descriptor'];
    ?>

    <?php
        settings_fields($this->plugin_name);
        do_settings_sections($this->plugin_name);
    ?>


		<h2><?php esc_attr_e( 'API Keys', 'WpAdminStyle' ); ?></h2>

    	<table class="form-table">
			<tr valign="top">	
				<th scope="row"><?php esc_attr_e( 'Test Mode', 'WpAdminStyle' ); ?></th>
				<td>
					<input id="<?php echo $this->plugin_name; ?>-test_mode" name="<?php echo $this->plugin_name; ?>[test_mode]" type="checkbox" value="1" <?php checked( $test_mode, 1 ); ?> />
					<span class="description"><?php esc_attr_e( 'Check this to use the plugin in test mode.', 'WpAdminStyle' ); ?></span><br>
				</td>
			</tr>
		</table>

		<table class="form-table">
			<tr valign="top">	
				<th scope="row"><?php esc_attr_e( 'Test Secret', 'WpAdminStyle' ); ?></th>
				<td>
					<input id="<?php echo $this->plugin_name; ?>-test_secret" name="<?php echo $this->plugin_name; ?>[test_secret]" type="text" class="regular-text" maxlength="50" value="<?php if(!empty($test_secret)) echo $test_secret;?>"/><br>
					<span class="description"><?php esc_attr_e( 'Paste your test secret key here.', 'WpAdminStyle' ); ?></span><br>
				</td>
			</tr>
			<tr valign="top">	
				<th scope="row"><?php esc_attr_e( 'Test Publishable', 'WpAdminStyle' ); ?></th>
				<td>
					<input id="<?php echo $this->plugin_name; ?>-test_publishable" name="<?php echo $this->plugin_name; ?>[test_publishable]" type="text" class="regular-text" maxlength="50" value="<?php if(!empty($test_publishable)) echo $test_publishable;?>"/><br>
					<span class="description"><?php esc_attr_e( 'Paste your test publishable key here.', 'WpAdminStyle' ); ?></span><br>
				</td>
			</tr>

			<tr valign="top">	
				<th scope="row"><?php esc_attr_e( 'Live Secret', 'WpAdminStyle' ); ?></th>
				<td>
					<input id="<?php echo $this->plugin_name; ?>-live_secret" name="<?php echo $this->plugin_name; ?>[live_secret]" type="text" class="regular-text" maxlength="50" value="<?php if(!empty($live_secret)) echo $live_secret;?>"/><br>
					<span class="description"><?php esc_attr_e( 'Paste your live secret key here.', 'WpAdminStyle' ); ?></span><br>
				</td>
			</tr>
			<tr valign="top">	
				<th scope="row"><?php esc_attr_e( 'Live Publishable', 'WpAdminStyle' ); ?></th>
				<td>
					<input id="<?php echo $this->plugin_name; ?>-live_publishable" name="<?php echo $this->plugin_name; ?>[live_publishable]" type="text" class="regular-text" maxlength="50" value="<?php if(!empty($live_publishable)) echo $live_publishable;?>"/><br>
					<span class="description"><?php esc_attr_e( 'Paste your live publishable key here.', 'WpAdminStyle' ); ?></span><br>
				</td>
			</tr>
		</table>

		<h2><?php esc_attr_e( 'Other Settings', 'WpAdminStyle' ); ?></h2>
		
		<table class="form-table">
			<tr valign="top">	
				<th scope="row"><?php esc_attr_e( 'Description for Donor Receipts', 'WpAdminStyle' ); ?></th>
				<td>
					<input id="<?php echo $this->plugin_name; ?>-statement_descriptor" name="<?php echo $this->plugin_name; ?>[statement_descriptor]" type="text" class="regular-text" maxlength="50" value="<?php if(!empty($statement_descriptor)) echo $statement_descriptor;?>"/><br>
					<span class="description"><?php esc_attr_e( 'Enter the description as you would like it to appear on donor receipts.', 'WpAdminStyle' ); ?></span><br>
				</td>
			</tr>
		</table>

        <?php submit_button('Save all changes', 'primary','submit', TRUE); ?>

    </form>

</div>