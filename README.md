TS Stripe
======
Contributors: Leia Sefkin

Requires at least: 1.0

Tested up to: 1.0

License: GPLv2 or later

License URI: http://www.gnu.org/licenses/gpl-2.0.html

Stripe WordPress plugin

Installation
======

**In order for this plugin to work properly, you must have a [Stripe account](https://dashboard.stripe.com/register) setup first.**

1. Upload `ts-stripe` to the `/wp-content/plugins/` directory

2. Activate the plugin through the 'Plugins' menu in WordPress

3. Go to the Stripe settings menu via the WordPress admin dashboard and enter in your API Keys.

   This plugin operates in two modes - test and live. To operate in test mode, check the "Test Mode" box on the settings page and enter in your test API Keys (found on the Stripe Dashboard). Stripe Offers a variety of test cards and codes to test transaction success and failures. If you wish to try these for yourself you can find those card numbers in the [Stripe documentation](https://stripe.com/docs/testing).  
   
   In this menu you can also configure the following:
   
   * Satement Description - the description of the transaction as it shows up on customer's receipts. If nothing is entered it will remain blank.
   * Minimum Amount - the minimum transaction amount. 

4. Place the shortcode `[ts-stripe-payment-form]` in your post or page, and you're all set!

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


### General Repository Structure

`/admin` - All code related to managing the WordPress admin page for this plugin. Here is where you will find the code for rendering the page which allows for the setting API keys and other configurations.

`/assets` - Assets for this repository

`/includes` - General classes used throughout the plugin. Including the main ts-stripe class, the activator/deactivator, loader and shortcodes.

`/public` - All code related to the public facing portions of this plugin. Here is where you will find the code for processing payments, and for rendering the checkout page. 

`/vendor` - All vendor related code. This is where the Stripe php libraries live. 

Screenshots
======
<img src="https://raw.githubusercontent.com/leia-sefkin/ts-stripe/master/assets/ts-stripe-preview.png" width="600px">



