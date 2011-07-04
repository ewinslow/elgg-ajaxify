elgg.provide('elgg.ajaxify.pagination');

elgg.ajaxify.pagination.init = function() {
	//Get context from the viewname (activity, thewire, blog etc.)
	//(Why?) Activity river stream and entity lists use different DOMs.
	elgg.ajaxify.pagination.context = elgg.ajaxify.getViewFromURL('activity').split('/')[0];

	$('.elgg-pagination li').live('click', function(event) {
		elgg.trigger_hook('read:submit', 'pagination', {'type': elgg.ajaxify.pagination.context}, {
			'item': $(this),
		});
		elgg.trigger_hook('read:success', 'pagination', {'type': elgg.ajaxify.pagination.context}, {
			'item': $(this),
		});
		return false;
	});
};

elgg.ajaxify.pagination.read_submit = function(hook, type, params, value) {
	$('.elgg-pagination').before(elgg.ajaxify.ajaxLoader);
};

elgg.ajaxify.pagination.read_success = function(hook, type, params, value) {
	//Activity river can be filtered using elgg-river-selector, the filter selected has to be preserved when a next page is requested, 
	//sending type, subtype, page_type helps in getting the exact content under the applied filters
	if (params.type === 'activity') {
		elgg.view('river/getactivity', {
			cache: false,
			data: {
				type: $.url().param('type') || 'all',
				subtype: $.url().param('subtype') || '',
				page_type: elgg.ajaxify.getViewFromURL('').split('/')[1] || '',
				offset: $(value.item).find('a').url().param('offset') || '', 
			},
			success: function(response) {
				var newRiver = $(response)[0];
				var newPagination = $(response)[1];
				$('.elgg-river').replaceWith(newRiver);
				$('.elgg-pagination').replaceWith(newPagination);
				$(elgg.ajaxify.ajaxLoader).remove();
				$('body').animate({scrollTop: 0}, 'slow');
			},
		});
	} else {
		elgg.view('entities/getentity', {
			cache: false,
			data: {
				subtype: elgg.ajaxify.pagination.context,
				limit: 15,
				page_type: elgg.ajaxify.getViewFromURL('').split('/')[1] || '',
				pagination: 'TRUE',
				offset: $(value.item).find('a').url().param('offset') || '',
			},
			success: function(response) {
				var newList = $(response)[0];
				var newPagination = $(response)[1];
				$('.elgg-entity-list').replaceWith(newList);
				$('.elgg-pagination').replaceWith(newPagination);
				$(elgg.ajaxify.ajaxLoader).remove();
				$('body').animate({scrollTop: 0}, 'slow');
			},
		});
	}
};

elgg.register_hook_handler('read:submit', 'pagination', elgg.ajaxify.pagination.read_submit); 
elgg.register_hook_handler('read:success', 'pagination', elgg.ajaxify.pagination.read_success); 
elgg.register_hook_handler('init', 'system', elgg.ajaxify.pagination.init);
