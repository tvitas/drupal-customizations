<?php
/**
 * @file
 * Default theme implementation to display a single Drupal page.
 *
 * The doctype, html, head and body tags are not in this template. Instead they
 * can be found in the html.tpl.php template in this directory.
 *
 * Available variables:
 *
 * General utility variables:
 * - $$GLOBALS['base_url']): The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/bartik.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $$GLOBALS['base_url']),
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 * - $messages: HTML for status and error messages. Should be displayed
 *   prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 *   menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 *   associated with the page, and the node ID is the second argument
 *   in the page's path (e.g. node/12345 and node/12345/revisions, but not
 *   comment/reply/12345).
 * - $content_root['menu_items'] (array): Max. 6 top level taxonomy vocabulary`s 'content_tree' terms
 *   to create top menu.
 *   $content_root['items_count']: items count. *
 *   It is because Zero`s page--front.tpl.php is not using any menu
 *   to create navigation items.
 *
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see template_process()
 * @see html.tpl.php
 *
 * @ingroup themeable
 */
?>
<?php
	global $language_content;
	$lang = $language_content -> language;
	$front_page = $GLOBALS['base_url'] . '/' . $lang;
	if (empty($site_owner_web)) {
		$site_owner_web = $front_page;
	}
	if (empty($site_owner_title)) {
		$site_owner_title = $site_name;
	}
  $front_slide_wrapper_class = 'front-slider-wrapper';
  if ($is_admin) {
    $front_slide_wrapper_class = 'front-slider-wrapper-admin';
  }
?>
<a id="0"></a>

<?php /*FRONT SLIDER*/ ?>
<?php if (theme_get_setting('toggle_front_video')): ?>
<?php $front_video = views_embed_view('content_manipulation', 'block_video');?>
<div id="front-slider" class="<?php echo $front_slide_wrapper_class; ?>">
<?php print ($front_video);?>
</div>
<?php else:?>
<?php if ($page['front_slider']):?>
<div id="front-slider" class="<?php echo $front_slide_wrapper_class; ?>">
<?php print render($page['front_slider']);?>
</div>
<?php endif;?>
<?php endif;?>

<?php /*HAMBURGER AND NAV*/ ?>
<?php if ($content_root['navbar']):?>

<nav id="uk-navbar-front" class="uk-navbar uk-navbar-attached" data-uk-sticky="{classactive: 'uk-navbar-attached', top: -10, animation: 'uk-animation-slide-top'}">

<?php /*nav taxonomy links*/ ?>
<div class="uk-hidden-small uk-hidden-medium uk-width-2-3">
<?php /*nav brand on large scr*/ ?>
<div class="uk-navbar-brand uk-hidden-small uk-hidden-medium uk-margin-left">
<?php if (theme_get_setting('toggle_logo_brand')): ?>
<a href="<?php echo $site_owner_web;?>" title="<?php echo $site_owner_title;?>"><img src="<?php echo $logo;?>" alt="<?php echo $site_owner_title;?>" title="<?php echo $site_owner_title;?>"></a>
<?php endif;?>
<?php if (theme_get_setting('toggle_site_name_as_home_link')): ?>
<h1 class="navbar-brand-title"><a href="<?php echo $front_page;?>" title="<?php echo htmlentities($site_slogan);?>"><?php echo $site_name;?></a></h1>
<?php else: ?>
<h1 class="navbar-brand-title" title="<?php echo htmlentities($site_slogan)?>"><?php echo $site_name;?></h1>
<?php endif; ?>
</div>
<?php /*hamburger on large devices*/ ?>
<a href="#offcanvas-bar" class="uk-navbar-toggle uk-hidden-small uk-hidden-medium" data-uk-offcanvas="{mode: 'reveal'}"></a>
<?php echo $content_root['navbar'];?>
</div>

<?php /*hamburger*/ ?>
<a href="#offcanvas-bar" class="uk-navbar-toggle uk-hidden-large" data-uk-offcanvas="{mode: 'reveal'}"></a>

<?php /*nav brand on small and medium scr*/ ?>
<div class="uk-navbar-brand uk-hidden-large">
<?php if (theme_get_setting('toggle_logo_brand')): ?>
<a href="<?php echo $site_owner_web;?>" title="<?php echo $site_owner_title;?>"><img src="<?php echo $logo;?>" alt="<?php echo $site_owner_title;?>" title="<?php echo $site_owner_title;?>"></a>
<?php endif;?>
<a href="<?php echo $front_page;?>" title="<?php echo $site_name;?>"><?php echo $site_abbreviation;?></a>
</div>


<?php /*nav menu and lang switcher links*/ ?>
<div class="uk-navbar-flip uk-hidden-small uk-hidden-medium uk-width-1-3">
<?php echo $content_root['navbar_menu'];?>
</div>
</nav>
<?php endif;?>

<?php /*SEARCH FORM*/ ?>
<?php if ($page['search_form'] || $filters_link):?>
<div id="search-form" class="search-form-wrapper">
<div class="uk-container uk-container-center">
<div class="search-form uk-navbar-flip">
<?php //$search_form = render($page['search_form']);?>
<?php //if ($filters_link) {$search_form .= $filters_link;}?>
<?php print render($page['search_form']);?>
<div class="uk-clearfix"></div>
</div>
</div>
</div>
<?php endif;?>


<?php /*MESSAGES*/ ?>
<?php if($messages && (theme_get_setting('dev_mode'))):?>
<div class="uk-container uk-container-center uk-margin-bottom">
<?php print $messages; ?>
</div>
<?php endif;?>


<?php /*FRONT BLOCKS*/ ?>
<section class="content-wrapper" id="content">
<h2 class="section-heading-invisible">Content</h2>

<?php /*TOPMOST*/?>
<?php
	$topmost = FALSE;
	$title = _t('_topmost_', t('Topmost'));
	$topmost = views_embed_view('content_manipulation', 'block_topmost', $lang);
?>
<?php if (!empty($topmost)):?>
<div id="topmost" class="topmost-wrapper">
<div class="topmost">
<div class="uk-container uk-container-center">
<div class="category-title-div">
<h2 class="category-title"><?php echo $title;?></h2>
</div>
<?php print $topmost;?>
</div>
</div>
</div>
<?php endif;?>

<?php
$output = '';
$index = 1;
foreach ($content_root['menu_items'] as $root) {
	$params = (!empty($root['term_settings'])) ? $root['term_settings'] : FALSE;
	$view = FALSE;
	if ($params['fragment']) {
		$filter = FALSE;
		if ($params) $filter = $params['filter'];
		$title = l($root['term_name'], drupal_get_path_alias('taxonomy/term/' . $root['term_id']));
		$tid = $root['term_id'];
		$block_id = strtolower(_the_zero_transliterate($root['term_name']));
		$zebra_class = ($index % 2 == true) ? 'zero-odd' : 'zero-even';
		$wrapper_class = "$zebra_class"."-wrapper";
		$views_block = (isset($params['block_id']) && $params['block_id']) ? $params['block_id'] : 'block_about';
		$view = views_embed_view('content_manipulation', $views_block, $lang, $tid, $filter);
		if (!empty($view)) {
			$output .= "<a id=\"$block_id\"></a>\n";
			$output .= "<div class=\"$wrapper_class\">\n";
			$output .= "<div id=\"$zebra_class-$index\" class=\"$zebra_class\">\n";
			$output .= '<div class="uk-container uk-container-center">'."\n";
			$output .= "<div class=\"category-title-div\"><h2 class=\"category-title\">$title</h2></div>\n";
			$output .= $view;
			$output .= "</div>\n</div>\n</div>\n";
			$index ++;
		}
	}
}
echo $output;
?>
</section>




<?php /*FOOTER*/ ?>
<section id="page-footer-wrapper" style="padding-top: 15px;">
<footer id="footer" class="page-footer">
<div class="uk-container uk-container-center">
<div class="uk-grid uk-grid-width-small-1-2 uk-grid-width-medium-1-3 uk-grid-width-large-1-4" data-uk-grid="{gutter: 5, animation: false}">
<?php echo _the_zero_get_footer_blocks('block_follow');?>
<?php echo _the_zero_get_footer_blocks('block_contacts');?>
<?php echo _the_zero_get_footer_blocks('block_site_operator');?>
<?php echo _the_zero_get_footer_blocks('block_site_owner');?>
</div>
</div>

<div class="uk-margin-top uk-text-muted">
<div class="uk-container uk-container-center uk-text-center">
<div class="uk-text-center uk-margin-top">
<?php print render($page['footer_zone']);?>
</div>
</div>
</div>

</footer>
</section>

<?php /*HIDDEN BLOCK MULTIPURPOSE*/ ?>
<?php if ($page['hidden_region']): ?>
<div id="hidden-block" class="section-heading-invisible">
<div class="node-body-wrapper">
<div class="node-boody">
<?php print render($page['hidden_region']);?>
</div>
</div>
</div>
<?php endif; ?>
</div>

<?php /*OFFCANVAS*/ ?>
<section id="offcanvas-bar" class="uk-offcanvas">
<div class="uk-offcanvas-bar">

<?php if (theme_get_setting('toggle_lang_switcher')): ?>
<div class="uk-navbar-flip">
<?php $switcher = render($page['language_switcher']);?>
<?php print str_replace(array('English', 'Lietuvių'), array('EN', 'LT'), $switcher);?>
</div>
<?php endif;?>

<div class="uk-clearfix"></div>
<?php foreach ($content_root['offcanvas'] as $offcanvas) :?>
<div class="offcanvas-menu-wrapper uk-nav-offcanvas">
<?php echo $offcanvas;?>
</div>
<?php endforeach;?>
</div>
</section>

<?php /*CONTACT FORM*/?>
<?php if($contact_form): ?>
<section id="contact-form" class="uk-modal">
<div class="uk-modal-dialog uk-modal-dialog-large">
<a class="uk-modal-close uk-close"></a>
<?php print drupal_render($contact_form);?>
</div>
</section>
<?php endif; ?>

<?php /*FILTER FORM*/?>
<?php if($filter_form): ?>
<section id="filter-form" class="uk-modal">
<div class="uk-modal-dialog uk-modal-dialog-large">
<a class="uk-modal-close uk-close"></a>
<?php print $filter_form->render_exposed_form(true);?>
</div>
</section>
<?php endif; ?>


<?php /*MARQUEE*/?>
<?php if ($display_marquee): ?>
<?php if ($page['marquee']):?>
<section id="marquee-section">
<div class="uk-container uk-container-center">
<div class="marquee">
<div>
<span><?php print render($page['marquee'])?></span>
</div>
</div>
</div>
</section>
<?php endif;?>
<?php endif;?>
