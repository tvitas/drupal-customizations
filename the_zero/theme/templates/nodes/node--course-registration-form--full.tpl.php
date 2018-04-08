<?php hide($content['links']);?>
<article class="article-wrapper">
<div class="node-body-wrapper">
<div class="node-body">
<?php if ($title):?>
<h3><?php print $title;?></h3>
<hr class="uk-article-divider">
<?php endif;?>
<?php print render($content);?>
</div>
</div>
</article>
