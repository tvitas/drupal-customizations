(function($) {
    Drupal.behaviors.CopyFieldValue = {
    attach: function (context, settings) {
      // Repeat this for all fields as needed
      $('#edit-field-isbn-und-0-value', context).on('blur', function () {
        // above you can use change instead of blur if element is not changed by another js
        if (!$('#edit-model').val() || 0 === $('#edit-model').val().length) {
          $('#edit-model').val($('#edit-field-isbn-und-0-value').val());
        }
      });
      // end of "repeat this"
    }
  };

  Drupal.behaviors.SetTaxonomyString = {
    attach: function (context, settings) {
			$('#edit-field-category-und', context).click(function(){
				var categories = [];
				$('#edit-field-category-und option:selected').each(function(){
					categories.push($(this).text().replace(/-/g,''));
				});
				$('#field-current-category').html(categories.join('&nbsp;&middot;&nbsp;'));
			});

		}
    };

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

})(jQuery);
