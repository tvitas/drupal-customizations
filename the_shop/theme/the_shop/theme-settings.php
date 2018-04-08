<?php
function the_shop_form_system_theme_settings_alter(&$form, &$form_state) {
// Work-around for a core bug affecting admin themes. See issue #943212.
if (isset($form_id)) {
	return;
}

$toggle_breadcrumb    = theme_get_setting('toggle_breadcrumb');
$toggle_lang_switcher = theme_get_setting('toggle_lang_switcher');

$site_abbreviation = theme_get_setting('site_abbreviation');
$teaser_len        = theme_get_setting('teaser_len');
$title_len         = theme_get_setting('title_len');
$author_len        = theme_get_setting('author_len');


$toggle_fb_share   = theme_get_setting('toggle_fb_share');
$toggle_tw_share   = theme_get_setting('toggle_tw_share');
$toggle_in_share   = theme_get_setting('toggle_in_share');

$fb_share_link    = theme_get_setting('fb_share_link');
$tw_share_link    = theme_get_setting('tw_share_link');
$in_share_link    = theme_get_setting('in_share_link');

$toggle_rss_follow = theme_get_setting('toggle_rss_follow');
$toggle_fb_follow  = theme_get_setting('toggle_fb_follow');
$toggle_tw_follow  = theme_get_setting('toggle_tw_follow');
$toggle_in_follow  = theme_get_setting('toggle_in_follow');

$rss_follow_name    = theme_get_setting('rss_follow_name');
$fb_follow_name     = theme_get_setting('fb_follow_name');
$tw_follow_name     = theme_get_setting('tw_follow_name');
$in_follow_name     = theme_get_setting('in_follow_name');
$social_links_order = theme_get_setting('social_links_order');

$offcanvas_menu_depth = theme_get_setting('offcanvas_menu_depth');
$terms_not_exposed    = theme_get_setting('terms_not_exposed');
$topmost_tid          = theme_get_setting('topmost_tid');
$topmost_title        = theme_get_setting('topmost_title');


$form['shop_settings'] = array(
	'#type' => 'fieldset',
	'#title' => 'The Shop settings',
	'#description' => t('Settings, implemented in The Shop'),

	'toggle_breadcrumb' => array(
		'#type' =>'checkbox',
		'#title' => 'Display breadcrumb',
		'#description' => t('Toggle display breadcrumbs on a page'),
		'#default_value' => $toggle_breadcrumb,
	),

	'toggle_lang_switcher' => array(
		'#type' =>'checkbox',
		'#title' => 'Display language switcher',
		'#description' => t('Toggle display language switcher on a page'),
		'#default_value' => $toggle_lang_switcher,
	),

	'topmost_tid' => array(
		'#type'          => 'textfield',
		'#title'         => t('Topmost block term tid'),
		'#description'   => t('TID to display in topmost block'),
		'#default_value' => $topmost_tid,
	),

	'topmost_title' => array(
		'#type'          => 'textfield',
		'#title'         => t('Topmost block title'),
		'#description'   => t('Title of topmost block'),
		'#default_value' => $topmost_title,
	),

	'offcanvas_menu_depth' => array(
		'#type'          => 'textfield',
		'#title'         => t('Offcanvas menu depth'),
		'#description'   => t('Items depth for default offcanvas menu.'),
		'#default_value' => $offcanvas_menu_depth,
	),

	'site_abbreviation' => array(
		'#type'          => 'textfield',
		'#title'         => t('Site abbreviation'),
		'#description'   => t('Site abbreviation, to display on small devices.'),
		'#default_value' => $site_abbreviation,
	),

	'terms_not_exposed' => array(
		'#type'          => 'textfield',
		'#title'         => t('Terms not using exposed sort'),
		'#description'   => t('Comma separated terms list.'),
		'#default_value' => $terms_not_exposed,
	),

	'teaser_len' => array(
		'#type'          => 'textfield',
		'#title'         => t('Teaser length'),
		'#description'   => t('Enter the number of characters of html stripped body in teaser view.'),
		'#default_value' => $teaser_len,
	),

	'title_len' => array(
		'#type'          => 'textfield',
		'#title'         => t('Title length'),
		'#description'   => t('Enter the number of characters of html stripped node title in teaser view.'),
		'#default_value' => $title_len,
	),

	'author_len' => array(
		'#type'          => 'textfield',
		'#title'         => t('Author name length'),
		'#description'   => t('Enter the number of characters of html stripped author title in teaser view.'),
		'#default_value' => $author_len,
	),


	'toggle_social' => array(
		'#type' => 'fieldset',
		'#title' => 'Linked social icons',
		'#description' => t('Toggle various social links'),

		'toggle_fb_share' => array(
			'#type' =>'checkbox',
			'#title' => 'Share link on Facebook',
			'#description' => t('Toggle share on Facebook link'),
			'#default_value' => $toggle_fb_share,
		),

		'fb_share_link' => array(
			'#type'          => 'textfield',
			'#title'         => t('Share on Facebook URL'),
			'#description'   => t('Link part to share on Facebook.'),
			'#default_value' => $fb_share_link,
		),

		'toggle_tw_share' => array(
			'#type' => 'checkbox',
			'#title' => 'Share link on Twitter',
			'#description' => t('Toggle share on Twitter link'),
			'#default_value' => $toggle_tw_share,
		),

		'tw_share_link' => array(
			'#type'          => 'textfield',
			'#title'         => t('Share on Twitter URL'),
			'#description'   => t('Link part to share on Twitter.'),
			'#default_value' => $tw_share_link,
		),

		'toggle_in_share' => array(
			'#type' => 'checkbox',
			'#title' => 'Share link on LinkedIn',
			'#description' => t('Toggle share on LinkedIn link'),
			'#default_value' => $toggle_in_share,
		),

		'in_share_link' => array(
			'#type'          => 'textfield',
			'#title'         => t('Share on LinkedIn URL'),
			'#description'   => t('Link part to share on LinkedIn.'),
			'#default_value' => $in_share_link,
		),

		'toggle_rss_follow' => array(
			'#type' => 'checkbox',
			'#title' => 'Follow rss',
			'#description' => t('Toggle follow rss link'),
			'#default_value' => $toggle_rss_follow,
		),

		'rss_follow_name' => array(
			'#type' => 'textfield',
			'#title' => 'RSS path',
			'#description' => 'Enter site rss path',
			'#default_value' => $rss_follow_name,
		),

		'toggle_fb_follow' => array(
			'#type' => 'checkbox',
			'#title' => 'Follow on Facebook',
			'#description' => t('Toggle follow on Facebook link'),
			'#default_value' => $toggle_fb_follow,
		),

		'fb_follow_name' => array(
			'#type' => 'textfield',
			'#title' => 'Facebook name to follow',
			'#description' => 'Enter Your account or site name on Facebook',
			'#default_value' => $fb_follow_name,
		),

		'toggle_tw_follow' => array(
			'#type' => 'checkbox',
			'#title' => 'Follow on Twitter',
			'#description' => t('Toggle follow on Twitter link'),
			'#default_value' => $toggle_tw_follow,
		),

		'tw_follow_name' => array(
			'#type' => 'textfield',
			'#title' => 'Twitter name to follow',
			'#description' => 'Enter Your account or site name on Twitter',
			'#default_value' => $tw_follow_name,
		),

		'toggle_in_follow' => array(
			'#type' => 'checkbox',
			'#title' => 'Follow on LinkedIn',
			'#description' => t('Toggle follow on LinkedIn link'),
			'#default_value' => $toggle_in_follow,
		),

		'in_follow_name' => array(
			'#type' => 'textfield',
			'#title' => 'LinkedIn name to follow',
			'#description' => 'Enter Your account or site name on LinkedIn',
			'#default_value' => $in_follow_name,
		),
		'social_links_order' => array(
			'#type' => 'textfield',
			'#title' => 'Social links order',
			'#description' => 'Order to display social links. A list, separated with comma.',
			'#default_value' => $social_links_order,
		),
	),
);
}
