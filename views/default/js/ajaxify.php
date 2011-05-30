elgg.provide('elgg.ajaxify');

elgg.ajaxify.init = function() {
	$('.elgg-menu-item-likes').live('click', function(event) {
		event.preventDefault();
		elgg.ajaxify.likes(this);
	});
	$('#thewire-submit-button').live('click', function(event) {
		event.preventDefault();
		elgg.ajaxify.thewire(this);
	});
	$('.elgg-menu-item-delete').live('click', function(event) {
		event.preventDefault();
		elgg.ajaxify.delete_entity(elgg.ajaxify.getMenuItemGUID(this));
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
	var url = elgg.normalize_url('ajax/view/'+name);
	options.success = function(data) {
		$(options.target).html(data);
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
 * Get GUID of current entity to which the menu item belongs
 *
 * @param {Object} The list item object which is clicked
 * @return {String}
 */

elgg.ajaxify.getMenuItemGUID = function(item) {
	return $(item).closest('li[id|="elgg-object"]').attr('id').match(/[0-9]+/)[0];
};

//Incomplete
elgg.ajaxify.thewire = function(button) {
	elgg.action('thewire/add', {
		data: {
			body: $('#thewire-textarea').val()
		},
		cache: false,
		success: function(response) {
		},
	});
};

elgg.ajaxify.likes = function(item) {
	actionURL = $(item).find('a').attr('href');
	entityGUID = elgg.ajaxify.getMenuItemGUID(item);
	elgg.action(actionURL, {
		success: function() {
			elgg.view('likes/display', {
				data: {
					'guid': entityGUID
				}, 
				target: $(item),
			});
		}
	});
};


elgg.ajaxify.showLoading = function(options) {
	ajaxLoader = elgg.normalize_url('_graphics/ajax_loader.gif');
	oldDOM = $(options.DOM);
	if (elgg.isNullOrUndefined(options.alt_text)) {
		options.alt_text = 'Loading';
	}
	if (elgg.isNullOrUndefined(options.id)) {
		return false;
	}
	$(options.DOM).replaceWith('<img id="'+options.id+'" alt="'+options.alt_text+'" src="'+ajaxLoader+'" width="'+options.width+'" height="'+options.height+'" />');
	return {
		DOM: oldDOM,
		animObj: $('#'+options.id),
	}
};

elgg.ajaxify.removeLoading = function(options) {
	options.animObj.after(options.DOM);
	options.animObj.replaceWith();
};

elgg.ajaxify.bookmarks = function(input) {
	inputURL = $(input).val().trim();
	loadingObj = elgg.ajaxify.showLoading({
		DOM: $('input[name=title]'),
		id: 'loadingTitle',
		width: '25px',
		height: '25px',
	});
	elgg.action('bookmarks/autofill', {
		data: {
			'address': inputURL
		},
		success: function(response) {
			elgg.ajaxify.removeLoading(loadingObj);
			$('input[name=title]').val(response.output.title);
		},
	});
};
	
elgg.register_hook_handler('init', 'system', elgg.ajaxify.init);
