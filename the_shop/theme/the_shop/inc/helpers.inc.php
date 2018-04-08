<?php
/*COMMON HELPERS*/
function _the_shop_init() {
	_the_shop_set_globals();
}

function _the_shop_set_globals() {
	if (!isset($GLOBALS['content_tree_vid'])) {
		$GLOBALS['content_tree_vid'] = taxonomy_vocabulary_machine_name_load('content_tree') -> vid;
	}
	if (!isset($GLOBALS['menu_tree_vid'])) {
		$GLOBALS['menu_tree_vid'] = taxonomy_vocabulary_machine_name_load('menu_tree') -> vid;
	}
}

/*THEME HELPERS*/
/*TAXONOMY HELPERS*/
/*RETURN TAGS*/
function _the_shop_get_tags($vars) {
	$output = '';
	$str = array();
	$button_class = 'uk-text-muted';
	foreach ($vars as $var) {
		if (isset($var['taxonomy_term'])) {
			$tname = $var['taxonomy_term'] -> name;
		} else {
			$tname = _the_shop_get_term($var['tid']);
		}
		$str[] = l($tname, 'taxonomy/term/'.$var['tid'], array('attributes' => array('class' => array($button_class))));
	}
	$output = implode($str, ' &middot ');
	return $output;
}

/*NESTED TREE ARRAY*/
function _the_shop_get_taxonomy_nested_tree($terms = array(), $max_depth = NULL, $parent = 0, $parents_index = array(), $depth = 0) {
	if (!is_array($terms)) {
		$terms = taxonomy_get_tree($terms);
	}
	foreach($terms as $term) {
		foreach($term -> parents as $term_parent) {
			if ($term_parent == $parent) {
				$return[$term->tid] = $term;
			}
			else {
				$parents_index[$term_parent][$term -> tid] = $term;
			}
		}
	}
	if (!isset($return)) {
		$return = array();
	}
	foreach($return as &$term) {
		if (isset($parents_index[$term->tid]) && (is_null($max_depth) || $depth < $max_depth)) {
			$term->children = _the_shop_get_taxonomy_nested_tree($parents_index[$term->tid], $max_depth, $term->tid, $parents_index, $depth + 1);
		}
	}
	return $return;
}



/*GET TERM NAME BY TID*/
function _the_shop_get_term($tid) {
	if (is_integer($tid)) {
		return db_select('taxonomy_term_data', 't')
		->fields('t', array('name'))
		->condition('tid', $tid)
		->execute()
		->fetchField();
	}
}

/*GET TERM VID BY TERM TID*/
function _the_shop_get_vid_by_tid($tid) {
	if (is_integer($tid)) {
		return db_select('taxonomy_term_data', 't')
		->fields('t', array('vid'))
		->condition('tid', $tid)
		->execute()
		->fetchField();
	}
}


/*GET TERMS BY GIVEN PARENT, WITH MAX. DEPTH*/
function _the_shop_get_terms_by_parent($parent_tid = 0, $max_depth = 1, $vid) {
	global $language_content;
	$lang = $language_content -> language;
	$base_url = $GLOBALS['base_url'] . '/' . $lang;
	$items = array();
	$counter = 0;
	if ($vid) {
		$terms = taxonomy_get_tree($vid, $parent_tid, $max_depth);
		foreach ($terms as $term) {
			$term_object = taxonomy_term_load($term -> tid);
			$settings = array();
			if (isset($term_object -> field_taxonomy_settings['und'])) {
				$settings = json_decode($term_object -> field_taxonomy_settings['und'][0]['value'], TRUE);
			}
			$items[$counter]['term_name'] = $term -> name;
			$items[$counter]['term_id'] = $term -> tid;
			$items[$counter]['term_parents'] = $term -> parents[0];
			$items[$counter]['term_desc'] = $term -> description;
			$items[$counter]['term_path'] = $base_url . '/' .drupal_get_path_alias('taxonomy/term/' . $term -> tid);
			$items[$counter]['term_settings'] = $settings;
			$items[$counter]['term_depth'] = $term -> depth;
			$counter ++;
		}
	}
	return $items;
}

function _the_shop_get_child_terms_dropdown($tid = 1, $max_depth = 1, $vid) {
	$depth = $max_depth;
	$terms = _the_shop_get_terms_by_parent($tid, $depth, $vid);
	$output = '';
	$parents = 0;
	if (!empty($terms)) {
		$output = '<div data-uk-dropdown="{justify: ' . "'#page-title'" . ', mode: ' . "'click'" . '}" style="position: relative;">' . "\n";
		$output .= '<button class="uk-button uk-button-large uk-button-danger"><i class="uk-icon-bars"></i>&nbsp;' . _t('_categories_', t('Categories')) . '</button>' . "\n";
		$output .= '<div class="uk-dropdown uk-dropdown-bottom uk-dropdown-scrollable">' . "\n";
		$output .= '<ul class="uk-nav">' . "\n";
		foreach($terms as $term) {
			$parents = count(taxonomy_get_parents_all($term['term_id']));
			if (count(taxonomy_select_nodes($term['term_id'], TRUE))) {
				$output .=  '<li class="item-depth-' . $term['term_depth'] . '">' . _the_shop_get_taxonomy_link($term, 'childs_dropdown', $parents) . '</li>' . "\n";
			}
		}
		$output .= '</ul>' . "\n" . '</div>' . "\n" . '</div>' ."\n" ;
	}
	return $output;
}

/*MISC HELPERS*/
/*SOCIAL LINKS*/
function _the_shop_get_social_links($context, $nid = NULL, $is_page = TRUE) {
	$social_order = explode(',', theme_get_setting('social_links_order'));
	$output = '';
	switch ($context) {
		case 'page': {
			foreach($social_order as $so) {
				$so = trim($so);
				$tg_var = 'toggle_'.$so.'_follow';
				$ln_var = $so.'_follow_name';
				$link = '';
				$icon = '';
				$link_title = $so;
				$toggle = theme_get_setting($tg_var);
				if(!empty($toggle)) {
					$path = theme_get_setting($ln_var);
					if (!empty($path)) {
						switch ($so) {
							case 'rss': {
								$link  = url(drupal_get_path_alias($path), array('absolute' => TRUE));
								$icon = 'uk-icon-rss';
								break;
							}
							case 'fb': {
								$link  = url('https://www.facebook.com/'.$path, array('external' => TRUE, 'absolute' => TRUE));
								$icon = 'uk-icon-facebook';
								break;
							}
							case 'tw': {
								$link  = url('https://twitter.com/'.$path, array('external' => TRUE, 'absolute' => TRUE));
								$icon = 'uk-icon-twitter';
								break;
							}
							case 'in': {
								$link  = url('https://linkedin.com/'.$path, array('external' => TRUE, 'absolute' => TRUE));
								$icon = 'uk-icon-linkedin';
								break;
							}
						}
					}
					$output .= "<a href=\"$link\" class=\"uk-icon-button uk-icon-hover $icon\" title=\"$link_title\" target=\"blank\"></a>&nbsp;\n";
				}
			}
			break;
		}
		case 'node': {
			foreach($social_order as $so) {
				$so = trim($so);
				$tg_var = 'toggle_'.$so.'_share';
				$ln_var = $so.'_share_link';
				$link = '';
				$icon = '';
				$link_title = $so;
				$toggle = theme_get_setting($tg_var);
				if(!empty($toggle)) {
					$path = theme_get_setting($ln_var);
					if (!empty($path)) {
						$node_url = url(drupal_get_path_alias('node/'.$nid), array('absolute'=>TRUE));
						$link  = url($path.$node_url, array('external' => TRUE, 'absolute' => TRUE));
						switch ($so) {
							case 'fb': {
								$icon = 'uk-icon-facebook';
								break;
							}
							case 'tw': {
								$icon = 'uk-icon-twitter';
								break;
							}
							case 'in': {
								$icon = 'uk-icon-linkedin';
								break;
							}
						}
						$icon .= ' uk-icon-button uk-icon-hover';
					}
					$output .= "<a href=\"$link\" class=\"$icon\" title=\"$link_title\" target=\"blank\"></a>&nbsp;\n";
				}
			}
			break;
		}
	}
	return $output;
}


/*ANALYZE TAXONOMY TERM SETTINGS AND RETURN LINK*/
function _the_shop_get_taxonomy_link($menu_item = array(), $destination = 'front', $parents_count = 0) {
	$link = '';
	$target = '';
	global $language_content;
	$lang = $language_content -> language;
	$base_url = $GLOBALS['base_url'] . '/' . $lang;
	if (isset($menu_item['term_settings'])) {
		if (!empty($menu_item['term_settings'])) {
			$target = $menu_item['term_settings']['target'];
			if (!empty($menu_item['term_settings']['url']) &&
					$menu_item['term_settings']['url'] !== 'term' &&
					$menu_item['term_settings']['fragment'] == FALSE &&
					$menu_item['term_settings']['menu'] == TRUE) {
				$link = l($menu_item['term_name'], $menu_item['term_settings']['url'],
				array('attributes' =>
				array('target' => $menu_item['term_settings']['target'], 'title' => $menu_item['term_name'])));
			} elseif (!empty($menu_item['term_settings']['url']) &&
						$menu_item['term_settings']['url'] == 'term' &&
						$menu_item['term_settings']['fragment'] == TRUE  &&
						$menu_item['term_settings']['menu'] == TRUE &&
						$destination == 'front') {
					$link = '<a href="#' . strtolower(_the_shop_transliterate($menu_item['term_name'])) . '">' . $menu_item['term_name'] . '</a>' . "\n";
			} elseif (!empty($menu_item['term_settings']['url']) &&
						$menu_item['term_settings']['url'] == 'term' &&
						$menu_item['term_settings']['fragment'] == TRUE  &&
						$menu_item['term_settings']['menu'] == TRUE &&
						$destination == 'page') {
						$link = l($menu_item['term_name'], $menu_item['term_path'],
					array('attributes' => array('target' => '_self', 'title' => $menu_item['term_name'])));
			} elseif (!empty($menu_item['term_settings']['url']) &&
						$menu_item['term_settings']['url'] == 'term'  &&
						$menu_item['term_settings']['fragment'] == FALSE &&
						$menu_item['term_settings']['menu'] == TRUE &&
						$destination == '') {
					$link = l($menu_item['term_name'], $menu_item['term_path'],
					array('attributes' => array('target' => '_self', 'title' => $menu_item['term_name'])));
			} elseif (!empty($menu_item['term_settings']['url']) &&
						$menu_item['term_settings']['url'] == 'term' &&
						/*
						$menu_item['term_settings']['fragment'] == TRUE  &&
						*/
						$menu_item['term_settings']['menu'] == TRUE &&
						$destination == 'offcanvas') {
						$link = l($menu_item['term_name'], $menu_item['term_path'],
					array('attributes' => array('target' => '_self', 'title' => $menu_item['term_name'])));
			} elseif (!empty($menu_item['term_settings']['url']) &&
						$menu_item['term_settings']['url'] == 'term' &&
						$menu_item['term_settings']['menu'] == TRUE &&
						$destination == 'childs_dropdown') {
					$link = l(str_repeat('-', $parents_count - 1) . ' ' . $menu_item['term_name'], $menu_item['term_path'],
					array('attributes' => array('target' => '_self', 'title' => $menu_item['term_name'])));
			} elseif (!empty($menu_item['term_settings']['url']) &&
						$menu_item['term_settings']['url'] == 'term' &&
						$menu_item['term_settings']['fragment'] == FALSE  &&
						$menu_item['term_settings']['menu'] == TRUE &&
						$destination == 'page') {
					$link = l($menu_item['term_name'], $menu_item['term_path'],
					array('attributes' => array('target' => '_self', 'title' => $menu_item['term_name'])));

			}
		}
	}
	return $link;
}

/*NESTED TREE OUTPUT*/
function _the_shop_output_taxonomy_nested_tree($tree, $classes = 'uk-list', $depth = 1, $parent_term = array(), $destination = 'front') {
	global $language_content;
	$lang = $language_content -> language;
	$base_url = $GLOBALS['base_url'] . '/' . $lang;
	$output = '';
    if (count($tree)) {
        $output = "<ul class=\"$classes\">";
		if (!empty($parent_term)) {
			$output .= '<li>' . _the_shop_get_taxonomy_link($parent_term, $destination) . '</li>';
		}
		$items = array();
        foreach ($tree as $term) {
			if (count(taxonomy_select_nodes($term -> tid, TRUE))) {
				$term_object = taxonomy_term_load($term -> tid);
				$settings = array();
				if (isset($term_object -> field_taxonomy_settings['und'])) {
					$settings = json_decode($term_object -> field_taxonomy_settings['und'][0]['value'], TRUE);
				}
				$items['term_name'] = $term -> name;
				$items['term_id'] = $term -> tid;
				$items['term_desc'] = $term -> description;
				$items['term_path'] = $base_url . '/' . drupal_get_path_alias('taxonomy/term/' . $term -> tid);
				$items['term_settings'] = $settings;
				if ($depth > $term->depth) {
					if (isset($term -> children)) {
						$output .= '<li class="item-depth-' . $term -> depth . ' uk-parent uk-nav-parent-icon">' . _the_shop_get_taxonomy_link($items, $destination);
						$output .= _the_shop_output_taxonomy_nested_tree($term->children, 'uk-nav-sub', $depth, $parent_term = array(), $destination);
						$output .= '</li>';
					} else {
						$output .= '<li class="item-depth-' . $term -> depth . '">' . _the_shop_get_taxonomy_link($items, $destination);
					}
				}
				$output .= '</li>';
			}
		}
        $output .= '</ul>';
    }
    return $output;
}


function _the_shop_output_offcanvas_nested_tree($tree, $classes = 'uk-list', $depth = 1, $parent_term = array(), $destination = 'front', $params = array()) {
	global $language_content;
	$lang = $language_content -> language;
	$base_url = $GLOBALS['base_url'] . '/' . $lang;
	$output = '';
    if (count($tree)) {
        $output = "<ul class=\"$classes\">";
		if (!empty($parent_term)) {
			$output .= '<li>' . _the_shop_get_taxonomy_link($parent_term, $destination) . '</li>';
		}
		$items = array();
        foreach ($tree as $term) {
			if (count(taxonomy_select_nodes($term -> tid, TRUE))) {
				$term_object = taxonomy_term_load($term -> tid);
				$settings = array();
				if (isset($term_object -> field_taxonomy_settings['und'])) {
					$settings = json_decode($term_object -> field_taxonomy_settings['und'][0]['value'], TRUE);
				}
				if ($depth > $term->depth) {
					if (isset($term -> children)) {
						$output .= '<li class="item-depth-' . $term -> depth . ' uk-parent">' . '<a href="#">' . $term -> name . '</a>';
						$output .= _the_shop_output_taxonomy_nested_tree($term->children, $classes, $depth, $parent_term = array(), $destination);
					} else {
						$output .= '<li class="item-depth-' . $term -> depth . '">' . _the_shop_get_taxonomy_link($items, $destination);
					}
				}
				$output .= '</li>';
			}
		}
        $output .= '</ul>';
    }
    return $output;
}


/*OFFCANVAS ALL ITEMS*/
function _the_shop_get_offcanvas_tree() {
	global $language_content;
	$lang = $language_content -> language;
	$c_vid = $GLOBALS['content_tree_vid'];
	$m_vid = $GLOBALS['menu_tree_vid'];
	$home_link = $GLOBALS['base_url'] . '/' . $lang;
	$content_terms = _the_shop_get_terms_by_parent(0, 1, $GLOBALS['content_tree_vid']);
	$menu_terms = _the_shop_get_terms_by_parent(0, 1, $GLOBALS['menu_tree_vid']);
	$o_depth = theme_get_setting('offcanvas_menu_depth');
	$m_depth = theme_get_setting('menu_depth');
	$output = '<ul class="uk-nav uk-nav-offcanvas uk-nav-parent-icon"  data-uk-nav="{multiple: false}">';
	$output .= '<li>' . '<a href="' . $home_link . '"><i class="uk-icon-home"></i></a>' . '</li>' . "\n";
//Content tree offcanvas menu
	foreach($content_terms as $term) {
		if (count(taxonomy_select_nodes($term['term_id'], TRUE))) {
			$childs = taxonomy_get_children($term['term_id'], $c_vid);
			if (!empty($childs)) {
				$output .= '<li class="uk-parent item-depth-' . $term['term_depth'] . '">' . '<a href="#">' . $term['term_name'] . '</a>' . "\n";
				$tree = _the_shop_get_taxonomy_nested_tree($c_vid, $o_depth, $term['term_id']);
				$output .= _the_shop_output_taxonomy_nested_tree($tree, 'uk-nav-sub', $o_depth, $term, 'offcanvas');
				$output .= '</li>';
			} else {
				$output .=  '<li>' . _the_shop_get_taxonomy_link($term, 'offcanvas') . '</li>';
			}
		}
	}
	$output .= '</ul>' . "\n";
	if (!empty($menu_terms)) {
		$output .= '<ul class="uk-nav uk-nav-offcanvas uk-margin-top uk-nav-parent-icon"  data-uk-nav="{multiple: false}">' . "\n";
		foreach($menu_terms as $term) {
			if (count(taxonomy_select_nodes($term['term_id'], TRUE))) {
				$childs = taxonomy_get_children($term['term_id'], $m_vid);
				if (!empty($childs)) {
					$output .= '<li class="uk-parent">' . '<a href="#">' . $term['term_name'] . '</a>' . "\n";
					$tree = _the_shop_get_taxonomy_nested_tree($m_vid, $m_depth, $term['term_id']);
					$output .= _the_shop_output_taxonomy_nested_tree($tree, 'uk-nav-sub', $m_depth, $term, 'offcanvas');
					$output .= '</li>';
				} else {
					$output .=  '<li>' . _the_shop_get_taxonomy_link($term, 'offcanvas') . '</li>';
				}
			}
		}
		$output .= '</ul>' . "\n";
	}
	return $output;
}


/*NAVBAR LINKS*/
function _the_shop_get_navbar($type = 'taxonomy', $destination = 'front') {
	global $language_content;
	$lang = $language_content -> language;
	$home_link = $GLOBALS['base_url'] . '/' . $lang;
	$output = '';
	if ($type == 'taxonomy') {
		$output .= "<ul class=\"uk-navbar-nav\" data-uk-scrollspy-nav=\"{closest: 'li', smoothscroll: {offset: 40}}\">\n";
	}
	if ($type == 'page') {
		$output .= "<ul class=\"uk-navbar-nav\"> \n";
	}

	if ($type == 'taxonomy') {
		$content_terms = _the_shop_get_terms_by_parent(0, 1, $GLOBALS['content_tree_vid']);
		foreach ($content_terms as $term) {
			if ($term['term_settings']['menu']) {
				if (count(taxonomy_select_nodes($term['term_id'], TRUE))) {
					$output .= "<li>";
					$output .= _the_shop_get_taxonomy_link($term, $destination);
					$output .= "</li>\n";
				}
			}
		}
	}

	if ($type == 'page') {
		$menu_terms = _the_shop_get_terms_by_parent(0, 1, $GLOBALS['menu_tree_vid']);
		$output .= '<li>' . '<a href="' . $home_link . '"><i class="uk-icon-home"></i></a>' . '</li>' . "\n";
		foreach ($menu_terms as $term) {
			if ($term['term_settings']['menu']) {
				if (count(taxonomy_select_nodes($term['term_id'], TRUE))) {
					$output .= "<li>";
					$output .= _the_shop_get_taxonomy_link($term, $destination);
					$output .= "</li>\n";
				}
			}
		}
	}
	$output .= "</ul>\n";
	return $output;
}


/*BLOCK CONTACTS ON TOP*/
function _the_shop_get_contact_block($context = 'header') {
	global $user;
	$output = '';
	$uc_store_name = variable_get('uc_store_name', FALSE);
	$uc_store_owner = variable_get('uc_store_owner', FALSE);
	$uc_store_phone = variable_get('uc_store_phone', FALSE);
	$uc_store_fax = variable_get('uc_store_fax', FALSE);
	$uc_store_email = variable_get('uc_store_email', FALSE);
	$uc_store_cell_phone = variable_get('uc_store_cell_phone', FALSE);
	$uc_store_residence = nl2br(variable_get('uc_store_residence', FALSE));
	if ($context == 'header') {
		$output = "<div id=\"header-middle\" class=\"uk-grid\">\n";
		if ($uc_store_phone) {
			$output .= '<div class="uk-width-medium-1-2 uk-text-center"><i class="uk-icon-button uk-icon-phone uk-icon-justify"></i>' . '<br />' . $uc_store_phone . "</div>\n";
		}
		if ($uc_store_cell_phone) {
			$output .= '<div class="uk-width-medium-1-2 uk-text-center"><i class="uk-icon-button uk-icon-mobile uk-icon-justify"></i>' . '<br />' . $uc_store_cell_phone . "</div>\n";
		}
		if (user_is_logged_in()) {
			$output .= '<div class="uk-width-medium-1-2 uk-text-center"><i class="uk-icon-button uk-icon-user uk-icon-justify"></i>' . '<br />' . l(_t('_my_profile_', t('My profile')), '/user/' . $user->uid) . "</div>\n";
			$output .= '<div class="uk-width-medium-1-2 uk-text-center"><i class="uk-icon-button uk-icon-sign-out uk-icon-justify"></i>' . '<br />' . l(_t('_log_out_', t('LogOut')), '/user/logout') . "</div>\n";
		} else {
			$output .= '<div class="uk-width-medium-1-2 uk-text-center"><i class="uk-icon-button uk-icon-user-plus uk-icon-justify"></i>' . '<br />' . l(_t('_user_register_', t('Register new account')), '/user/register') . "</div>\n";
			$output .= '<div class="uk-width-medium-1-2 uk-text-center"><i class="uk-icon-button uk-icon-sign-in uk-icon-justify"></i>' . '<br />' . l(_t('_log_in_', t('LogIn')), '/user') . "</div>\n";
		}
		$output .= "</div>\n";
	}
	return $output;
}

/*FOOTER BLOCKS*/
function _the_shop_get_footer_blocks($context = 'block_follow') {
	global $user;
	global $language_content;
	$lang = $language_content -> language;
	$home_link = $GLOBALS['base_url'] . '/' . $lang;
	$output = '';
	switch ($context) {
		case 'block_follow': {
			$output .= '<div id="block-store-follow">' . "\n";
			$output .= '<h3>' . _t('_follow_on_social_', t('Follow Us')) . '</h3>' . "\n";
			$output .= _the_shop_get_social_links('page');
			$output .= '<h3>' . _t('_leave_a_message_', t('Leave a message')) . '</h3>' . "\n";
			$output .= '<a href="#" data-uk-modal="' . "{target:'#contact-form-site-contact', bgclose:false}" . '"><i class="uk-icon-button uk-icon-send-o"></i></a>' . "\n";
			$output .= '</div>' . "\n";
			break;
		}
		case 'block_contacts': {
			$output .= '<div id="block-store-contacts">' . "\n";
			$output .= '<h3>' . _t('_contacts_', t('Contacts')) . '</h3>' . "\n";
			$output .= '<p><i class="uk-icon-button uk-icon-phone"></i>&nbsp;' . variable_get('uc_store_phone', '') . '</p>' . "\n";
			$output .= '<p><i class="uk-icon-button uk-icon-mobile"></i>&nbsp;' . variable_get('uc_store_cell_phone', '') . '</p>' . "\n";
			$output .= '<p><i class="uk-icon-button uk-icon-envelope-o"></i>&nbsp;' . variable_get('uc_store_email', '') . '</p>' . "\n";
			$output .= '</div>' . "\n";
			break;
		}
		case 'block_store_address': {
			$output .= '<div id="block-store-address">' . "\n";
			$output .= '<h3>' . variable_get('uc_store_name', '') . '</h3>' . "\n";
			$output .= '<p>' . nl2br(variable_get('uc_store_operator_address')) . '</p>' . "\n";
			$output .= '</div>' . "\n";
			break;
		}
		case 'block_store_owner': {
			$output .= '<div id="block-store-owner">' . "\n";
			$output .= '<h3>' . variable_get('uc_store_owner', '') . '</h3>' . "\n";
			$output .= '<p>' . nl2br(variable_get('uc_store_residence', '')) . '<br />' . "\n";
			$output .= _t('_company_number_short_', t('Company No')) . ' ' . variable_get('uc_company_number', '') . '<br />' . "\n";
			$output .= _t('_company_vat_number_short_', t('VAT No')) . ' ' . variable_get('uc_vat_number', '') . '<br />' . "\n";
			$output .= _t('_account_number_short_', t('Acc. No')) . ' ' . variable_get('uc_bank_account', '') . '<br />' . "\n";
			$output .= _t('_bank_title_short_', t('Bank')) . ' ' . variable_get('uc_bank_title', '') . '<br />' . "\n";
			$output .= _t('_bank_number_short_', t('Bank No')) . ' ' . variable_get('uc_bank_number', '') . '</p>' . "\n";
			$output .= '</div>' . "\n";
			break;
		}
		case 'block_user': {
			$output .= '<div id="block-store-user">' . "\n";
			$output .= '<h3>' . _t('_account_', 'Paskyra') . '</h3>' . "\n";
			if (user_is_logged_in()) {
				$output .= '<p><i class="uk-icon-button uk-icon-user uk-icon-justify"></i>' . '<br />' . l(_t('_my_orders_', t('My orders')), '/user/' . $user->uid . '/orders') . "</p>\n";
				$output .= '<p><i class="uk-icon-button uk-icon-sign-out uk-icon-justify"></i>' . '<br />' . l(_t('_log_out_', t('LogOut')), '/user/logout') . "</p>\n";
			} else {
				$output .= '<p><i class="uk-icon-button uk-icon-user-plus uk-icon-justify"></i>' . '<br />' . l(_t('_user_register_', t('Register new account')), '/user/register') . "</p>\n";
				$output .= '<p><i class="uk-icon-button uk-icon-sign-in uk-icon-justify"></i>' . '<br />' . l(_t('_log_in_', t('Log In')), '/user') . "</p>\n";
			}
			$output .= '</div>' . "\n";
			break;
		}
	}
	return $output;
}

/*
 * THIS FUNCTION IS COPY PASTED FROM views.module,
 * BECAUSE TOO MUCH CALLS to _the_shop_truncate_html() WAS MAKED BEFORE IN CODE :(.
 * LEARN API!
 * ORIGINAL FUNCTION:
 *  views_trim_text($alter, $value)
 *
 *  $alter = array(
 * 'max_length' => 400, //Integer
 * 'ellipsis' => TRUE, //Boolean
 * 'word_boundary' => TRUE, //Boolean
 * 'html' => TRUE, //Boolean
 * );
 *
 *  $value //String (or html markup :));
 */
function _the_shop_truncate_html($value, $max_len, $ellipsis = TRUE, $word_boundary = TRUE, $html = TRUE) {
	$alter['max_length'] = $max_len;
	$alter['ellipsis'] = $ellipsis;
	$alter['word_boundary'] = $word_boundary;
	$alter['html'] = $html;
	if (drupal_strlen($value) > $alter['max_length']) {
		$value = drupal_substr($value, 0, $alter['max_length']);
		// TODO: replace this with cleanstring of ctools
		if (!empty($alter['word_boundary'])) {
			$regex = "(.*)\b.+";
			if (function_exists('mb_ereg')) {
				mb_regex_encoding('UTF-8');
				$found = mb_ereg($regex, $value, $matches);
			} else {
				$found = preg_match("/$regex/us", $value, $matches);
			}
			if ($found) {
				$value = $matches[1];
			}
		}
	// Remove scraps of HTML entities from the end of a strings
		$value = rtrim(preg_replace('/(?:<(?!.+>)|&(?!.+;)).*$/us', '', $value));
		if (!empty($alter['ellipsis'])) {
			$value .= t(' ...');
		}
	}
	if (!empty($alter['html'])) {
		$value = _filter_htmlcorrector($value);
	}
	return $value;
}

/*TRANSLITERATE TO ASCII*/
function _the_shop_transliterate($str) {
  return _tlr($str);
}
