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
<?php print drupal_render($form['account']);?>
</div>
<hr class="uk-article-divider">
<?php print drupal_render($form['form_build_id']);?>
<?php print drupal_render($form['form_id']);?>
<?php print drupal_render($form['actions']);?>
<?php print drupal_render($form['yoursiteurl']);?>
</div>
</div>
