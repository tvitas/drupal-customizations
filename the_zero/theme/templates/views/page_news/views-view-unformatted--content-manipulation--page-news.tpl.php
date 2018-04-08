<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
$classes = 'uk-grid uk-grid-width-medium-1-1 uk-grid-width-large-1-2';
if ($view -> total_rows == 1) $classes = 'uk-grid uk-grid-width-medium-1-1 uk-grid-width-large-1-1';
?>
<?php if (!empty($title)): ?>
<h3><?php print $title; ?></h3>
<?php endif; ?>
<div class="<?php echo $classes;?>" data-uk-grid="{gutter: 15, animation: false}">
<?php foreach ($rows as $id => $row): ?>
<?php print $row;?>
<?php endforeach; ?>
</div>
