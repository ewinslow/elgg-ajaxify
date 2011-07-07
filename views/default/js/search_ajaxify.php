elgg.provide('elgg.ajaxify.search');

elgg.ajaxify.search.init = function() {
	elgg.ajaxify.search.fetch_limit = 10;
	elgg.ajaxify.search.context = elgg.ajaxify.getViewFromURL('all').split('/')[0];
	elgg.ajaxify.search.strip_desc = 40;

	$('#elgg-search-autocomplete').autocomplete({
		minLength: 2,
		html: true,
		max: elgg.ajaxify.search.fetch_limit,
		source: function(req, res) {
			elgg.get('livesearch', {
				cache: false,
				data: {
					'term': req.term,
					'match_on': elgg.ajaxify.search.context,
				},
				dataType: 'json',
				success: function(response) {
					res($.map(response, function(result) {
						return {
							//Todo trigger a handler to return subtype specific label
							label: result.icon+" <a>"+result.name+"</a><br />"+result.desc.substr(0, elgg.ajaxify.search.strip_desc)+"...",
							attributes: result,
						}
					}));
				},
			});
		},
		select: function(event, ui) {
			elgg.trigger_hook('read:submit', 'search', {'type': elgg.ajaxify.search.context}, {
				ui: ui,
			});
			return false;
		},
	});
};

elgg.ajaxify.search.read_submit = function(hook, type, params, value) {
	var forward_url = '';
	var guid = value.ui.item.attributes.guid;
	var name = value.ui.item.attributes.name;
	var desc = value.ui.item.attributes.desc;
	var entity_type = value.ui.item.attributes.type;
	switch (params.type) {
		case 'blog':
		case 'pages':
		case 'file':
		case 'bookmarks':
			forward_url = params.type+'/view/'+guid;
			break;
		case 'thewire':
			forward_url = params.type+'/thread/'+guid;
			break;
		case 'members': 
			forward_url = '/profile/'+desc;
			break;
		case 'groups':
			forward_url = params.type+'/profile/'+guid;
			break;
		case 'all':
			switch (entity_type) {
				case 'user': 
					forward_url = '/profile/'+desc;
					break;
				case 'group':
					forward_url = 'groups/profile/'+guid;
					break;
			}	
			break;
	}
	elgg.forward(elgg.normalize_url(forward_url));
};

elgg.register_hook_handler('read:submit', 'search', elgg.ajaxify.search.read_submit); 
elgg.register_hook_handler('init', 'system', elgg.ajaxify.search.init);
