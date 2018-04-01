=== Plugin Name ===
Contributors: Leia Sefkin
Donate link: https://github.com/leia-sefkin
Requires at least: 1.0
Tested up to: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Stripe plugin integration for WordPress

== Installation ==

In order for this plugin to work properly, you must have Stripe account setup. To do so you can visit: https://dashboard.stripe.com/register

1. Upload `ts-stripe` to the `/wp-content/plugins/` directory

2. Activate the plugin through the 'Plugins' menu in WordPress

3. Go to the Stripe settings menu via the WordPress admin dashboard and enter in your API Keys. 

This plugin operates in two modes - test and live. To operate in test mode, check the "Test Mode" box on the settings page and enter in your test API Keys (found on the Stripe Dashboard).

Stripe Offers a variety of test cards and codes to test transaction success and failures. If you wish to try these for yourself you can find those card numbers in the Stripe documentation here: https://stripe.com/docs/testing

You can also configure the description that will show up on customer's receipts here. If nothing is entered it will remain blank.

Additionally if you choose to do so, you can set a minimum amount for donations here.

4. Place the shortcode [ts-stripe-payment-form] in your templates, and you're set!

== Screenshots ==

![alt text][preview]

[preview]: https://github.com/leia-sefkin/ts-stripe/blob/master/assets/ts-stripe-preview.png "TS Stripe Plugin Preview"
