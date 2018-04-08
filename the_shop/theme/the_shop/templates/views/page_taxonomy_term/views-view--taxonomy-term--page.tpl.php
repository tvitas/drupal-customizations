<?php $terms_not_exposed = explode(',', theme_get_setting('terms_not_exposed'));?>
<div id="taxonomy-content">
<?php if ($header): ?>
<?php print $header; ?>
<?php endif; ?>

<?php if ($attachment_before): ?>
<?php print $attachment_before; ?>
<?php endif; ?>

<?php if ($exposed): ?>
<?php if (!in_array(arg(2), $terms_not_exposed)): ?>
<div id="taxonomy-term-exposed">
<?php print $exposed;?>
</div>
<div class="uk-clearfix"></div>
<?php endif;?>
<?php endif; ?>

<?php if ($pager): ?>
<?php print $pager; ?>
<?php endif; ?>

<?php if ($rows): ?>
<?php print $rows; ?>
<?php elseif ($empty): ?>
<?php print $empty; ?>
<?php endif; ?>

<?php if ($pager): ?>
<?php print $pager; ?>
<?php endif; ?>

<?php if ($attachment_after): ?>
<?php print $attachment_after; ?>
<?php endif; ?>
<?php if ($more): ?>
<?php print $more; ?>
<?php endif; ?>
<?php if ($footer): ?>
<?php print $footer; ?>
<?php endif; ?>
<?php if ($feed_icon): ?>
<?php print $feed_icon; ?>
<?php endif; ?>
<?php /* class view */ ?>
</div>
