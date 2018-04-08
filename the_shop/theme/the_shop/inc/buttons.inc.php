<?php

/**
 * Colorize buttons based on the text value.
 *
 * @param string $text
 *   Button text to search against.
 *
 * @return string
 *   The specific button class to use or FALSE if not matched.
 */
function _the_shop_colorize_button($text) {
  // Text values containing these specific strings, which are matched first.
  $specific_strings = array(
    'uk-button-primary' => array(
      t('Download feature'),
      t('Save and add'),
      t('Add another item'),
      t('Update style'),
      t('Mail'),
      t('Continue'),
      t('Update cart'),
      t('Subscribe'),
      t('Submit'),
      t('Atnaujinti'),
    ),
    'uk-button-success' => array(
      t('Add effect'),
      t('Add and configure'),
      t('Back'),
      t('Checkout'),
      t('Review'),
    ),
    'uk-button-danger' => array(
      t('Empty'),
      t('Cancel'),
    )
  );
  // Text values containing these generic strings, which are matches last.
  $generic_strings = array(
    'uk-button-primary' => array(
      t('Save'),
      t('Confirm'),
      t('Submit'),
      t('Search'),
      t('Export'),
      t('Import'),
      t('Restore'),
      t('Rebuild'),
      t('Log In'),
      t('Apply'),
      t('Add to cart'),
    ),
    'uk-button-success' => array(
      t('Create'),
      t('Write'),
      t('Update'),
    ),
    'uk-button-danger' => array(
      t('Delete'),
      t('Remove'),
      t('Cancel'),
    )
  );
  // Specific matching first.
  foreach ($specific_strings as $class => $strings) {
    foreach ($strings as $string) {
      if (strpos(drupal_strtolower($text), drupal_strtolower($string)) !== FALSE) {
        return $class;
      }
    }
  }
  // Generic matching last.
  foreach ($generic_strings as $class => $strings) {
    foreach ($strings as $string) {
      if (strpos(drupal_strtolower($text), drupal_strtolower($string)) !== FALSE) {
        return $class;
      }
    }
  }
  return FALSE;
}
