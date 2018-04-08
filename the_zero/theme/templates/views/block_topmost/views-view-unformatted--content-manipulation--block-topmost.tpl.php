<?php
/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>

<?php $result = count($view -> result);?>
<?php if (($result % 2) !== 0): ?>
<?php $rows[] = $rows[0];?>
<?php endif;?>

<div data-uk-slideset="{small: 1, medium: 2, large: 2, autoplay: true, autoplayInterval: 5000, duration: 500}">
<div class="uk-slidenav-position">
<ul class="uk-grid uk-slideset">
<?php foreach ($rows as $id => $row): ?>
<li>
<?php print $row; ?>
</li>
<?php endforeach; ?>
</ul>
<a href="#" class="uk-slidenav uk-slidenav-previous" data-uk-slideset-item="previous"></a>
<a href="#" class="uk-slidenav uk-slidenav-next" data-uk-slideset-item="next"></a>
</div>
</div>
