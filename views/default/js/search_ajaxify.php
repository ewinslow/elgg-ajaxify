elgg.provide('elgg.ajaxify.search');

elgg.ajaxify.search.init = function() {
	elgg.ajaxify.search.fetch_limit = 10;
	elgg.ajaxify.search.context = elgg.ajaxify.getViewFromURL('all').split('/')[0];

//Incomplete
	$('#elgg-search-autocomplete').autocomplete({
		source: function(req, res) {
			elgg.get('livesearch', {
				cache: false,
				data: {
					'q': req.term,
					'match_on': elgg.ajaxify.search.context,
					'limit': elgg.ajaxify.search.fetch_limit,
				},
				dataType: 'json',
				success: function(response) {
					res($.map(response, function(result) {
						return {
							label: result.icon+" "+result.desc,
						}
					}));
				},
			});
		},
		minLength: 2,
		html: true,
	});
}

elgg.register_hook_handler('init', 'system', elgg.ajaxify.search.init);
