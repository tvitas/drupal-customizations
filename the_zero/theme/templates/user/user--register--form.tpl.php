<?php
	global $language_content;
	$lang = $language_content->language;
	$base_url = $GLOBALS['base_url'] . '/' . $lang;
?>
<div class="login-body-wrapper uk-width-small-1-1">
<div class="node-body">
<h3><?php print drupal_render($form['#title']);?></h3>
<hr class="uk-article-divider">
<?php print drupal_render($form['account']);?>
<hr class="uk-article-divider">
<?php
print drupal_render($form['form_build_id']);
print drupal_render($form['form_id']);
print drupal_render($form['yoursiteurl']);
print drupal_render($form['actions']);
?>
<hr class="uk-article-divider">
<a href="<?php print $base_url;?>/user/login" class="uk-button uk-button-primary uk-margin-bottom"><?php print _t('_login_', t('Prisijungti'))?></a>&emsp;
<a href="<?php print $base_url;?>/user/password" class="uk-button uk-button-primary uk-margin-bottom"><?php print _t('_fogot_password_', t('Forgot password?'))?></a>
</div>
</div>
