<?php

/**
 * @file
 * Theme the more link.
 *
 * - $view: The view object.
 * - $more_url: the url for the more link.
 * - $link_text: the text for the more link.
 *
 * @ingroup views_templates
 */
?>

<div class="more-link uk-text-center">
<a href="<?php print $more_url;?>" class="uk-button uk-button-primary uk-button-large uk-margin-top"><?php echo _t('_view_all_items_');?></a>
</div>
