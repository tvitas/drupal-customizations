<?php
global $language_content;
$lang = $language_content -> language;
$link = $GLOBALS['base_url'] . '/' . drupal_get_path_alias('node/' . $fields['nid'] -> content);
$title_len = theme_get_setting('title_len');
$body_len = theme_get_setting('teaser_len');
$fields['title'] -> content = _the_shop_truncate_html($fields['title'] -> content, $title_len);
$fields['field_image'] -> content = !isset($fields['field_image'] -> content) ? '<img src="' . $GLOBALS['base_url'] . '/' . drupal_get_path('theme', 'the_shop') . '/img/placeholder-175x175.png' . '" width="173" height="173">' : $fields['field_image'] -> content;
?>
<div class="node-body-wrapper">
<div class="node-body">
<h3><?php print $fields['title'] -> content;?></h3>
<hr class="uk-article-divider">
<div class="uk-grid uk-grid-width-1-2">
<figure class="uk-text-center figure-top-most">
<?php print $fields['field_image'] -> content;?>
</figure>
<div class="body-topmost">
<?php print $fields['body'] -> content;?>
</div>
</div>
<hr class="uk-article-divider">
<div class="uk-text-center">
<a href="<?php print $link;?>" title="<?php print $fields['title'] -> content;?>" class="uk-button uk-button-danger"><?php print _t('_read_more_elipsis_', 'Daugiau...');?></a>
</div>
</div>
</div>
