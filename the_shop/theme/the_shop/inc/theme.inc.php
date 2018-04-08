<?php
function the_shop_theme() {
	$items = array();
	$items['user_login'] = array(
						'render element' => 'form',
						'path' => drupal_get_path('theme', 'the_shop') . '/templates/user',
						'template' => 'user--login--form',
						'preprocess functions' => array('the_shop_preprocess_user_login'),
						);
	$items['user_pass'] = array(
						'render element' => 'form',
						'path' => drupal_get_path('theme', 'the_shop') . '/templates/user',
						'template' => 'user--password--form',
						'preprocess functions' => array('the_shop_preprocess_user_pass'),
						);
	$items['user_register_form'] = array(
						'render element' => 'form',
						'path' => drupal_get_path('theme', 'the_shop') . '/templates/user',
						'template' => 'user--register--form',
						'preprocess functions' => array('the_shop_preprocess_user_register'),
						);
	$items['user_profile_form'] = array(
						'render element' => 'form',
						'path' => drupal_get_path('theme', 'the_shop') . '/templates/user',
						'template' => 'user--profile--edit--form',
						'preprocess functions' => array('the_shop_preprocess_user_profile_edit'),
						);
	$items['user_pass_reset'] = array(
						'render element' => 'form',
						'path' => drupal_get_path('theme', 'the_shop') . '/templates/user',
						'template' => 'user--reset--form',
						'preprocess functions' => array('the_shop_preprocess_user_pass_reset'),
						);
	$items['uc_cart_pane_quotes'] = array(
						'render element' => 'form',
						'path' => drupal_get_path('theme', 'the_shop') . '/templates/uc',
						'template' => 'uc--cart--pane--quotes',
						'preprocess functions' => array('the_shop_preprocess_cart_pane_quotes'),
						);
	$items['uc_coupon_form'] = array(
						'render element' => 'form',
						'path' => drupal_get_path('theme', 'the_shop') . '/templates/uc',
						'template' => 'uc--coupon--form',
						'preprocess functions' => array('the_shop_preprocess_uc_coupon_form'),
						);
	$items['uc_cart_view_form'] = array(
						'render element' => 'form',
						'path' => drupal_get_path('theme', 'the_shop') . '/templates/uc',
						'template' => 'uc--cart--view--form',
						'preprocess functions' => array('the_shop_preprocess_uc_cart_view_form'),
						);
	$items['uc_cart_checkout_form'] = array(
						'render element' => 'form',
						'path' => drupal_get_path('theme', 'the_shop') . '/templates/uc',
						'template' => 'uc--cart--checkout--form',
						'preprocess functions' => array('the_shop_preprocess_uc_cart_checkout_form'),
						);
	return $items;
}
