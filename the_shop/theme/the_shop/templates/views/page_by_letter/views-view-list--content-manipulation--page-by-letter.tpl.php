<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * - $title : The title of this group of rows.  May be empty.
 * - $options['type'] will either be ul or ol.
 * @ingroup views_templates
 */
?>
<?php if (!empty($title)) : ?>
<h3 class="abc-class"><?php print $title; ?></h3>
<?php endif; ?>
<div class="uk-grid uk-grid-width-small-1-2 uk-grid-width-medium-1-5 uk-grid-width-large-1-7" data-uk-grid="{gutter: 15, animation: false}">
<?php foreach ($rows as $id => $row): ?>
<div>
<div class="article-wrapper">
<?php print $row; ?>
</div>
</div>
<?php endforeach; ?>
</div>
