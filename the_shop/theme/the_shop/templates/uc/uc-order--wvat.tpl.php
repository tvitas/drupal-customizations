<?php

/**
 * @file
 * This file is the default customer invoice template for Ubercart.
 *
 * Available variables:
 * - $products: An array of product objects in the order, with the following
 *   members:
 *   - title: The product title.
 *   - model: The product SKU.
 *   - qty: The quantity ordered.
 *   - total_price: The formatted total price for the quantity ordered.
 *   - individual_price: If quantity is more than 1, the formatted product
 *     price of a single item.
 *   - details: Any extra details about the product, such as attributes.
 * - $line_items: An array of line item arrays attached to the order, each with
 *   the following keys:
 *   - line_item_id: The type of line item (subtotal, shipping, etc.).
 *   - title: The line item display title.
 *   - formatted_amount: The formatted amount of the line item.
 * - $shippable: TRUE if the order is shippable.
 *
 * Tokens: All site, store and order tokens are also available as
 * variables, such as $site_logo, $store_name and $order_first_name.
 *
 * Display options:
 * - $op: 'view', 'print', 'checkout-mail' or 'admin-mail', depending on
 *   which variant of the invoice is being rendered.
 * - $business_header: TRUE if the invoice header should be displayed.
 * - $shipping_method: TRUE if shipping information should be displayed.
 * - $help_text: TRUE if the store help message should be displayed.
 * - $email_text: TRUE if the "do not reply to this email" message should
 *   be displayed.
 * - $store_footer: TRUE if the store URL should be displayed.
 * - $thank_you_message: TRUE if the 'thank you for your order' message
 *   should be displayed.
 *
 * @see template_preprocess_uc_order()
 */
?>
<div class="uk-overflow-container">
<h3><?php print _t('_order_', 'Užsakymas');?> <?php print $_order['order_id']?><small>, <?php print $_invoice['date'];?></small></h3>
<div>
<?php print $_order['order_summary'];?>
</div>
<table cellspacing="0" cellpadding="5" width="100%" style="white-space: nowrap;">
<tr>
<td><h4><?php print _t('_the_seller_', 'Pardavėjas');?></h4><?php print $_order['the_seller'];?></td>
<td><h4><?php print _t('_the_buyer_', 'Pirkėjas');?></h4><?php print $_order['the_buyer'];?></td>
</tr>
</table>
<div>
<?php print $_order['table'];?>
</div>
<div>
<?php if (isset($_order['order_comments'][0])) print nl2br($_order['order_comments'][0] -> message);?>
</div>
<div>
<p><?php print $_order['order_message']?></p>
</div>
<div>
<p><?php print $_order['order_contacts']?></p>
</div>
</div>

<div style="min-height: 50px; page-break-before: always;"></div>

<div class="uk-overflow-container">
<h3><?php print _t('_prepaid_invoice_', 'Išankstinio mokėjimo sąskaita');?><small>, <?php print $_invoice['date'];?>, <?php print _t('_order_', 'Užsakymas');?> <?php print $_invoice['order_id'];?></small></h3>
<table cellspacing="0" cellpadding="5" width="100%" style="white-space: nowrap;">
<tr>
<td><h4><?php print _t('_the_seller_', 'Pardavėjas');?></h4><?php print $_invoice['the_seller'];?></td>
<td><h4><?php print _t('_the_buyer_', 'Pirkėjas');?></h4><?php print $_invoice['the_buyer'];?></td>
</tr>
</table>
<div>
<?php print $_invoice['table'];?>
</div>
<div>
<?php print $_invoice['order_summary'];?>
</div>
</div>
<?php if ($op == 'print'):?>
<p><?php print _t('_invoice_created_by_', 'Sąskaitą išrašė');?>:&nbsp;<input type="text" id="edit-prepaid-invoice-created-by" name="edit-prepaid-invoice-created-by" value="<?php echo variable_get('uc_invoice_creator_name', FALSE);?>"></p>
<?php endif;?>


<?php if (!empty($_invoice['products_summary'])):?>
<div style="min-height: 180px; page-break-before: always;"></div>
<div class="uk-overflow-container">
<?php if ($op == 'print'):?>
<h6><?php print _t('_invoice_date_', 'Data');?>:&nbsp;<input type="text" id="edit-invoice-date" name="edit-invoice-date" value="<?php echo date('Y-m-d');?>"></h6>
<?php endif;?>
<table cellspacing="0" cellpadding="5" width="100%" style="white-space: nowrap;">
<tr>
<td>
	<h5><?php print _t('_the_seller_', 'Pardavėjas');?></h5><?php print $_invoice['the_seller'];?>
</td>
<td>
	<h5><?php print _t('_the_buyer_', 'Pirkėjas');?></h5><?php print $_invoice['the_buyer'];?>
</td>
</tr>
</table>
<div>
<?php print $_invoice['table'];?>
</div>
<h5><?php print _t('_products_totals_', t('Products totals'));?></h5>
<div>
<?php print $_invoice['products_summary'];?>
</div>

<h5><?php print _t('_shipping_totals_', t('Shippping totals'));?></h5>
<div>
<?php print $_invoice['shipping_summary'];?>
</div>

<!--<h5><?php print _t('_order_summary_', t('Order summary'));?></h5>-->
<div>
<?php print $_invoice['order_summary'];?>
</div>
</div>
<?php if ($op == 'print'):?>
<p><?php print _t('_invoice_created_by_', 'Sąskaitą išrašė');?>:&nbsp;<input type="text" id="edit-invoice-created-by" name="edit-invoice-created-by" value="<?php echo variable_get('uc_invoice_creator_name', FALSE);?>"></p>
<?php endif;?>
<?php endif;?>
