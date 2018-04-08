<?php
//$fields['nid']->content;
//$fields['title']->content;
//$fields['field_image']->content;
global $language_content;
$lang = $language_content -> language;
$link = $GLOBALS['base_url'] . '/' . drupal_get_path_alias(strip_tags($fields['field_linkto'] -> content));
$title_len = theme_get_setting('title_len');
$teaser_len = theme_get_setting('teaser_len');
//$fields['title'] -> raw = _the_zero_truncate_html($fields['title'] -> raw, $title_len);
//$fields['field_description'] -> content = _the_zero_truncate_html($fields['field_description'] -> content, $teaser_len);
$button_class = '';
$has_more_button = ($fields['field_linkto_button'] -> content == 'Yes') ? TRUE : FALSE;
if ($has_more_button) {
	switch ($fields['field_linkto_class'] -> content) {
		case 'Blue': {
			$button_class = ' uk-button-primary';
			break;
		}
		case 'Red': {
			$button_class = ' uk-button-danger';
			break;
		}
		case 'Green': {
			$button_class = ' uk-button-success';
			break;
		}
		default: {
			$button_class = ' uk-button-default';
			break;
		}
	}
}
$filter_view = views_get_view('content_manipulation');
$filter_view->set_display('search_page');
$filter_view->init_handlers();
$filter_var['filter_form'] = $filter_view->display_handler->get_plugin('exposed_form');
?>
<?php print $view -> render_field('field_image', $view -> row_index);?>
<div id="slide-show-block">
<div class="uk-overlay-panel uk-overlay-background uk-flex uk-flex-center uk-flex-middle uk-text-center">
<div class="slide-text-wrapper">
<h2><?php echo $fields['title'] -> raw;?></h2>
<?php echo $fields['field_description'] -> content;?>

<?php //print $filter_var['filter_form']->render_exposed_form(true);?>

<?php if ($has_more_button):?>
<p class="uk-text-center uk-margin-top"><button class="uk-button uk-button-large<?php echo $button_class;?>"><?php echo _t('_learn_more_', 'Sužinokite daugiau');?></button></p>
<?php endif;?>
</div>
</div>
</div>
<?php if ($has_more_button):?>
<a class="uk-position-cover" href="<?php echo $link;?>"></a>
<?php endif;?>
