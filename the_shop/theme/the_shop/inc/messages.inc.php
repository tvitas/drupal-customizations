<?php
function the_shop_status_messages($variables) {
  $display = $variables['display'];
  $output = '';
  $uk_msg = '';
  $uk_msg_status = '';
  $the_shop_dev_mode = theme_get_setting('dev_mode');

  $status_heading = array(
    'status' => t('Status message'),
    'error' => t('Error message'),
    'warning' => t('Warning message'),
    'info' => t('Informative message'),
  );

  $status_class = array(
    'status' => 'success',
    'error' => 'danger',
    'warning' => 'warning',
    'info' => 'primary',
  );

  foreach (drupal_get_messages($display) as $type => $messages) {
    $class = (isset($status_class[$type])) ? ' uk-alert-' . $status_class[$type] : '';
	$uk_msg_status = (isset($status_class[$type])) ? $status_class[$type] : 'info';
    $output .= "<div class=\"uk-alert $class\" data-uk-alert>\n";
	foreach ($messages as $key => $msg) {
		if ($msg == 'A welcome message with further instructions has been sent to your e-mail address.') {
			$messages[$key] = _t('_welcome_message_', $msg);
		}
		if ($msg == 'Your message has been sent.') {
			$messages[$key] = _t('_message_has_been_sent_', $msg);
		}
		if ($msg == 'You have reached the download limit for this file.Please contact the site administrator if this message has been received in error.') {
			$messages[$key] = _t('_ucf_message_reached_limit_', t($msg));
		}
		if ($msg == 'The specified passwords do not match.') {
			$messages[$key] = _t('_passwords_do_not_match_', $msg);
		}
		if ($msg == 'Your item(s) have been updated.') {
			$messages[$key] = _t('_items_updated_', $msg);
		}
		if ($msg == 'Your order will be processed as soon as your payment clears at webtopay.com.') {
			$messages[$key] = _t('_paysera_completion_msg_', $msg);
		}
		if ($msg == 'The changes have been saved.') {
			$messages[$key] = _t('_saved_', $msg);
		}
		if ($msg == 'You have not reached the minimum order total for this coupon.') {
			$messages[$key] = _t('_minimum_total_', $msg);
		}
		if ($msg == 'The e-mail address did not match.') {
			$messages[$key] = _t('_email_not_match_', $msg);
		}
		if ($msg == 'This coupon combination is not allowed.') {
			$messages[$key] = _t('_not_coupon_combination_', $msg);
		}
		if ($msg == 'You must enter a valid e-mail address.') {
			$messages[$key] = _t('_email_not_valid_', $msg);
		}
		if ($msg == 'In order to continue with the checkout process you must first accept the Terms') {
			$messages[$key] = _t('_terms_agree_continue_', 'Privalote sutikti su taisyklėmis ir sąlygomis, jeigu norite užbaigti užsakymą.');
		}
		if (strpos($msg, 'removed from your shopping cart')) {
			$messages[$key] = str_replace('removed from your shopping cart', _t('_removed_from_cart_'), $messages[$key]);
		}
		if (strpos($msg, 'added to')) {
			$messages[$key] = str_replace('added to', _t('_added_to_'), $messages[$key]);
		}
		if (strpos($msg, 'your shopping cart')) {
			$messages[$key] = str_replace('your shopping cart', _t('_your_shopping_cart_'), $messages[$key]);
		}
		if ($msg == 'Your cart has been updated.') {
			$messages[$key] = _t('_items_updated_');
		}
		if (strpos($msg, '-mail address')) {
			$messages[$key] = str_replace('E-mail address', _t('_your_e_mail_address_', t('E-mail address')), $messages[$key]);
		}
		if (strpos($msg, 'onfirm e-mail address')) {
			$messages[$key] = str_replace('Confirm e-mail address', _t('_confirm_e_mail_address_', t('Confirm e-mail address')), $messages[$key]);
		}
		if (strpos($msg, 'hone number')) {
			$messages[$key] = str_replace('Phone number', _t('_phone_number_', t('Phone number')), $messages[$key]);
		}
		if (strpos($msg, 'irst name')) {
			$messages[$key] = str_replace('First name', _t('_first_name_', t('First name')), $messages[$key]);
		}
		if (strpos($msg, 'sername')) {
			$messages[$key] = str_replace('Username', _t('_username_', t('User name')), $messages[$key]);
		}
		if (strpos($msg, 'ast name')) {
			$messages[$key] = str_replace('Last name', _t('_last_name_', t('Last name')), $messages[$key]);
		}
		if (strpos($msg, 'treet address')) {
			$messages[$key] = str_replace('Street address', _t('_street_address_', t('Street address')), $messages[$key]);
		}
		if (strpos($msg, 'ity')) {
			$messages[$key] = str_replace('City', _t('_city_', t('City')), $messages[$key]);
		}
		if (strpos($msg, 'field is required')) {
			$messages[$key] = str_replace('field is required', _t('_field_is_required_'), $messages[$key]);
		}
		if (strpos($msg, 'coupon code is invalid or has expired')) {
			$messages[$key] = str_replace('This coupon code is invalid or has expired', _t('_coupon_expired_'), $messages[$key]);
		}
		if (strpos($msg, 'must enter a valid coupon code')) {
			$messages[$key] = str_replace('You must enter a valid coupon code', _t('_coupon_expired_'), $messages[$key]);
		}
		if (strpos($msg, 'has been applied to your order')) {
			$messages[$key] = _t('_discount_applied_', $msg);
		}
		if (strpos($msg, 'quantity must be a number.')) {
			$messages[$key] = _t('_must_number_', $msg);
		}
		if (strpos($msg, 'password is too short')) {
			$messages[$key] = _t('_pass_too_short_', $msg);
		}
		if (strpos($msg, 'og in successful for')) {
			$messages[$key] = _t('_login_success_', $msg);
		}
		if (strpos($msg, 'You will receive a confirmation e-mail shortly containing further')) {
			$messages[$key] = _t('_subscribe_information_', $msg);
		}
		if (strpos($msg, 'reCAPTCHA')) {
			$messages[$key] = _t('_google_recaptcha_message_', $msg);
		}
	}
    if (!empty($status_heading[$type])) {
      $output .= '<h4 class="element-invisible">' . $status_heading[$type] . "</h4>\n";
    }

    $output .= "  <a class=\"uk-close uk-alert-close\" href=\"\"></a>\n";

    if (count($messages) > 1) {
      $output .= " <ul>\n";
      foreach ($messages as $message) {
        $output .= '  <li>' . $message . "</li>\n";
        $uk_msg .= "&middot; " . $message."<br />";
      }
      $output .= " </ul>\n";
    }
    else {
      $output .= $messages[0];
      $uk_msg .= $messages[0];

    }
    $output .= "</div>\n";
  }
  //return $output;

	if (!empty($output) && !$the_shop_dev_mode) {
		drupal_add_js("UIkit.notify('$uk_msg', {status:'$uk_msg_status', pos:'top-center'});", array('type' => 'inline', 'scope' => 'footer', 'group' => JS_THEME, 'weight' => 5,));
	}
	if ($the_shop_dev_mode) {
		return $output;
	} else {
		if (module_exists('uc_ajax_cart_alt')) {
			return $uk_msg;
		}
	}

}
