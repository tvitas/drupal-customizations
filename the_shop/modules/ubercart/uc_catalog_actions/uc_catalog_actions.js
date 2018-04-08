(function($) {
  Drupal.behaviors.SetLevelOneBold = {
    attach: function (context, settings) {
			$('#edit-catalog-value option').each(function(){
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

})(jQuery);
