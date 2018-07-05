<?php

/*
 * Display a brief overview of shipping discounts
 */

function uc_shipping_discounts_display() {
    $output = '';
    $output .= '<ul class="action-links"><li>' . l(t('Add new shipping discount'), 'admin/store/shipping-discounts/add') . '</li></ul>';

    $header = array(
        array('data' => t('Actions')),
        array(
            'data' => t('Description'),
            'field' => 'discount_description',
            'sort' => 'asc',
        ),
        array(
            'data' => t('Order subtotal'),
            'field' => 'discount_order_value',
        ),
        array(
            'data' => t('Discount, %'),
            'field' => 'discount_percent',
        ),
        array(
            'data' => t('Valid until'),
            'field' => 'discount_until',
        ),
        array(
            'data' => t('Apply to'),
            'field' => 'discount_apply_to',
        ),
        array(
            'data' => t('Enabled?'),
            'field' => 'discount_enabled',
        ),
    );

    $query = db_select('uc_shipping_discounts', 'sd')
        ->extend('TableSort')
        ->extend('PagerDefault')
        ->orderByHeader($header);
        $query->fields('sd');

    $rows = array();

    $result = $query->execute();

    foreach ($result as $discount) {
        $rows[] = array(
            uc_shipping_discounts_display_actions($discount->discount_id),
            check_plain($discount->discount_description),
            number_format($discount->discount_order_value, 2, ',', '.'),
            number_format($discount->discount_percent, 2, ',', '.'),
            $discount->discount_until ? date("Y-m-d H:i:s", $discount->discount_until) : t('Forever'),
            uc_shipping_discounts_get_applied_methods_list($discount),
            $discount->discount_enabled ? t('Yes') : t('No'),
        );
    }

    if (count($rows)) {
        $output .= theme('table', array('header' => $header, 'rows' => $rows, 'attributes' => array('width' => '100%')));
        $output .= theme('pager', array('tags' => NULL));
    } else {
        $output .= '<p>' . t('There are currently no defined shipping discounts.') . '</p>';
    }

    return $output;
}

/**
 * Show the actions a user may perform on a shipping discount.
 */

function uc_shipping_discounts_display_actions($did) {
    $actions = [];
    $links = [];

    $actions[] = [
        'url' => 'admin/store/shipping-discounts/' . $did . '/edit',
        'icon' => drupal_get_path('module', 'uc_store') . '/images/order_edit.gif',
        'title' => t('Edit shipping discount.'),
    ];

    $actions[] = [
        'url' => 'admin/store/shipping-discounts/' . $did . '/delete',
        'icon' => drupal_get_path('module', 'uc_store') . '/images/order_delete.gif',
        'title' => t('Edit shipping discount.'),
    ];

    foreach ($actions as $action) {
        $icon = theme('image', array('path' => $action['icon'], 'alt' => $action['title']));
        $links[] = l($icon, $action['url'], array('attributes' => array('title' => $action['title']), 'html' => TRUE));
    }
    return implode(' ', $links);
}


/**
 * Delete shipping discount confirm form
 *
 */
function uc_shipping_discounts_delete_confirm($form, &$form_state, $discount) {
  $form['#uc_shipping_discounts_did'] = $discount->discount_id;
  return confirm_form($form,
  t('Are you sure you want to delete shipping discount?'),
  'admin/store/shipping-discounts/list',
   t('This action cannot be undone.'), t('Delete'));
}

/**
 * Delete shipping discount confirm form submit handler.
 */
function uc_shipping_discounts_delete_confirm_submit($form, &$form_state) {
  $discount = uc_shipping_discounts_delete($form['#uc_shipping_discounts_did']);
  drupal_set_message(t('Shipping discount has been deleted.'));
  $form_state['redirect'] = 'admin/store/shipping-discounts/list';
}


function uc_shipping_discounts_add_form($form, &$form_state, $discount = NULL, $action = NULL) {

    if ($discount) {
        $form['#uc_shipping_discounts_did'] = $discount->discount_id;
    } else {
        $discount = new stdClass;
    }

    $form['discount_description'] = array(
      '#type' => 'textfield',
      '#title' => t('Discount description'),
      '#description' => t('A brief description of this shipping discount.'),
      '#default_value' => isset($discount->discount_description) ? $discount->discount_description : '',
      '#required' => TRUE,
      '#weight' => 0,
    );

    $form['discount_order_value'] = array(
      '#type' => 'textfield',
      '#title' => t('Order subtotal'),
      '#description' => t('Minimum order value to apply this shipping discount. Enter 0 to ignore order value. In this case this discount will apply to all orders.'),
      '#default_value' => isset($discount->discount_order_value) ? $discount->discount_order_value : 0,
      '#size' => 25,
      '#required' => true,
      '#weight' => 2,
    );

    $form['discount_percent'] = array(
      '#type' => 'textfield',
      '#title' => t('Discount percent'),
      '#description' => t('Discount on shipping cost on percents.'),
      '#default_value' => isset($discount->discount_percent) ? $discount->discount_percent : 0,
      '#size' => 25,
      '#required' => true,
      '#weight' => 4,
    );

    $form['discount_until'] = array(
      '#type' => 'textfield',
      '#title' => t('Discount valid until'),
      '#description' => t('Datetime until this discount is valid for, if "Enabled?" is checked. Format Y-m-d H:i:s'),
      '#default_value' => uc_shipping_discounts_get_date_time($action, $discount),
      '#required' => true,
      '#weight' => 6,
    );

    $form['discount_enabled'] = array(
      '#type' => 'checkbox',
      '#title' => t('Discount enabled?'),
      '#description' => t('Check/uncheck to enable/disable this shipping discount.'),
      '#default_value' => !empty($discount->discount_enabled) ? 1 : 0,
      '#required' => false,
      '#weight' => 8,
    );

    $form['discount_apply_to'] = array(
      '#type' => 'radios',
      '#title' => t('To which of shipping quotes apply this discount.'),
      '#description' => t('Check the boxes of shipping methods.'),
      '#options' => uc_shipping_discounts_get_methods_list(),
      '#default_value' => !empty($discount->discount_method_id) ? $discount->discount_method_id : '',
      '#required' => true,
      '#weight' => 10,
    );

    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Save shipping discount'),
      '#weight' => 90,
    );

    $form['cancel'] = array(
        '#markup' => l(t('Go back'), 'admin/store/shipping-discounts'),
        '#weight' => 98,
    );

    return $form;
}

function uc_shipping_discounts_add_form_submit($form, &$form_state) {
    $applied = $form_state['values']['discount_apply_to'];
    $methods = uc_quote_methods(TRUE);
    $prepared = [];
    $discount = new stdClass;
    foreach ($methods as $key => $method) {
        $prepared[$key]['value'] = $method['title'];
        $prepared[$key]['selected'] = FALSE;
        if ($key == $applied) {
            $prepared[$key]['selected'] = TRUE;
            $form_state['values']['discount_method_id'] = $applied;
        }
    }
    $form_state['values']['discount_apply_to'] = $prepared;
    if (isset($form['#uc_shipping_discounts_did'])) {
        $form_state['values']['discount_id'] = (int) $form['#uc_shipping_discounts_did'];
    }
    foreach ($form_state['values'] as $key => $value) {
        if (strstr($key, 'discount')) {
            $discount->$key = $value;
        }
    }
    $discount->discount_until = uc_shipping_discounts_set_date_time($discount->discount_until);
    uc_shipping_discounts_save($discount);
    drupal_set_message(t('Shipping discount has been saved.'));
    $form_state['redirect'] = 'admin/store/shipping-discounts/list';
}
