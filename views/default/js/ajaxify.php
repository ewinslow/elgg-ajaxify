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
 * elgg.view('
 * @param {string} name Viewname
 * @param {Object} vars Parameters to pass to the view
 * @param {Object} options {@see jQuery#ajax}
 * @return {XMLHttpRequest}
 */
elgg.view = function(name, vars, options) {
	elgg.assertTypeOf('string', name);
	var url = elgg.normalize_url('ajax/view/'+name+'?');
	for (key in vars) {
		url = url.concat(key+'='+vars[key]+'&');
	}
	//remove the extra &
	url = url.substring(0, url.length - 1);
	return elgg.post(url, options);
}

elgg.ajaxify.likes = function(object) {
	actionURL = $(object).find('a').attr('href');
	guid = $(object).parents('li[id|="elgg-object"]').attr('id').match(/[0-9]+/);
	elgg.action(actionURL);
	elgg.view('likes/display', {guid: guid}, {cache: false, success: function(data) {
			$(object).html(data);
		}
	});

}

elgg.register_hook_handler('init', 'system', elgg.ajaxify.init);
