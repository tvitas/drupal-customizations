<?php
/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */

?>

<div id="category-on-sale-box" class="uk-margin" data-uk-slideset="{small: 2, medium: 4, large: 5, animation: 'fade'}">
<div class="uk-slidenav-position uk-margin">
<ul class="uk-slideset uk-grid uk-flex-center uk-grid-width-large-1-5, uk-grid-width-medium-1-3 uk-grid-width-small-1-2">
<?php foreach ($rows as $id => $row): ?>
<li>
    <?php print $row; ?>
</li>
<?php endforeach; ?>
</ul>
<a href="#" class="uk-slidenav uk-slidenav-previous" data-uk-slideset-item="previous"></a>
<a href="#" class="uk-slidenav uk-slidenav-next" data-uk-slideset-item="next"></a>
</div>
<ul class="uk-slideset-nav uk-dotnav uk-flex-center">
<?php foreach ($rows as $id => $row): ?>
<li>
    <?php print $id; ?>
</li>
<?php endforeach; ?>
</ul>
</div>
