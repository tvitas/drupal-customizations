<?php
/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
$classes = 'uk-grid uk-grid-width-medium-1-2 uk-grid-width-large-1-2 uk-grid-width-xlarge-1-2 views-row';
if (count($view -> result) == 1) $classes = 'uk-grid uk-grid-width-medium-1-1 uk-grid-width-large-1-1 views-row';
$controls = '';
?>
<div class="view-content">
<div class="<?php echo $classes;?>" data-uk-grid="{gutter: 15<?php echo $controls;?>}">
<?php foreach ($rows as $id => $row): ?>
<?php print $row;?>
<?php endforeach; ?>
</div>
</div>
