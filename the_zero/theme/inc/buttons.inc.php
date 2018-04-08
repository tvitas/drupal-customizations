<?php
/**
 * Overrides theme_button().
 */
function the_zero_button($variables) {
  $element = $variables['element'];
  $label = $element['#value'];
  $str_id = _gid($element['#value']);
  $label = _t($str_id, $label);
  $icons = array();
  $icon = '';
  element_set_attributes($element, array('id', 'name', 'value', 'type'));

  // If a button type class isn't present then add in default.
  $button_classes = array(
    'uk-button',
    'uk-button-primary',
    'uk-button-success',
    'uk-button-danger',
    'uk-button-link',
  );

  $icon_classes = array(
    'fa',
    'fa-shopping-basket',
    'fa-lg',
  );

  $class_intersection = array_intersect($button_classes, $element['#attributes']['class']);

  $icon_intersection = array_intersect($icon_classes, $element['#attributes']['class']);

  if (!empty($icon_intersection)) {
    $i = 0;
	foreach($element['#attributes']['class'] as $attributes_class) {
      foreach ($icon_classes as $icon_class) {
        if ($icon_class == $attributes_class) {
          unset ($element['#attributes']['class'][$i]);
          $icons['#attributes']['class'][] =  $icon_class;
        }
      }
      $i++;
    }
    $icon = '<i ' . drupal_attributes($icons['#attributes']) . '></i>&nbsp';
  }

  if (empty($class_intersection)) {
    $element['#attributes']['class'][] = 'uk-button uk-margin-bottom';
  }

  // Add in the button type class.
  $element['#attributes']['class'][] = 'form-' . $element['#button_type'];

  // This line break adds inherent margin between multiple buttons.
  return '<button' . drupal_attributes($element['#attributes']) . ' type="button">' . $icon . $label . '</button>' . "\n";
}


function the_zero_preprocess_button(&$variables) {
  $variables['element']['#attributes']['class'][] = 'uk-button';
  $variables['element']['#attributes']['class'][] = 'uk-margin-bottom';
  if (isset($variables['element']['#value'])) {
    if ($class = _the_zero_colorize_button($variables['element']['#value'])) {
      $variables['element']['#attributes']['class'][] = $class;
    }
  }
}

/**
 * Colorize buttons based on the text value.
 *
 * @param string $text
 *   Button text to search against.
 *
 * @return string
 *   The specific button class to use or FALSE if not matched.
 */
function _the_zero_colorize_button($text) {
  // Text values containing these specific strings, which are matched first.
  $specific_strings = array(
    'uk-button-primary' => array(
      t('Download feature'),
      t('Save and add'),
      t('Add another item'),
      t('Update style'),
      t('Review'),
      t('Mail'),
      t('Continue'),
      t('Update cart'),
      t('Back'),
      t('Subscribe'),
      t('Submit'),
      t('Atnaujinti'),
      t('Send'),
    ),
    'uk-button-success' => array(
      t('Add effect'),
      t('Add and configure'),
      t('Atgal'),
      t('Checkout'),
      t('Užsakyti'),
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
