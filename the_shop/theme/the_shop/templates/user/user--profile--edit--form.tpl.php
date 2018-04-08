<?php
	global $language_content;
	$lang = $language_content->language;
	$base_url = $GLOBALS['base_url'] . '/' . $lang;
?>
<div class="login-body-wrapper">
<div class="node-body">
<h3><?php print drupal_render($form['#title']);?></h3>
<hr class="uk-article-divider">
<div class="uk-margin-bottom">
<?php print drupal_render($form['field_firstname']);?>
<?php print drupal_render($form['field_lastname']);?>
<?php print drupal_render($form['account']);?>
</div>
<div class="uk-margin-bottom">
<h4><?php print _t('_products_delivery_address_', t('Products delivery address'));?></h4>
<?php print drupal_render($form['field_street_address']);?>
<?php print drupal_render($form['field_postal_code']);?>
<?php print drupal_render($form['field_city']);?>
<?php print drupal_render($form['field_phone_no']);?>
</div>
<div class="uk-margin-bottom">
<h4><?php print _t('_company_', t('Company'));?></h4>
<?php print drupal_render($form['field_company_title']);?>
<?php print drupal_render($form['field_company_number']);?>
<?php print drupal_render($form['field_company_vat_number']);?>
</div>
<hr class="uk-article-divider">
<?php print drupal_render($form['form_build_id']);?>
<?php print drupal_render($form['form_id']);?>
<?php print drupal_render($form['actions']);?>
<?php print drupal_render($form['yoursiteurl']);?>
</div>
</div>
