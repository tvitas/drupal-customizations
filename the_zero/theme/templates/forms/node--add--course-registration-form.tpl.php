<div class="node-body-wrapper">
<div class="node-body">
<h3><?php print drupal_render($form['#title']);?></h4>
<hr class="uk-article-divider">

<div class="uk-grid uk-grid-width-small-1-2">

<div>
<?php print drupal_render($form['field_first_name']);?>
<?php print drupal_render($form['field_last_name']);?>
<?php print drupal_render($form['field_gender']);?>
<?php print drupal_render($form['field_affiliation']);?>
<?php print drupal_render($form['field_e_mail_address']);?>
<?php print drupal_render($form['field_telephone_number']);?>
</div>

<div>
<?php print drupal_render($form['field_degrees_you_have_obtained']);?>
<?php print drupal_render($form['field_previous_experience']);?>
<?php print drupal_render($form['field_current_advisor_s_name']);?>
<?php print drupal_render($form['field_main_publications_list']);?>
<?php print drupal_render($form['field_personal_research_interest']);?>
<?php print drupal_render($form['field_learning_expectations']);?>
<?php print drupal_render($form['field_link_to_cv']);?>
</div>
</div><?php /*end grid*/?>
<hr class="uk-article-divider">
<?php print drupal_render($form['form_id']);?>
<?php print drupal_render($form['yoursiteurl']);?>
<?php print drupal_render($form['actions']);?>

</div><?php /*end node-body*/?>
</div>
