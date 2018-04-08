<div class="uk-grid uk-grid-width-small-1-2" data-uk-grid="{gutter: 15, animation: false}">

<?php /*CUSTOMER E-MAIL AND DELIVERY ADDRESS*/?>
<section>
<div class="node-body-wrapper">
<div class="node-body">
<h3><?php print $form['panes']['customer']['#title']?></h3>
<hr class="uk-article-divider">
<?php print drupal_render($form['panes']['customer']['primary_email']);?>
<?php print drupal_render($form['panes']['customer']['primary_email_confirm']);?>

<?php if (isset($form['panes']['customer']['email_text'])):;?>
<div class="uk-form-row">
<?php print drupal_render($form['panes']['customer']['email_text']);?>
</div>
<?php endif;?>

<?php print drupal_render($form['panes']['delivery']['address']['delivery_phone']);?>
<?php print drupal_render($form['panes']['delivery']['address']['delivery_first_name']);?>
<?php print drupal_render($form['panes']['delivery']['address']['delivery_last_name']);?>
<?php print drupal_render($form['panes']['delivery']['address']['delivery_street1']);?>
<?php print drupal_render($form['panes']['delivery']['address']['delivery_postal_code']);?>
<?php print drupal_render($form['panes']['delivery']['address']['delivery_city']);?>
<?php print drupal_render($form['panes']['delivery']['address']['delivery_country']);?>


<div class="uk-form-row">

<div class="uk-accordion" data-uk-accordion="{showfirst: false, toggle: '.accordion-toggle'}">

<a href="#" id="edit-delivery-is-company" class="uk-margin-bottom accordion-toggle">
<?php print _t('_company_', t('Company'))?>&nbsp;<i class="uk-icon-caret-down"></i>
</a>


<div class="uk-accordion-content uk-margin-top">
<?php print drupal_render($form['panes']['delivery']['address']['delivery_company']);?>
<?php print drupal_render($form['panes']['delivery']['delivery_company_number']);?>
<?php print drupal_render($form['panes']['delivery']['delivery_company_vat_number']);?>

</div>
</div>
</div>




</div>
</div>
</section>

<?php /*PAYMENT METHOD*/?>
<section>
<div class="node-body-wrapper">
<div class="node-body">
<h3><?php print $form['panes']['payment']['#title'];?></h3>
<hr class="uk-article-divider">
<?php print drupal_render($form['panes']['payment']['payment_method']);?>
</div>
</div>
</section>

<section>
</section>

<?php /*SHIPPING QUOTES*/?>
<?php if ($product_shippable):?>
<section class="uk-margin-bottom">
<div class="node-body-wrapper">
<div class="node-body">
<h3><?php print $form['panes']['quotes']['#title']?></h3>
<hr class="uk-article-divider">
<?php print drupal_render($form['panes']['quotes']['quotes']);?>
</div>
</div>
</section>
<?php else:?>
<?php hide($form['panes']['quotes']['quotes']);?>
<?php endif;?>

</div> <?php /*end grid*/?>

<div class="uk-grid uk-grid-width-small-1-2" data-uk-grid="{gutter: 30, animation: false}">

<?php /*ORDER COMMENTS*/?>
<section class="uk-margin-top">
<div class="node-body-wrapper">
<div class="node-body">
<h3><?php print $form['panes']['comments']['#title']?></h3>
<hr class="uk-article-divider">
<?php print drupal_render($form['panes']['comments']['comments']);?>
</div>
</div>
</section>

<?php /*TERMS OF SERVICE*/?>
<section class="uk-margin-top">
<div class="node-body-wrapper">
<div class="node-body">
<h3><?php print $form['panes']['uc_termsofservice_agreement_checkout']['#title']?></h3>
<hr class="uk-article-divider">
<?php print drupal_render($form['panes']['uc_termsofservice_agreement_checkout']['tos_text']);?>
<?php print drupal_render($form['panes']['uc_termsofservice_agreement_checkout']['tos_agree']);?>
</div>
</div>
</section>

</div> <?php /*end grid*/?>


<div class="uk-form-row uk-margin-top">
<?php print drupal_render($form['form_build_id']);?>
<?php print drupal_render($form['form_id']);?>
<?php print drupal_render($form['form_token']);?>
<?php print drupal_render($form['yoursiteurl']);?>
<hr class=""uk-article-divider">
<?php print drupal_render($form['actions']);?>
</div>
