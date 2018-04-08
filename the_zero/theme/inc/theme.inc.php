<?php
function the_zero_theme() {
	$items = array();
	$items['user_login'] = array(
						'render element' => 'form',
						'path' => drupal_get_path('theme', 'the_zero') . '/templates/user',
						'template' => 'user--login--form',
						'preprocess functions' => array('the_zero_preprocess_user_login'),
						);
	$items['user_pass'] = array(
						'render element' => 'form',
						'path' => drupal_get_path('theme', 'the_zero') . '/templates/user',
						'template' => 'user--password--form',
						'preprocess functions' => array('the_zero_preprocess_user_pass'),
						);
	$items['user_register_form'] = array(
						'render element' => 'form',
						'path' => drupal_get_path('theme', 'the_zero') . '/templates/user',
						'template' => 'user--register--form',
						'preprocess functions' => array('the_zero_preprocess_user_register'),
						);
	$items['user_profile_form'] = array(
						'render element' => 'form',
						'path' => drupal_get_path('theme', 'the_zero') . '/templates/user',
						'template' => 'user--profile--edit--form',
						'preprocess functions' => array('the_zero_preprocess_user_profile_edit'),
						);
	$items['user_pass_reset'] = array(
						'render element' => 'form',
						'path' => drupal_get_path('theme', 'the_zero') . '/templates/user',
						'template' => 'user--reset--form',
						'preprocess functions' => array('the_zero_preprocess_user_pass_reset'),
						);
	$items['course_registration_form_node_form'] = array(
						'render element' => 'form',
						'path' => drupal_get_path('theme', 'the_zero') . '/templates/forms',
						'template' => 'node--add--course-registration-form',
						'preprocess functions' => array('the_zero_preprocess_course_registration_form'),
						);
	return $items;
}

function the_zero_preprocess_course_registration_form(&$variables) {
	$variables['form']['#title']['#markup'] = _t('_registration_form_', t('Course registration form'));
}

