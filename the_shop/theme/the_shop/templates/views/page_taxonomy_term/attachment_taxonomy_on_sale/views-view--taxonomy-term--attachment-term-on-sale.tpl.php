<?php
global $language_content;
$lang = $language_content -> language;
$term = taxonomy_get_term_by_name('Išpardavimas','content_tree');
if ($term) {
	$tid = key($term);
	$more_url = $GLOBALS['base_url'] . '/' . $lang . '/' . drupal_get_path_alias('taxonomy/term/' . $tid);
	$title = _t('_on_sale_', 'Išpardavimas');
}
?>
<?php if ($view -> args[0] != $tid): ?>
<?php if ($rows): ?>
<?php if ($title): ?>
<h3 class="uk-text-center"><?php print $title;?></h3>
<?php endif;?>
<div class="divider-last"></div>

<?php print $rows; ?>
<?php if ($more): ?>

<div class="more-link uk-text-center">
<a href="<?php print $more_url;?>" class="uk-button uk-button-primary uk-button-large uk-margin-top"><?php echo _t('_view_all_items_');?></a>
</div>

<?php endif; ?>
<div class="divider-last"></div>
<h3 class="uk-text-center"><?php print _t('_products_', 'Prekės');?></h3>
<?php elseif ($empty): ?>
<?php print $empty; ?>
<?php endif; ?>
<?php endif; ?>
<?php /* class view */ ?>
