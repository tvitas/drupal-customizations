<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
$classes = 'uk-grid uk-grid-width-medium-1-2 uk-grid-width-large-1-2 uk-margin-top';
$view = views_get_current_view();
$filter_value = '';
if (isset($view->exposed_input['populate'])) {
	$filter_value = $view->exposed_input['populate'];
}
if (empty($filter_value)) {
	$filter_value = _t('_all_content_', 'Visas turinys');
}
$title = _t('_phrase_search_', 'Frazės paieška');
?>
<h2 class="uk-text-center"><?php echo _t($title, $title); ?></h2>
<h3 class="uk-text-center"><?php echo _t('_entered_phrase_', 'Paieškos frazė') . ': „' . $filter_value . '“'; ?></h3>
<div class="<?php echo $classes;?>" data-uk-grid="{gutter: 15, animation: false}">
<?php foreach ($rows as $id => $row): ?>
<?php print $row;?>
<?php endforeach; ?>
</div>
