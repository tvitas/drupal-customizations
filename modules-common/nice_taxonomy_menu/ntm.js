function changeClass(checkId, thisElement) {
	if (jQuery(checkId).is(':visible')) {
		jQuery(checkId).hide('fast');
		jQuery(thisElement).removeClass('expandend');
	} else {
		jQuery(checkId).show('fast');
		jQuery(thisElement).addClass('expandend');
	}
}



