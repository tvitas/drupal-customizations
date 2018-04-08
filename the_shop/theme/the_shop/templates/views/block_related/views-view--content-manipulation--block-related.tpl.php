<?php
$block_title = _t($view -> get_title($view -> current_display), 'Panašios prekės');
?>
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
<h2 class="uk-text-center"><?php echo $block_title;?></h2>
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
<?php if ($footer): ?>
<?php print $footer; ?>
<?php endif; ?>
<?php if ($feed_icon): ?>
<?php print $feed_icon; ?>
<?php endif; ?>
<?php /* class view */ ?>
