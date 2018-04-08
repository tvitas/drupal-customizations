<?php foreach ($fields as $id => $field): ?>
<?php if (!empty($field->separator)): ?>
<?php print $field->separator; ?>
<?php endif; ?>


<?php $wrapper_prefix = '<div class="abc-title">';?>
<?php $wrapper_suffix = '</div>';?>

<?php if ($id == 'field_image'): ?>
<?php $wrapper_prefix = '<figure class="abc-figure">';?>
<?php $wrapper_suffix = '</figure>';?>
<?php endif;?>

<?php print $wrapper_prefix; ?>
<?php print $field->content; ?>
<?php print $wrapper_suffix; ?>

<?php endforeach; ?>
