<?php
/*BREADCRUMB*/
function the_shop_breadcrumb($vars) {
	global $language_content;
	global $user;
	$lang = $language_content->language;
	$breadcrumb = $vars['breadcrumb'];
	if (($breadcrumb) && (theme_get_setting('toggle_breadcrumb'))) {
		$stripped = strtolower(strip_tags($breadcrumb[0]));
		if ($stripped == 'home') {
			$breadcrumb[0] = str_replace('Home',_t('_home_', 'Pradžia'), $breadcrumb[0]);
		}
		$switcher = arg(0);
		$title = '';
		$parents_chain = array();
		$path_prefix = '';
		switch($switcher) {
			case 'node': {
				$obj_id = arg(1);
				if ($obj_id !== 'add') {
					$node = node_load($obj_id);
					$title = $node -> title;
					$vocabulary = array();
					if (isset($node -> field_category) && ($node -> type !== 'article')) {
						$vocabulary = $node -> field_category;
					} elseif (isset($node -> field_menu_tree) && ($node -> type == 'article')) {
						$vocabulary = $node -> field_menu_tree;
					}
					if (isset($vocabulary['und'])) {
						$last_term = $vocabulary['und'][count($vocabulary['und'])-1]['tid'];
						$parents_chain = array_reverse(taxonomy_get_parents_all($last_term));
						$path_prefix = 'taxonomy/term/';
						foreach($parents_chain as $crumb) {
							$breadcrumb[] = l($crumb -> name, $path_prefix.$crumb -> tid);
						}
					}
				}
				if ($obj_id == 'add') {
					if (isset($breadcrumb[1])) {
						$breadcrumb[1] = str_replace('content', 'new', $breadcrumb[1]);
					}
				}
				break;
			}
			case 'taxonomy': {
				$obj_id = arg(2);
				$parents_chain = array_reverse(taxonomy_get_parents_all($obj_id));
				$path_prefix = 'taxonomy/term/';
				foreach($parents_chain as $crumb) {
					$breadcrumb[] = l($crumb -> name, $path_prefix.$crumb -> tid);
				}
				break;
			}
			case 'user': {
				if (isset($user->roles[1])) {
					$breadcrumb = array(l(_t('_home_', 'Pradžia'), '/'), _t('_administrator_', 'Administratorius'));
				} else {
					$breadcrumb = array(l(_t('_home_', 'Pradžia'), '/'), _t('_clients_', 'Pirkėjai'));
				}
				if (arg(2) == 'orders') {
					$breadcrumb[] = _t('_orders_', 'Užsakymai');
				}
				if (arg(2) == 'imce') {
					$breadcrumb[] = _t('_imce_', 'Failų tvarkyklė');
				}
				if (arg(2) == 'addresses') {
					$breadcrumb[] = _t('_addresses_', 'Išsaugoti adresai');
				}
				break;
			}
			case 'cart': {
				$breadcrumb[] = l(_t('_basket_', 'Krepšelis'), '/cart');
				if (NULL !== arg(1) && arg(1) == 'checkout') {
					$breadcrumb[] = l(_t('_the_checkout_', 'Užsakymas'), '/cart/checkout');
				}
				if (NULL !== arg(2) && arg(1) == 'complete') {
					$breadcrumb[] = _t('_complete_', 'Pateiktas');
				}
				break;
			}
			case 'search': {
				//$breadcrumb[] = l(_t('_product_search_', 'Prekių paieška'), '/search');
				$breadcrumb[] = _t('_product_search_', 'Prekių paieška');
				break;
			}
			case 'filter':
			case 'adv-search': {
				//$breadcrumb[] = l(_t('_product_search_', 'Prekių paieška'), '/search');
				$breadcrumb[] = _t('_adv_search_', 'Filtruoti');
				break;
			}
			case 'news': {
				if (isset($vars['breadcrumb'][1])) {
					$crumb = strip_tags($vars['breadcrumb'][1]);
				}
				$breadcrumb = array(l(_t('_home_', 'Pradžia'), '/'), _t($crumb, t($crumb)));
				break;
			}
			case 'abc': {
				$breadcrumb = array(l(_t('_home_', 'Pradžia'), '/'), _t('_abc_', 'Abėcėlinis sąrašas'));
				break;
			}
			case 'contact': {
				$breadcrumb = array(l(_t('_home_', 'Pradžia'), '/'), _t('_leave_a_message_', 'Palikite žinutę'));
				break;
			}
			default: {
				break;
			}
		}
		if (!empty($title)) {
			return implode(' &raquo; ', $breadcrumb).' &raquo; '. $title;
		} else {
			return implode(' &raquo; ', $breadcrumb);
		}
	}
	return NULL;
}
