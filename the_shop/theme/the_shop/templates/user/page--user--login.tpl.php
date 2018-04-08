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

<header id="page-header" class="page-header top-40 uk-container uk-container-center">
<div class="uk-grid uk-grid-width-small-1-1 uk-grid-width-medium-1-3 uk-grid-width-large-1-3">

<div class="top-40">
<?php if($site_name):?>
<?php if (!empty($logo)): ?>
<span class="logo"><img src="<?php echo $logo; ?>"></span>
<?php endif; ?>
<h2><strong><?php print l($site_name, $front_page);?></strong></h2>
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
<?php print render($page['search_form']);?>
<div class="uk-clearfix"></div>
</div>
</div>
</section>
<?php endif;?>


<?php /*CONTENT START*/ ?>
<div class="page-wrapper">
<div class="page">

<?php /*BREADCRUMB*/?>
<?php if(isset($breadcrumb)):?>
<div class="uk-container uk-container-center">
<div class="breadcrumb-wrapper">
<div class="breadcrumb">
<?php print $breadcrumb;?>
</div>
</div>
</div>
<?php endif;?>

<section>
<h1 class="section-heading-invisible"><?php print $site_name?></h1>

<?php /*MESSAGES*/ ?>
<?php if($messages && (theme_get_setting('dev_mode'))):?>
<div class="uk-container uk-container-center uk-margin-bottom">
<?php print $messages; ?>
</div>
<?php endif;?>

<?php if ($page['highlighted']): ?>
<div id="highlighted" class="uk-container uk-container-center uk-margin-top">
<?php print render($page['highlighted']); ?>
</div>
<?php endif; ?>

<a id="main-content"></a>
<div id="content" class="uk-container uk-container-center uk-margin-top">
<?php print render($page['help']); ?>

<?php /*CHILD TERMS DROPDOWN*/ ?>
<?php if ($content_root['child_terms_dropdown']): ?>
<div id="child-terms-dropdown">
<?php echo $content_root['child_terms_dropdown']?>
</div>
<?php endif;?>

<?php /*TITLE*/ ?>
<?php if($show_title && $title): ?>
<div id="page-title">
<h2 class="uk-text-center">
<?php print _t($title, $title); ?>
</h2>
</div>
<?php endif; ?>


<?php if ($is_admin && $tabs): ?>
<div class="tabs">
<?php print render($tabs); ?>
</div>
<?php endif; ?>


<?php /*PAGE CONTENT*/?>
<?php if ($action_links): ?>
<ul class="action-links">
<?php print render($action_links); ?>
</ul>
<?php endif; ?>
<?php print render($page['content']); ?>
</div>

<?php if ($page['related']): ?>
<div id="content-related" class="uk-container uk-container-center uk-margin-top">
<?php print render($page['related']); ?>
</div>
<?php endif; ?>
</section>
</div>
</div>


<?php /*FOOTER*/ ?>
<section id="page-footer-wrapper">
<footer id="footer" class="page-footer">
<div class="uk-container uk-container-center">
<div class="uk-grid uk-grid-width-small-1-2 uk-grid-width-medium-1-3 uk-grid-width-large-1-5" data-uk-grid="{gutter: 5, animation: false}">
<?php echo _the_shop_get_footer_blocks('block_follow');?>
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
<div class="off">
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
