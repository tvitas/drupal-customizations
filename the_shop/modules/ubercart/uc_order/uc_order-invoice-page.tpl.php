<?php

/**
 * @file
 * Default theme implementation to display a printable Ubercart invoice.
 *
 * @see template_preprocess_uc_order_invoice_page()
 */
?>
<!DOCTYPE html>
<html xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">

<head>
  <?php print $head; ?>
  <title><?php print $head_title; ?></title>
  <style type="text/css">
    .buttons {
      text-align: right;
      margin: 0 1em 1em 0;
    }
	ul, ol {
		list-type-style: none;
	}
  </style>
  <style type="text/css" media="print">
    .buttons {
      display: none;
    }
  </style>
</head>
<body>
  <div class="buttons">
    <input type="button" value="<?php print t('Print invoice'); ?>" onclick="window.print();" />
  </div>

  <?php print $content; ?>
</body>
</html>
