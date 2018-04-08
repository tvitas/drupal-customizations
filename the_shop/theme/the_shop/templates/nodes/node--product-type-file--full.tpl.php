<article class="grid-item">
<div class="uk-grid uk-grid-width-small-1-2 uk-grid-width-medium-1-2 uk-grid-width-large-1-2">
<div>
<div class="img-box-full uk-text-center uk-margin-bottom">
<div class="uk-slidenav-position" data-uk-slideshow="{autoplay:true,autoplayInterval:3000}">
<ul class="uk-slideshow">
<?php $counter = 0;?>
<?php foreach($content['field_image'] as $val):?>
<?php if(isset($content['field_image'][$counter])):?>
<?php $image_href = file_create_url($content['field_image'][$counter]['#item']['uri']);?>
<li>
<figure class="border-grey onsale-wrapper">
<a href="<?php echo $image_href?>" data-uk-lightbox="{group:'grp'}" title="<?php echo $node_title;?>">
<?php print render ($content['field_image'][$counter]);?>
</a>
</figure>
</li>
<?php endif;?>
<?php $counter ++;?>
<?php endforeach;?>
</ul>
<a href="#" class="uk-slidenav uk-slidenav-previous" data-uk-slideshow-item="previous"></a>
<a href="#" class="uk-slidenav uk-slidenav-next" data-uk-slideshow-item="next"></a>
</div>
</div>
</div>

<div>
<div class="product-box-full">
<h4><?php print isset($content['field_author']['#items'][0]['value']) ? $content['field_author']['#items'][0]['value'] : '';?></h4>
<h3><strong><?php print $node_title;?></strong></h3>
<?php if ($on_sale['is']):?>
<div class="on-sale-wrapper">
<span class="figure-on-sale uk-vertical-align">
<span class="text-on-sale uk-vertical-align-middle"><?php print $on_sale['percent'];?></span>
</span>
</div>
<?php endif;?>
<?php print render($content['display_price']);?>
<?php print render($content['field_old_price']);?>
<?php if ($on_sale['is']):?>
<span class="on-sale-saving"><?php print $on_sale['value'];?></span>
<?php endif;?>
<div class="in-stock">
<span class="stock-level"><?php print $stock_level; ?></span><br />
</div>
<div id="add-to-cart-button" class="uk-margin-bottom">
<?php print render($content['add_to_cart']);?>
</div>
<div class="clearfix"></div>
<ul class="uk-tab" data-uk-tab="{connect:'#tab-content'}">
<li><a href="#"><?php echo _t('_product_specs_', 'Specifikacija')?></a></li>
<li><a href="#"><?php echo _t('_product_description_', 'Aprašymas')?></a></li>
</ul>
<div id="tab-content" class="uk-switcher uk-margin">
<div>
<p>
<?php print render($content['model']);?>
<?php print render($content['field_author']);?>
<?php print render($content['field_isbn']);?>
<?php print render($content['field_publishing_house']);?>
<?php print render($content['field_published']);?>
<?php print render($content['field_book_language']);?>
<?php print render($content['field_pages']);?>
<?php print render($content['field_specifications']);?>
<?php print render($content['weight']);?>
<?php print render($content['dimensions']);?>
<?php print render($content['field_file']);?>
</p>

<?php print render($content['field_file']);?>

<h4><?php echo _t('_category_', 'Prekių grupė');?></h4>
<?php echo $tags;?>

<h4><?php echo $share_social_title;?></h4>
<?php echo $share_social;?>
</div>



<div>
<?php print render($content['body']);?>
</div>

</div>

</div>
</div>
</div>
</article>
