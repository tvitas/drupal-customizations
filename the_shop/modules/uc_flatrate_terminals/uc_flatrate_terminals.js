/*
Contains
    $("input[id*='DiscountType']").each(function (i, el) {
         //It'll be an array of elements
     });
Starts With
    $("input[id^='DiscountType']").each(function (i, el) {
         //It'll be an array of elements
     });
Ends With
     $("input[id$='DiscountType']").each(function (i, el) {
         //It'll be an array of elements
     });
Elements which id is not a given string
    $("input[id!='DiscountType']").each(function (i, el) {
         //It'll be an array of elements
     });
Elements which id contains a given word, delimited by spaces
     $("input[id~='DiscountType']").each(function (i, el) {
         //It'll be an array of elements
     });
Elements which id is equal to a given string or starting with that string followed by a hyphen
     $("input[id|='DiscountType']").each(function (i, el) {
         //It'll be an array of elements
     });
*/
(function($) {
	Drupal.behaviors.IsCheckedFlatrateTerminal = {attach: function (context, settings) {
			var tlist = [];
			$("#quote :input[type='radio']").each(function(){
				var quote_element_id = $(this).attr('id');
				if (-1 == quote_element_id.indexOf("edit-panes-quotes-quotes-quote-option-flatrate-terminals-")) {
					$(this).on('click', function() {
						for (i in tlist) {
							$(tlist[i]).fadeOut('fast');
							if($.browser.msie){
								$(tlist[i]).css({"visibility":"hidden"});
							}
						}			
					});
				}
				if (-1 !== quote_element_id.indexOf("edit-panes-quotes-quotes-quote-option-flatrate-terminals-")) {
					var splitted = quote_element_id.split('-');
					var sl = splitted.length;
					var quote_id = splitted[sl - 2] + '---' + splitted[sl - 1] + '-list';
					var class_id = '.form-item-panes-quotes-quotes-flatrate-terminals-' + quote_id;

					$(class_id).fadeOut('fast');
					tlist.push(class_id);

					$(this).on('click', function() {
						if ($(this).is(":checked")) {
							$(class_id).fadeIn('slow');
							if($.browser.msie){
								$(tlist[i]).css({"visibility":"visible"});
							}
						}
					});
				}
			});
		}
	}
})(jQuery);
