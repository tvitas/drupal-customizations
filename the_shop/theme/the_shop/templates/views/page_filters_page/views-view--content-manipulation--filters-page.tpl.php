<?php if ($header): ?>
<?php print $header; ?>
<?php endif; ?>
<?php if ($exposed): ?>
<?php //print $exposed;?>
<?php endif; ?>
<?php if ($attachment_before): ?>
<?php print $attachment_before; ?>
<?php endif; ?>
<?php if ($rows): ?>
<a id="rows-anchor"></a>
<h2 class="product-category-title"><?php echo _t('_found_products_', 'Rastos prekės');?></h2>

<div id="search-content">
<?php if ($pager): ?>
<?php print $pager; ?>
<?php endif; ?>

<?php print $rows; ?>
<?php elseif ($empty): ?>
<?php print $empty; ?>
<?php endif; ?>
</div>
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
<?php if ($view->total_rows > 0):?>
<script type="text/javascript">
jQuery('html,body').animate({scrollTop: jQuery('#rows-anchor').offset().top-55}, 1100);
</script>
<?php endif;?>

