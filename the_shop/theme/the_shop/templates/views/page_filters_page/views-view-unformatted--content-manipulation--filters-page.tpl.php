<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
$classes = 'uk-grid uk-grid-width-medium-1-3 uk-grid-width-large-1-5 uk-grid-width-small-1-2 uk-margin-top';
//$title = _t('_product_search_page_', 'Prekių paieška');
?>
<div class="<?php echo $classes;?>" data-uk-grid="{gutter: 15, animation: false}">
<?php foreach ($rows as $id => $row): ?>
<?php print $row;?>
<?php endforeach; ?>
</div>

