<?php hide($content['links']);?>
<?php hide($content['field_image']);?>
<?php hide($content['field_file']);?>
<?php
$share_social_title = isset($share_social_title) ? '<h3>' . $share_social_title . '</h3>' : '';
$share_social = isset($share_social) ? $share_social : '';
if (isset($content['field_image'][0])) {
$image_href = file_create_url($content['field_image'][0]['#item']['uri']);
$content['body'] = "<div class=\"align_left\"><figure>"
. "<a href=\"$image_href\" data-uk-lightbox=\"{group:'grp'}\" title=\"$title\">"
. render($content['field_image'][0])
. "</a>"
. "</figure></div>"
. render($content['body'][0]['#markup'])
. $share_social_title
. $share_social
. '<div class="uk-clearfix"></div>';
} else {
	$content['body'] = render($content['body']);
	if (isset($share_social_title) && isset($share_social)) {
		$content['body'] .= '<h4>' . $share_social_title . '</h4>' . $share_social;
	}
}
?>

<article class="article-wrapper">

<div class="node-body-wrapper">
<div class="node-body">
<?php if ($title):?>
<h3><?php print $title;?></h3>
<hr class="uk-article-divider">
<?php endif;?>
<?php print render($content['body']);?>
</div>
</div>


<?php if (count($content['field_image']) > 0  && isset($content['field_image'][1])):?>
<div class="node-images-wrapper uk-margin-top">
<div class="node-images">
<h3><?php print _t('_gallery_', 'Galerija');?></h3>
<hr class="uk-article-divider">
<div class="uk-grid uk-grid-width-small-1-1 uk-grid-width-medium-1-3 uk-grid-width-large-1-6" data-uk-grid="{gutter: 15}">
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



<?php if (count($content['field_file']) > 0 && isset($content['field_file'][0])):?>
<div class="node-files-wrapper uk-margin-top">
<div class="node-files">
<h3><?php print _t('_files_', 'Failai');?></h3>
<hr class="uk-article-divider">
<div class="uk-grid uk-grid-width-small-1-1 uk-grid-width-medium-1-4 uk-grid-width-large-1-6">
<?php $counter = 0;?>
<?php foreach ($content['field_file'] as $val):?>
<?php if(isset($content['field_file'][$counter])):?>
<div>
<?php print render ($content['field_file'][$counter]);?>
</div>
<?php endif;?>
<?php $counter++;?>
<?php endforeach;?>
</div>
</div>
</div>
<?php endif;?>

</article>
