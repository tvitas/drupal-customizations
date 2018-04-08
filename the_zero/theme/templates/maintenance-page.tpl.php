<?php

/**
 * @file
 * Default theme implementation to display a single Drupal page while offline.
 *
 * All the available variables are mirrored in html.tpl.php and page.tpl.php.
 * Some may be blank but they are provided for consistency.
 *
 * @see template_preprocess()
 * @see template_preprocess_maintenance_page()
 *
 * @ingroup themeable
 */
?>
<!DOCTYPE html>
<html lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php print $head_title; ?></title>
<style>
@font-face {
    font-family: 'dosis_bold';
    src: url('sites/knygos.lsmuni.lt/themes/the_shop/fonts/Dosis/dosis-extrabold-webfont.eot');
    src: url('sites/knygos.lsmuni.lt/themes/the_shop/fonts/Dosis/dosis-extrabold-webfont.eot?#iefix') format('embedded-opentype'),
         url('sites/knygos.lsmuni.lt/themes/the_shop/fonts/Dosis/dosis-extrabold-webfont.woff2') format('woff2'),
         url('sites/knygos.lsmuni.lt/themes/the_shop/fonts/Dosis/dosis-extrabold-webfont.woff') format('woff'),
         url('sites/knygos.lsmuni.lt/themes/the_shop/fonts/Dosis/dosis-extrabold-webfont.svg#dosisextrabold') format('svg');
    font-weight: bold;
    font-style: normal;

}

@font-face {
    font-family: 'dosis_light';
    src: url('sites/knygos.lsmuni.lt/themes/the_shop/fonts/Dosis/dosis-light-webfont.eot');
    src: url('sites/knygos.lsmuni.lt/themes/the_shop/fonts/Dosis/dosis-light-webfont.eot?#iefix') format('embedded-opentype'),
         url('sites/knygos.lsmuni.lt/themes/the_shop/fonts/Dosis/dosis-light-webfont.woff2') format('woff2'),
         url('sites/knygos.lsmuni.lt/themes/the_shop/fonts/Dosis/dosis-light-webfont.woff') format('woff'),
         url('sites/knygos.lsmuni.lt/themes/the_shop/fonts/Dosis/dosis-light-webfont.svg#dosislight') format('svg');
    font-weight: normal;
    font-style: normal;

}


@font-face {
    font-family: 'dosis';
    src: url('sites/knygos.lsmuni.lt/themes/the_shop/fonts/Dosis/dosis-regular-webfont.eot');
    src: url('sites/knygos.lsmuni.lt/themes/the_shop/fonts/Dosis/dosis-regular-webfont.eot?#iefix') format('embedded-opentype'),
         url('sites/knygos.lsmuni.lt/themes/the_shop/fonts/Dosis/dosis-regular-webfont.woff2') format('woff2'),
         url('sites/knygos.lsmuni.lt/themes/the_shop/fonts/Dosis/dosis-regular-webfont.woff') format('woff'),
         url('sites/knygos.lsmuni.lt/themes/the_shop/fonts/Dosis/dosis-regular-webfont.svg#dosisregular') format('svg');
    font-weight: normal;
    font-style: normal;

}

html {
	height: 100%;
    background: url('sites/knygos.lsmuni.lt/themes/the_shop/img/0.jpg') no-repeat center center scroll;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    background-size: cover;
    -o-background-size: cover;
}


body {
	height: 100%;
	font-family: 'dosis', sans-serif;
	font-size: 18px;
	color: #eee;
	margin: 0;
}


.header {
    display: table;
    position: relative;
    width: 100%;
    height: 100%;
}

.text-vertical-center {
    display: table-cell;
    text-align: center;
    vertical-align: middle;
	text-shadow: 1px 1px 5px #000;
    background: rgba(0,0,0,0.5);
}

.small {
	width: 30%;
}
</style>
</head>
<body class="<?php print $classes; ?>">
<header class="header">
<div class="text-vertical-center">
<h1><?php print $site_name;?></h1>
<h2>
<?php print _t('_maintenance_msg_', 'The site is under maintenance. Please visit us later.');?>
</h2>
</div>
</header>
</body>
</html>
