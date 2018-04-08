<?php
function the_shop_table(&$variables) {
	$variables['attributes']['class'][] = 'uk-table';
	$variables['#prefix'] = '<div class="uk-overflow-container">';
	$variables['#suffix'] = '</div>';
	return $variables['#prefix'] . theme_table($variables) . $variables['#suffix'];
}
