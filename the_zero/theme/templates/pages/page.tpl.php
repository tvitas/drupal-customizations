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
?>
<a id="0"></a>
<?php /*HAMBURGER AND NAV*/ ?>
<?php if ($content_root['navbar']):?>

<nav id="uk-navbar-front" class="uk-navbar uk-navbar-attached" data-uk-sticky="{classactive: 'uk-navbar-attached', top: -10, animation: 'uk-animation-slide-top'}">

<?php /*nav taxonomy links*/ ?>
<div class="uk-hidden-small uk-hidden-medium uk-width-2-3">
<?php /*nav brand on large scr*/ ?>
<div class="uk-navbar-brand uk-hidden-small uk-hidden-medium uk-margin-left">
<?php if (theme_get_setting('toggle_logo_brand')): ?>
<a href="<?php echo $site_owner_web;?>" title="<?php echo $site_owner_title;?>"><img src="<?php echo $logo;?>" alt="<?php echo $site_owner_title;?>" title="<?php echo $site_owner_title;?>"></a>
<?php endif; ?>
<?php if (theme_get_setting('toggle_site_name_as_home_link')): ?>
<a href="<?php echo $front_page;?>" title="<?php echo htmlentities($site_slogan);?>"><?php echo $site_name;?></a>
<?php else: ?>
<span title="<?php echo htmlentities($site_slogan)?>"><?php echo $site_name;?></span>
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
<?php endif; ?>
<a href="<?php echo $front_page;?>" title="<?php echo $site_name;?>"><?php echo $site_abbreviation;?></a>
</div>


<?php /*nav menu and lang switcher links*/ ?>
<div class="uk-navbar-flip uk-hidden-small uk-hidden-medium uk-width-1-3">
<?php echo $content_root['navbar_menu'];?>
</div>
</nav>
<?php endif;?>

<?php /*HEADER*/ ?>
<header>
<?php /*PAGE FRONT SLIDER*/ ?>
<?php if ($page['front_slider']):?>
<div id="page-slider" class="page-slider-wrapper">
<?php print render($page['front_slider']);?>
</div>
<?php endif;?>
</header>

<?php /*SEARCH FORM*/ ?>
<?php if ($page['search_form'] || $filters_link):?>
<div id="search-form" class="search-form-wrapper uk-margin-bottom">
<div class="uk-container uk-container-center">
<div class="search-form uk-navbar-flip">
<?php print render($page['search_form']);?>
<div class="uk-clearfix"></div>
</div>
</div>
</div>
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

<?php /*MESSAGES*/ ?>
<?php if($messages && (theme_get_setting('dev_mode'))):?>
<div class="uk-container uk-container-center uk-margin-bottom">
<?php print $messages; ?>
</div>
<?php endif;?>


<a id="main-content"></a>
<div id="content" class="uk-container uk-container-center uk-margin-top">
<?php print render($page['help']); ?>

<?php if($show_title && $title): ?>
<h1 class="uk-text-center page-title"><?php print _t($title, $title); ?></h1>
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
<div id="sidebar-first" class="uk-container uk-container-center uk-margin-top">
<?php print render($page['related']); ?>
</div>
<?php endif; ?>
</section>
</div>
</div>

<div class="divider-last"></div>


<?php /*FOOTER*/ ?>
<section id="page-footer-wrapper">
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
<?php if ($display_marquee):?>
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
