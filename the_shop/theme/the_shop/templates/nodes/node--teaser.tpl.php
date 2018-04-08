<?php hide($content['links']);?>
<?php hide($content['field_image']);?>
<?php hide($content['field_file']);?>
<?php
if (isset($content['links']['node']['#links']['node-readmore']['title'])) {
	$content['links']['node']['#links']['node-readmore']['title'] = str_replace('Read more', _t('_read_more_', 'Daugiau...'), $content['links']['node']['#links']['node-readmore']['title']);
	$content['links']['node']['#links']['node-readmore']['title'] = str_replace('about', _t('_about_', 'apie'), $content['links']['node']['#links']['node-readmore']['title']);
}
$share_social_title = isset($share_social_title) ? $share_social_title : '';
$share_social = isset($share_social) ? $share_social : '';
?>

<article id="article-<?php print $node -> nid;?>" class="uk-article">

<div class="node-body-wrapper">
<div class="node-body">
<?php if ($title):?>
<h3><a href="<?php print $node_url;?>"><?php print $title;?></a></h3>
<hr class="uk-article-divider">
<?php endif;?>
<div class="uk-grid uk-grid-width-1-2">

<figure class="uk-text-center figure-top-most">
<?php if (isset($content['field_image'][0])):?>
<?php $image_href = file_create_url($content['field_image'][0]['#item']['uri']);?>
<?php print render ($content['field_image'][0]);?>
<?php endif;?>
</figure>

<div class="body-topmost">
<?php print render ($content['body']);?>
</div>

</div>

<h4><?php print $share_social_title;?></h4>
<?php print $share_social;?>
<div class="uk-margin-top">
<?php print render($content['links']);?>
</div>

</div>
</div>

</article>
