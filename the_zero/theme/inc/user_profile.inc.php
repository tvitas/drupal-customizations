<?php
function the_zero_preprocess_user_profile(&$variables) {
	if (isset($variables['user_profile']['summary']['#access'])) {
		$variables['user_profile']['summary']['#access'] = FALSE;
	}
}

function the_zero_preprocess_user_login(&$variables) {
	if (!isset($variables['form']['#title'])) {
		$variables['form']['#title']['#markup'] = _t('_login_', t('Login'));
	}
    $form['name']['#attributes']['autofocus'] = 'autofocus';
}

function the_zero_preprocess_user_pass(&$variables) {
	if (!isset($variables['form']['#title'])) {
		$variables['form']['#title']['#markup'] = _t('_fogot_password_', t('Forgot password?'));
	}
}

function the_zero_preprocess_user_register(&$variables) {
	if (!isset($variables['form']['#title'])) {
		$variables['form']['#title']['#markup'] = _t('_register_account_', t('New account'));
	}
}

function the_zero_preprocess_user_pass_reset(&$variables) {
	if (!isset($variables['form']['#title'])) {
		$variables['form']['#title']['#markup'] = _t('_reset_password_', t('Reset password'));
	}
}

function the_zero_preprocess_user_profile_edit(&$variables) {
	if (!isset($variables['form']['#title'])) {
		$variables['form']['#title']['#markup'] = _t('_account_settings_', t('Account settings'));
	}
	if (isset($variables['form']['account']['current_pass']['#weight'])) {
		$variables['form']['account']['current_pass']['#weight'] = 0.001;
	}
	if (isset($variables['form']['account']['pass']['#attached'])) {
		unset ($variables['form']['account']['pass']['#attached']);
	}
	if (isset($variables['form']['account']['pass']['#description'])) {
		unset ($variables['form']['account']['pass']['#description']);
	}
}
