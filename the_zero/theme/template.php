<?php
include('inc/theme.inc.php');
include('inc/user_profile.inc.php');
include('inc/theme_elements.inc.php');
include('inc/messages.inc.php');
include('inc/helpers.inc.php');
include('inc/breadcrumb.inc.php');
include('inc/table.inc.php');

_the_zero_init();


function the_zero_html_head_alter(&$head_elements) {
	//dpm($head_elements);
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

function the_zero_css_alter(&$css) {
  // Remove defaults.css file.
	foreach ($css as $sheet) {
		if (!strpos($sheet['data'], 'the_zero')) {
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

function the_zero_preprocess_page (&$variables) {
	global $language_content;
	$lang = $language_content->language;

	$language_switcher = render($variables['page']['language_switcher']);
	$language_switcher = str_replace(array('English', 'Lietuvių'), array('EN', 'LT'), $language_switcher);
	$default_footer = theme_get_setting('toggle_default_footer');

	$variables['default_footer'] = FALSE;
	$variables['show_title'] = TRUE;
	$variables['site_abbreviation'] = '';
	$variables['display_marquee'] = theme_get_setting('toggle_marquee');
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

	$variables['logo'] = $GLOBALS['base_url'] . '/' . drupal_get_path('theme', 'the_zero') . '/img/logo/logo-brand.png';

	if ($variables['is_front']) {
		$variables['content_root']['navbar'] = _the_zero_get_navbar('taxonomy');
	} else {
		$vid = _the_zero_get_vid_by_tid(arg(2));
		$variables['content_root']['navbar'] = _the_zero_get_navbar('taxonomy', 'page');
		$variables['content_root']['child_terms_dropdown'] = _the_zero_get_child_terms_dropdown(arg(2), theme_get_setting('offcanvas_menu_depth'), $vid);
	}

//	$variables['content_root']['offcanvas'] = _the_zero_get_offcanvas_tree();
	$variables['content_root']['navbar_menu'] = _the_zero_get_navbar('page', 'page');

	$block_content_tree = module_invoke('nice_taxonomy_menu', 'block_view', 'ntm_1');
	$block_menu_tree = module_invoke('nice_taxonomy_menu', 'block_view', 'ntm_2');

	$variables['site_abbreviation'] = variable_get('site_abbreviation');
	$variables['site_owner_web'] = variable_get('site_owner_web');
	$variables['site_owner_title'] = variable_get('site_owner_title');

	$home_link = base_path() . $lang;
	$variables['content_root']['offcanvas'][0] = '<ul class="uk-nav uk-nav-offcanvas uk-nav-parent-icon"><li>'
	. '<a href="' . $home_link 	. '"><i class="uk-icon-home"></i></a>'
	. '</li></ul>';
	$variables['content_root']['offcanvas'][1] = $block_content_tree['content'];
	$variables['content_root']['offcanvas'][2] = $block_menu_tree['content'];

	if (theme_get_setting('toggle_lang_switcher')) {
		$variables['content_root']['navbar_menu'] .= $language_switcher;
	}

	$variables['content_root']['menu_items'] = _the_zero_get_terms_by_parent(0, 1, $GLOBALS['content_tree_vid']);

	if(isset($variables['node']) && $variables['node']->type == 'article') {
		$variables['show_title'] = FALSE;
	}

	if(isset($variables['node']) && $variables['node']->type == 'article_static') {
		$variables['show_title'] = FALSE;
	}

	if(isset($variables['node']) && $variables['node']->type == 'course_registration_form') {
		$variables['show_title'] = FALSE;
	}

	if (arg(0) == 'filter') {
		drupal_set_title(_t('_adv_search_'));
	}
	if (arg(0) == 'search') {
		$variables['show_title'] = FALSE;
	}

	if (arg(0) == 'user') {
		$variables['show_title'] = FALSE;
	}

	if (arg(2) == 'course-registration-form') {
		$variables['show_title'] = FALSE;
	}
}


function the_zero_preprocess_node(&$variables) {
	// Add css class "node--NODETYPE--VIEWMODE" to nodes
	//$variables['classes_array'][] = 'node--' . $variables['type'] . '--' . $variables['view_mode'];
	// Make "node--NODETYPE--VIEWMODE.tpl.php" templates available for nodes
	$variables['theme_hook_suggestions'][] = 'node__' . $variables['view_mode'];
	$variables['theme_hook_suggestions'][] = 'node__' . $variables['type'] . '__' . $variables['view_mode'];
	if (isset($variables['content']['links'])) {
		$variables['content']['links']['#attributes']['class'][] = 'uk-list';
	}

	if (isset($variables['content']['links']['node']['#links']['node-readmore']['attributes']['title'])) {
		$variables['content']['links']['node']['#links']['node-readmore']['attributes']['class'] = 'uk-button uk-button-primary uk-margin-bottom';
	}

	if (isset($variables['content']['body'][0]['#markup']) && $variables['teaser']) {
		$variables['content']['body'][0]['#markup'] = _the_zero_truncate_html($variables['content']['body'][0]['#markup'], theme_get_setting('teaser_len'));
	}
//	$variables['submitted'] = t($submitted_by, array('!username' => $variables['name'], '!datetime' => $variables['date']));
	$variables['share_social_title'] = _t('_share_on_social_', t('Share on...'));
	$variables['share_social'] = _the_zero_get_social_links('node', $variables['nid'], $variables['page']);
}



function the_zero_preprocess_table(&$variables) {
	$variables['#prefix'] = '<div class="uk-overflow-container">';
	$variables['#suffix'] = '</div>';
}

/*
Forms Cancel button callback.
*/
function the_zero_form_cancel($form, &$form_state) {
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

function the_zero_form_alter(&$form, &$form_state, $form_id) {
	global $language_content;
	$lang = $language_content -> language;
	$form['#attributes'] = array('class' => array('uk-form'));
	$types = array(
		'article',
		'vocabulary',
		'page',
		'user',
		'alumni_registration_form',
		'association_registration_form',
	);

	foreach($types as $type) {
		if($type . '_node_form' == $form_id || $type . '_profile_form' == $form_id) {
			$form['actions']['cancel'] = array(
				'#type'   => 'submit',
				'#value'  => _t('_cancel_', t('Cancel')),
				'#access' => TRUE,
				'#weight' => 100,
				'#submit' => array('the_zero_form_cancel', 'node_form_submit_build_node'),
				'#limit_validation_errors' => array(),
			);
		}
	}

	if (isset($form['form']['#attached']['css'])) {
		unset($form['form']['#attached']['css']);
	}


	if( $form_id == 'contact_site_form' ){
		$form['#prefix'] = '';
		$form['#prefix'] .= '<div class="uk-modal-header"><h3>' . variable_get('site_name', FALSE) . '</h3><h4>' . variable_get('site_slogan', FALSE) . '</h4></div>';
		$form['actions']['#prefix'] = '<div class="uk-modal-footer">';
		$form['#suffix'] = '</div>';
		$form['name']['#required'] = FALSE;
		$form['name']['#access'] = FALSE;
    }

	//views filters exposed form views-exposed-form
	if ($form_id  == 'views_exposed_form') {
		$form['submit']['#attributes'] = array('class' => array('uk-button-primary'));
		if (isset($form['populate'])) {
			$form['populate']['#title'] = _t('_enter_search_term_', 'Įveskite paieškos frazę ir spauskite ENTER');
			$form['populate']['#size'] = 29;
			//$form['filters_link']['#markup'] = l(_t('_adv_search_', t('Advanced search')),
			//$GLOBALS['base_url'] . '/' . $lang . '/filter', array('attributes' => array('class' => array('uk-button', 'uk-button-primary', 'uk-margin-bottom'))));
			//$form['filters_link']['#weight'] = 100;
			/*THIS FOR GLASS*/
			//$form['submit']['#value'] = decode_entities('&#xf002;');
			//$form['submit']['#value'] = _t('_apply_', 'Pritaikyti');
			//$form['submit']['#attributes'] = array('class' => array('uk-hidden-small', 'uk-hidden-medium', 'uk-hidden-large'));
		}
	} // end views filters exposed form views-exposed-form
}
