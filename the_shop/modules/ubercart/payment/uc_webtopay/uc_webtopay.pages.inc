<?php

function uc_webtopay_complete($cart_id = 0) {

	if(isset($_GET['accept'])) {

		$Order = uc_order_load($_GET['order_id']);

		drupal_set_message(t('Your order will be processed as soon as your payment clears at webtopay.com.'));
	    uc_order_comment_save($Order->order_id, 0, t('Payment is pending approval at webtopay.com.'),'admin');

	  	// Empty that cart...
		uc_cart_empty($cart_id);

	  	// Save changes to order without it's completion.
	  	//uc_order_save($Order);   //SVARBU

	  	// Add a comment to let sales team know this came in through the site.
	  	uc_order_comment_save($Order->order_id, 0, t('Order created through website.'), 'admin');

		$build = uc_cart_complete_sale($Order, variable_get('uc_new_customer_login', FALSE));

		$page = variable_get('uc_cart_checkout_complete_page', '');

		if (!empty($page)) {
			drupal_goto($page);
		}

		return $build;
	}
//Must change all $_GET to $_POST if checked „send all requests as POST“ on paysera.lt project admin page

	if(isset($_GET['callback'])) {

		require_once('libwebtopay/WebToPay.php');
		if ($_GET[WebToPay::PREFIX.'status'] != '1')
			exit('Status not accepted: ' . $_GET[WebToPay::PREFIX.'status']);
	    try {
	        $orderid = $_GET[WebToPay::PREFIX.'orderid'];
	        WebToPay::toggleSS2(true);
	        $response = WebToPay::checkResponse($_GET, array(
		        'projectid'     => variable_get('uc_webtopay_sid', ''),
		        'sign_password' => variable_get('uc_webtopay_secret_word', ''),
		    ));

		    $Order = uc_order_load($orderid);

		    if (round($Order->order_total * 100) != round($_GET[WebToPay::PREFIX.'amount'])) {
		    	throw new WebToPayException('Bad price!');
		    }

			if (variable_get('uc_currency_code', '') !== $_GET[WebToPay::PREFIX.'currency']) {
		    	throw new WebToPayException('Bad currency!');
		    }

		    uc_order_update_status($orderid, 'payment_received');

			exit('OK');

	    } catch (Exception $e) {
	        echo get_class($e).': '.$e->getMessage();
	    }

	    exit;
	}
}
