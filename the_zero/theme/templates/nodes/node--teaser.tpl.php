<?php
if (isset($content['links']['node']['#links']['node-readmore']['title'])) {
	$content['links']['node']['#links']['node-readmore']['title'] = str_replace('Read more', _t('_read_more_', 'Daugiau...'), $content['links']['node']['#links']['node-readmore']['title']);
	$content['links']['node']['#links']['node-readmore']['title'] = str_replace('about', _t('_about_', 'apie'), $content['links']['node']['#links']['node-readmore']['title']);
}
	$content['content'] = render($content['body']);
  if ($share_social) {
    $content['content'] .= '<h4>' . $share_social_title . '</h4>' . $share_social;
  }
?>
<?php if ((isset($content['field_image'])) && (count($content['field_image']) > 0)):?>
<?php
if (isset($content['field_image'][0])) {
	$markup = $content['body'][0]['#markup'];
	$image = render($content['field_image'][0]);
	$content['content'] = '<div class="uk-grid">' . "\n";
	$content['content'] .= '<figure class="uk-margin-bottom  uk-width-small-1-1 uk-width-medium-1-1 uk-width-large-1-2">' . "\n";
	$content['content'] .= $image;
	$content['content'] .= '</figure>' . "\n";
	$content['content'] .= '<div class="uk-width-small-1-1 uk-width-medium-1-1 uk-width-large-1-2">' . "\n";
	$content['content'] .= '<div class="teaser-body">' . "\n";
	$content['content'] .= $markup;
	$content['content'] .= '</div>' . "\n";
	$content['content'] .= '</div>' . "\n";
	$content['content'] .= '</div>' . "\n";
  if ($share_social) {
    $content['content'] .= '<h4>' . $share_social_title . '</h4>' . $share_social;
  }
}
?>
<?php endif;?>

<article class="article-wrapper uk-article">

<div class="node-body-wrapper">
<div class="node-body">
<?php if ($title):?>
<h3 class="teaser-title"><a href="<?php print $node_url;?>"><?php print $title;?></a></h3>
<hr class="uk-article-divider">
<?php endif;?>
<?php print $content['content'];?>
<?php //print render($content['links']);?>
</div>
</div>
</article>
