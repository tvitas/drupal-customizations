<?php
	global $language_content;
	$lang = $language_content->language;
	$base_url = $GLOBALS['base_url'] . '/' . $lang;
?>
<div class="login-body-wrapper uk-width-small-1-1">
<div class="node-body">
<h3><?php print drupal_render($form['#title']);?></h3>
<hr class="uk-article-divider">

<?php print drupal_render($form['name']);?>


<?php print drupal_render($form['pass']);?>

<?php
print drupal_render($form['actions']);
print drupal_render($form['form_build_id']);
print drupal_render($form['form_id']);

?>

<hr class="uk-article-divider">
<a href="<?php print $base_url;?>/user/password" class="uk-button uk-button-success uk-margin-bottom"><?php print _t('_fogot_password_', t('Pamiršote slaptažodį?'))?></a>&emsp;
</div>
</div>

