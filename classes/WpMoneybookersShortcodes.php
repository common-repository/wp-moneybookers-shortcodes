<?php 
class WpMoneybookersShortcodes {
	// CONST
	const CONST_URL_MONEYBOOKERS_TEST		= "http://www.moneybookers.com/app/test_payment.pl";
	const CONST_URL_MONEYBOOKERS_PRODUCTION	= "https://www.moneybookers.com/app/payment.pl";
	
	// STATE MONEYBOOKERS
	private $_production;				// true : production, false : test phase (=sandbox) 
	private $_urlMoneybookers;			// url moneybookers (test or production)
	private $_urlPlugin;				// url file plugin
	private $_urlPluginMoneybookers; 	// url plugin moneybookers
	
	// MERCHANT DETAILS
	private $_pay_to_email;				// REQUIRED FIELD. merchant email (ex: merchant@moneybookers.com)
	private $_recipient_description;	// A description of the Merchant, which will be shown on the gateway. If no value is submitted, the pay_to_email value will be shown as the recipient of the payment. (Max 30 characters)
	private $_transaction_id;			// Reference or identification number provided by the Merchant. MUST be unique for each payment (Max 32 characters) (ex: A205220)
	private $_return_url;				// URL to which the customer will be returned when the payment is made. If this field is not filled, the gateway window will simply close automatically at the end of the transaction, so that the customer will be returned to the last page on the Merchant's website where he has been before. A secure return_url functionality is available. Please see section 3.5. (ex: http://www.mySite.com/payment_made.php)
	private $_return_url_text;			// The text on the button when the user finishes his payment.
	private $_return_url_target;		// Specifies a target in which the return_url value will be called upon successful payment from customer. Default value is 1. 1 = '_top' 2 = '_parent' 3 = '_self' 4= '_blank'
	private $_cancel_url;				// URL to which the customer will be returned if the payment process is cancelled. If this field is not filled, the gateway window will simply close automatically upon clicking the cancellation button, so the customer will be returned to the last page on the Merchant's website where the customer has been before. (ex: http://www.mySite.com/payment_cancelled.php)
	private $_cancel_url_target;		// Specifies a target in which the cancel_url value will be called upon cancellation of payment from customer. Default value is 1. 1 = '_top' 2 = '_parent' 3 = '_self' 4= '_blank'
	private $_status_url;				// URL to which the transaction details will be posted after the payment process is complete. Alternatively, you may specify an email address to which you would like to receive the results. If the status_url is omitted, no transaction details will be sent to the Merchant. (ex: https://www.merchant.com/process_payment.cgi or merchant@merchant.com)
	private $_status_url2;				// Second URL to which the transaction details will be posted after the payment process is complete. Alternatively you may specify an email address to which you would like to receive the results. (ex: https://www.merchant.com/process_payment.cgi or merchant2@merchant.com)
	private $_new_window_redirect;		// Merchants can choose to redirect customers to the Sofortueberweisung payment method in a new window instead of in the same window. The accepted values are 0(default) and 1.
	private $_language;					// REQUIRED FIELD. 2-letter code of the language used for Moneybookers' pages. Can be any of EN, DE, ES, FR, IT, PL, GR RO, RU, TR, CN, CZ, NL, DA, SV or FI. (ex: EN or FR)
	private $_hide_login;				// Merchants can show their customers the gateway page without the prominent login section. See 3.10 for more detailed explanation. (ex: 1)
	private $_confirmation_note;		// Merchant may show to the customer on the confirmation screen - the end step of the process - a note, confirmation number, PIN or any other message. Line breaks <br> may be used for longer messages. (ex: Samplemerchant wishes you pleasure reading your new book!)
	private $_logo_url;					// The URL of the logo which you would like to appear at the top of the gateway. The logo must be accessible via HTTPS otherwise it will not be shown. For best integration results we recommend that Merchants use logos with dimensions up to 200px in width and 50px in height. (ex: https://www.merchant.com/logo.jpeg)
	private $_prepare_only;				// Forces only SID to be returned without actual page. Useful when using alternative ways to redirect the customer to the gateway. See 2.3.2 for a more detailed explanation. Accepted values are 1 and 0. (ex: 1)
	private $_rid;						// Merchants can pass the unique referral ID or email of the affiliate from which the customer is referred. The rid value must be included within the actual payment request. (ex: 123456)
	private $_ext_ref_id;				// Merchants can pass additional identifier in this field in order to track affiliates. You MUST inform your account manager about	 the exact value that will be submitted so that affiliates can be tracked
	private $_merchant_fields;			// A comma-separated list of field names that should be passed back to the Merchant's server when the payment is confirmed at moneybookers.com (maximum 5 fields). (ex: Field1, Field2 or customer_number, session_id)
	private $_field_1;					// An example merchant field (ex: Value 1)
	private $_field_2;					// An example merchant field (ex: Value 1)
	private $_customer_number;			// An example merchant field (ex: C1234)
	private $_session_ID;				// An example merchant field (ex: A3DFA2234)

	// CUSTOMER DETAILS
	private $_pay_from_email;			// Email address of the customer who is making the payment. If left empty, the customer has to enter his email address himself. (ex: payer@moneybookers.com)
	private $_title;					// Customer‟s title. Accepted values: Mr, Mrs or Ms (ex: Mr)
	private $_firstname;				// Customer‟s first name (ex: John)
	private $_lastname;					// Customer‟s last name (ex: PAYER)
	private $_date_of_birth;			// Date of birth of the customer. The format is ddmmyyyy. Only numeric values are	No	8 accepted (ex: 01121980)
	private $_address;					// Customer‟s address (e.g. street) (ex: Payerstreet)
	private $_address2;					// Customer‟s address (e.g. town) (ex: Payerstreet)
	private $_phone_number;				// Customer‟s phone number. Only numeric values are accepted (ex: 0207123456)
	private $_postal_code;				// Payer postal code (ex: EC45MQ)
	private $_city;						// Customer‟s city (ex: Payertown)
	private $_state;					// Customer‟s state or region. (ex: Central London
	private $_country;					// Customer‟s country in the 3-digit ISO Code (see Annex II for a list of allowed codes). (ex: GBR)
		
	// PAYMENT DETAILS
	private $_amount;					// price product (ex: 39.60 or 39.6 or 39)
	private $_currency;					// 3-letter code of the currency of the amount according to ISO 4217 (see Annex I for accepted currencies) (ex: GBP)
	private $_amount2_description;		// Merchant may specify a detailed calculation for the total amount payable. Please note that Moneybookers does not check the validity of these data - they are only displayed in the ‟More information‟ section in the header of the gateway. (ex: Product Price:)
	private $_amount2;					// This amount in the currency defined in field 'currency' will be shown next to amount2_description. (ex: 29.90)
	private $_amount3_description;		// See above (ex: Handling Fees & Charges:)
	private $_amount3;					// See above (ex: 3.10)
	private $_amount4_description;		// See above (ex: VAT (20%))
	private $_amount4;					// See above (ex: 6.60)
	private $_detail1_description;		// REQUIRED FIELD. Merchant may show up to 5 details about the product or transfer in the ‟More information‟ section in the header of the gateway. (ex: ;Product ID:;)
	private $_detail1_text;				// REQUIRED FIELD. The detailX_text is shown next to the detailX_description. The detail1_text is also shown to the client in his history at Moneybookers‟ website. (ex: 4509334)
	private $_detail2_description;		// 2nd description (ex: ;Description:;)
	private $_detail2_text;				// 2nd text (ex: Romeo and Juliet (W. Shakespeare))
	private $_detail3_description;		// 3th description (ex: ;Special Conditions:;)
	private $_detail3_text;				// 3th text (ex: 5-6 days for delivery)
	private $_detail4_description;		// 4me description (ex: ;Special Conditions:;)
	private $_detail4_text;				// 4me text (ex: 5-6 days for delivery)
	private $_detail5_description;		// 5me description (ex: ;Special Conditions:;)
	private $_detail5_text;				// 5me text (ex: 5-6 days for delivery)

	
	/**
	 * __toString() : PHP5 définit une nouvelle méthode __toString qui est appelée lors de l'affichage d'un objet (via echo ou print uniquement).
	 * $a = new WpMoneybookersShortcodes
	 * echo $a;
	 */
	function __toString(){
		return "Class ".__CLASS__; // __METHOD__
	}
	
	/**
	 * Construct : init "email seller" and "language default"
	 * @param string $pay_to_email	contact@yourSite.com (accound moneybookers)
	 * @param string $language		EN, DE, ES, FR, IT, ...
	 * @param string $currency		EUR, GBP, ...
	 */
	function WpMoneybookersShortcodes($pay_to_email, $production=true, $language="FR", $currency="EUR") {
		$this->_urlPlugin		= home_url('/')."wp-content/plugins";
		$this->_urlPluginMoneybookers = $this->_urlPlugin."/wp-moneybookers-shortcodes";
		$this->_pay_to_email	= $pay_to_email;
		$this->_language		= $language;
		$this->_currency		= $currency;
		$this->_production		= $production;
		$this->_return_url		= $this->_urlPluginMoneybookers."/payment_made.php";		// return page (url of the page is created for receipt of payment made)
		$this->_cancel_url		= $this->_urlPluginMoneybookers."/payment_cancelled.php";	// cancel page (url of the page is created for receiving payment canceled)
		$this->_status_url		= $this->_urlPluginMoneybookers."/process_payment.php";		// status page (url of the page is created for receiving the payment process)
		
		// State : production or Test
		if( $this->_production == false ){	$this->_urlMoneybookers = self::CONST_URL_MONEYBOOKERS_TEST; }
		else{								$this->_urlMoneybookers = self::CONST_URL_MONEYBOOKERS_PRODUCTION; }
		
		//echo "constructeur ".__CLASS__." - ".__METHOD__."<br />";
	}
	
	public function getMoneybookersBtn() {
		
		$form = "
		<form action='".$this->_urlMoneybookers."' method='post' target='_blank'>";

			// MERCHANT DETAILS
			$form .= "
			<input type='hidden' name='pay_to_email' value='".$this->_pay_to_email."'>
			<input type='hidden' name='recipient_description' value='".$this->_recipient_description."'>";
			if( !empty($this->_transaction_id) ):
			$form .= "<input type='hidden' name='transaction_id' value='".$this->_transaction_id."'>";
			endif;
			$form .= "<input type='hidden' name='return_url' value='".$this->_return_url."'>";
			if( !empty($this->_return_url_text) ):
			$form .= "<input type='hidden' name='return_url_text' value='".$this->_return_url_text."'>";
			endif;
			$form .= "<input type='hidden' name='cancel_url' value='".$this->_cancel_url."'>";
			if( !empty($this->_cancel_url_target) ):
			$form .= "<input type='hidden' name='cancel_url_target' value='".$this->_cancel_url_target."'>";
			endif;
			$form .= "<input type='hidden' name='status_url' value='".$this->_status_url."'>";
			if( !empty($this->_status_url2) ):
			$form .= "<input type='hidden' name='status_url2' value='".$this->_status_url2."'>";
			endif;
			if( !empty($this->_new_window_redirect) ):
			$form .= "<input type='hidden' name='new_window_redirect' value='".$this->_new_window_redirect."'>";
			endif;
			$form .= "<input type='hidden' name='language' value='".$this->_language."'>";
			if( !empty($this->_hide_login) ):
			$form .= "<input type='hidden' name='hide_login' value='".$this->_hide_login."'>";
			endif;
			if( !empty($this->_confirmation_note) ):
			$form .= "<input type='hidden' name='confirmation_note' value='".$this->_confirmation_note."'>";
			endif;
			if( !empty($this->_logo_url) ):
			$form .= "<input type='hidden' name='logo_url' value='".$this->_logo_url."'>";
			endif;
			if( !empty($this->_prepare_only) ):
			$form .= "<input type='hidden' name='prepare_only' value='".$this->_prepare_only."'>";
			endif;
			if( !empty($this->_rid) ):
			$form .= "<input type='hidden' name='rid' value='".$this->_rid."'>";
			endif;
			if( !empty($this->_ext_ref_id) ):
			$form .= "<input type='hidden' name='ext_ref_id' value='".$this->_ext_ref_id."'>";
			endif;
			if( !empty($this->_merchant_fields) ):
			$form .= "<input type='hidden' name='merchant_fields' value='".$this->_merchant_fields."'>";
			endif;
			if( !empty($this->_field_1) ):
			$form .= "<input type='hidden' name='field_1' value='".$this->_field_1."'>";
			endif;
			if( !empty($this->_field_2) ):
			$form .= "<input type='hidden' name='field_2' value='".$this->_field_2."'>";
			endif;
			if( !empty($this->_customer_number) ):
			$form .= "<input type='hidden' name='customer_number' value='".$this->_customer_number."'>";
			endif;
			if( !empty($this->_session_ID) ):
			$form .= "<input type='hidden' name='session_ID' value='".$this->_session_ID."'>";
			endif;
	
			// CUSTOMER DETAILS
			if( !empty($this->_pay_from_email) ):
			$form .= "<input type='hidden' name='pay_from_email' value='".$this->_pay_from_email."'>";
			endif;
			if( !empty($this->_title) ):
			$form .= "<input type='hidden' name='title' value='".$this->_title."'>";
			endif;
			if( !empty($this->_firstname) ):
			$form .= "<input type='hidden' name='firstname' value='".$this->_firstname."'>";
			endif;
			if( !empty($this->_lastname) ):
			$form .= "<input type='hidden' name='lastname' value='".$this->_lastname."'>";
			endif;
			if( !empty($this->_date_of_birth) ):
			$form .= "<input type='hidden' name='date_of_birth' value='".$this->_date_of_birth."'>";
			endif;
			if( !empty($this->_address) ):
			$form .= "<input type='hidden' name='address' value='".$this->_address."'>";
			endif;
			if( !empty($this->_address2) ):
			$form .= "<input type='hidden' name='address2' value='".$this->_address2."'>";
			endif;
			if( !empty($this->_phone_number) ):
			$form .= "<input type='hidden' name='phone_number' value='".$this->_phone_number."'>";
			endif;
			if( !empty($this->_postal_code) ):
			$form .= "<input type='hidden' name='postal_code' value='".$this->_postal_code."'>";
			endif;
			if( !empty($this->_city) ):
			$form .= "<input type='hidden' name='city' value='".$this->_city."'>";
			endif;
			if( !empty($this->_state) ):
			$form .= "<input type='hidden' name='state' value='".$this->_state."'>";
			endif;
			if( !empty($this->_country) ):
			$form .= "<input type='hidden' name='country' value='".$this->_country."'>";
			endif;
	
			// PAYMENT DETAILS
			$form .= "<input type='hidden' name='amount' value='".$this->_amount."'>";
			$form .= "<input type='hidden' name='currency' value='".$this->_currency."'>";
			$form .= "<input type='hidden' name='amount2_description' value='".$this->_amount2_description."'>";
			$form .= "<input type='hidden' name='amount2' value='".$this->_amount2."'>";
			if( !empty($this->_amount3_description) ):
			$form .= "<input type='hidden' name='amount3_description' value='".$this->_amount3_description."'>";
			endif;
			if( !empty($this->_amount3) ):
			$form .= "<input type='hidden' name='amount3' value='".$this->_amount3."'>";
			endif;
			if( !empty($this->_amount4_description) ):
			$form .= "<input type='hidden' name='amount4_description' value='".$this->_amount4_description."'>";
			endif;
			if( !empty($this->_amount4) ):
			$form .= "<input type='hidden' name='amount4' value='".$this->_amount4."'>";
			endif;
			if( !empty($this->_detail1_description) ):
			$form .= "<input type='hidden' name='detail1_description' value='".$this->_detail1_description."'>";
			endif;
			if( !empty($this->_detail1_text) ):
			$form .= "<input type='hidden' name='detail1_text' value='".$this->_detail1_text."'>";
			endif;
			if( !empty($this->_detail2_description) ):
			$form .= "<input type='hidden' name='detail2_description' value='".$this->_detail2_description."'>";
			endif;
			if( !empty($this->_detail2_text) ):
			$form .= "<input type='hidden' name='detail2_text' value='".$this->_detail2_text."'>";
			endif;
			if( !empty($this->_detail3_description) ):
			$form .= "<input type='hidden' name='detail3_description' value='".$this->_detail3_description."'>";
			endif;
			if( !empty($this->_detail3_text) ):
			$form .= "<input type='hidden' name='detail3_text' value='".$this->_detail3_text."'>";
			endif;
	
			$form .= "<input type='submit' value='".__("Pay!", "wp-moneybookers-shortcodes")."'>
		</form>";
		
		return $form;
	}
	
	
	
	// STATE
	public function getProduction(){						return $this->_production;	}
	public function setProduction($value){					$this->_production = $value; }
	
	// MERCHANT DETAILS
	public function getPayToEmail(){						return $this->_pay_to_email;	}
	public function setPayToEmail($value){					$this->_pay_to_email = is_email($value) ? $value : false; }
	
	public function getRecipientDescription(){				return $this->_recipient_description;	}
	public function setRecipientDescription($value){		$this->_recipient_description = $value;	}
	
	public function getTransactionId(){						return $this->_transaction_id;	}
	public function setTransactionId($value){				$this->_transaction_id = $value;	}
	
	public function getReturnUrl(){							return $this->_return_url;	}
	public function setReturnUrl($value){					$this->_return_url = $value;	}
	
	public function getReturnUrlText(){						return $this->_return_url_text;	}
	public function setReturnUrlText($value){				$this->_return_url_text = $value;	}
	
	public function getReturnUrlTarget(){					return $this->_return_url_target;	}
	public function setReturnUrlTarget($value){				$this->_return_url_target = $value;	}
	
	public function getCancelUrl(){							return $this->_cancel_url;	}
	public function setCancelUrl($value){					$this->_cancel_url = $value;	}
	
	public function getCancelUrlTarget(){					return $this->_cancel_url_target;	}
	public function setCancelUrlTarget($value){				$this->_cancel_url_target = $value;	}
	
	public function getStatusUrl(){							return $this->_status_url;	}
	public function setStatusUrl($value){					$this->_status_url = $value;	}
	
	public function getStatusUrl2(){						return $this->_status_url2;	}
	public function setStatusUrl2($value){					$this->_status_url2 = $value;	}
	
	public function getNewWindowRedirect(){					return $this->_new_window_redirect;	}
	public function setNewWindowRedirect($value){			$this->_new_window_redirect = $value;	}
	
	public function getLanguage(){							return $this->_language;	}
	public function setLanguage($value){					$this->_language = $value;	}
	
	public function getHideLogin(){							return $this->_hide_login;	}
	public function setHideLogin($value){					$this->_hide_login = $value;	}
	
	public function getConfirmationNote(){					return $this->_confirmation_note;	}
	public function setConfirmationNote($value){			$this->_confirmation_note = $value;	}
	
	public function getLogoUrl(){							return $this->_logo_url;	}
	public function setLogoUrl($value){						$this->_logo_url = $value;	}
	
	public function getPrepareOnly(){						return $this->_prepare_only;	}
	public function setPrepareOnly($value){					$this->_prepare_only = $value;	}
	
	public function getRid(){								return $this->_rid;	}
	public function setRid($value){							$this->_rid = $value;	}
	
	public function getExtRefId(){							return $this->_ext_ref_id;	}
	public function setExtRefId($value){					$this->_ext_ref_id = $value;	}
	
	public function getMerchantFields(){					return $this->_merchant_fields;	}
	public function setMerchantFields($value){				$this->_merchant_fields = $value;	}
	
	public function getField1(){							return $this->_field_1;	}
	public function setField1($value){						$this->_field_1 = $value;	}
	
	public function getField2(){							return $this->_field_2;	}
	public function setField2($value){						$this->_field_2 = $value;	}
	
	public function getCustomerNumber(){					return $this->_customer_number;	}
	public function setCustomerNumber($value){				$this->_customer_number = $value;	}
	
	public function getSessionID(){							return $this->_session_ID;	}
	public function setSessionID($value){					$this->_session_ID = $value;	}
	
	
	
	// CUSTOMER DETAILS
	public function getPayFromEmail(){						return $this->_pay_from_email;	}
	public function setPayFromEmail($value){				$this->_pay_from_email = $value;	}
	
	public function getTitle(){								return $this->_title;	}
	public function setTitle($value){						$this->_title = $value;	}
	
	public function getFirstname(){							return $this->_firstname;	}
	public function setFirstname($value){					$this->_firstname = $value;	}
	
	public function getLastname(){							return $this->_lastname;	}
	public function setLastname($value){					$this->_lastname = $value;	}
	
	public function getDateOfBirth(){						return $this->_date_of_birth;	}
	public function setDateOfBirth($value){					$this->_date_of_birth = $value;	}
	
	public function getAddress(){							return $this->_address;	}
	public function setAddress($value){						$this->_address = $value;	}
	
	public function getAddress2(){							return $this->_address2;	}
	public function setAddress2($value){					$this->_address2 = $value;	}
	
	public function getPhoneNumber(){						return $this->_phone_number;	}
	public function setPhoneNumber($value){					$this->_phone_number = $value;	}
	
	public function getPostalCode(){						return $this->_postal_code;	}
	public function setPostalCode($value){					$this->_postal_code = $value;	}
	
	public function getCity(){								return $this->_city;	}
	public function setCity($value){						$this->_city = $value;	}
	
	public function getState(){								return $this->_state;	}
	public function setState($value){						$this->_state = $value;	}
	
	public function getCountry(){							return $this->_country;	}
	public function setCountry($value){						$this->_country = $value;	}
	
	
	
	// PAYMENT DETAILS
	public function getAmount(){							return $this->_amount;	}
	public function setAmount($value){						$this->_amount = $value;	}
	
	public function getCurrency(){							return $this->_currency;	}
	public function setCurrency($value){					$this->_currency = $value;	}
	
	public function getAmount2Description(){				return $this->_amount2_description;	}
	public function setAmount2Description($value){			$this->_amount2_description = $value;	}
	
	public function getAmount2(){							return $this->_amount2;	}
	public function setAmount2($value){						$this->_amount2 = $value;	}
	
	public function getAmount3Description(){				return $this->_amount3_description;	}
	public function setAmount3Description($value){			$this->_amount3_description = $value;	}
	
	public function getAmount3(){							return $this->_amount3;	}
	public function setAmount3($value){						$this->_amount3 = $value;	}
	
	public function getAmount4Description(){				return $this->_amount4_description;	}
	public function setAmount4Description($value){			$this->_amount4_description = $value;	}
	
	public function getAmount4(){							return $this->_amount4;	}
	public function setAmount4($value){						$this->_amount4 = $value;	}
	
	public function getDetail1Description(){				return $this->_detail1_description;	}
	public function setDetail1Description($value){			$this->_detail1_description = $value;	}
	
	public function getDetail1Text(){						return $this->_detail1_text;	}
	public function setDetail1Text($value){					$this->_detail1_text = $value;	}
	
	public function getDetail2Description(){				return $this->_detail2_description;	}
	public function setDetail2Description($value){			$this->_detail2_description = $value;	}
	
	public function getDetail2Text(){						return $this->_detail2_text;	}
	public function setDetail2Text($value){					$this->_detail2_text = $value;	}
	
	public function getDetail3Description(){				return $this->_detail3_description;	}
	public function setDetail3Description($value){			$this->_detail3_description = $value;	}
	
	public function getDetail3Text(){						return $this->_detail3_text;	}
	public function setDetail3Text($value){					$this->_detail3_text = $value;	}
	
	public function getDetail4Description(){				return $this->_detail4_description;	}
	public function setDetail4Description($value){			$this->_detail4_description = $value;	}
	
	public function getDetail4Text(){						return $this->_detail4_text;	}
	public function setDetail4Text($value){					$this->_detail4_text = $value;	}
	
	public function getDetail5Description(){				return $this->_detail5_description;	}
	public function setDetail5Description($value){			$this->_detail5_description = $value;	}
	
	public function getDetail5Text(){						return $this->_detail5_text;	}
	public function setDetail5Text($value){					$this->_detail5_text = $value;	}
	
}// end class
?>