<?php
/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>
<div class="uk-slidenav-position" data-uk-slideshow="{autoplay:true, pauseOnHover: false}">
<ul class="uk-slideshow uk-slideshow-fullscreen">
<?php foreach ($rows as $id => $row): ?>
<li>
<?php print $row;?>
</li>
<?php endforeach; ?>
</ul>
<a href="#" class="uk-slidenav uk-slidenav-contrast uk-slidenav-previous" data-uk-slideshow-item="previous"></a>
<a href="#" class="uk-slidenav uk-slidenav-contrast uk-slidenav-next" data-uk-slideshow-item="next"></a>
</div>
