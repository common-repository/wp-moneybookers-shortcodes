<?php
/*
Plugin Name: WP Moneybookers Shortcodes
Plugin URI: http://www.webtux.info/wordpress-plugins/
Description: Add moneybookers button with shortcodes.
Version: 0.2
Author: Michael DUMONTET
Author URI: http://www.webtux.info/wordpress-plugins/wp-moneybooekers-shortcodes

Copyright 2011  Michael DUMONTET  (email : contact@webtux.info)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// SOURCE : aide pour realiser un plugin wordpress http://codex.wordpress.org/Writing_a_Plugin



// For not use include_once, require_once
// autoload (function of langage PHP). ex: new Xxx(); -> call classes/Xxx.php
function __autoload( $nom_de_classe){
	require_once ("classes/".$nom_de_classe.".php");
}
//$a = new WpMoneybookersShortcodes();






// Gestion lang (dossier lang dans le plugin, contenant les .mo)
load_plugin_textdomain("wp-moneybookers-shortcodes", false, dirname( plugin_basename( __FILE__ ) ) . '/lang');



// Config plugin :
// REQUIRED FIELD
define("MONEYBOOKERS_EMAIL_MERCHANT",			"contact@webtux.info");											// merchant email account moneybookers
define("MONEYBOOKERS_DETAIL1_DESCRIPTION",		"Product :");													// description (has managed in the shortcode)
define("MONEYBOOKERS_DETAIL1_TEXT",				"T-Shirt");														// text (has managed in the shortcode)
// OPTIONAL ( but important ;) )
define( "MONEYBOOKERS_URL_PLUGINS",				home_url('/')."wp-content/plugins/".dirname(plugin_basename( __FILE__ )) );
define("MONEYBOOKERS_RECIPIENT_DESCRIPTION",	"CompanyName");													// CompanyName
define("MONEYBOOKERS_LOGO_URL",					get_bloginfo('template_url')."/images/logo-moneybookers.jpg");	// logo url
define("MONEYBOOKERS_PAGE_RETURN",				MONEYBOOKERS_URL_PLUGINS."/payment_made.php");				// return page (url of the page is created for receipt of payment made)
define("MONEYBOOKERS_PAGE_CANCEL",				MONEYBOOKERS_URL_PLUGINS."/payment_cancelled.php");			// cancel page (url of the page is created for receiving payment canceled)
define("MONEYBOOKERS_PAGE_STATUS",				MONEYBOOKERS_URL_PLUGINS."/process_payment.php");			// status page (url of the page is created for receiving the payment process)



// Shortcodes : add button moneybookers
function getMoneybookersBtn( $atts='' ){
	
	//echo $obj_a = new WpMoneybookersShortcodes();
	
	// recup valeur autorisée par le shortcode
	extract( shortcode_atts(array(
		"production"			=> "false",									// true : production, false : test phase (=sandbox) 
	
		// MERCHANT DETAILS
		"pay_to_email"			=> MONEYBOOKERS_EMAIL_MERCHANT,				// REQUIRED FIELD. merchant email (ex: merchant@moneybookers.com)
		"recipient_description"	=> MONEYBOOKERS_RECIPIENT_DESCRIPTION,		// A description of the Merchant, which will be shown on the gateway. If no value is submitted, the pay_to_email value will be shown as the recipient of the payment. (Max 30 characters)
//		"transaction_id"		=> "A205220",								// Reference or identification number provided by the Merchant. MUST be unique for each payment (Max 32 characters) (ex: A205220)
		"return_url"			=> MONEYBOOKERS_PAGE_RETURN,				// URL to which the customer will be returned when the payment is made. If this field is not filled, the gateway window will simply close automatically at the end of the transaction, so that the customer will be returned to the last page on the Merchant's website where he has been before. A secure return_url functionality is available. Please see section 3.5. (ex: http://www.mySite.com/payment_made.php)
//		"return_url_text"		=> "Return to Sample Merchant",				// The text on the button when the user finishes his payment.
//		"return_url_target"		=> "1",										// Specifies a target in which the return_url value will be called upon successful payment from customer. Default value is 1. 1 = '_top' 2 = '_parent' 3 = '_self' 4= '_blank'
		"cancel_url"			=> MONEYBOOKERS_PAGE_CANCEL,				// URL to which the customer will be returned if the payment process is cancelled. If this field is not filled, the gateway window will simply close automatically upon clicking the cancellation button, so the customer will be returned to the last page on the Merchant's website where the customer has been before. (ex: http://www.mySite.com/payment_cancelled.php)
//		"cancel_url_target"		=> "1",										// Specifies a target in which the cancel_url value will be called upon cancellation of payment from customer. Default value is 1. 1 = '_top' 2 = '_parent' 3 = '_self' 4= '_blank'
		"status_url"			=> MONEYBOOKERS_PAGE_STATUS,				// URL to which the transaction details will be posted after the payment process is complete. Alternatively, you may specify an email address to which you would like to receive the results. If the status_url is omitted, no transaction details will be sent to the Merchant. (ex: https://www.merchant.com/process_payment.cgi or merchant@merchant.com)
//		"status_url2"			=> MONEYBOOKERS_PAGE_STATUS,				// Second URL to which the transaction details will be posted after the payment process is complete. Alternatively you may specify an email address to which you would like to receive the results. (ex: https://www.merchant.com/process_payment.cgi or merchant2@merchant.com)
//		"new_window_redirect"	=> 1,										// Merchants can choose to redirect customers to the Sofortueberweisung payment method in a new window instead of in the same window. The accepted values are 0(default) and 1.
		"language"				=> "FR",									// REQUIRED FIELD. 2-letter code of the language used for Moneybookers' pages. Can be any of EN, DE, ES, FR, IT, PL, GR RO, RU, TR, CN, CZ, NL, DA, SV or FI. (ex: EN or FR)
//		"hide_login"			=> "1",										// Merchants can show their customers the gateway page without the prominent login section. See 3.10 for more detailed explanation. (ex: 1)
		"confirmation_note"		=> __("Samplemerchant wishes you pleasure reading your new book!", "wp-moneybookers-shortcodes"),	// Merchant may show to the customer on the confirmation screen - the end step of the process - a note, confirmation number, PIN or any other message. Line breaks <br> may be used for longer messages. (ex: Samplemerchant wishes you pleasure reading your new book!)
		"logo_url"				=> MONEYBOOKERS_LOGO_URL, // The URL of the logo which you would like to appear at the top of the gateway. The logo must be accessible via HTTPS otherwise it will not be shown. For best integration results we recommend that Merchants use logos with dimensions up to 200px in width and 50px in height. (ex: https://www.merchant.com/logo.jpeg)
//		"prepare_only"			=> "1",										// Forces only SID to be returned without actual page. Useful when using alternative ways to redirect the customer to the gateway. See 2.3.2 for a more detailed explanation. Accepted values are 1 and 0. (ex: 1)
//		"rid"					=> "123456",								// Merchants can pass the unique referral ID or email of the affiliate from which the customer is referred. The rid value must be included within the actual payment request. (ex: 123456)
//		"ext_ref_id"			=> "AffiliateName",							// Merchants can pass additional identifier in this field in order to track affiliates. You MUST inform your account manager about	 the exact value that will be submitted so that affiliates can be tracked
//		"merchant_fields"		=> "customer_number, session_id",			// A comma-separated list of field names that should be passed back to the Merchant's server when the payment is confirmed at moneybookers.com (maximum 5 fields). (ex: Field1, Field2 or customer_number, session_id)
//		"field_1"				=> "Value 1",								// An example merchant field (ex: Value 1)
//		"field_2"				=> "Value 2",								// An example merchant field (ex: Value 1)
//		"customer_number"		=> "C1234",									// An example merchant field (ex: C1234)
//		"session_ID"			=> "A3DFA2234",								// An example merchant field (ex: A3DFA2234)

		// CUSTOMER DETAILS
//		"pay_from_email"		=> "payer@moneybookers.com",				// Email address of the customer who is making the payment. If left empty, the customer has to enter his email address himself. (ex: payer@moneybookers.com)
//		"title"					=> "Mr",									// Customer‟s title. Accepted values: Mr, Mrs or Ms (ex: Mr)
//		"firstname"				=> "John",									// Customer‟s first name (ex: John)
//		"lastname"				=> "PAYER",									// Customer‟s last name (ex: PAYER)
//		"date_of_birth"			=> "01121980",								// Date of birth of the customer. The format is ddmmyyyy. Only numeric values are	No	8 accepted (ex: 01121980)
//		"address"				=> "Payerstreet",							// Customer‟s address (e.g. street) (ex: Payerstreet)
//		"address2"				=> "Payertown",								// Customer‟s address (e.g. town) (ex: Payerstreet)
//		"phone_number"			=> "0207123456",							// Customer‟s phone number. Only numeric values are accepted (ex: 0207123456)
//		"postal_code"			=> "EC45MQ",								// Payer postal code (ex: EC45MQ)
//		"city"					=> "London",								// Customer‟s city (ex: Payertown)
//		"state"					=> "Central London",						// Customer‟s state or region. (ex: Central London
//		"country"				=> "FRA",									// Customer‟s country in the 3-digit ISO Code (see Annex II for a list of allowed codes). (ex: GBR)
		
		// PAYMENT DETAILS
		"amount"				=> "10.50",									// price product (ex: 39.60 or 39.6 or 39)
		"currency"				=> "EUR",									// 3-letter code of the currency of the amount according to ISO 4217 (see Annex I for accepted currencies) (ex: GBP)
//		"amount2_description"	=> "Product Price:",						// Merchant may specify a detailed calculation for the total amount payable. Please note that Moneybookers does not check the validity of these data - they are only displayed in the ‟More information‟ section in the header of the gateway. (ex: Product Price:)
//		"amount2"				=> "29.90",									// This amount in the currency defined in field 'currency' will be shown next to amount2_description. (ex: 29.90)
//		"amount3_description"	=> "Handling Fees & Charges:",				// See above (ex: Handling Fees & Charges:)
//		"amount3"				=> "3.10",									// See above (ex: 3.10)
//		"amount4_description"	=> "VAT (20%)",								// See above (ex: VAT (20%))
//		"amount4"				=> "6.60",									// See above (ex: 6.60)
		"detail1_description"	=> MONEYBOOKERS_DETAIL1_DESCRIPTION,		// REQUIRED FIELD. Merchant may show up to 5 details about the product or transfer in the ‟More information‟ section in the header of the gateway. (ex: "Product ID:")
		"detail1_text"			=> MONEYBOOKERS_DETAIL1_TEXT,				// REQUIRED FIELD. The detailX_text is shown next to the detailX_description. The detail1_text is also shown to the client in his history at Moneybookers‟ website. (ex: 4509334)
//		"detail2_description"	=> "Description:",							// 2nd description (ex: "Description:")
//		"detail2_text"			=> "Romeo and Juliet (W. Shakespeare)",		// 2nd text (ex: Romeo and Juliet (W. Shakespeare))
//		"detail3_description"	=> "Special Conditions:",					// 3th description (ex: "Special Conditions:")
//		"detail3_text"			=> "5-6 days for delivery",					// 3th text (ex: 5-6 days for delivery)
//		"detail4_description"	=> "Special Conditions:",					// 4me description (ex: "Special Conditions:")
//		"detail4_text"			=> "5-6 days for delivery",					// 4me text (ex: 5-6 days for delivery)
//		"detail5_description"	=> "Special Conditions:",					// 5me description (ex: "Special Conditions:")
//		"detail5_text"			=> "5-6 days for delivery"					// 5me text (ex: 5-6 days for delivery)

	), $atts ));
	/*$id = (int)$id;
	if( $id == 0 ){
		return '';
	}//fin if*/
	
	// State : production or Test
	if( $production == "false" ){	$urlMoneybookers = "http://www.moneybookers.com/app/test_payment.pl."; }
	else{							$urlMoneybookers = "https://www.moneybookers.com/app/payment.pl"; }

	// START - button moneybookers
	?>
	<!--
	<?php // METHOD 1 : simple form ?>
	<form action="<?php //echo $urlMoneybookers; ?>" method="post" target="_blank">
		<input type="hidden" name="pay_to_email" value="<?php //echo $pay_to_email; ?>">
		<input type="hidden" name="status_url" value="<?php //echo $status_url; ?>">
		<input type="hidden" name="language" value="<?php //echo $language; ?>">
		<input type="hidden" name="amount" value="<?php //echo $amount; ?>">
		<input type="hidden" name="currency" value="<?php //echo $currency; ?>">
		<input type="hidden" name="detail1_description" value="<?php //echo $detail1_description; ?>">
		<input type="hidden" name="detail1_text" value="<?php //echo $detail1_text; ?>">
		<input type="hidden" name="confirmation_note" value="<?php //echo $confirmation_note; ?>">
		<input type="submit" value="<?php //_e("Pay!", "wp-moneybookers-shortcodes"); ?>">
	</form>
	-->

	<?php // METHOD 2 : complete form ?>
	<form action="<?php echo $urlMoneybookers; ?>" method="post" target="_blank">
		<?php // MERCHANT DETAILS ?>
		<input type="hidden" name="pay_to_email" value="<?php echo $pay_to_email; ?>">
		<input type="hidden" name="recipient_description" value="<?php echo $recipient_description; ?>">
		<?php if( !empty($transaction_id) ): ?>
		<input type="hidden" name="transaction_id" value="<?php echo $transaction_id; ?>">
		<?php endif; ?>
		<input type="hidden" name="return_url" value="<?php echo $return_url; ?>">
		<?php if( !empty($return_url_text) ): ?>
		<input type="hidden" name="return_url_text" value="<?php echo $return_url_text; ?>">
		<?php endif; ?>
		<input type="hidden" name="cancel_url" value="<?php echo $cancel_url; ?>">
		<?php if( !empty($cancel_url_target) ): ?>
		<input type="hidden" name="cancel_url_target" value="<?php echo $cancel_url_target; ?>">
		<?php endif; ?>
		<input type="hidden" name="status_url" value="<?php echo $status_url; ?>">
		<?php if( !empty($status_url2) ): ?>
		<input type="hidden" name="status_url2" value="<?php echo $status_url2; ?>">
		<?php endif; ?>
		<?php if( !empty($new_window_redirect) ): ?>
		<input type="hidden" name="new_window_redirect" value="<?php echo $new_window_redirect; ?>">
		<?php endif; ?>
		<input type="hidden" name="language" value="<?php echo $language; ?>">
		<?php if( !empty($hide_login) ): ?>
		<input type="hidden" name="hide_login" value="<?php echo $hide_login; ?>">
		<?php endif; ?>
		<?php if( !empty($confirmation_note) ): ?>
		<input type="hidden" name="confirmation_note" value="<?php echo $confirmation_note; ?>">
		<?php endif; ?>
		<?php if( !empty($logo_url) ): ?>
		<input type="hidden" name="logo_url" value="<?php echo $logo_url; ?>">
		<?php endif; ?>
		<?php if( !empty($prepare_only) ): ?>
		<input type="hidden" name="prepare_only" value="<?php echo $prepare_only; ?>">
		<?php endif; ?>
		<?php if( !empty($rid) ): ?>
		<input type="hidden" name="rid" value="<?php echo $rid; ?>">
		<?php endif; ?>
		<?php if( !empty($ext_ref_id) ): ?>
		<input type="hidden" name="ext_ref_id" value="<?php echo $ext_ref_id; ?>">
		<?php endif; ?>
		<?php if( !empty($merchant_fields) ): ?>
		<input type="hidden" name="merchant_fields" value="<?php echo $merchant_fields; ?>">
		<?php endif; ?>
		<?php if( !empty($field_1) ): ?>
		<input type="hidden" name="field_1" value="<?php echo $field_1; ?>">
		<?php endif; ?>
		<?php if( !empty($field_2) ): ?>
		<input type="hidden" name="field_2" value="<?php echo $field_2; ?>">
		<?php endif; ?>
		<?php if( !empty($customer_number) ): ?>
		<input type="hidden" name="customer_number" value="<?php echo $customer_number; ?>">
		<?php endif; ?>
		<?php if( !empty($session_ID) ): ?>
		<input type="hidden" name="session_ID" value="<?php echo $session_ID; ?>">
		<?php endif; ?>

		<?php // CUSTOMER DETAILS ?>
		<?php if( !empty($pay_from_email) ): ?>
		<input type="hidden" name="pay_from_email" value="<?php echo $pay_from_email; ?>">
		<?php endif; ?>
		<?php if( !empty($title) ): ?>
		<input type="hidden" name="title" value="<?php echo $title; ?>">
		<?php endif; ?>
		<?php if( !empty($firstname) ): ?>
		<input type="hidden" name="firstname" value="<?php echo $firstname; ?>">
		<?php endif; ?>
		<?php if( !empty($lastname) ): ?>
		<input type="hidden" name="lastname" value="<?php echo $lastname; ?>">
		<?php endif; ?>
		<?php if( !empty($date_of_birth) ): ?>
		<input type="hidden" name="date_of_birth" value="<?php echo $date_of_birth; ?>">
		<?php endif; ?>
		<?php if( !empty($address) ): ?>
		<input type="hidden" name="address" value="<?php echo $address; ?>">
		<?php endif; ?>
		<?php if( !empty($address2) ): ?>
		<input type="hidden" name="address2" value="<?php echo $address2; ?>">
		<?php endif; ?>
		<?php if( !empty($phone_number) ): ?>
		<input type="hidden" name="phone_number" value="<?php echo $phone_number; ?>">
		<?php endif; ?>
		<?php if( !empty($postal_code) ): ?>
		<input type="hidden" name="postal_code" value="<?php echo $postal_code; ?>">
		<?php endif; ?>
		<?php if( !empty($city) ): ?>
		<input type="hidden" name="city" value="<?php echo $city; ?>">
		<?php endif; ?>
		<?php if( !empty($state) ): ?>
		<input type="hidden" name="state" value="<?php echo $state; ?>">
		<?php endif; ?>
		<?php if( !empty($country) ): ?>
		<input type="hidden" name="country" value="<?php echo $country; ?>">
		<?php endif; ?>

		<?php // // PAYMENT DETAILS ?>
		<input type="hidden" name="amount" value="<?php echo $amount; ?>">
		<input type="hidden" name="currency" value="<?php echo $currency; ?>">
		<input type="hidden" name="amount2_description" value="<?php echo $amount2_description; ?>">
		<input type="hidden" name="amount2" value="<?php echo $amount2; ?>">
		<?php if( !empty($amount3_description) ): ?>
		<input type="hidden" name="amount3_description" value="<?php echo $amount3_description; ?>">
		<?php endif; ?>
		<?php if( !empty($amount3) ): ?>
		<input type="hidden" name="amount3" value="<?php echo $amount3; ?>">
		<?php endif; ?>
		<?php if( !empty($amount4_description) ): ?>
		<input type="hidden" name="amount4_description" value="<?php echo $amount4_description; ?>">
		<?php endif; ?>
		<?php if( !empty($amount4) ): ?>
		<input type="hidden" name="amount4" value="<?php echo $amount4; ?>">
		<?php endif; ?>
		<?php if( !empty($detail1_description) ): ?>
		<input type="hidden" name="detail1_description" value="<?php echo $detail1_description; ?>">
		<?php endif; ?>
		<?php if( !empty($detail1_text) ): ?>
		<input type="hidden" name="detail1_text" value="<?php echo $detail1_text; ?>">
		<?php endif; ?>
		<?php if( !empty($detail2_description) ): ?>
		<input type="hidden" name="detail2_description" value="<?php echo $detail2_description; ?>">
		<?php endif; ?>
		<?php if( !empty($detail2_text) ): ?>
		<input type="hidden" name="detail2_text" value="<?php echo $detail2_text; ?>">
		<?php endif; ?>
		<?php if( !empty($detail3_description) ): ?>
		<input type="hidden" name="detail3_description" value="<?php echo $detail3_description; ?>">
		<?php endif; ?>
		<?php if( !empty($detail3_text) ): ?>
		<input type="hidden" name="detail3_text" value="<?php echo $detail3_text; ?>">
		<?php endif; ?>

		<input type="submit" value="<?php echo _e("Pay!", "wp-moneybookers-shortcodes"); ?>">
	</form>
	<?php // END - button moneybookers ?>

<?php 				
}//end function
add_shortcode('moneybookersBtn', 'getMoneybookersBtn');