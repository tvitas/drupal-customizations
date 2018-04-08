<?php
//$fields['nid']->content;
//$fields['title']->content;
//$fields['field_image']->content;
global $language_content;
$lang = $language_content -> language;
$title_len = theme_get_setting('title_len');
$teaser_len = theme_get_setting('teaser_len');
//$fields['title'] -> raw = _the_zero_truncate_html($fields['title'] -> raw, $title_len);
$fields['field_description'] -> content = _the_zero_truncate_html($fields['field_description'] -> content, $teaser_len);
?>
<?php print $view -> render_field('field_image', $view -> row_index);?>
<div id="slide-show-block-page">
<div class="uk-overlay-panel uk-overlay-background uk-flex uk-flex-center uk-flex-middle uk-text-center">
<div>
<h2><?php echo $fields['title'] -> raw;?></h2>
<?php echo $fields['field_description'] -> content;?>
</div>
</div>
</div>
