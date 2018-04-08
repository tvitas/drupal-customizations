<?php global $user;?>
<div class="node-body-wrapper">
<div class="node-body">
<h3><?php print _t('_my_orders_', $title);?></h3>
<hr class="uk-article-divider">
<?php if ($header): ?>
<?php print $header; ?>
<?php endif; ?>
<?php if ($exposed): ?>
<?php print $exposed;?>
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
<?php print l(_t('_my_profile_', t('My profile')), '/user/' . $user->uid, array('attributes' =>array('class'=> array('uk-button', 'uk-button-primary'))));?>&emsp;
<?php if (module_exists('uc_file')):?>
<?php print l(_t('_my_files_', t('My files')), '/user/' . $user->uid . '/purchased-files', array('attributes' =>array('class'=> array('uk-button', 'uk-button-primary'))));?>&emsp;
<?php endif;?>
<?php print l(_t('_log_out_', t('Log out')), '/user/logout', array('attributes' =>array('class'=> array('uk-button', 'uk-button-danger'))));?>&emsp;
</div>
</div>
