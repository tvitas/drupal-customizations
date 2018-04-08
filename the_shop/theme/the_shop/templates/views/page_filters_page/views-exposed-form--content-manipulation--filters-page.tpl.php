<div class="node-body-wrapper">
<div id="acc-filter" class="node-body">

<h3><?php echo _t('_exposed_description_', t('Select any filter or filters combination and click on Apply to or press ENTER see results'));?></h3>
<hr class="uk-article-divider">

<?php /*divide main form into halfs*/?>
<div class="uk-grid uk-grid-width-small-1-1 uk-grid-width-medium-1-2">


<div id="acc-filter-category-box"><?php /* main form 1/2 */?>
<h5><?php print _t('_category_', t('Category'));?></h5>
<div class="uk-scrollable-box">
<?php print($widgets['filter-field_category_tid']->widget);?>
</div>
</div>

<div><?php /* main form 1/2 */?>
<?php print($widgets['filter-title']->widget);?>
<?php print($widgets['filter-field_author_value']->widget);?>
<?php print($widgets['filter-field_isbn_value']->widget);?>
<?php print($widgets['filter-field_publishing_house_value']->widget);?>
<?php print($widgets['filter-field_published_value']->widget);?>
<?php print($widgets['filter-field_pages_value']->widget);?>
<?php print($widgets['filter-body_value']->widget);?>
<?php print($widgets['filter-field_specifications_value']->widget);?>
<?php /*Now divide into thirds*/?>
<div class="uk-margin-top uk-grid uk-grid-width-small-1-1 uk-grid-width-medium-1-3 uk-grid-width-large-1-3">

<div><?php /* 1/3 */?>
<?php print($widgets['filter-field_cover_value_i18n']->widget);?>
</div>

<div><?php /* 1/3 */?>
<?php print($widgets['filter-field_book_language_value_i18n']->widget);?>
</div><?php /* end 1/3 */?>

<div><?php /* 1/3 */?>
<?php //print($widgets['filter-field_format_value_i18n']->widget);?>
</div>
</div>

<?php print($sort_by);?>
<?php print($sort_order);?>

</div>
</div>

<div class="uk-margin-top">
<?php print($button);?>
</div>


</div>
</div>
