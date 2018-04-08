<?php
include('inc/theme.inc.php');
include('inc/user_profile.inc.php');
include('inc/theme_elements.inc.php');
include('inc/messages.inc.php');
include('inc/tapir.inc.php');
include('inc/helpers.inc.php');
include('inc/uc_helpers.inc.php');
include('inc/uc.inc.php');
include('inc/breadcrumb.inc.php');
include('inc/table.inc.php');

_the_shop_init();


function the_shop_html_head_alter(&$head_elements) {
	foreach($head_elements as $key => $element) {
		switch ($key) {
		case 'system_meta_content_type':
			$head_elements[$key]['#attributes'] = array('charset' => 'utf-8');
			break;
		case 'system_meta_generator':
			unset($head_elements[$key]);
			break;
		}
	}
}

function the_shop_css_alter(&$css) {
  // Remove defaults.css file.
	foreach ($css as $sheet) {
		if (!strpos($sheet['data'], 'the_shop')) {
			if (!strpos($sheet['data'], 'honeypot')) {
				if (!strpos($sheet['data'], 'fontawesome')) {
					if (!strpos($sheet['data'], 'plupload')) {
						if (!strpos($sheet['data'], 'imce')) {
							unset($css[$sheet['data']]);
						}
					}
				}
			}
		}
	}
}


function the_shop_preprocess_page (&$variables) {
	global $language_content;
	$lang = $language_content->language;

	$language_switcher = render($variables['page']['language_switcher']);


	$variables['show_title'] = TRUE;
	$variables['site_abbreviation'] = '';
	$variables['contact_form'] = array();

	$variables['filter_form'] = new stdClass();

	$view = views_get_view('content_manipulation');
	$view->set_display('filters_page');
	$view->init_handlers();
	$variables['filter_form'] = $view->display_handler->get_plugin('exposed_form');

	if (module_exists('contact')) {
		module_load_include('inc', 'contact', 'contact.pages');
		$variables['contact_form'] = drupal_get_form('contact_site_form');
	}

	$variables['logo'] = $GLOBALS['base_url'] . '/' . drupal_get_path('theme', 'the_shop') . '/img/logo/logo-brand.png';

	if ($variables['is_front']) {
		$variables['content_root']['navbar'] = _the_shop_get_navbar('taxonomy');
	} else {
		$vid = _the_shop_get_vid_by_tid(intval(arg(2)));
		$variables['content_root']['navbar'] = _the_shop_get_navbar('taxonomy', 'page');
		$variables['content_root']['child_terms_dropdown'] = _the_shop_get_child_terms_dropdown(arg(2), theme_get_setting('offcanvas_menu_depth'), $vid);
	}

//	$variables['content_root']['offcanvas'] = _the_shop_get_offcanvas_tree();


	$block_content_tree = module_invoke('nice_taxonomy_menu', 'block_view', 'ntm_1');
	$block_menu_tree = module_invoke('nice_taxonomy_menu', 'block_view', 'ntm_2');

	//dpm ($block_menu_tree);

	$home_link = base_path() . $lang;
	$variables['content_root']['offcanvas'][0] = '<ul class="uk-nav uk-nav-offcanvas uk-nav-parent-icon"><li>'
	. '<a href="' . $home_link 	. '"><i class="uk-icon-home"></i></a>'
	. '</li></ul>';
	$variables['content_root']['offcanvas'][1] = $block_content_tree['content'];
	$variables['content_root']['offcanvas'][2] = $block_menu_tree['content'];

	$variables['site_abbreviation'] = theme_get_setting('site_abbreviation');
	$variables['contact_block_top'] = _the_shop_get_contact_block();
	$variables['contact_block_foot'] = _the_shop_get_contact_block('footer');
	$variables['contact_block_contact'] = _the_shop_get_contact_block('contact');
	$variables['contact_block_address'] = _the_shop_get_contact_block('address');

	$variables['content_root']['navbar_menu'] = _the_shop_get_navbar('page', 'page');

	if (theme_get_setting('toggle_lang_switcher')) {
		$variables['content_root']['navbar_menu'] .= $language_switcher;
	}

	$variables['content_root']['menu_items'] = _the_shop_get_terms_by_parent(0, 2, $GLOBALS['content_tree_vid']);

	if(isset($variables['node']) && $variables['node']->type == 'product_type_accessories') {
		$variables['show_title'] = FALSE;
	}
	if(isset($variables['node']) && $variables['node']->type == 'product_type_other') {
		$variables['show_title'] = FALSE;
	}
	if(isset($variables['node']) && $variables['node']->type == 'newsletters_subscribe_page') {
		$variables['show_title'] = FALSE;
	}
	if(isset($variables['node']) && $variables['node']->type == 'article') {
		$variables['show_title'] = FALSE;
	}
	if (arg(0) == 'news' && !arg(1)) {
		drupal_set_title(_t('_bookstore_news_'));
	}
	if (arg(0) == 'cart' && !arg(1)) {
		drupal_set_title(_t('_cart_'));
	}
	if (arg(0) == 'cart' && arg(1) == 'checkout') {
		drupal_set_title(_t('_order_'));
	}
	if (arg(0) == 'cart' && arg(1) == 'checkout' && arg(2) == 'review') {
		drupal_set_title(_t('_accept_', 'Patvirtinti'));
	}
	if (arg(0) == 'cart' && arg(1) == 'webtopay' && arg(2) == 'complete') {
		drupal_set_title(_t('_complete_'));
	}
	if (arg(0) == 'cart' && arg(1) == 'empty') {
		drupal_set_title(_t('_sure_to_empty_'));
	}
	if (arg(0) == 'search') {
		drupal_set_title(_t('_search_'));
	}
	if (arg(0) == 'filter') {
		drupal_set_title(_t('_adv_search_'));
	}
	if (arg(0) == 'user' && arg(2) == 'orders') {
		$variables['show_title'] = FALSE;
	}
	if (arg(0) == 'user') {
		$variables['show_title'] = FALSE;
	}
	if (arg(0) == 'newsletter' && arg(1) == 'confirm') {
		$variables['show_title'] = FALSE;
	}
	if (arg(0) == 'contact') {
		drupal_set_title(_t('_leave_a_message_', t('Leave a message')));
	}
}


function the_shop_preprocess_node(&$variables) {
	// Add css class "node--NODETYPE--VIEWMODE" to nodes
	//$variables['classes_array'][] = 'node--' . $variables['type'] . '--' . $variables['view_mode'];
	// Make "node--NODETYPE--VIEWMODE.tpl.php" templates available for nodes
	$variables['theme_hook_suggestions'][] = 'node__' . $variables['view_mode'];
	$variables['theme_hook_suggestions'][] = 'node__' . $variables['type'] . '__' . $variables['view_mode'];

	if (isset($variables['content']['links']['node']['#links']['node-readmore']['attributes'])) {
		$variables['content']['links']['node']['#links']['node-readmore']['attributes']['class'] = 'uk-button uk-button-primary';
	}

	$variables['contact_form'] = '';
	$variables['stock_level'] = '';
	$variables['stock_level_value'] = '';
	$sr_val = '';
	$sr_label = '';

	$array_sku = uc_product_get_models($variables['node']->nid, FALSE);

	foreach ($array_sku as $sku) {
		$stock_level = uc_stock_level($sku);
		$variables['stock_level_value'] = $stock_level;
	}

	$variables['on_sale']['is'] = FALSE;

	if (isset($variables['field_old_price'][0]['value']) && isset($variables['price'])) {
		$op = floatval($variables['field_old_price'][0]['value']);
		$price = floatval($variables['price']);
		if ($variables['price'] - $op < 0) {
			$variables['on_sale']['is'] = TRUE;
			$variables['on_sale']['percent'] = uc_percent_format('-'.(1-$price/$op)*100);
			$variables['on_sale']['value'] = '<i class="fa fa-thumbs-o-up" aria-hidden="true"></i>' . '&nbsp;' . _t('_you_save_', 'Sutaupote') . ' ' .uc_currency_format($op - $price);
		}
	}

	if ($stock_level > 0) {
		$variables['stock_level'] = '<i class="fa fa-cubes" aria-hidden="true"></i>' . '&nbsp;' . _t('_in_stock_', 'Turime sandėlyje');// . ' ' . $stock_level;
	} else {
		$variables['stock_level'] = '<i class="fa fa-file-o" aria-hidden="true"></i>' . '&nbsp;' . _t('_accepting_orders_', 'Priimami išankstiniai užsakymai');
	}

	$variables['node_title'] = $variables['title'];

	if (($variables['type'] == 'product_type_accessories') || ($variables['type'] == 'product_type_other')  || ($variables['type'] == 'product_type_file'))  {
		$variables['tags'] = '';
		if (isset($variables['field_category'])) {
			if (isset($variables['field_category']['und'])) {
				$variables['tags'] = _the_shop_get_tags($variables['field_category']['und']);
			} else {
				$variables['tags'] = _the_shop_get_tags($variables['field_category']);
			}
		}

	}

	$variables['share_social_title'] = _t('_share_on_social_', 'Dalintis');
	$variables['share_social'] = _the_shop_get_social_links('node', $variables['nid'], $variables['page']);

	if (isset($variables['content']['field_published'][0]['#markup'])) {
		$variables['content']['full_product_title'] = $variables['node_title'] . ', ' . $variables['content']['field_published'][0]['#markup'];
	} else {
		$variables['content']['full_product_title'] = $variables['node_title'];
	}

	if ($variables['teaser']) {
		if (isset($variables['content']['add_to_cart']['#form']['attributes'])) {
			unset($variables['content']['add_to_cart']['#form']['attributes']);
		}

		$variables['node_title'] = _the_shop_truncate_html($variables['node_title'], theme_get_setting('title_len'));

		if (isset($variables['content']['field_author'][0]['#markup'])) {
			$variables['content']['field_author'][0]['#markup'] = _the_shop_truncate_html($variables['content']['field_author'][0]['#markup'], theme_get_setting('author_len'));
		}
	}

	if (isset($variables['field_sell_restrictions'][0]['value'])) {
//		$sr_label = list_allowed_values(field_info_field('field_sell_restrictions'))[$sr_val];
//		$variables['content']['sr_label'] =  '<i class="uk-icon-refresh" aria-hidden="true"></i>&nbsp;' . _t(_gid($sr_label));
		$variables['content']['sr_value'] = $variables['field_sell_restrictions'][0]['value'];
	} else  {
		$variables['content']['sr_value'] = 'WOR';
	}

	if (!$variables['teaser']) {
		if (isset($variables['content']['add_to_cart']['#form']['actions']['submit'])) {
			if ($variables['content']['sr_value'] !== 'WOR') {
				unset($variables['content']['add_to_cart']['#form']['actions']['submit']);
				$variables['content']['add_to_cart']['#form']['actions']['_order_product_']['#markup'] = '<a id="call-contact-form-'.  $variables['nid']. '" href="#contact-form" class="uk-button uk-button-primary uk-button-large" data-uk-modal="{center:true}" data-form-subject="' . $variables['content']['full_product_title'] . ' ' . strtolower(_t('_order_', 'Užsakymas')) . '"><i class="fa fa-check-square-o fa-lg" aria-hidden="true"></i>&nbsp;' . _t('_order_product_', 'Užsakyti') . '</a> ';
			}
			//$variables['content']['add_to_cart']['#form']['actions']['continue_shopping']['#markup'] = '<a href="' . $_SESSION['LAST_URI'] . '" class="uk-button uk-button-large uk-button-success">' . _t('_continue_shopping_', t('Tęsti apsipirkimą')) . '</a>';
		} else {
			//$variables['content']['continue_shopping']['#markup'] = '<a href="' . $_SESSION['LAST_URI'] . '" class="uk-button uk-button-primary">' . _t('_go_back_', t('Atgal')) . '</a>';
		}
	}
}/*preprocess node*/

function the_shop_preprocess_field (&$variables, $hook) {
	$element_title = '_' . str_replace(' ', '_',strtolower($variables['element']['#title'])) . '_';
	$variables['element']['#title'] = _t($element_title, $variables['element']['#title']);
	$variables['label'] = _t($element_title, $variables['label']);
}

/*
Forms Cancel button callback.
*/
function the_shop_form_cancel($form, &$form_state) {
	$link = '';
	$path = 'node';
	if('user_profile_form' == $form['#form_id']) {
		$path = 'user';
	}
	if(arg(1) == 'add') {
// If adding entity link to [user|node]/add screen
		$link = $path . '/add/'.arg(2);
	} elseif(arg(2) == 'edit') {
// If editing entity, link to node view screen
		$link = $path . '/' . arg(1);
	}
	$url = (isset($_GET['destination'])) ? $_GET['destination'] : $link;
	drupal_goto($url);
}

function the_shop_form_alter(&$form, &$form_state, $form_id) {
	global $language_content;
	$lang = $language_content -> language;
	$form['#attributes'] = array('class' => array('uk-form'));
	$types = array(
		'article',
		'vocabulary',
		'page',
		'user',
	);

	foreach($types as $type) {
		if($type.'_node_form' == $form_id || $type.'_profile_form' == $form_id) {
			$form['actions']['cancel'] = array(
				'#type'   => 'submit',
				'#value'  => _t('_cancel_', t('Cancel')),
				'#access' => TRUE,
				'#weight' => 100,
				'#submit' => array('the_shop_form_cancel', 'node_form_submit_build_node'),
				'#limit_validation_errors' => array(),
			);
		}
	}

	if( $form_id == 'contact_site_form' ){
		$form['#prefix'] = '';
		if (arg(0) !== 'contact') {
			$form['#prefix'] .= '<a class="uk-modal-close uk-close"></a>';
		}
		$form['#prefix'] .= '<div class="uk-modal-header">' . variable_get('site_name', FALSE) . '</div>';
		$form['actions']['#prefix'] = '<div class="uk-modal-footer">';
		$form['#suffix'] = '</div>';
		$form['name']['#required'] = FALSE;
		$form['name']['#access'] = FALSE;
    }

	if (isset($form['form']['#attached']['css'])) {
		unset($form['form']['#attached']['css']);
	}

	//views filters exposed form views-exposed-form
	if ($form_id  == 'views_exposed_form') {
		if (isset($form['#info'])) {
			foreach($form['#info'] as $label => $value) {
				$gid = _gid($label);
				$field = str_replace('filter-', '', $label);
				$lbl = _t($gid, t($form['#info'][$label]['label']));
				$form['#info'][$label]['label'] = $lbl;
				if (isset($form[$field])) {
					if (isset($form[$field]['#type'])) {
						$form[$field]['#title'] = $lbl;
					}
				}
			}
			$form['#attributes']['class'][] = 'uk-margin-right';
		}

		if (isset($form['sort_order'])) {
			if (isset($form['sort_order']['#options'])) {
				$gid = '';
				foreach($form['sort_order']['#options'] as $key => $value) {
					$gid = _gid($form['sort_order']['#options'][$key]);
					$form['sort_order']['#options'][$key] = _t($gid, t($form['sort_order']['#options'][$key]));
				}
			}
			$form['sort_order']['#title'] = _t('_sort_order_', t($form['sort_order']['#title']));
		}

		if (isset($form['items_per_page'])) {
			if (isset($form['items_per_page']['#options'])) {
				$gid = '';
				foreach($form['items_per_page']['#options'] as $key => $value) {
					$gid = _gid($form['items_per_page']['#options'][$key]);
					$form['items_per_page']['#options'][$key] = _t($gid, t($form['items_per_page']['#options'][$key]));
				}
			}
			$form['items_per_page']['#title'] = _t('_items_per_page_', t($form['items_per_page']['#title']));
		}

		if (isset($form['sort_by'])) {
			if (isset($form['sort_by']['#options'])) {
				$gid = '';
				foreach($form['sort_by']['#options'] as $key => $value) {
					$gid = _gid($form['sort_by']['#options'][$key]);
					$form['sort_by']['#options'][$key] = _t($gid, t($form['sort_by']['#options'][$key]));

				}
			}
			$form['sort_by']['#title'] = _t('_sort_by_', t($form['sort_by']['#title']));
			$form['sort_by']['#default_value'] = 'field_sort_value_1';
			//To prevent the "An illegal choice has been detected. Please contact the site administrator." error
			$form['sort_by']['#validated'] = TRUE;
		}

		if (isset($form['field_category_tid']['#options']['All'])) {
			$form['field_category_tid']['#options']['All'] = _t('_any_', t('- Any -'));
		}

		//$form['submit']['#attributes'] = array('class' => array('uk-button-primary'));
		if (isset($form['populate'])) {
			$form['populate']['#title'] = _t('_enter_search_term_', t('Search for...'));
			$form['populate']['#size'] = 24;
			$form['filters_link']['#markup'] = '<a id="call-filter-form" href="#filter-form" class="uk-button uk-button-primary" data-uk-modal="{center:true, bgclose:false}">' .
			_t('_adv_search_', t('Filter products')) . '</a>';

			$form['filters_link']['#weight'] = 100;

			//$form['abc_link']['#markup'] = l(_t('_abc_list_', t('ABC list')),
			//$GLOBALS['base_url'] . '/' . $lang . '/abc', array('attributes' => array('class' => array('uk-button', 'uk-button-primary', 'abc-button'))));
			//$form['abc_link']['#weight'] = 110;
		}
	} // end views filters exposed form views-exposed-form

	//add to cart
	if (substr($form_id, 0, 27) == 'uc_product_add_to_cart_form') {
		if (isset($form['qty']['#title'])) {
			$form['qty']['#title'] = _t('_qty_', t('Quantity'));
		}
		$form['actions']['submit']['#attributes']['class'][] = 'uk-button-large';
		$form['actions']['submit']['#attributes']['class'][] = 'fa';
		$form['actions']['submit']['#attributes']['class'][] = 'fa-lg';
		$form['actions']['submit']['#attributes']['class'][] = 'fa-shopping-basket';

	}

	if ($form_id == 'uc_cart_empty_confirm') {
		$form['description']['#prefix'] = '<div>';
		$form['description']['#prefix'] .= "<div class=\"article-wrapper uk-article uk-margin-bottom\">\n";
		$form['description']['#prefix'] .= "<div class=\"node-body-wrapper\">\n";
		$form['description']['#prefix'] .= "<div class=\"node-body\">\n";
		$form['description']['#suffix'] = "</div>\n</div>\n</article>\n";
		$form['description']['#suffix'] .= '</div>';
		$form['description']['#markup'] = '<h3>' . _t('_cannot_undone_', t('Cannot undone')) . '</h3>' . "\n";
		$form['description']['#markup'] .= '<hr class="uk-article-divider">' . "\n";
		$form['actions']['cancel']['#options']['attributes']['class'] = array('uk-button uk-margin-bottom uk-button-danger');
		$form['actions']['cancel']['#title'] = _t('_cancel_', t('Cancel'));
	}
}
