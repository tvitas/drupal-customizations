<?php hide($content['links']);?>
<?php hide($content['field_image']);?>
<?php
if (isset($content['field_image'][0])) {
$image_href = file_create_url($content['field_image'][0]['#item']['uri']);
$content['field_description'] = "<div class=\"align_left\"><figure>"
. "<a href=\"$image_href\" data-uk-lightbox=\"{group:'grp'}\" title=\"$title\">"
. render($content['field_image'][0])
. "</a>"
. "</figure></div>\n"
. render($content['field_description'][0]['#markup'])
. '<div class="uk-clearfix"></div>';
} else {
	$content['field_description'] = render($content['field_description']);
}
?>

<article class="article-wrapper">

<div class="node-body-wrapper">
<div class="node-body">
<?php if ($title):?>
<h3><?php print $title;?></h3>
<hr class="uk-article-divider">
<?php endif;?>
<?php print (isset($content['field_description'])) ? $content['field_description'] : '';?>
</div>
</div>

<?php if (count($content['field_image']) > 0  && isset($content['field_image'][1])):?>
<div class="node-images-wrapper uk-margin-top">
<div class="node-images">
<h3><?php print _t('_gallery_', 'Galerija');?></h3>
<hr class="uk-article-divider">
<div class="uk-grid uk-grid-width-small-1-1 uk-grid-width-medium-1-3 uk-grid-width-large-1-6">
<?php $counter = 0;?>
<?php foreach ($content['field_image'] as $val):?>
<?php if(isset($content['field_image'][$counter])):?>
<?php $image_href = file_create_url($content['field_image'][$counter]['#item']['uri']);?>
<div>
<figure>
<a href="<?php echo $image_href?>" data-uk-lightbox="{group: 'grp'}"><?php print render ($content['field_image'][$counter]);?></a>
</figure>
</div>
<?php endif;?>
<?php $counter++;?>
<?php endforeach;?>
</div>
</div>
</div>
<?php endif;?>

</article>



