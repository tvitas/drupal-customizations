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
?>

<section id="heading">
<?php /*MENU NAV*/ ?>
<?php if ($content_root['navbar_menu']):?>
<section id="uk-navbar-menu">
<nav class="uk-navbar">

<?php /*nav menu and lang switcher links*/ ?>
<div class="uk-navbar-flip uk-hidden-small">
<?php echo $content_root['navbar_menu'];?>
</div>

</nav>
</section>
<?php endif;?>


<?php /*HEADER*/ ?>
<section id="section-header" class="page-header-wrapper">

<header id="page-header" class="page-header top-40 uk-container uk-container-center uk-animation uk-animation-slide-bottom">
<div class="uk-grid uk-grid-width-small-1-1 uk-grid-width-medium-1-3 uk-grid-width-large-1-3">

<div class="top-40">
<?php if($site_name):?>
<?php if (!empty($logo)): ?>
<span class="logo"><img src="<?php echo $logo; ?>"></span>
<?php endif; ?>
<h1><strong><?php print l($site_name, $front_page);?></strong></h1>
<?php endif;?>
<?php if($site_slogan):?>
<h4><?php print $site_slogan; ?></h4>
<?php endif;?>
</div>

<div class="uk-tex-center uk-hidden-small">
<?php if (!empty($contact_block_top)):?>
<?php echo $contact_block_top;?>
<?php endif;?>
</div>

<div class="uk-text-center cart-top-40 uk-hidden-small">
<?php if ($page['cart_block_top']):?>
<?php print render ($page['cart_block_top']);?>
<?php endif;?>
</div>

</div>
</header>
</section>

<?php /*HAMBURGER AND CATEGORIES NAV*/ ?>
<?php if ($content_root['navbar']):?>
<section id="uk-navbar-categories">
<nav class="uk-navbar uk-navbar-attached" data-uk-sticky="{classactive: 'uk-navbar-attached', top: -40, animation: 'uk-animation-slide-top'}">

<?php /*if need hamburger remove ul, leave a, add class uk-offcanvas-toggle*/ ?>
<ul class="navbar-nav-all-products">
<li><a href="#offcanvas-bar" data-uk-offcanvas="{mode:'slide'}"><i class="uk-icon-bars"></i>&nbsp;<?php echo _t('_all_products_', t('All products'));?></a></li>
</ul>
<div class="uk-hidden-small uk-hidden-medium">
<?php /*nav taxonomy links*/ ?>
<?php echo $content_root['navbar'];?>
</div>

<div id="cart-block-small" class="uk-navbar-flip uk-hidden-large uk-hidden-medium">
<?php if ($page['cart_block_top']):?>
<?php print render ($page['cart_block_top']);?>
<?php endif;?>
</div>

</nav>
</section>
<?php endif;?>
</section>

<?php /*SEARCH FORM*/ ?>
<?php if ($page['search_form'] || $filters_link):?>
<section id="search-form" class="search-form-wrapper">
<div class="uk-container uk-container-center">
<div class="search-form uk-navbar-flip">
<?php //$search_form = render($page['search_form']);?>
<?php //if ($filters_link) {$search_form .= $filters_link;}?>
<?php print render($page['search_form']);?>
<div class="uk-clearfix"></div>
</div>
</div>
</section>
<?php endif;?>


<?php /*MESSAGES*/ ?>
<?php if($messages && (theme_get_setting('dev_mode'))):?>
<div class="uk-container uk-container-center uk-margin-bottom">
<?php print $messages; ?>
</div>
<?php endif;?>


<?php /*FRONT BLOCKS*/ ?>
<section class="content-wrapper" id="content">
<h1 class="section-heading-invisible"><?php print $site_slogan?></h1>

<?php /*FRONT SLIDER*/ ?>
<?php if ($page['front_slider']):?>
<div id="front-slider" class="front-slider-wrapper uk-margin-bottom uk-margin-top uk-hidden-small">
<div class="uk-container uk-container-center">
<?php print render($page['front_slider']);?>
</div>
</div>
<?php endif;?>


<?php /*TOPMOST*/?>
<?php
$topmost = FALSE;
$tid = theme_get_setting('topmost_tid');
if (!empty($tid)) {
	$title = theme_get_setting('topmost_title');
	$title_gid = _gid($title);
	$title = _t($title_gid, t($title));
	$link = '<a href="' . $front_page . '/' . drupal_get_path_alias('taxonomy/term/' . $tid) . '" title="' . $title . '">' . $title . '</a>' . "\n";
	$topmost = views_embed_view('content_manipulation', 'block_topmost', $lang, $tid);
}
?>
<?php if (!empty($topmost)):?>
<div id="topmost" class="topmost-wrapper">
<div class="topmost uk-margin-bottom">
<div class="uk-container uk-container-center">
<div class="category-title-div">
<h2 class="product-category-title"><?php echo $link;?></h2>
</div>
<?php print $topmost;?>
</div>
</div>
</div>
<?php endif;?>



<?php /*HIGHLIGHTED*/ ?>
<?php if($page['highlighted']):?>
<div id="highlighted" class="shop-odd-wrapper">
<div class="shop-odd">
<div class="uk-container uk-container-center">
<?php print render ($page['highlighted'])?>
</div>
</div>
</div>
<?php endif;?>

<?php /*FRONT TAXONOMY BLOCKS*/
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
		$block_id = strtolower(_the_shop_transliterate($root['term_name']));
		$zebra_class = ($index % 2 == true) ? 'shop-odd' : 'shop-even';
		$wrapper_class = "$zebra_class"."-wrapper";
		$view = views_embed_view('content_manipulation', 'block_about', $lang, $tid, $filter);
		if (!empty($view)) {
			$output .= "<a id=\"$block_id\"></a>\n";
			$output .= "<div class=\"$wrapper_class\">\n";
			$output .= "<div id=\"$zebra_class-$index\" class=\"$zebra_class\">\n";
			$output .= '<div class="uk-container uk-container-center">'."\n";
			$output .= "<div class=\"category-title-div\"><h2 class=\"product-category-title\">$title</h2></div>\n";
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
<section id="front-page-footer-wrapper">
<footer id="footer" class="page-footer">
<div class="uk-container uk-container-center">
<div class="uk-grid uk-grid-width-small-1-2 uk-grid-width-medium-1-3 uk-grid-width-large-1-5" data-uk-grid="{gutter: 15, animation: false}">
<?php echo _the_shop_get_footer_blocks('block_follow');?>
<?php echo _the_shop_get_footer_blocks('block_user');?>
<?php echo _the_shop_get_footer_blocks('block_contacts');?>
<?php echo _the_shop_get_footer_blocks('block_store_address');?>
<?php echo _the_shop_get_footer_blocks('block_store_owner');?>
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
<div class="offcanvas-menu-wrapper uk-nav-offcanvas uk-parent-icon">
<?php echo $offcanvas;?>
</div>
<?php endforeach;?>
</div>
</section>

<?php /*CONTACT FORM ORDER*/?>
<?php if($contact_form): ?>
<section id="contact-form" class="uk-modal">
<div class="uk-modal-dialog uk-modal-dialog-large">
<?php print drupal_render($contact_form);?>
</div>
</section>
<?php endif; ?>


<?php /*CONTACT FORM SITE CONTACT*/?>
<?php if($contact_form): ?>
<section id="contact-form-site-contact" class="uk-modal">
<div class="uk-modal-dialog uk-modal-dialog-large">
<a class="uk-modal-close uk-close"></a>
<div class="uk-modal-header">
<?php print $site_name;?>
</div>
<?php print $contact_form['#children'];?>
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

