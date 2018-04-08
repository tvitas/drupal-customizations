<?php
/*UBERCART HELPERS*/
function _the_shop_get_order_requisites($order, $data = array(), $type = '_the_seller_') {
	$output = '';
	if (!empty($data)) {
		$output .= "<p>\n";
		if ((!empty($order -> delivery_company)) && (!empty($order -> data['company_requisites']['company_number']))) {
			unset ($data['delivery_first_name']);
			unset ($data['delivery_last_name']);
		}
		if ((!empty($order -> billing_company)) && (!empty($order -> data['company_requisites']['company_number']))) {
			unset ($data['billing_first_name']);
			unset ($data['billing_last_name']);
		}
		foreach ($data as $key => $requisite) {
			$p = '';
			if (!empty($requisite['prefix'])) {
				$p = $requisite['prefix'].': ';
			}
			if ($type == '_the_seller_') {
				$output .= $p.nl2br(variable_get($key, ''))."<br /> \n";
			}
			if (($type == '_the_buyer_') || ($type == '_the_payer_')) {
				if (!empty($order -> $key)) {
					if ($key == 'company_requisites') {
						$requisites_arr = explode("\n", $order -> $key);
						if (isset($requisites_arr[0])) {
							$p = _t('_company_number_', t('Company number')) . ': ';
							$output .= $p . $requisites_arr[0];
						}
						if (isset($requisites_arr[1])) {
							$p = _t('_company_vat_number_', t('Company VAT number')) . ': ';
							$output .= '<br />' . $p . $requisites_arr[1] . '<br />';
						}
					} else {
						$output .= $p . nl2br($order -> $key) . "<br />\n";
					}
				}
			}
		}
		$output .= "</p>\n";
	}
	return $output;
}

/*REQUISITES*/
function _the_shop_get_order_requisites_table($order, $columns = array('_the_seller_' => array(), '_the_buyer_' => array())) {
	$variables = array();
	$variables['rows'] = array();
	$variables['attributes'] = array('class' => array('uk-table',
												'uk-table-striped',
												'uk-table-condensed',
												'uk-text-nowrap'));
	$variables['caption'] = null;
	$variables['colgroups'] = null;
	$variables['sticky'] = null;
	$variables['empty'] = null;
	$rows = array();
	foreach ($columns as $key => $col) {
		$variables['header'][] = _t($key);
		$rows[0][] = _the_shop_get_order_requisites($order, $col, $key);
	}
	$variables['rows'] = $rows;
	return theme_table($variables);
}


/*PRINTABLE INVOICE ON ADMIN USER – SHIPPING ONLY TOTALS TABLE*/
function _the_shop_get_shipping_summary($line_items, $type = 'order') {
	$vat_payer = variable_get('uc_vat_payer', FALSE);
	if ($vat_payer) {
		$variables = array();
		$variables['header'] = array(_t('_shipping_amount_', t('Shipping amount')),
								_t('_shipping_vat_amount_', t('Shipping VAT amount')),
								_t('_shipping_amount_total_', t('Shipping total')),
								_t('_shipping_vat_rate_', t('Shipping VAT rate')),);
		$variables['rows'] = array();
		$variables['attributes'] = array('class' => array('uk-table',
												'uk-table-striped',
												'uk-table-condensed',
												'uk-text-nowrap'), 'width'=>'100%');
		$variables['caption'] = null;
		$variables['colgroups'] = null;
		$variables['sticky'] = null;
		$variables['empty'] = null;
		$vat_rates = json_decode(variable_get('uc_vat_rates',json_encode(array("0"=>0,"5"=>5,"9"=>9,"21"=>21))), true);
		$vat_amount = array();
		$rows = array();
		$shipping = array();
		$totals = array('shipping_cost' => 0, 'shipping_vat_amount' => 0, 'shipping_total' => 0);
		foreach ($vat_rates as $f => $g) {
			$vat_amount[$f]['shipping_cost'] = 0;
			$vat_amount[$f]['shipping_amount'] = 0;
			$vat_amount[$f]['vat_amount'] = 0;
		}
		$shipping = _the_shop_get_order_shipping ($line_items, $type);
		if ($shipping['vat_amount'] != NULL) {
			unset($shipping['vat_amount']);
		}
		if ($shipping['total'] != NULL) {
			unset($shipping['total']);
		}
		foreach ($shipping as $shipping_item) {
			$vat_rate = intval(str_replace('%', '', $shipping_item[4]));
			$shipping_cost = floatval(str_replace(array(',', '€'), array('.',''), $shipping_item[3]));
			$shipping_total = $shipping_cost + $shipping_cost * $vat_rate / 100;
			$vat_amount[$vat_rate]['shipping_cost'] += $shipping_cost;
			$vat_amount[$vat_rate]['shipping_amount'] += $shipping_total;
			$vat_amount[$vat_rate]['vat_amount'] += $shipping_total - $shipping_cost;
		};
		ksort($vat_amount);
		$counter = 0;
		foreach($vat_amount as $k => $v) {
			if (!empty($v['shipping_cost']) && !empty($v['shipping_amount'])) {
				$rows[$counter][0] = uc_currency_format($v['shipping_cost']);
				$rows[$counter][1] = uc_currency_format($v['vat_amount']);
				$rows[$counter][2] = uc_currency_format($v['shipping_amount']);
				$rows[$counter][3] = uc_percent_format($k);
				$totals['shipping_cost'] += $v['shipping_cost'];
				$totals['shipping_vat_amount'] += $v['vat_amount'];
				$totals['shipping_total'] += ($v['shipping_amount']);
				$counter ++;
			}
		}
		$counter ++;
		$rows[$counter][0] = uc_currency_format($totals['shipping_cost']);
		$rows[$counter][1] = uc_currency_format($totals['shipping_vat_amount']);
		$rows[$counter][2] = uc_currency_format($totals['shipping_total']);
		$rows[$counter][3] = '&nbsp;';
		$variables['rows'] = $rows;
		$variables['#prefix'] = '<div class="uk-overflow-container">';
		$variables['#suffix'] = '</div>';
		return theme_table($variables);
	}
	return '';
}


/*PRINTABLE INVOICE ON ADMIN USER – PRODUCTS ONLY TOTALS TABLE*/
function _the_shop_get_products_summary($products, $line_items, $type = 'order', $odata = array()) {
	$vat_payer = variable_get('uc_vat_payer', FALSE);
	if ($vat_payer) {
		$variables = array();
		$variables['header'] = array(_t('_products_amount_', t('Products amount')),
								_t('_products_vat_amount_', t('VAT amount')),
								_t('_products_amount_total_', t('Total')),
								_t('_products_vat_rate_', t('Products VAT rate')),);
		$variables['rows'] = array();
		$variables['attributes'] = array('class' => array('uk-table',
												'uk-table-striped',
												'uk-table-condensed',
												'uk-text-nowrap'), 'width'=>'100%');
		$variables['caption'] = null;
		$variables['colgroups'] = null;
		$variables['sticky'] = null;
		$variables['empty'] = null;

		$amount = 0;
		$vat = 0;
		$price_wvat = 0;
		$vat_total = 0;
		$vat_rates = json_decode(variable_get('uc_vat_rates',json_encode(array("0"=>0,"5"=>5,"9"=>9,"21"=>21))), true);
		$vat_amount = array();
		$rows = array();
		$totals['products_amount'] = 0;
		$totals['products_vat_amount'] = 0;
		$totals['products_amount_total'] = 0;
		foreach ($vat_rates as $f => $g) {
			$vat_amount[$f]['product_amount'] = 0;
			$vat_amount[$f]['vat_amount'] = 0;
		}

//PRODUCTS
		foreach ($products as $key => $product) {
			$vat = 1 + $product->vat_rate / 100;
			$price = $product->price;
//RECALCULATE DISCOUNT INTO PRODUCT PRICE
			if (!empty($odata) && isset($odata['coupons'])) {
				$discount_amount = _the_shop_get_discount_amount($product->nid, $odata);
				$price = $price - $discount_amount / $product->qty;
			}
//			$price_wvat = $price / $vat;
			$price_wvat = round(($price / $vat), 4, PHP_ROUND_HALF_EVEN);
			$vat_id = ((intval($product->vat_rate)));
			if (($type == 'invoice') && $vat_payer) {
//				$amount = $product->qty * $price_wvat;
				$amount = round(($product->qty * $price_wvat), 4, PHP_ROUND_HALF_EVEN);
			}
			$vat_amount[$vat_id]['vat_amount'] += ($price - $price_wvat) * $product->qty;
			$vat_amount[$vat_id]['product_amount'] += $amount;
		}
		ksort($vat_amount);
		$counter = 0;
		foreach($vat_amount as $k => $v) {
			if (!empty($v['product_amount']) && !empty($v['vat_amount'])) {
				$rows[$counter][0] = uc_currency_format($v['product_amount']);
				$rows[$counter][1] = uc_currency_format($v['vat_amount']);
				$rows[$counter][2] = uc_currency_format($v['vat_amount'] + $v['product_amount']);
				$rows[$counter][3] = uc_percent_format($k);
				$totals['products_amount'] += $v['product_amount'];
				$totals['products_vat_amount'] += $v['vat_amount'];
				$totals['products_amount_total'] += ($v['vat_amount'] + $v['product_amount']);
				$counter ++;
			}
		}
		$counter ++;
		$rows[$counter][0] = uc_currency_format($totals['products_amount']);
		$rows[$counter][1] = uc_currency_format($totals['products_vat_amount']);
		$rows[$counter][2] = uc_currency_format($totals['products_amount_total']);
		$rows[$counter][3] = '&nbsp;';
		$variables['rows'] = $rows;
		$variables['#prefix'] = '<div class="uk-overflow-container">';
		$variables['#suffix'] = '</div>';
		return theme_table($variables);
	}
	return '';
}


/*ORDER, PREPAID INVOICE TABLE*/
function _the_shop_get_order_table($products, $line_items, $type = 'order', $odata = array()) {
	$vat_payer = variable_get('uc_vat_payer', FALSE);
	$variables = array();
	$variables['header'] = array(_t('_title_', 'Title'),
								_t('_qty_', 'Qty'),
								_t('_price_', 'Price'),
								_t('_amount_', 'Amount'),);
	if (($type == 'invoice') && $vat_payer) {
			$variables['header'][] = _t('_vat_rate_', 'VAT rate');
	}
	$variables['rows'] = array();
	$variables['attributes'] = array('class' => array('uk-table',
												'uk-table-striped',
												'uk-table-condensed',
												'uk-text-nowrap'), 'width'=>'100%');
	$variables['caption'] = null;
	$variables['colgroups'] = null;
	$variables['sticky'] = null;
	$variables['empty'] = null;
	$counter = 0;
	$total = 0;
	$amount = 0;
	$vat = 0;
	$price_wvat = 0;
	$shipping_wvat = 0;
	$vat_id = '';
	$vat_total = 0;
	$vat_rate = '';
	$coupons_amount = 0;
	$shipping_amount = 0;
	$shipping_vat_amount = 0;
	$amount_after_discounts	= 0;
	$products_amount = 0;
	$products_vat_amount = $vat_amount = json_decode(variable_get('uc_vat_rates',json_encode(array("0"=>0,"5"=>5,"9"=>9,"21"=>21))), true);
	foreach ($vat_amount as $f => $g) {
		$vat_amount[$f] = 0;
	}
//PRODUCTS
	foreach ($products as $key => $product) {
		$has_coupon = FALSE;
		$title_str = $product->model.' '.$product->title;
		if (isset($product -> data['attributes']) && !empty($product -> data['attributes'])) {
			$attrib_str = '<br /><small>';
			$attrib_str .= _the_shop_attrib_str_($product -> data['attributes']);
			$attrib_str .= '</small>';
			$title_str .= $attrib_str;
		}
		$vat = 1 + $product->vat_rate / 100;
		$price = $product->price;
//RECALCULATE DISCOUNT INTO PRODUCT PRICE
		if (!empty($odata) && isset($odata['coupons'])) {
			$discount_amount = _the_shop_get_discount_amount($product->nid, $odata);
			$price = $price - $discount_amount / $product->qty;
			if ($discount_amount) {
				$has_coupon = TRUE;
			}
		}
		$price_wvat = round(($price / $vat), 4, PHP_ROUND_HALF_EVEN);
		$vat_id = ((intval($product->vat_rate)));
		if (($type == 'invoice') && $vat_payer) {
			$amount = round(($product->qty * $price_wvat), 4, PHP_ROUND_HALF_EVEN);
			if ($has_coupon) {
				$title_str .= '<br /><small>('.(_t('_price_wo_discount_', 'Kaina be nuolaidos ')).uc_currency_format($product->price / $vat).')</small>';
			}
		} else {
			$amount = $product->qty * $price;
			if ($has_coupon) {
				$title_str .= '<br /><small>('.(_t('_price_wo_discount_', 'Kaina be nuolaidos ')).uc_currency_format($product->price).')</small>';
			}

		}
		$rows[$counter] = array($title_str,	number_format($product -> qty, 2, ',', '.' ),);
		if (($type == 'invoice') && $vat_payer) {
			$result[$counter] = array_merge($rows[$counter], array(number_format($price_wvat, 4, ',', '.'),
										uc_currency_format($amount),
										number_format($product->vat_rate, 0, null, null).'%'));
		} else {
			$result[$counter] = array_merge($rows[$counter], array(number_format($price, 2, ',', '.'),
										uc_currency_format($amount)));
		}
		$rows = $result;
		$total += $amount;
		$vat_amount[$vat_id] += ($price - $price_wvat) * $product->qty;
		$products_amount += $amount;
		$products_vat_amount[$vat_id] += ($price - $price_wvat) * $product->qty;
		$counter ++;
	}
//SHIPPING LINE ITEM AS PRODUCT ITEM
	$shipping = _the_shop_get_order_shipping ($line_items, $type);
	$total += $shipping['total'];
	foreach ($shipping['vat_amount'] as $key => $va) {
		$vat_amount[$key] += $va;
	}
	unset ($shipping['vat_amount']);
	if (($type == 'invoice') && $vat_payer) {
		usort($rows, function($a, $b) {
			return $a[4] - $b[4];
		});
	}
	if ($shipping['total'] != 0) {
		unset($shipping['total']);
		$result = array_merge($rows, $shipping);
		$rows = $result;
	}

//LINE ITEMS TYPE NOT SHIPPING NOR COUPON
	$li_other = _the_shop_get_order_li_other ($line_items, $type);
	$total += $li_other['total'];
	foreach ($li_other['vat_amount'] as $key => $va) {
		$vat_amount[$key] += $va;
	}
	unset ($li_other['vat_amount']);

	if ($li_other['total'] != 0) {
		unset($li_other['total']);
		$result = array_merge($rows, $li_other);
		$rows = $result;
	}

	$subtotal = _the_shop_get_order_subtotal($total, $type);
	$result = array_merge($rows, $subtotal);
	$rows = $result;

//VATS
	if ($type == 'invoice' && $vat_payer) {
		foreach ($vat_amount as $key => $vats) {
			$vat_title = _t('_vat_', 'PVM').' '.uc_percent_format($key);
			if ($vats != 0) {
				$rows[] = array('&nbsp;', '&nbsp;', $vat_title, uc_currency_format($vats), '&nbsp;');
				$total += $vats;
			}
		}
		$subtotal = _the_shop_get_order_subtotal($total, $type);
		$result = array_merge($rows, $subtotal);
		$rows = $result;
	}

//DISCOUNTS
	$discounts = _the_shop_get_order_li_coupons_discount($line_items, $type);
	foreach ($discounts as $key => $discount) {
		$total += $discount[3];
		$discounts[$key][3] =  uc_currency_format(abs($discount[3]));
	}
	$result = array_merge($rows, $discounts);
	$rows = $result;
	$subtotal = _the_shop_get_order_subtotal($total, $type, '_grand_total_');
	$result = array_merge($rows, $subtotal);
	$rows = $result;
	$variables['rows'] = $rows;
	$variables['#prefix'] = '<div class="uk-overflow-container">';
	$variables['#suffix'] = '</div>';
	return theme_table($variables);
}

function _the_shop_get_discount_amount ($nid, $odata) {
	$return = 0;
	foreach ($odata['coupons'] as $coupon) {
		if (isset($coupon[$nid])) {
			$return = $coupon[$nid]->discount;
		}
	}
	return $return;
}

function _the_shop_get_order_subtotal ($subtotal, $type = 'order', $text = '_subtotal_') {
	$vat_payer = variable_get('uc_vat_payer', FALSE);
	$return[0] = array('&nbsp;', '&nbsp;', _t($text, 'Subtotal'), uc_currency_format($subtotal));
	if ($type == 'invoice' && $vat_payer) {
		$return[0][] = '&nbsp;';
	}
	return $return;
}

function _the_shop_get_order_coupons ($line_items, $type = 'order') {
	$vat = 0;
	$return = array();
	$vat_payer = variable_get('uc_vat_payer', FALSE);
	$counter = 0;
	$total = 0;
	foreach ($line_items as $line_item) {
		if ($line_item['type'] == 'coupon') {
			$str_id = _gid($line_item['title']);
			$return[$counter] = array('&nbsp;', '&nbsp;', _t($str_id, $line_item['title']));
			if ($type=='invoice' && $vat_payer) {
				$result[$counter] = array_merge($return[$counter], array(uc_currency_format($line_item['amount']), '&nbsp;'));
			} else {
				$result[$counter] = array_merge($return[$counter], array(uc_currency_format($line_item['amount'])));
			}
			$return = $result;
			$total += $line_item['amount'];
			$counter ++;
		}
	}
	$return['total'] = $total;
	return $return;
}


function _the_shop_get_order_li_coupons_discount ($line_items, $type = 'order') {
	$vat = 0;
	$return = array();
	$vat_payer = variable_get('uc_vat_payer', FALSE);
	$counter = 0;
	$total = 0;
	foreach ($line_items as $line_item) {
		if ($line_item['type'] == 'coupon') {
			$str_id = _gid($line_item['title']);
			$return[$counter] = array('&nbsp;', '&nbsp;', _t($str_id, $line_item['title']));
			if ($type=='invoice' && $vat_payer) {
				$result[$counter] = array_merge($return[$counter], array($line_item['amount'], '&nbsp;'));
			} else {
				$result[$counter] = array_merge($return[$counter], array($line_item['amount']));
			}
			$return = $result;
			$counter ++;
		}
	}
	return $return;
}

function _the_shop_get_order_li_other ($line_items, $type = 'order') {
	$vat = 0;
	$vat_amount = array();
	$vat_rate = 0;
	$return = array();
	$vat_payer = variable_get('uc_vat_payer', FALSE);
	$counter = 0;
	$total = 0;
	foreach ($line_items as $line_item) {
		$vat_amount[intval($line_item['vat_rate'])] = 0;
	}
	foreach ($line_items as $line_item) {
		if (($line_item['type'] !== 'shipping') && ($line_item['type'] !== 'coupon') && ($line_item['type'] !== 'subtotal') && ($line_item['type'] !== 'total')) {
			$vat = 1 + $line_item['vat_rate']/100;
			$price_wvat = $line_item['amount'] / $vat;
			$vat = $line_item['amount'] - $price_wvat;
			$vat_id = ((intval($line_item['vat_rate'])));
			$str_id = _gid($line_item['title']);
			$return[$counter] = array(_t($str_id, $line_item['title']),	'&nbsp;', '&nbsp;',);
			if ($type=='invoice' && $vat_payer) {
				$result[$counter] = array_merge($return[$counter], array(uc_currency_format($price_wvat), number_format($line_item['vat_rate'], 0, null, null).'%'));
				$vat_amount[$vat_id] += $vat;
				$total += $price_wvat;
			} else {
				$result[$counter] = array_merge($return[$counter], array(uc_currency_format($line_item['amount'])));
				$total += $line_item['amount'];
			}
			$return = $result;
			$counter ++;
		}
	}
	$return['vat_amount'] = $vat_amount;
	$return['total'] = $total;
	return $return;
}

/*SHIPPING*/
function _the_shop_get_order_shipping ($line_items, $type = 'order') {
	$vat = 0;
	$vat_amount = array();
	$vat_rate = 0;
	$return = array();
	$vat_payer = variable_get('uc_vat_payer', FALSE);
	$counter = 0;
	$total = 0;
	foreach ($line_items as $line_item) {
		$vat_amount[intval($line_item['vat_rate'])] = 0;
	}
	foreach ($line_items as $line_item) {
		if ($line_item['type'] == 'shipping') {
			$vat = 1 + $line_item['vat_rate']/100;
			$price_wvat = $line_item['amount'] / $vat;
			$vat = $line_item['amount'] - $price_wvat;
			$vat_id = ((intval($line_item['vat_rate'])));
			$str_id = _gid($line_item['title']);
			$return[$counter] = array(_t('_shipping_cost_') . '<br /><small>(' . _t($str_id, t($line_item['title'])) .')</small>',
			'&nbsp;', '&nbsp;',);
			if ($type=='invoice' && $vat_payer) {
				$result[$counter] = array_merge($return[$counter], array(uc_currency_format($price_wvat), number_format($line_item['vat_rate'], 0, null, null).'%'));
				$vat_amount[$vat_id] += $vat;
				$total += $price_wvat;
			} else {
				$result[$counter] = array_merge($return[$counter], array(uc_currency_format($line_item['amount'])));
				$total += $line_item['amount'];
			}
			$return = $result;
			$counter ++;
		}
	}
	$return['vat_amount'] = $vat_amount;
	$return['total'] = $total;
	return $return;
}

function _the_shop_get_order_totals ($order, $type = 'order') {
	$variables = array();
	$items = array();
	$totals = array();
	$ifo = array();
	$dt = _the_shop_get_order_coupons($order->line_items);
	$totals['_order_id_'] = '#'.$order->order_id;
	$totals['_order_date_'] = date('Y-m-d', $order->created);
	$totals['_order_total_'] = uc_currency_format($order->order_total);
	$totals['_discount_total_'] = uc_currency_format(abs($dt['total']));
	if (isset($order->quote['method'])) {
		$totals['_shipping_method_'] = _t(_gid($order->quote['method']), $order->quote['method']);
	}
	$totals['_payment_method_'] = _t(_gid($order->payment_method), $order->payment_method);
	if (!empty($order->flatrate_terminal)) {
		$totals['_flatrate_terminal_'] = nl2br($order->flatrate_terminal);
	}
	if ($order -> delivery_country !== '440') {
		$totals['_shipping_method_'] = _t('_other_', 'Kitas');
		unset($totals['_flatrate_terminal_']);
		$totals['_payment_method_'] = _t('_other', 'Kitas');
	}
	$totals['_order_modified_'] = date('Y-m-d H:i:s', $order->modified);
	foreach ($totals as $key => $t) {
		$items[] = array('data' => _t($key, $key).': '.$t, 'class' => array('li-order-totals'));

	}
	$variables['title'] = NULL;
	$variables['type'] = 'ul';
	$variables['items'] = $items;
	$variables['attributes']['class'] = array('uk-list', 'ul-order-totals');
	if ($type == 'order') {
		return theme_item_list($variables);
	} else {
		return implode('; ', $totals);
	}
}


function _the_shop_attrib_str_($attribs) {
	$s = '';
	foreach (element_children($attribs) as $a) {
		$key = key($attribs[$a]);
		$z = $attribs[$a][$key];
		$s .= $a.': '.$z.', ';
	}
	return trim($s, ', ');
}
