<div>
<article class="article-wrapper">
<div class="product-wrapper uk-text-center">
<div class="img-box">
<figure class="uk-container-center">
<?php if ($on_sale['is']):?>
<span class="figure-on-sale uk-vertical-align">
<span class="text-on-sale uk-vertical-align-middle"><?php print $on_sale['percent'];?></span>
</span>
<?php endif;?>
<?php if (count($content['field_image']) > 0):?>
<?php if (isset($content['field_image'][0]) &&  ($content['field_image'][0] !== NULL)):?>
<?php print render($content['field_image'][0]);?>
<?php else:?>
<div class="cover-box">
<h5><?php print $node_title;?></h5>
</div>
<?php endif;?>
<?php endif;?>
</figure>
</div>
<div class="grey-box">
<div class="product-info-wrapper">
<h6>&nbsp;</h6>
<h5><a href="<?php print $node_url; ?>"><?php print $node_title;?></h5></a>
<h6><?php print _t('_other_products_', t('Other products'));?></h6>
<?php print render($content['display_price']);?>
<?php print render($content['field_old_price']);?>
<?php if ($on_sale['is']):?>
<span class="on-sale-saving"><?php print $on_sale['value'];?></span>
<?php endif;?>
<div><?php print $stock_level;?></div>
</div>

<div class="shop-add-to-cart-form-wrapper">
<?php if($content['sr_value'] !== 'WR'): ?>
<?php print render($content['add_to_cart']);?>
<?php else: ?>
<div class="add-to-cart">
<div class="form-action form-wrapper">
<a id="call-contact-form-<?php echo $node->nid;?>" href="#contact-form" class="uk-button uk-button-primary uk-button-large" data-uk-modal="{center:true}" data-form-subject="<?php echo $content['full_product_title'] . ' ' . strtolower(_t('_order_', t('Order')));?>"><i class="fa fa-check-square-o fa-lg" aria-hidden="true"></i>&nbsp;<?php print _t('_order_product_', t('Order product'));?></a>
</div>
</div>
<?php endif; ?>
</div>
</div>

</div>
</article>
</div>
