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
<?php print drupal_render($form['message']);?>
<?php print drupal_render($form['help']);?>
</div>
<hr class="uk-article-divider">
<?php print drupal_render($form['actions']);?>
<?php print drupal_render($form['yoursiteurl']);?>
</div>
