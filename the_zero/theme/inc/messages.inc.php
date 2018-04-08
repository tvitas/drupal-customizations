<?php
function the_zero_status_messages($variables) {
  $display = $variables['display'];
  $output = '';
  $uk_msg = '';
  $uk_msg_status = '';
  $the_zero_dev_mode = theme_get_setting('dev_mode');

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
		if (strpos($msg, 'ork place, position')) {
			$messages[$key] = str_replace('Work place, position', _t('_work_place__position_'), $messages[$key]);
		}
		if (strpos($msg, 'urname')) {
			$messages[$key] = str_replace('Surname', _t('_surname_'), $messages[$key]);
		}
		if (strpos($msg, 'aculty')) {
			$messages[$key] = str_replace('Faculty', _t('_faculty_'), $messages[$key]);
		}
		if (strpos($msg, 'aculty')) {
			$messages[$key] = str_replace('Faculty', _t('_faculty_'), $messages[$key]);
		}
		if (strpos($msg, '-mail address')) {
			$messages[$key] = str_replace('E-mail address', _t('_e_mail_address_'), $messages[$key]);
		}
		if (strpos($msg, 'irst name')) {
			$messages[$key] = str_replace('First name', _t('_first_name_'), $messages[$key]);
		}
		if (strpos($msg, 'ear of graduation')) {
			$messages[$key] = str_replace('Year of graduation', _t('_year_of_graduation_'), $messages[$key]);
		}
		if (strpos($msg, 'lient name')) {
			$messages[$key] = str_replace('Client name', _t('_client_name_'), $messages[$key]);
		}
		if (strpos($msg, 'lient lastname')) {
			$messages[$key] = str_replace('Client lastname', _t('_client_lastname_'), $messages[$key]);
		}
		if (strpos($msg, 'lient phone')) {
			$messages[$key] = str_replace('Client phone', _t('_client_phone_'), $messages[$key]);
		}
		if (strpos($msg, 'our e-mail address')) {
			$messages[$key] = str_replace('Your e-mail address', _t('_your_e_mail_address_'), $messages[$key]);
		}
		if (strpos($msg, 'ubject')) {
			$messages[$key] = str_replace('Subject', _t('_subject_'), $messages[$key]);
		}
		if (strpos($msg, 'essage')) {
			$messages[$key] = str_replace('Message', _t('_message_'), $messages[$key]);
		}
		if (strpos($msg, 'reCAPTCHA')) {
			$messages[$key] = str_replace('Google reCAPTCHA does not accept this submission.', _t('_recaptcha_msg_'), $messages[$key]);
		}
		if (strpos($msg, 'field is required')) {
			$messages[$key] = str_replace('field is required', _t('_field_is_required_'), $messages[$key]);
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
	}
    if (!empty($status_heading[$type])) {
      $output .= '<h4 class="element-invisible">' . $status_heading[$type] . "</h4>\n";
    }

    $output .= "  <a class=\"uk-close uk-alert-close\" href=\"\"></a>\n";

    if (count($messages) > 1) {
      $output .= " <ul>\n";
      foreach ($messages as $message) {
        $output .= '  <li>' . $message . "</li>\n";
        $uk_msg .= $message . "<br /></br />";
      }
      $output .= " </ul>\n";
    }
    else {
      $output .= $messages[0];
      $uk_msg .= $messages[0];

    }
    $output .= "</div>\n";
  }
	if (!empty($output) && !$the_zero_dev_mode) {
		drupal_add_js("UIkit.notify('$uk_msg', {status:'$uk_msg_status', pos:'top-center', timeout: 0});", array('type' => 'inline', 'scope' => 'footer', 'group' => JS_THEME, 'weight' => 5,));
	}
	if ($the_zero_dev_mode) {
		return $output;
	} else {
		if (module_exists('uc_ajax_cart_alt')) {
			return $uk_msg;
		}
	}
}
