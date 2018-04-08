<?php
	global $language_content;
	$lang = $language_content->language;
	$base_url = $GLOBALS['base_url'] . '/' . $lang;
?>
<div class="login-body-wrapper uk-width-small-1-1">
<div class="node-body">
<h3><?php print drupal_render($form['#title']);?></h3>
<hr class="uk-article-divider">
<div class="uk-margin-bottom">
<?php print drupal_render($form['name']);?>
</div>
<?php
print drupal_render($form['form_build_id']);
print drupal_render($form['form_id']);
print drupal_render($form['actions']);
print drupal_render($form['yoursiteurl']);
?>
<hr class="uk-article-divider">
<a href="<?php print $base_url;?>/user/login" class="uk-button uk-button-success uk-margin-bottom"><?php print _t('_login_', t('Prisijungti'))?></a>&emsp;
<a href="<?php print $base_url;?>/user/register" class="uk-button uk-button-success uk-margin-bottom"><?php print _t('_register_account_', t('Registruoti paskyrą'))?></a>
</div>
</div>
