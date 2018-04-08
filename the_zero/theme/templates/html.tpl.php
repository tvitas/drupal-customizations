<?php

/**
 * @file
 * Default theme implementation to display the basic html structure of a single
 * Drupal page.
 *
 * Variables:
 * - $css: An array of CSS files for the current page.
 * - $language: (object) The language the site is being displayed in.
 *   $language->language contains its textual representation.
 *   $language->dir contains the language direction. It will either be 'ltr' or 'rtl'.
 * - $rdf_namespaces: All the RDF namespace prefixes used in the HTML document.
 * - $grddl_profile: A GRDDL profile allowing agents to extract the RDF data.
 * - $head_title: A modified version of the page title, for use in the TITLE
 *   tag.
 * - $head_title_array: (array) An associative array containing the string parts
 *   that were used to generate the $head_title variable, already prepared to be
 *   output as TITLE tag. The key/value pairs may contain one or more of the
 *   following, depending on conditions:
 *   - title: The title of the current page, if any.
 *   - name: The name of the site.
 *   - slogan: The slogan of the site, if any, and if there is no title.
 * - $head: Markup for the HEAD section (including meta tags, keyword tags, and
 *   so on).
 * - $styles: Style tags necessary to import all CSS files for the page.
 * - $scripts: Script tags necessary to load the JavaScript files and settings
 *   for the page.
 * - $page_top: Initial markup from any modules that have altered the
 *   page. This variable should always be output first, before all other dynamic
 *   content.
 * - $page: The rendered page content.
 * - $page_bottom: Final closing markup from any modules that have altered the
 *   page. This variable should always be output last, after all other dynamic
 *   content.
 * - $classes String of classes that can be used to style contextually through
 *   CSS.
 *
 * @see template_preprocess()
 * @see template_preprocess_html()
 * @see template_process()
 *
 * @ingroup themeable
 */
?>
<!DOCTYPE html>
<html lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>">
<head>
  <?php print $head; ?>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="telephone=no">
  <meta name="theme-color" content="#ffffff">
  <title><?php print $head_title;?></title>
  <link rel="shortcut icon" href="http://web.lsmuni.lt/bnni/sites/bnni.lsmuni.lt/themes/the_zero/icons/favicon.ico" type="image/vnd.microsoft.icon" />
  <link rel="apple-touch-icon" sizes="76x76" href="http://web.lsmuni.lt/bnni/sites/bnni.lsmuni.lt/themes/the_zero/icons/apple-touch-icon.png">
  <link rel="icon" type="image/png" href="http://web.lsmuni.lt/bnni/sites/bnni.lsmuni.lt/themes/the_zero/icons/favicon-32x32.png" sizes="32x32">
  <link rel="icon" type="image/png" href="http://web.lsmuni.lt/bnni/sites/bnni.lsmuni.lt/themes/the_zero/icons/favicon-16x16.png" sizes="16x16">
  <link rel="manifest" href="http://web.lsmuni.lt/bnni/sites/bnni.lsmuni.lt/themes/the_zero/icons/manifest.json">
  <link rel="mask-icon" href="http://web.lsmuni.lt/bnni/sites/bnni.lsmuni.lt/themes/the_zero/icons/safari-pinned-tab.svg" color="#5bbad5">
  <?php print $styles; ?>
  <?php print $scripts; ?>
  <script>
    var $buoop = {c:2};
    function $buo_f(){
      var e = document.createElement("script");
      e.src = "//browser-update.org/update.min.js";
      document.body.appendChild(e);
    };
    try {document.addEventListener("DOMContentLoaded", $buo_f,false)}
    catch(e){window.attachEvent("onload", $buo_f)}
  </script>
</head>
<body onunload="">
  <div id="skip-link">
    <a href="#main-content" class="element-invisible element-focusable"><?php print t('Skip to main content'); ?></a>
  </div>
  <?php print $page_top; ?>
  <?php print $page; ?>
  <?php print $page_bottom; ?>
</body>
</html>
