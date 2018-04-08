<?php
//$fields['nid']->content;
//$fields['title']->content;
//$fields['field_image']->content;
global $language_content;
$lang = $language_content -> language;
$link = $GLOBALS['base_url'] . '/' . drupal_get_path_alias('node/'.$fields['nid'] -> content);
$title_len = theme_get_setting('title_len')+15;
$fields['title'] -> content = _the_shop_truncate_html($fields['title'] -> raw, $title_len);
?>
<figure class="uk-overlay uk-overlay-hover">
<?php print $fields['field_image'] -> content;?>
<div class="uk-overlay-panel uk-overlay-background-white uk-text-center">
<h5><?php echo $fields['title'] -> content;?></h5>
<?php echo $fields['display_price'] -> content;?>
<?php echo $fields['field_old_price'] -> content;?>
</div>
<a class="uk-position-cover" href="<?php echo $link;?>"></a>
</figure>
