(function($) {
  Drupal.behaviors.SetTaxonomyString = {
    attach: function (context, settings) {
			$('#edit-field-category-und', context).click(function(){
				var categories = [];
				$('#edit-field-category-und option:selected').each(function(){
					categories.push($(this).text().replace(/-/g,''));
				});
				$('#field-current-category').html(categories.join('&nbsp;&middot;&nbsp;'));
			});
			$('#edit-field-menu-tree-und', context).click(function(){
				var menu_options = [];
				$('#edit-field-menu-tree-und option:selected').each(function(){
					menu_options.push($(this).text().replace(/-/g,''));
				});
				$('#field-current-menu-tree').html(menu_options.join('&nbsp;&middot;&nbsp;'));
			});
		}
    };

/*
  Drupal.behaviors.SetLevelOneBold = {
    attach: function (context, settings) {
			$('#edit-field-category-und option').each(function(){
				var dash_count = ($(this).text().split('-').length - 1);
				switch (dash_count) {
					case 0:
						$(this).css('font-weight', 'bold');
						$(this).css('color', 'blue');
						break;
					case 1:
						$(this).css('color', 'blue');
						break;
					case 2:
						$(this).css('color', 'green');
						break;
				}
			});
		}
    };
*/
})(jQuery);
