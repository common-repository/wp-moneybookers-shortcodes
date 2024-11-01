=== WP Moneybookers Shortcodes ===
Contributors: webtux
Donate link: http://www.webtux.info/wordpress-plugins/
Tags: moneybookers, shortcode
Requires at least: 2.6
Tested up to: 3.1
Stable tag: 0.2

This plugin insert Moneybookers button (pages, posts), with shortcode or use class.

== Description ==

Add a moneybookers button (using shortcode) into your pages/posts
Edit the wp-content/plugins/wp-moneybookers-shortcodes/wp-moneybookers-shortcodes.php for configure the plugin.
Or use class for integration moneybookers into your page.

= Shortcode =
Insert the button in your pages or posts with this shortcode
`[moneybookersBtn production="true" amount="50" detail1_description="Product Identity:" detail1_text="T-Shirt Webtux"]`

= Integration moneybookers into your page =
Add this code to your template page.

`
$a = new WpMoneybookersShortcodes("contact@webtux.info");	// account moneybookers email
/*
// If you want custom your page : payment made, payment cancelled and process payment.
$a->setReturnUrl(get_bloginfo('template_url')."/moneybookers_payment_made.php");		// return page (url of the page is created for receipt of payment made) 
$a->setCancelUrl(get_bloginfo('template_url')."/moneybookers_payment_cancelled.php");	// cancel page (url of the page is created for receiving payment canceled)
$a->setStatusUrl(get_bloginfo('template_url')."/moneybookers_process_payment.php");		// status page (url of the page is created for receiving the payment process)
*/
$a->setProduction(true);						// false:test, true:production
$a->setLanguage("FR");							// location (ex: EN, DE, ES, FR, IT, ...)
$a->setCurrency("EUR");							// currency (ex: EUR or GBP or ...)
$a->setAmount(10);								// price product (ex: 39.60 or 39.6 or 39)
$a->setDetail1Description("Product ID: ");		// description (ex: Product ID:)
$a->setDetail1Text("T-Shirt Webtux");			// text (ex: T-Shirt Webtux)
echo $a->getMoneybookersBtn();					// show your moneybookers button
`

See the [Changelog](http://wordpress.org/extend/plugins/wp-moneybookers-shortcodes/changelog/) for what's new.

== Installation ==

1. Download the plugin Zip archive.
1. Upload 'wp-moneybookers-shortcodes' folder to your '/wp-content/plugins/' directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Edit wp-moneybookers-shortcodes.php and define your settings.

== Frequently Asked Questions ==

= how use the plugin =

With the shortcode "moneybookersBtn" into your pages/posts.
Ex: [moneybookersBtn production="true" amount="50" detail1_description="Product Identity:" detail1_text="T-Shirt Webtux"]
You can create multiple shortcode.

== Screenshots ==

1. Active the extension wordpress admin.
1. Page integration shortcode [more informations](http://wwww.webtux.info) French web agency.

== Changelog ==

= 0.2 =
* add class access for manage button into your file (ex: page.php)

= 0.1 =
* Original version released to wordpress.org repository

== Upgrade Notice ==

= 0.1 =
nothing

== Arbitrary section ==

[For information contact me](http://www.webtux.info)

= Usage =
[moneybookersBtn production="true" amount="50" detail1_description="Product Identity:" detail1_text="T-Shirt Webtux"]

= Moneybookers official manual =
[Official page](http://www.moneybookers.com/ads/paiement-en-ligne/centre-information/)
Integration manual [en](http://www.moneybookers.com/merchant/en/moneybookers_gateway_manual.pdf) [fr](http://www.moneybookers.com/merchant/fr/moneybookers_gateway_manual.pdf)
Handbook of automated payment interface [en](http://www.moneybookers.com/merchant/en/automated_payments_interface_manual.pdf) [fr](http://www.moneybookers.com/merchant/fr/automated_payments_interface_manual.pdf)