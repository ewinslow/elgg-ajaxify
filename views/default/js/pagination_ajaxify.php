elgg.provide('elgg.ajaxify.pagination');

elgg.ajaxify.pagination.init = function() {
	//Get context from the viewname (activity, thewire, blog etc.)
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
	if (params.type === 'activity') {
		$('.elgg-pagination').before(elgg.ajaxify.ajaxLoader);
	}
};

elgg.ajaxify.pagination.read_success = function(hook, type, params, value) {
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
				
			},
		});
	}
};

elgg.register_hook_handler('read:submit', 'pagination', elgg.ajaxify.pagination.read_submit); 
elgg.register_hook_handler('read:success', 'pagination', elgg.ajaxify.pagination.read_success); 
elgg.register_hook_handler('init', 'system', elgg.ajaxify.pagination.init);
