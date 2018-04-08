<?php
global $language_content;
$lang = $language_content -> language;
$link = $GLOBALS['base_url'] . '/' . $lang . '/' . drupal_get_path_alias('node/' . $fields['nid'] -> content);
$title_len = theme_get_setting('title_len');
$body_len = theme_get_setting('teaser_len');
$fields['title'] -> content = _the_zero_truncate_html($fields['title'] -> content, $title_len);
$fields['body'] -> content = _the_zero_truncate_html($fields['body'] -> content, $body_len);
$fields['field_image'] -> content = !isset($fields['field_image'] -> content) ? '<img src="' . $GLOBALS['base_url'] . '/' . drupal_get_path('theme', 'the_zero') . '/img/placeholder-175x175.png' . '" width="173" height="173">' : $fields['field_image'] -> content;
?>
<div class="node-body-wrapper">
<div class="node-body">
<h3><?php print $fields['title'] -> content;?></h3>
<hr class="uk-article-divider uk-hidden-small">
<div class="uk-grid uk-grid-width-small-1-1 uk-grid-width-medium-1-1 uk-grid-width-large-1-2">
<figure class="uk-text-center figure-top-most uk-hidden-small">
<?php print $fields['field_image'] -> content;?>
</figure>
<div class="teaser-body uk-hidden-small">
<?php print $fields['body'] -> content;?>
</div>
</div>
<div class="uk-text-center uk-margin-top">
<a href="<?php print $link;?>" title="<?php print $fields['title'] -> content;?>" class="uk-button uk-button-danger"><?php print _t('_read_more_elipsis_', t('More...'));?></a>
</div>
</div>
</div>
