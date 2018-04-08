<div class="uk-accordion" data-uk-accordion="{collapse: false, showfirst: true}">

<button class="uk-accordion-title uk-button uk-button-primary" type="button"><?php echo _t('_filter_', 'Filtras');?> <i class="uk-icon-caret-down"></i></button>

<div id="acc-content" class="uk-accordion-content">
<div class="node-body-wrapper">
<div id="acc-filter" class="node-body">

<h3><?php echo _t('_exposed_description_', t('Select any filter and click on Apply to or press ENTER see results'));?></h3>
<hr class="uk-article-divider">

<div class="uk-grid uk-grid-width-small-1-1 uk-grid-width-medium-1-2">

<div>
<div class="uk-grid uk-grid-width-small-1-1 uk-grid-width-medium-1-2">

<div>
<?php print($widgets['filter-field_category_tid']->widget);?>
</div>

</div>
</div>

<div>
<?php print($widgets['filter-title']->widget);?>
<?php print($widgets['filter-body_value']->widget);?>
<?php print($sort_by);?>
<?php print($sort_order);?>
<div class="uk-clearfix"></div>
</div>
<div>
<?php print($button);?>
</div>
</div>

</div>
</div>
</div>
</div>
