<?php
function the_shop_uc_empty_cart() {
	global $language_content;
	$lang = $language_content -> language;
	$output = '<div class="order-review-wrapper">';
	$output .= '<div class="order-review">';
	$output .= '<h3 class="uc-cart-empty">' . _t('_thea_empty_cart_', t('The basket is empty yet')) . '</h3>';
	$output .= '<hr class="uk-article-divider">';
	$output .= l(_t('_back_to_', 'Atgal į') . ' ' . variable_get('site_name', FALSE), $GLOBALS['base_url'] . '/' . $lang, array('attributes' => array('class' => array('uk-button', 'uk-button-primary', 'uk-margin-bottom'), 'rel'=> array('nofollow')))) . "\n";
	$output .= '</div></div>' . "\n";
	return $output;
}



//CHECKOUT REVIEW. LAST PAGE OF CHECKOUT PROCESS
function the_shop_uc_cart_checkout_review($variables) {
	if (($order_id = intval($_SESSION['cart_order'])) > 0) {
    	$order = uc_order_load($order_id);
    }
	$tabs = array();
	$owner_requisites = array('uc_store_owner' => array('prefix' => ''),
						'uc_store_residence' => array('preix' => ''),
						'uc_company_number' => array('prefix' => _t('_company_number_')),
						'uc_vat_number' => array('prefix' => _t('_company_vat_number_')),
						'uc_bank_account' => array('prefix' => _t('_account_number_')),
						'uc_bank_title' => array('prefix' => _t('_bank_title_')),
						'uc_bank_number' => array('prefix' => _t('_bank_number_')));
	$delivery_requisites = array('delivery_first_name' => array('prefix' => _t('_first_name_')),
							'delivery_last_name'  => array('prefix' => _t('_last_name_')),
							'delivery_company'  => array('prefix' => ''),
							'company_requisites'  => array('prefix' => _t('_company_number_vat_number_')),
							'delivery_street1'  => array('prefix' => _t('_address_')),
							'delivery_street2'  => array('prefix' => ''),
							'delivery_postal_code'  => array('prefix' => _t('_edit_panes_delivery_address_delivery_postal_code_')),
							'delivery_city'  => array('prefix' => _t('_edit_panes_delivery_address_delivery_city_')),
							'delivery_phone'  => array('prefix' => _t('_edit_panes_delivery_address_delivery_phone_')),
							'primary_email'  => array('prefix' => _t('_edit_panes_customer_primary_email_')),
							);
	$billing_requisites = array('billing_first_name' => array('prefix' => _t('_first_name_')),
							'billing_last_name'  => array('prefix' => _t('_last_name_')),
							'billing_company'  => array('prefix' => _t('_company_title_')),
							'billing_ucxf_company_number'  => array('prefix' => _t('_company_number_')),
							'billing_ucxf_vat_number'  => array('prefix' => _t('_company_vat_number_')),
							'billing_street1'  => array('prefix' => _t('_address_')),
							'billing_street2'  => array('prefix' => ''),
							'billing_postal_code'  => array('prefix' => _t('_edit_panes_billing_address_billing_postal_code_')),
							'billing_city'  => array('prefix' => _t('_edit_panes_billing_address_billing_city_')),
							'billing_phone'  => array('prefix' => _t('_edit_panes_billing_address_billing_phone_')),
							'primary_email'  => array('prefix' => _t('_edit_panes_customer_primary_email_')),
							);
	$output = "<div id=\"review-instructions\">". filter_xss_admin(variable_get('uc_checkout_review_instructions', uc_get_message('review_instructions'))) . "</div>\n";

	$output .= "<div id=\"order-review-wrapper\" class=\"order-review-wrapper\">";
	$output .= "<div id=\"order-review\" class=\"order-review\">";

	$output .= "<h3>"._t('_order_').' #'.$order -> order_id.', '.date("Y-m-d", $order -> created).', '.uc_currency_format($order->order_total)."</h3>\n";
	$output .= "<hr class=\"uk-article-divider\">\n";
	$tabs['_order_']['title'][] = _t('_order_', 'Užsakymas');
	$tabs['_order_']['content'][] = _the_shop_get_order_table($order->products, $order->line_items, 'order', $order->data)._the_shop_get_order_totals($order);
	$tabs['_invoice_']['title'][] = _t('_invoice_', 'Sąskaita');
	$tabs['_invoice_']['content'][] = _the_shop_get_order_table($order->products, $order->line_items, 'invoice', $order->data)._the_shop_get_order_totals($order);
	foreach (array('_the_seller_', '_the_buyer_', '_the_payer_') as $var) {
		switch ($var) {
			case '_the_seller_': {
				$requisites = $owner_requisites;
				$t = "Pardavėjas";
				break;
			}
			case '_the_buyer_': {
				$requisites = $delivery_requisites;
				$t = "Pirkėjas";
				break;
			}
			case '_the_payer_': {
				$requisites = $billing_requisites;
				$t = "Mokėtojas";
				break;
			}
		}
		$tabs[$var]['title'][] = _t($var, $t);
		$tabs[$var]['content'][] = _the_shop_get_order_requisites($order, $requisites, $var);
	}
	//tabs titles

	$output .= "<ul class=\"uk-tab\" data-uk-tab=\"{connect:'#tab-content'}\">\n";
	foreach ($tabs as $tab) {
		$tab_title = $tab['title'];
		foreach ($tab_title as $title) {
			$output .= "<li>";
			$output .= "<a href=\"#\">".$title."</a>";
			$output .= "</li>";
		}

	}
	$output .= "</ul>\n";
	//tabs content
	$output .= "<div id=\"tab-content\" class=\"uk-switcher uk-margin\">";
	foreach ($tabs as $tab) {
		$tab_content = $tab['content'];
		foreach ($tab_content as $content) {
			$output .= "<div>".$content."</div>";
		}

	}
	$output .= "</div>\n";
	$output .= "</div>\n";

	$output .= '<div class="order-buttons-wrapper">';
	$output .= '<div class="order-buttons">';
	$output .= drupal_render($variables['form']);
	$output .= '</div>';
	$output .= '</div>';
	$output .= '</div>';
	return $output;
}

//PRINTABLE ORDER & INVOICE
function the_shop_preprocess_uc_order(&$variables) {
	global $user;
	$is_admin = FALSE;
	if (in_array('administrator', array_values($user->roles))) {
		$is_admin = TRUE;
	}
	$order = $variables['order'];
	$owner_requisites = array('uc_store_name' => array('prefix' => ''),
						'uc_store_owner' => array('prefix' => ''),
						'uc_store_residence' => array('prefix' => ''),
						'uc_company_number' => array('prefix' => _t('_company_number_')),
						'uc_vat_number' => array('prefix' => _t('_company_vat_number_')),
						'uc_bank_account' => array('prefix' => _t('_account_number_')),
						'uc_bank_title' => array('prefix' => _t('_bank_title_')),
						'uc_bank_number' => array('prefix' => _t('_bank_number_')));
	$delivery_requisites = array('delivery_first_name' => array('prefix' => _t('_first_name_')),
							'delivery_last_name'  => array('prefix' => _t('_last_name_')),
							'delivery_company'  => array('prefix' => _t('_company_title_')),
							'company_requisites'  => '',
							'delivery_street1'  => array('prefix' => _t('_address_')),
							'delivery_street2'  => array('prefix' => ''),
							'delivery_postal_code'  => array('prefix' => _t('_edit_panes_delivery_address_delivery_postal_code_')),
							'delivery_city'  => array('prefix' => _t('_edit_panes_delivery_address_delivery_city_')),
							'delivery_phone'  => array('prefix' => _t('_edit_panes_delivery_address_delivery_phone_')),
							'primary_email'  => array('prefix' => _t('_edit_panes_customer_primary_email_')),
							);

	$billing_requisites = array('billing_first_name' => array('prefix' => _t('_first_name_')),
							'billing_last_name'  => array('prefix' => _t('_last_name_')),
							'billing_company'  => array('prefix' => _t('_company_title_')),
							'billing_ucxf_company_number'  => array('prefix' => _t('_company_number_')),
							'billing_ucxf_vat_number'  => array('prefix' => _t('_company_vat_number_')),
							'billing_street1'  => array('prefix' => _t('_address_')),
							'billing_street2'  => array('prefix' => ''),
							'billing_postal_code'  => array('prefix' => _t('_edit_panes_billing_address_billing_postal_code_')),
							'billing_city'  => array('prefix' => _t('_edit_panes_billing_address_billing_city_')),
							'billing_phone'  => array('prefix' => _t('_edit_panes_billing_address_billing_phone_')),
							'primary_email'  => array('prefix' => _t('_edit_panes_customer_primary_email_')),
							);
	$variables['_order']['order_id'] = '#' . $order->order_id;
	$variables['_order']['the_seller'] = _the_shop_get_order_requisites($order, $owner_requisites, '_the_seller_');
	$variables['_order']['the_buyer'] = _the_shop_get_order_requisites($order, $delivery_requisites, '_the_buyer_');
	$variables['_order']['the_payer'] = _the_shop_get_order_requisites($order, $billing_requisites, '_the_payer_');
	$variables['_order']['table'] = _the_shop_get_order_table($order->products, $order->line_items, 'order', $order->data);
	$variables['_order']['order_summary'] = _the_shop_get_order_totals($order);
	$variables['_order']['order_comments'] =  uc_order_comments_load($order->order_id, FALSE);
	$variables['_order']['order_message'] = _t('_order_message_', 'Dėkojame, kad pirkote mūsų parduotuvėje. Užsakytos, bet neapmokėtos knygos rezervuojamos 3 darbo dienas.');
	$variables['_order']['order_contacts'] = _t('_contact_information_', 'Kontaktai pasiteiravimui') . ': ' . variable_get('uc_store_email', FALSE) . ', ' . variable_get('uc_store_phone', FALSE) . ', ' . variable_get('uc_store_cell_phone', FALSE);

	$variables['_invoice']['order_id'] = '#' . $order->order_id;
	$variables['_invoice']['the_seller'] = _the_shop_get_order_requisites($order, $owner_requisites, '_the_seller_');
	$variables['_invoice']['the_buyer'] = _the_shop_get_order_requisites($order, $delivery_requisites, '_the_buyer_');
	$variables['_invoice']['the_payer'] = _the_shop_get_order_requisites($order, $billing_requisites, '_the_payer_');
	$variables['_invoice']['table']= _the_shop_get_order_table($order->products, $order->line_items, 'invoice', $order->data);
	$variables['_invoice']['date']= date('Y-m-d');
	$variables['_invoice']['order_summary'] = _the_shop_get_order_totals($order);
	$variables['_invoice']['products_summary'] = '';
	$variables['_invoice']['shipping_summary'] = '';
	if ($is_admin) {
		$variables['_invoice']['products_summary'] = _the_shop_get_products_summary($order->products, $order->line_items, 'invoice', $order->data);
		$variables['_invoice']['shipping_summary'] = _the_shop_get_shipping_summary($order->line_items, 'invoice');
		$variables['_invoice']['order_summary'] = _the_shop_get_order_totals($order, 'invoice');
	}
}

//ESTIMATED SHIPPING COST
function the_shop_preprocess_cart_pane_quotes(&$variables) {
	$variables['form']['#title']['#markup'] = check_plain(_t('_estimated_shipping_cost_', t('Estimated shipping cost')));

	foreach ($variables['form']['quote']['#items'] as $key => $item) {
		$title = strip_tags($item);
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
		$variables['form']['quote']['#items'][$key] = $title;
	}
}


//COUPON CODE
function the_shop_preprocess_uc_coupon_form(&$variables) {
	$variables['form']['#title']['#markup'] = _t('_coupon_discount_', t('Coupon discount'));
	$variables['form']['apply']['#theme_wrappers'][] = 'container';
}

//CART VIEW
function the_shop_preprocess_uc_cart_view_form(&$variables) {
	global $user;
	global $language_content;
	$lang = $language_content -> language;
	$variables['form']['#title']['#markup'] = check_plain(_t('_cart_', t('Shopping cart')));
	if (isset($variables['form']['actions']['update'])) {
		unset($variables['form']['actions']['update']);
	}
	if (!($user -> uid)) {
		if (isset($variables['form']['actions']['empty']['#weight'])) {
			$variables['form']['actions']['empty']['#weight'] = -2;
		}
		$variables['form']['login_actions'] = array(
			'#type' => 'container',
			'#prefix' => '<hr class="uk-article-divider">',
		);
		$variables['form']['login_actions']['login'] = array(
			'#weight' => -1,
			'#markup' => l(_t('_login_', t('Login')), $GLOBALS['base_url'] .'/' . $lang .'/user?destination=cart', array('attributes' => array('class' => array('uk-button','uk-button-success', 'uk-margin-bottom')))),
			'#suffix' => '&nbsp;<span class="uk-margin-bottom span-value-or">' . _t('_or_', '–Or–') . '</span>&nbsp;',
		);
		$variables['form']['login_actions']['checkout'] = array(
			'#weight' => 0,
			'#markup' => l(_t('_checkout_not_logged_in_', t('Checkout without login')), $GLOBALS['base_url'] .'/' . $lang .'/cart/checkout', array('attributes' => array('class' => array('uk-button','uk-button-success', 'uk-margin-bottom', 'uk-button-large')))),
		);
		unset ($variables['form']['actions']['checkout']);
	}
}

//HORRIBLE, TERRIBLE CHECKOUT
function the_shop_preprocess_uc_cart_checkout_form(&$variables) {
	if (($order_id = intval($_SESSION['cart_order'])) > 0) {
    	$order = uc_order_load($order_id);
    }

	$variables['product_shippable'] = FALSE;

	if ((isset($order)) && (!empty($order))) {
		foreach ($order -> products as $product) {
			if ((isset($product -> shippable)) && ($product -> shippable)) {
				$variables['product_shippable'] = TRUE;
				break;
			}
			if ((isset($product -> data['shippable'])) && ($product -> data['shippable'])) {
				$variables['product_shippable'] = TRUE;
				break;
			}
		}
	}

	$variables['form']['#title']['#markup'] = _t('_checkout_', t('Checkout'));
	$title = $variables['form']['panes']['customer']['#title'];
	$title = _t(_gid($title), t('Customer information'));
	$variables['form']['panes']['customer']['#title'] = $title . ', ' . _t(_gid('Delivery address'), t('Delivery address'));
	$variables['form']['panes']['payment']['#title'] = _t(_gid('Payment method'), t('Payment method'));
	$variables['form']['panes']['quotes']['#title'] = _t(_gid('Shipping cost'), t('Shipping cost'));
	$variables['form']['panes']['comments']['#title'] = _t(_gid('Order comments'), t('Order comments'));
	if (isset($variables['form']['panes']['payment']['payment_method']['#ajax'])) {
		unset($variables['form']['panes']['payment']['payment_method']['#ajax']);
	}
	$elements = element_children($variables['form']['panes']['payment']['payment_method']);
	foreach ($elements as $element) {
		if (isset($variables['form']['panes']['payment']['payment_method'][$element]['#attached'])) {
			unset($variables['form']['panes']['payment']['payment_method'][$element]['#attached']);
		}
	}
	$variables['form']['actions']['continue']['#attributes'] = array('class' => array('uk-button-large'));
}

//CART BLOCK
function the_shop_uc_cart_block_content($variables) {
	global $language_content;
	$lang = $language_content -> language;
	$help_text = $variables['help_text'];
	$items = $variables['items'];
	$item_count = $variables['item_count'];
	$item_text = $variables['item_text'];
	$total = $variables['total'];
	$summary_links = $variables['summary_links'];
	$collapsed = $variables['collapsed'];
	$output = '';
// Add a table of items in the cart or the empty message.
//	$output .= theme('uc_cart_block_items', array('items' => $items, 'collapsed' => $collapsed));
// Add the summary section beneath the items table.
	$output .= theme('uc_cart_block_summary', array('item_count' => $item_count, 'item_text' => $item_text, 'total' => $total, 'summary_links' => $summary_links));
//	dpm('cart block lang: '. $lang);
	return $output;
}

//CART BLOCK SUMMARY
function the_shop_uc_cart_block_summary($variables) {
	global $language_content;
	$lang = $language_content -> language;
	$item_count = $variables['item_count'];
	$item_text = $variables['item_text'];
	$total = $variables['total'];
	$summary_links = $variables['summary_links'];
	$summary_links['cart-block-view-cart']['href'] = $GLOBALS['base_url'] . '/' . $lang . '/' . $summary_links['cart-block-view-cart']['href'];
	$output = '<span class="cart-total"><a href="' . $summary_links['cart-block-view-cart']['href'] . '"><i class="fa fa-shopping-basket fa-lg"></i>&nbsp;' . uc_currency_format($total) . '</a></span>';
	return $output;
}

//PRODUCT ATTRIBUTES ROW
function the_shop_uc_product_attributes($variables) {
  $attributes = $variables['attributes'];
  $option_rows = array();
  $output = '';
  foreach (element_children($attributes) as $key) {
    $optionstr = '';
    foreach ((array)$attributes[$key]['#options'] as $option) {
      // We only need to allow translation from the second option onward
      if (empty($optionstr)) {
        $optionstr .= $option;
      }
      else {
        $optionstr .= t(', !option', array('!option' => $option));
      }
    }
    if ($optionstr != '') {
      $option_rows[$key] = t('@attribute: @option', array('@attribute' => $attributes[$key]['#attribute_name'], '@option' => $optionstr));
    }
  }
  if (!empty($option_rows)) {
    $output .= '<div class="attribute-options"><small>';
	$output .= implode(', ', array_values($option_rows));
	$output .= '</small></div>'."\n";
	return $output;
	//ORIGINAL OUTPUT AS ITEMS LIST
    //return theme('item_list', array('items' => array_values($option_rows), 'attributes' => array('class' => array('uk-list'))));
  }
  return '';
}

function the_shop_uc_product_model($variables) {
  $model = $variables['model'];
  $attributes = $variables['attributes'];
  $attributes['class'][] = "product-info";
  $attributes['class'][] = "model";

  $output = '<div ' . drupal_attributes($attributes) . '>';
  $output .= '<span class="product-info-label">' . _t('_sku_', 'Prekės kodas') . ':</span> ';
  $output .= '<span class="product-info-value">' . check_plain($model) . '</span>';
  $output .= '</div>';
  return $output;
}

function the_shop_uc_product_weight($variables) {
  $amount = $variables['amount'];
  $units = $variables['units'];
  $attributes = $variables['attributes'];
  $attributes['class'][] = "product-info";
  $attributes['class'][] = "weight";

  $output = '';
  if ($amount) {
    $output = '<div ' . drupal_attributes($attributes) . '>';
    $output .= '<span class="product-info-label">' . _t('_weight_', 'Svoris') . ':</span> ';
    $output .= '<span class="product-info-value">' . uc_weight_format($amount, $units) . '</span>';
    $output .= '</div>';
  }

  return $output;
}

function the_shop_uc_product_dimensions($variables) {
  $length = $variables['length'];
  $width = $variables['width'];
  $height = $variables['height'];
  $units = $variables['units'];
  $attributes = $variables['attributes'];
  $attributes['class'][] = "product-info";
  $attributes['class'][] = "dimensions";

  $output = '';
  if ($length || $width || $height) {
    $output = '<div ' . drupal_attributes($attributes) . '>';
    $output .= '<span class="product-info-label">' . _t('_dimensions_', 'Matmenys') . ':</span> ';
    $output .= '<span class="product-info-value">' ;
    $output .= uc_length_format($length, $units) . ' × ';
    $output .= uc_length_format($width, $units) . ' × ';
    $output .= uc_length_format($height, $units) . '</span>';
    $output .= '</div>';
  }

  return $output;
}

/*User profile files download table*/

function the_shop_uc_file_user_downloads($variables) {
	global $user;
	$header = $variables['header'];
	foreach ($header as $index => $head) {
		$header[$index]['data'] = _t('_ucf' . _gid($head['data']), t($head['data']));
	}
	$files = $variables['files'];
	$rows = array();
	$row = 0;
	foreach ($files as $file) {
		$file['link'] = str_replace('expires on', _t('_ucf_expires_on_', t('expires on')), $file['link']);
		$rows[] = array(
			array('data' => format_date($file['granted'], 'uc_store'), 'class' => array('date-row'), 'id' => 'date-' . $row),
			array('data' => $file['link'], 'class' => array('filename-row'), 'id' => 'filename-' . $row),
			array('data' => $file['description'], 'class' => array('description-row'), 'id' => 'description-' . $row),
			array('data' => $file['accessed'] . '/' . ($file['download_limit'] ? $file['download_limit'] : _t('_ucf_unlimited_', t('Unlimited'))), 'class' => array('download-row'), 'id' => 'download-' . $row),
			array('data' => count(unserialize($file['addresses'])) . '/' . ($file['address_limit'] ? $file['address_limit'] : _t('_ucf_unlimited_', t('Unlimited'))), 'class' => array('addresses-row'), 'id' => 'addresses-' . $row),
		);
		$row++;
	}
	$output = '<div class="node-body-wrapper">' . "\n";
	$output .= '<div class="node-body">' . "\n";
	$output .= '<h3>' . _t('_my_files_', t('My files')) . '</h3>' . "\n";
	$output .= '<hr class="uk-article-divider">' . "\n";
	$output .= theme('table', array(
		'header' => $header,
		'rows' => $rows,
		'empty' => _t('_ucf_nodownloads_', t('No downloads found')),
		'attributes' => array('class' => array('uk-table', 'uk-table-striped', 'uk-table-condensed', 'uk-text-nowrap', 'uk-table-hover')),
		));
	$output .= theme('pager');
/*
	$output .= '<div class="form-item"><p class="description">' .
	t('Once your download is finished, you must refresh the page to download again. (Provided you have permission)') .
	'<br />' . t('Downloads will not be counted until the file is finished transferring, even though the number may increment when you click.') .
	'<br /><b>' . t('Do not use any download acceleration feature to download the file, or you may lock yourself out of the download.') . '</b>' .
	'</p></div>';
*/
	$output .= l(_t('_my_profile_', t('My profile')), '/user/' . $user->uid, array('attributes' =>array('class'=> array('uk-button', 'uk-button-primary')))) . '&emsp;';
	$output .= l(_t('_my_orders_', t('My orders')), '/user/' . $user->uid . '/orders', array('attributes' =>array('class'=> array('uk-button', 'uk-button-primary')))) . '&emsp;';
	$output .= l(_t('_log_out_', t('Log out')), '/user/logout', array('attributes' =>array('class'=> array('uk-button', 'uk-button-danger')))) . '&emsp;';
	$output .= '</div>' ."\n" . '</div>' . "\n";
	return $output;
}


/*User profile files downloads admin table*/
function the_shop_uc_file_hook_user_file_downloads($variables) {
  $form = $variables['form'];
  $header = array(
    array('data' => t('Remove'    )),
    array('data' => t('Filename'  )),
    array('data' => t('Expiration')),
    array('data' => t('Downloads' )),
    array('data' => t('Addresses' )),
  );
  $rows = array();
  $output = '';

  foreach (element_children($form['file_download']) as $key) {

    if (!isset($form['file_download'][$key]['addresses_in'])) {
      continue;
    }

    $file_download = &$form['file_download'][$key];

    $rows[] = array(
      'data' => array(
        array('data' => drupal_render($file_download['remove'])),

        array('data' => drupal_render($file_download['filename'])),

        array(
          'data' =>
            drupal_render($file_download['expires']) . ' <br />' .

            '<div class="duration">' .
              drupal_render($file_download['time_polarity']) .
              drupal_render($file_download['time_quantity']) .
              drupal_render($file_download['time_granularity']) .
            '</div>',
        ),

        array(
          'data' =>
            '<div class="download-table-index">' .
              drupal_render($file_download['downloads_in']) . '/' . drupal_render($file_download['download_limit']) .
            '</div>',
        ),

        array(
          'data' =>
            '<div class="download-table-index">' .
              drupal_render($file_download['addresses_in']) . '/' . drupal_render($file_download['address_limit']) .
            '</div>',
        ),
      ),
      'class' => array('download-table-row'),
    );
  }

  $output .= theme('table', array(
    'header' => $header,
    'rows' => $rows,
    'attributes' => array('id' => 'download-table', 'class' => array('uk-table', 'uk-table-striped', 'uk-table-condensed', 'uk-text-nowrap', 'uk-table-hover')),
    'empty' => t('No files can be downloaded by this user.'),
  ));
  $output .= drupal_render_children($form);

  return $output;
}
