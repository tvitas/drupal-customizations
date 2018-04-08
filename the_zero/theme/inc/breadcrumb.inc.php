<?php
/*BREADCRUMB*/
function the_zero_breadcrumb($vars) {
	global $language_content;
	global $user;
	$lang = $language_content->language;
	$home_link = $GLOBALS['base_url'] . '/' . $lang;
	$breadcrumb = $vars['breadcrumb'];
	if (($breadcrumb) && (theme_get_setting('toggle_breadcrumb'))) {
		$stripped = strtolower(strip_tags($breadcrumb[0]));
		if ($stripped == 'home') {
			$breadcrumb[0] = l(_t('_home_', 'Pradžia'), $home_link);
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
					$last_term = 0;
					if (isset($node -> field_category) || isset($node -> field_menu_tree)) {
						if (isset($node -> field_category['und'])) {
							$last_term = $node -> field_category['und'][count($node -> field_category['und'])-1]['tid'];
						}
						if (isset($node -> field_menu_tree['und'])) {
							$last_term = $node -> field_menu_tree['und'][count($node -> field_menu_tree['und'])-1]['tid'];
						}
						$parents_chain = array_reverse(taxonomy_get_parents_all($last_term));
						$path_prefix = 'taxonomy/term/';
						foreach($parents_chain as $crumb) {
							$breadcrumb[] = l($crumb -> name, $path_prefix.$crumb -> tid);
						}
					}
				}
				if ($obj_id == 'add') {
					if (isset($breadcrumb[1])) {
						$breadcrumb[1] = _t('_add_new_', t('Add new'));//str_replace('content', 'new', $breadcrumb[1]);
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
					$breadcrumb = array(l(_t('_home_', 'Pradžia'), $home_link), t('Administrator'));
				} else {
					$breadcrumb = array(l(_t('_home_', 'Pradžia'), $home_link), t('Users'));
				}
				break;
			}
			case 'search': {
				if (isset($vars['breadcrumb'][1])) {
					$crumb = strip_tags($vars['breadcrumb'][1]);
				}
				$breadcrumb = array(l(_t('_home_', 'Pradžia'), $home_link), _t($crumb, t($crumb)));
				break;
			}
			case 'filter':
			case 'adv-search': {
				$breadcrumb[] = _t('_adv_search_', 'Filtruoti');
				break;
			}
			case 'news': {
				if (isset($vars['breadcrumb'][1])) {
					$crumb = strip_tags($vars['breadcrumb'][1]);
				}
				$breadcrumb = array(l(_t('_home_', 'Pradžia'), $home_link), _t($crumb, t($crumb)));
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
