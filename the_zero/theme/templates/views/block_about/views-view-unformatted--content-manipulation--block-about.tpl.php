<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
$cols_small = '1';
$cols_medium = '2';
$cols_large = '2';
if ((isset($view -> args[1])) && $view -> args[1]) {
	$term_object = taxonomy_term_load($view -> args[1]);
	$settings = array();
	if (isset($term_object -> field_taxonomy_settings['und'])) {
		$settings = json_decode($term_object -> field_taxonomy_settings['und'][0]['value'], TRUE);
	}
	if (isset($settings['cols'])) {
		$arr = explode(',', $settings['cols']);
		if (isset($arr[0])) {
			$cols_small = $arr[0];
		}
		if (isset($arr[1])) {
			$cols_medium = $arr[1];
		}
		if (isset($arr[2])) {
			$cols_large = $arr[2];
		}
	}
}
$classes = 'uk-grid uk-grid-width-small-1-' . $cols_small . ' uk-grid-width-medium-1-' . $cols_medium .' uk-grid-width-large-1-' . $cols_large .' uk-margin-top';
?>
<?php if (!empty($title)): ?>
<h3><?php print $title; ?></h3>
<?php endif; ?>
<div class="<?php echo $classes;?>" data-uk-grid="{gutter: 15, animation: false}">
<?php foreach ($rows as $id => $row): ?>
<?php print $row;?>
<?php endforeach; ?>
</div>
