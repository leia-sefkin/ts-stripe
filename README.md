TS Stripe
======
Contributors: Leia Sefkin

Donate link: https://github.com/leia-sefkin

Requires at least: 1.0

Tested up to: 1.0

License: GPLv2 or later

License URI: http://www.gnu.org/licenses/gpl-2.0.html

Stripe plugin integration for WordPress

Installation
======

In order for this plugin to work properly, you must have a [Stripe account setup](https://dashboard.stripe.com/register).

1. Upload `ts-stripe` to the `/wp-content/plugins/` directory

2. Activate the plugin through the 'Plugins' menu in WordPress

3. Go to the Stripe settings menu via the WordPress admin dashboard and enter in your API Keys.

   This plugin operates in two modes - test and live. To operate in test mode, check the "Test Mode" box on the settings page and enter in your test API Keys (found on the Stripe Dashboard).Stripe Offers a variety of test cards and codes to test transaction success and failures. If you wish to try these for yourself you can find those card numbers in the [Stripe documentation](https://stripe.com/docs/testing). 

   You can also configure the description that will show up on donor's receipts. If nothing is entered it will remain blank.

   Additionally if you choose to do so, you can set a minimum amount for donations here.

4. Place the shortcode [ts-stripe-payment-form] in your post or page, and you're all set!

Other Notes
======
This plugin creates a new table named wp_ts_stripe in the WordPress database, where it saves basic data about the transaction. This includes the following: 

* Donor name
* Donor email
* The last 4 digits of the card used in the transaction
* The amount of the donation
* Whether the charge was successful
* If the charge was unsuccessful - details about what went wrong (the error as it comes from Stripe). 

On uninstall all data will be removed - including this table. If you wish to preserve this data please make a copy before uninstalling. 

Screenshots
======
![TS Stripe Preview](https://raw.githubusercontent.com/leia-sefkin/ts-stripe/master/assets/ts-stripe-preview.png | width=600)
