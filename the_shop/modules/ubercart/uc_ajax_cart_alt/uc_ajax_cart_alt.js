(function ($) {

Drupal.behaviors.ucAjaxCartAlt = {
  attach: function (context, settings) {
    Drupal.settings.currentlang = Drupal.settings.pathPrefix;
    $links = $(Drupal.settings.ucAjaxCartAlt.linkSelector).not('.uc-ajax-cart-alt-processed').addClass('uc-ajax-cart-alt-processed');
    // Store original link for when cart is empty.
    $links.each(function() {
      $(this).data('uc_ajax_cart_alt_original', $(this).html());
    });

    // We refresh only one time.
    $refresh = $('html').not('.uc-ajax-cart-alt-processed').addClass('uc-ajax-cart-alt-processed');
    element = $refresh[0];
	
    if (element) {
      var element_settings = {
        url: Drupal.settings.basePath + Drupal.settings.pathPrefix + 'uc_ajax_cart_alt/ajax/refresh',
        event: 'ucAjaxCartAltOnLoad',
        progress: {
          type: 'none'
        },
        effect: 'fade',
        speed: 500,
      };
      var base = 'ucAjaxCartAltOnLoad';
      var ajax = new Drupal.ajax(base, element, element_settings);
      Drupal.ajax[base] = ajax;
      $(ajax.element).trigger('ucAjaxCartAltOnLoad');
    }
  }
}

/**
 * Inserts status message when product added to cart successfully.
 *
 * This function can be overriden on the theme if necessary.
 *
 * response.messages: Drupal status messages.
 * response.status_messages: Drupal themed status messages.
 */
Drupal.ajax.prototype.commands.ucAjaxCartAltAddItemSuccess = function(ajax, response, status) {
//  if (!ajax.ucAjaxCartAltMessageElement) {
//    ajax.ucAjaxCartAltMessageElement = $('<div class="uc-ajax-cart-alt-status-messages"></div>');
//    ajax.ucAjaxCartAltMessageElement = $('<div class="uc-ajax-cart-alt-status-messages"></div>');
//    $(ajax.element).before(ajax.ucAjaxCartAltMessageElement);
//  }
//  $(ajax.ucAjaxCartAltMessageElement).html(response.status_messages);
  UIkit.notify('<i class="uk-icon-check"></i>&nbsp;' + response.status_messages, {status:'primary', pos:'top-center'});
};

/**
 * Inserts status message when product add to cart fails with errors.
 *
 * This function can be overriden in the theme if necessary.
 *
 * response.messages: Drupal status messages.
 * response.status_messages: Drupal themed status messages.
 */
Drupal.ajax.prototype.commands.ucAjaxCartAltAddItemError = function(ajax, response, status) {
//  if (!ajax.ucAjaxCartAltMessageElement) {
//    ajax.ucAjaxCartAltMessageElement = $('<div class="uc-ajax-cart-alt-status-messages"></div>');
//    ajax.ucAjaxCartAltMessageElement = $('<div class="uc-ajax-cart-alt-status-messages"></div>');
//    $(ajax.element).before(ajax.ucAjaxCartAltMessageElement);
//  }
  UIkit.notify('<i class="uk-icon-ban"></i>&nbsp;' + response.status_messages, {status:'danger', pos:'top-center'});
//  $(ajax.ucAjaxCartAltMessageElement).html(response.status_messages);
};

/**
 * AJAX command called after cart refresh.
 *
 * This function can be overriden in the theme if necessary.
 */
Drupal.ajax.prototype.commands.ucAjaxCartAltRefresh = function(ajax, response, status) {
  if (response.empty) {
    $(response.selector).each(function() {
      $(this).html($(this).data('uc_ajax_cart_alt_original'));
    });
  }
 
  if (Drupal.settings.ucAjaxCartAlt.removeLink) {
    $('.block-uc-ajax-cart-alt table.cart-block-items td.cart-block-item-price').each(function(index) {
      var newElement = $(this).after(Drupal.theme('uc_ajax_cart_alt_remove', index));
      Drupal.attachBehaviors(newElement[0]);
    });
  }
};

/**
 * AJAX command called after cart view form is refreshed.
 *
 * This function can be overriden in the theme if necessary.
 */
Drupal.ajax.prototype.commands.ucAjaxCartAltViewForm = function(ajax, response, status) {
  // This probably will work just for garland and some themes, not all.
  // You might want to replicate this in your theme and update as necessary.
  // It will depend on how theme('status_messages') is output.
  //$('#messages').remove();
  var msg = '';
  if ($('#uc-cart-view-form-table > div:not([class])').length) {
    msg = '<i class="uk-icon-check"></i>&nbsp;' + $('#uc-cart-view-form-table > div:not([class])').text();
    $('#uc-cart-view-form-table > div:not([class])').remove();
  }
  if ($('.uc-cart-empty > div:not([class])').length) {
    msg = '<i class="uk-icon-check"></i>&nbsp;' + $('.uc-cart-empty > div:not([class])').text();
    $('.uc-cart-empty > div:not([class])').remove();
  }
  UIkit.notify(msg, {status:'primary', pos:'top-center'});
//  if ($("#uc-cart-view-form-table .messages").length) {
//    var newScroll = $("#uc-cart-view-form-table .messages").offset().top - $("#uc-cart-view-form-table .messages").outerHeight();

//    if ($('body').scrollTop() > newScroll) {
//      $('body').animate({
//        scrollTop :newScroll
//      }, 100);
//    }
//  }
};

/**
 * Theme function to output remove product link in the AJAX cart block.
 */
Drupal.theme.prototype.uc_ajax_cart_alt_remove = function(index) {
  return '<a class="use-ajax" href="' + Drupal.settings.basePath + 'uc_ajax_cart_alt/ajax/remove/' + index + '">x</a>';
}

})(jQuery);
