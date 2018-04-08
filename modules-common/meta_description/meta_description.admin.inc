<?php
/**
 * Create form for managing and configure meta description tags
 *
 * @param $form
 * @param &$form_state
 *
 * @return array
 */

require('constants.inc');

function meta_description_settings_form($form, &$form_state) {

  $md_settings = variable_get('md_settings', array());

  $form['md_default_site'] = array(
    '#title' => t('Default meta description for whole site'),
    '#type' => 'textarea',
    '#default_value' => $md_settings['md_default_site'],
    '#rows' => 3,
    '#description' => t('Enter a default meta description tag content for whole site. It applies on whole site pages if any other values below is blank. If leaving it blank, a concatenated string of site name and slogan will be entered.'),
    '#resizable' => TRUE,
    '#required' => FALSE,
  );

  $form['md_default_front_page'] = array(
    '#title' => t('Default meta description for front page'),
    '#type' => 'textarea',
    '#default_value' => $md_settings['md_default_front_page'],
    '#rows' => 3,
    '#description' => t('Enter a default meta description tag content for front page. It applies on front page.'),
    '#resizable' => TRUE,
    '#required' => FALSE,
  );

  $form['md_default_taxonomy_term'] = array(
    '#title' => t('Default meta description for taxonomy term pages'),
    '#type' => 'textarea',
    '#default_value' => $md_settings['md_default_taxonomy_term'],
    '#rows' => 3,
    '#description' => t('Enter a default meta description tag content for taxonomy term. It applies on all taxonomy term pages if taxonomy term description is blank.'),
    '#resizable' => TRUE,
    '#required' => FALSE,
  );

  $form['md_default_node'] = array(
    '#title' => t('Default meta description for node view pages'),
    '#type' => 'textarea',
    '#default_value' => $md_settings['md_default_node'],
    '#rows' => 3,
    '#description' => t('Enter a default meta description tag content for node view pages. It applies on all node view pages if node field body is blank.'),
    '#resizable' => TRUE,
    '#required' => FALSE,
  );

  $form['md_node_words_threshold_min'] = array(
    '#title' => t('Words count threshold on node body'),
    '#type' => 'textfield',
    '#default_value' => $md_settings['md_node_words_threshold_min'],
    '#description' => t('Enter a node words threshold value, on which use a default description. Default value 10.'),
    '#required' => FALSE,
  );

  $form['md_node_words_truncate_threshold'] = array(
    '#title' => t('Words truncate threshold on node body'),
    '#type' => 'textfield',
    '#default_value' => $md_settings['md_node_words_truncate_threshold'],
    '#description' => t('Enter a node words threshold value, on which truncate a node body. Default value 150.'),
    '#required' => FALSE,
  );

  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Save'),
  );

  return $form;
}

/**
 * Submit handler
 *
 * @param $form
 * @param $form_state
 */
function meta_description_settings_form_submit($form, &$form_state) {
  $md_settings = variable_get('md_settings');
  $default = trim(variable_get('site_name', '') . '. ' . variable_get('site_slogan', ''));

  $md_settings['md_default_site'] = $form_state['values']['md_default_site'];
  if (empty($md_settings['md_default_site'])) {
    $md_settings['md_default_site'] = $default;
  }

  $md_settings['md_default_taxonomy_term'] = $form_state['values']['md_default_taxonomy_term'];
  $md_settings['md_default_node'] = $form_state['values']['md_default_node'];
  $md_settings['md_default_front_page'] = $form_state['values']['md_default_front_page'];

  $md_settings['md_node_words_threshold_min'] = $form_state['values']['md_node_words_threshold_min'];
  if (empty($md_settings['md_node_words_threshold_min'])) {
    $md_settings['md_node_words_threshold_min'] = WORD_COUNT_THRESHOLD;
  }

  $md_settings['md_node_words_truncate_threshold'] = $form_state['values']['md_node_words_truncate_threshold'];
  if (empty($md_settings['md_node_words_truncate_threshold'])) {
    $md_settings['md_node_words_truncate_threshold'] = WORD_TRUNCATE_THRESHOLD;
  }

  variable_set('md_settings', $md_settings);

  drupal_set_message(t('Meta description tag settings saved.'));

  $form_state['redirect'] = 'admin/config/content/meta_description';
}
