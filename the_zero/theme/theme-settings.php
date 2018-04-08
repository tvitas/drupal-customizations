<?php
function the_zero_form_system_theme_settings_alter(&$form, &$form_state) {
// Work-around for a core bug affecting admin themes. See issue #943212.
if (isset($form_id)) {
	return;
}

$toggle_breadcrumb             = theme_get_setting('toggle_breadcrumb');
$toggle_lang_switcher          = theme_get_setting('toggle_lang_switcher');
$toggle_site_name_as_home_link = theme_get_setting('toggle_site_name_as_home_link');
$toggle_logo_brand             = theme_get_setting('toggle_logo_brand');
$toggle_marquee                = theme_get_setting('toggle_marquee');
$toggle_front_video            = theme_get_setting('toggle_front_video');

$teaser_len        = theme_get_setting('teaser_len');
$title_len         = theme_get_setting('title_len');

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

$rss_follow_name   = theme_get_setting('rss_follow_name');
$fb_follow_name    = theme_get_setting('fb_follow_name');
$tw_follow_name    = theme_get_setting('tw_follow_name');
$in_follow_name    = theme_get_setting('in_follow_name');
$social_links_order= theme_get_setting('social_links_order');

$toggle_default_footer     = theme_get_setting('toggle_default_footer');
$footer_menu_depth         = theme_get_setting('footer_menu_depth');
$dropdown_menu_depth       = theme_get_setting('dropdown_menu_depth');

$form['shop_settings'] = array(
	'#type' => 'fieldset',
	'#title' => 'The Zero settings',
	'#description' => t('Settings, implemented in theme "The Zero"'),

	'toggle_lang_switcher' => array(
		'#type' =>'checkbox',
		'#title' => 'Display lang switcher',
		'#description' => t('Toggle display language switcher on a page and offcanvas'),
		'#default_value' => $toggle_lang_switcher,
	),

	'toggle_breadcrumb' => array(
		'#type' =>'checkbox',
		'#title' => 'Display breadcrumb',
		'#description' => t('Toggle display breadcrumbs on a page'),
		'#default_value' => $toggle_breadcrumb,
	),

	'toggle_site_name_as_home_link' => array(
		'#type' =>'checkbox',
		'#title' => 'Display site name as home link',
		'#description' => t('Toggle display site name as home link'),
		'#default_value' => $toggle_site_name_as_home_link,
	),

	'toggle_logo_brand' => array(
		'#type' =>'checkbox',
		'#title' => 'Display brand logo',
		'#description' => t('Toggle display brand logo.'),
		'#default_value' => $toggle_logo_brand,
	),

	'toggle_default_footer' => array(
		'#type' =>'checkbox',
		'#title' => 'Display default footer',
		'#description' => t('Default footer contains follow us icons and repeated menu links'),
		'#default_value' => $toggle_default_footer,
	),

	'toggle_marquee' => array(
		'#type' =>'checkbox',
		'#title' => 'Display marquee',
		'#description' => t('Toggle display marquee at the bottom of screen'),
		'#default_value' => $toggle_marquee,
	),

	'toggle_front_video' => array(
		'#type' =>'checkbox',
		'#title' => 'Display background video',
		'#description' => t('Display background video instead of picture on front page slide show.'),
		'#default_value' => $toggle_front_video,
	),

	'footer_menu_depth' => array(
		'#type'          => 'textfield',
		'#title'         => t('Footer menu depth'),
		'#description'   => t('Items depth for default footer menu.'),
		'#default_value' => $footer_menu_depth,
	),

	'dropdown_menu_depth' => array(
		'#type'          => 'textfield',
		'#title'         => t('Dropdown menu depth'),
		'#description'   => t('Items depth for default dropdown menu.'),
		'#default_value' => $dropdown_menu_depth,
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
