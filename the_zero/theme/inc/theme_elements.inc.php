<?php
function the_zero_container($variables) {
  $element = $variables['element'];
  // Ensure #attributes is set.
  $element += array('#attributes' => array());

  // Special handling for form elements.
  if (isset($element['#array_parents'])) {
    // Assign an html ID.
    if (!isset($element['#attributes']['id'])) {
      $element['#attributes']['id'] = $element['#id'];
    }
    // Add the 'form-wrapper' class.
    $element['#attributes']['class'][] = 'form-wrapper';
  }
  $element['#attributes']['class'][] = 'uk-form-row';
  return '<div' . drupal_attributes($element['#attributes']) . '>' . $element['#children'] . '</div>';
}


function the_zero_form_element($variables) {
  $element = &$variables['element'];

  // This function is invoked as theme wrapper, but the rendered form element
  // may not necessarily have been processed by form_builder().
  $element += array(
    '#title_display' => 'before',
  );

  // Add element #id for #type 'item'.
  if (isset($element['#markup']) && !empty($element['#id'])) {
    $attributes['id'] = $element['#id'];
  }
  // Add element's #type and #name as class to aid with JS/CSS selectors.
  $attributes['class'] = array('form-item');
  if (!empty($element['#type'])) {
    $attributes['class'][] = 'form-type-' . strtr($element['#type'], '_', '-');
  }
  if (!empty($element['#name'])) {
    $attributes['class'][] = 'form-item-' . strtr($element['#name'], array(' ' => '-', '_' => '-', '[' => '-', ']' => ''));
  }
  // Add a class for disabled elements to facilitate cross-browser styling.
  if (!empty($element['#attributes']['disabled'])) {
    $attributes['class'][] = 'form-disabled';
  }

  $attributes['class'][] = 'uk-form-row';

  $output = '<div' . drupal_attributes($attributes) . '>' . "\n";

  if ($element['#type'] == 'radio' && $element['#return_value'] === '_none') {
    $element['#attributes']['disabled'] = TRUE;
  }

  // If #title is not set, we don't display any label or required marker.
  if ($element['#type'] == 'textfield' || $element['#type'] == 'password') {
	$element['#title_display'] = 'invisible';
	if (isset($element['#title']) && $element['#title']) {
		$tran = trim(_t(_gid(strip_tags($element['#title'])), t(strip_tags($element['#title']))));
		$placeholder = ' placeholder="' . $tran . '" ';
		$element['#children'] = substr_replace($element['#children'], $placeholder, 6, 0);
	}
	if (isset($element['#description'])) {
		$tran = trim(_t(_gid(strip_tags($element['#title']) . '_desc'), t(strip_tags($element['#description']))));
		$tooltip = ' title="' . $tran . '"';
		$element['#children'] = substr_replace($element['#children'], $tooltip, 6, 0);
		//unset($element['#description']);
	}

	if (isset($element['#required']) && $element['#required']) {
		$element['#children'] = $element['#children'] . theme('form_required_marker', $element);
	}
  }

  if ($element['#type'] == 'textarea') {
	$element['#title_display'] = 'invisible';
	if (isset($element['#title']) && $element['#title']) {
		$tran = trim(_t(_gid(strip_tags($element['#title'])), t(strip_tags($element['#title']))));
		$placeholder = ' placeholder="' . $tran . '" ';
		$element['#children'] = substr_replace($element['#children'], $placeholder, 45, 0);
	}
	if (isset($element['#description'])) {
		$tran = trim(_t(_gid(strip_tags($element['#title']) . '_desc'), t(strip_tags($element['#description']))));
		$tooltip = ' title="' . $tran . '" ';
		$element['#children'] = substr_replace($element['#children'], $tooltip, 45, 0);
		//unset($element['#description']);
	}
  }

  if ($element['#type'] == 'select') {
	if (isset($element['#required']) && $element['#required']) {
		$element['#children'] = $element['#children'] . theme('form_required_marker', $element);
	}
  }

  if (!isset($element['#title'])) {
    $element['#title_display'] = 'none';
  }

  $prefix = isset($element['#field_prefix']) ? '<span class="field-prefix">' . $element['#field_prefix'] . '</span> ' : '';
  $suffix = isset($element['#field_suffix']) ? ' <span class="field-suffix">' . $element['#field_suffix'] . '</span>' : '';

  switch ($element['#title_display']) {
    case 'before':
    case 'invisible':
      $output .= ' ' . theme('form_element_label', $variables);
      $output .= ' ' . $prefix . $element['#children'] . $suffix . "\n";
      break;

    case 'after':
      $output .= ' ' . $prefix . $element['#children'] . $suffix;
      $output .= ' ' . theme('form_element_label', $variables) . "\n";
      break;

    case 'none':
    case 'attribute':
      // Output no label and no required marker, only the children.
      $output .= ' ' . $prefix . $element['#children'] . $suffix . "\n";
      break;
  }

  if (!empty($element['#description'])) {
//    $output .= '<div class="description">' . t($element['#description']) . "</div>\n";
	$tran = trim(_t(_gid(strip_tags($element['#title']) . '_desc'), t(strip_tags($element['#description']))));
    $output .= '<p class="element-description uk-form-help-block uk-text-muted">' . $tran . "</p>\n";
  }

  $output .= "</div>\n";
  return $output;
}

function the_zero_textarea($variables) {
  $element = $variables['element'];
  element_set_attributes($element, array('id', 'name', 'cols', 'rows'));
  _form_set_class($element, array('form-textarea'));

  $wrapper_attributes = array(
    'class' => array('form-textarea-wrapper'),
  );

  // Add resizable behavior.
  if (!empty($element['#resizable'])) {
    //drupal_add_library('system', 'drupal.textarea');
   // $wrapper_attributes['class'][] = 'resizable';
  }

  $output = '<div' . drupal_attributes($wrapper_attributes) . '>';
  $output .= '<textarea' . drupal_attributes($element['#attributes']) . '>' . check_plain($element['#value']) . '</textarea>';
  if (isset($element['#required']) && $element['#required']) {
	  $output .= theme('form_required_marker', $element);
  }
  $output .= '</div>';
  return $output;
}

function the_zero_item_list($variables) {
  $items = $variables['items'];
  $title = $variables['title'];
  $type = $variables['type'];
  $attributes = $variables['attributes'];
  $attributes['class'][] = 'uk-list uk-list-striped';
  // Only output the list container and title, if there are any list items.
  // Check to see whether the block title exists before adding a header.
  // Empty headers are not semantic and present accessibility challenges.
  $output = '<div class="item-list">';
  if (isset($title) && $title !== '') {
    $output .= '<h3>' . $title . '</h3>';
  }

  if (!empty($items)) {
    $output .= "<$type" . drupal_attributes($attributes) . '>';
    $num_items = count($items);
    $i = 0;
    foreach ($items as $item) {
      $attributes = array();
      $children = array();
      $data = '';
      $i++;
      if (is_array($item)) {
        foreach ($item as $key => $value) {
          if ($key == 'data') {
            $data = $value;
          }
          elseif ($key == 'children') {
            $children = $value;
          }
          else {
            $attributes[$key] = $value;
          }
        }
      }
      else {
        $data = $item;
      }
      if (count($children) > 0) {
        // Render nested list.
        $data .= theme_item_list(array('items' => $children, 'title' => NULL, 'type' => $type, 'attributes' => $attributes));
      }
      if ($i == 1) {
        $attributes['class'][] = 'first';
      }
      if ($i == $num_items) {
        $attributes['class'][] = 'last';
      }
      $output .= '<li' . drupal_attributes($attributes) . '>' . $data . "</li>\n";
    }
    $output .= "</$type>";
  }
  $output .= '</div>';
  return $output;
}



function the_zero_form_required_marker($variables) {
  // This is also used in the installer, pre-database setup.
  $class = '';
  if (isset($variables['element']['#type']) && $variables['element']['#type']) {
	  $class .= 'form-required-' . $variables['element']['#type'];
  }
  $t = get_t();
  $attributes = array(
    'class' => array($class, 'uk-icon-star-o', 'form-required'),
  );
  if (module_exists('the_zero_helpers')) {
	$attributes['title'] = _t('_this_field_is_required__', $t('This field is required.'));
  } else {
    $attributes['title'] = $t('This field is required.');
  }

  return ' <i' . drupal_attributes($attributes) . '></i> ';
}


function the_zero_form_element_label($variables) {
  $element = $variables['element'];
  // This is also used in the installer, pre-database setup.
  $t = get_t();

  $label_prefix = '';
  $label_suffix = '';

  // If title and required marker are both empty, output no label.
  if ((!isset($element['#title']) || $element['#title'] === '') && empty($element['#required'])) {
    return '';
  }

  // If the element is required, a required marker is appended to the label.
//  $required = !empty($element['#required']) ? theme('form_required_marker', array('element' => $element)) : '';
  $required = '';
  $title = filter_xss_admin($element['#title']);

  $has_colon = strpos($title, ':');
  if ($has_colon) {
	$title_arr = explode(':', $title);
	if (!empty($title_arr)) {
		$title = '';
		foreach ($title_arr as $item) {
			$title .= _t(_gid($item), t($item)) . ' ';
		}
	}
  } else {
	  $title = _t(_gid($title), _t(_gid(strip_tags($title)), t($title)));
  }

  $attributes = array();
  // Style the label as class option to display inline with the element.
  if ($element['#title_display'] == 'after') {
    $attributes['class'] = 'option';
  }
  // Show label only to screen readers to avoid disruption in visual flows.
  elseif ($element['#title_display'] == 'invisible') {
    $attributes['class'] = 'element-invisible';
  }

  if (!empty($element['#id'])) {
    $attributes['for'] = $element['#id'];
  }

  if ($element['#type'] == 'select') {
	  $label_prefix = '<div>';
	  $label_suffix = '</div>';
  }
  // The leading whitespace helps visually separate fields from inline labels.
//  return ' <label' . drupal_attributes($attributes) . '>' . $t('!title !required', array('!title' => $title, '!required' => $required)) . "</label>\n";
  return $label_prefix . ' <label' . drupal_attributes($attributes) . '>' . $title. '</label>' . "\n" . $label_suffix . "\n";
}


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

function _the_zero_colorize_button($text) {
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
