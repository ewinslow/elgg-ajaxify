elgg.provide('elgg.ajaxify');

elgg.ajaxify.init = function() {
	elgg.ajaxify.ajaxLoader = $('<div class=elgg-ajax-loader></div>');
	$('.elgg-menu-item-likes').live('click', function(event) {
		elgg.ajaxify.likes.action(this);
		event.preventDefault();
	});
	$('#thewire-submit-button').live('click', function(event) {
		elgg.ajaxify.thewire.add(this);
		event.preventDefault();
	});
	$('.elgg-menu-item-reply').toggle(function() {
		elgg.ajaxify.thewire.reply(this);
		$(this).find('a').html('Close');
	}, function() {
		$(this).find('a').html('Reply');
		$(this).closest('.elgg-list-item').find('div[id^=elgg-reply-div]').slideUp('fast');
	});
	$('.elgg-menu-item-delete').live('click', function(event) {
		elgg.ajaxify.delete_entity(elgg.ajaxify.getGUIDFromMenuItem(this));
		event.preventDefault();
	});
	$('input[name=address]').live('blur', function(event) {
		elgg.ajaxify.bookmarks(this);
	});
};

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
	if (new RegExp("^(https?://)", "i").test(name)) {
		name = name.split(elgg.config.wwwroot)[1];
	}
	var url = elgg.normalize_url('ajax/view/'+name);
	if (elgg.isNullOrUndefined(options.success)) {
		options.manipulationMethod = options.manipulationMethod || 'html';
		options.success = function(data) {
			$(options.target)[options.manipulationMethod](data);
		}
	}
	elgg.get(url, options);
};

/**
 * Delete an entity
 *
 * @param guid The guid of the entity we want to delete
 * @return {XMLHttpRequest}
 */

elgg.ajaxify.delete_entity = function(guid) {
	guid = parseInt(guid);
	if (guid < 1) {
		return false;
	}
	$('#elgg-object-'+guid).slideUp();
	return elgg.action('entity/delete', {guid: guid});
};

/**
 * Get URL from ElggMenuItem 
 *
 * @param item {Object} List item 
 * @return URL {String}
 */

elgg.ajaxify.getURLFromMenuItem = function(item) {
	var actionURL = $(item).find('a').attr('href');
	return actionURL;
};

/**
 * Parse guid from ElggMenuItem 
 *
 * @param item {Object} List item 
 * @return guid {String}
 */

elgg.ajaxify.getGUIDFromMenuItem = function(item) {
	return elgg.ajaxify.getURLFromMenuItem(item).match(/guid=(\d+)/)[1];
};

elgg.register_hook_handler('init', 'system', elgg.ajaxify.init);
