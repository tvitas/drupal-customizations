<?php

/**
 * @file
 * Default theme implementation to present all user profile data.
 *
 * This template is used when viewing a registered member's profile page,
 * e.g., example.com/user/123. 123 being the users ID.
 *
 * Use render($user_profile) to print all profile items, or print a subset
 * such as render($user_profile['user_picture']). Always call
 * render($user_profile) at the end in order to print all remaining items. If
 * the item is a category, it will contain all its profile items. By default,
 * $user_profile['summary'] is provided, which contains data on the user's
 * history. Other data can be included by modules. $user_profile['user_picture']
 * is available for showing the account picture.
 *
 * Available variables:
 *   - $user_profile: An array of profile items. Use render() to print them.
 *   - Field variables: for each field instance attached to the user a
 *     corresponding variable is defined; e.g., $account->field_example has a
 *     variable $field_example defined. When needing to access a field's raw
 *     values, developers/themers are strongly encouraged to use these
 *     variables. Otherwise they will have to explicitly specify the desired
 *     field language, e.g. $account->field_example['en'], thus overriding any
 *     language negotiation rule that was previously applied.
 *
 * @see user-profile-category.tpl.php
 *   Where the html is handled for the group.
 * @see user-profile-item.tpl.php
 *   Where the html is handled for each item in the group.
 * @see template_preprocess_user_profile()
 *
 * @ingroup themeable
 */
?>
<?php
	global $language_content;
	$lang = $language_content -> language;
	$front_page = $GLOBALS['base_url'] . '/' . $lang;
?>
<div class="login-body-wrapper">
<div class="node-body">
<h3><?php print $user->name;?></h3>
<hr class="uk-article-divider">
<h4><?php print render($user_profile['field_firstname']);?> <?php print render($user_profile['field_lastname']);?></h4>
<?php print $user->mail;?>
<h4><?php print _t('_products_delivery_address_', t('Products delivery address'));?></h4>
<?php print render($user_profile['field_street_address']);?>
<?php print render($user_profile['field_postal_code']);?>
<?php print render($user_profile['field_city']);?>
<?php print render($user_profile['field_phone_no']);?>
<h4><?php print _t('_company_', t('Company'));?></h4>
<?php print render($user_profile);?>
<div>
<?php print l(_t('_profile_edit_', t('Edit profile')), '/user/' . $user->uid . '/edit', array('attributes' =>array('class'=> array('uk-button', 'uk-button-primary'))));?>&emsp;
<?php print l(_t('_my_orders_', t('My orders')), '/user/' . $user->uid . '/orders', array('attributes' =>array('class'=> array('uk-button', 'uk-button-primary'))));?>&emsp;
<?php if (module_exists('uc_file')):?>
<?php print l(_t('_my_files_', t('My files')), '/user/' . $user->uid . '/purchased-files', array('attributes' =>array('class'=> array('uk-button', 'uk-button-primary'))));?>&emsp;
<?php endif;?>
<?php print l(_t('_log_out_', t('Log out')), '/user/logout', array('attributes' =>array('class'=> array('uk-button', 'uk-button-danger'))));?>&emsp;
</div>
</div>
</div>
