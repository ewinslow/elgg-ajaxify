elgg.provide('elgg.ajaxify');

elgg.ajaxify.init = function() {
	
	$('.elgg-menu-item-likes').live('click', function(event) {
		event.preventDefault();
		elgg.ajaxify.likes(this);
	});
		
}

/**
 * Fetch a view via AJAX
 *
 * @example Usage:
 * Use it to fetch a view using /ajax/view
 * can also be used to refresh a view
 * elgg.view('likes/display', {data: {guid: GUID}, target: targetDOM})
 * @param {string} name Viewname
 * @param {Object} options Parameters to the view along with jQuery options {@see jQuery#ajax}
 * @return {void}
 */
elgg.view = function(name, options) {
	elgg.assertTypeOf('string', name);
	var url = elgg.normalize_url('ajax/view/'+name);
	options.success = function(data) {
		$(options.target).html(data);
	}
	elgg.get(url, options);
}

elgg.ajaxify.likes = function(item) {
	actionURL = $(item).find('a').attr('href');
	entityGUID = $(item).closest('li[id|="elgg-object"]').attr('id').match(/[0-9]+/)[0];
	elgg.action(actionURL);
	elgg.view('likes/display', {
			data: {guid: entityGUID}, 
			target: $(item),
			cache: false 
	});
}

elgg.register_hook_handler('init', 'system', elgg.ajaxify.init);
