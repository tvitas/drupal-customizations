<div id="abc-list-wrapper">
<?php if ($header): ?>
<?php print $header; ?>
<?php endif; ?>
<?php if ($exposed): ?>
<?php print $exposed; ?>
<?php endif; ?>
<?php if ($attachment_before): ?>
<?php print $attachment_before; ?>
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
<?php print $more;?>
<?php endif; ?>
<?php if ($footer): ?>
<?php print $footer; ?>
<?php endif; ?>
<?php if ($feed_icon): ?>
<?php print $feed_icon; ?>
<?php endif; ?>
</div>
