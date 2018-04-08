<?php
//$fields['nid']->content;
//$fields['title']->content;
//$fields['field_image']->content;
global $language_content;
$lang = $language_content -> language;
//$link = $GLOBALS['base_url'] . '/' . drupal_get_path_alias(strip_tags($fields['field_button_link'] -> content));
$title_len = theme_get_setting('title_len');
$teaser_len = theme_get_setting('teaser_len');
$fields['title'] -> raw = _the_shop_truncate_html($fields['title'] -> raw, $title_len);
$fields['field_description'] -> content = _the_shop_truncate_html($fields['field_description'] -> content, $teaser_len);
$product_css_class = strtolower(_tlr($fields['title'] -> raw));
$link = $fields['field_button_link'] -> content;
?>
<?php print $fields['field_image'] -> content;?>
<div id="slide-show-block">
<div class="uk-overlay-panel uk-overlay-background uk-flex uk-flex-center uk-flex-middle uk-text-center">
<div>
<h2 class="<?php echo $product_css_class;?>"><?php echo $fields['title'] -> raw;?></h2>
<?php echo $fields['field_description'] -> content;?>
<?php if (isset($link) && $link): ?>
<div class="uk-text-center"><button class="uk-button uk-button-primary uk-button-large"><?php echo _t('_learn_more_', 'Sužinokite daugiau');?></button></div>
<?php endif;?>
</div>
</div>
</div>
<?php if (isset($link) && $link): ?>
<a class="uk-position-cover" href="<?php echo $link;?>"></a>
<?php endif;?>



