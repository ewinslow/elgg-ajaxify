define(function(require) {
	var $ = require('jquery');
	var elgg = require('elgg');
	var i18n = require('elgg/i18n');
	
	/**
	 * Check if two urls have the same scheme, host, and port.
	 * 
	 * @param {Location} url1
	 * @param {Location} url2
	 * @return {boolean}
	 */
	function isSameOrigin(url1, url2) {
		return url1.host == url2.host &&
               url1.protocol == url2.protocol;
	}
	
	/**
	 * If the user is holding any keys down that indicates "load in a new page", we don't want to ajaxify.
	 * 
	 * @param {jQuery.Event} event
	 * @return {boolean}
	 */
	function isEventAjaxable(event) {
		return !event.metaKey && !event.ctrlKey;
	}

	/**
	 * It's only possible to ajaxify urls that are from this Elgg site.
	 * 
	 * @param {string} url
	 * @return {boolean}
	 */
	function isUrlAjaxable(url) {
		return url && url.indexOf(elgg.config.wwwroot) === 0;
	}
	
	/**
	 * Whether the URL represents an Elgg action.
	 * 
	 * @param {string} url
	 * @return {boolean}
	 */
	function isUrlAction(url) {
		return url.indexOf('/action/') !== -1;
	}
	
	/**
	 * Get the name of the action from the given url.
	 * 
	 * @example
	 * getActionFromUrl('http://example.org/action/do/something'); // returns 'do/something'
	 * 
	 * @warning This has undefined behavior if the url is not a valid action url.
	 * @see isUrlAction
	 * 
	 * @param {string} url
	 * @return {string}
	 */
	function getActionFromUrl(url) {
		// Ignore any query string
		url = url.split('?')[0];
		
		// Get only the path after /action/
		return url.substr(url.indexOf('/action/') + '/action/'.length);
	}
	
	/**
	 * If an action has been registered as ajaxable, send it to the server. Fires a bunch of hooks that
	 * other plugins can listen for to update the UI, for example.
	 */
	function maybeSendAjaxAction(action, data, event) {
		// Only ajaxify supported actions
		var actions = elgg.trigger_hook('ajaxify', 'actions', event, {});
		if (actions[action]) {
			
			// TODO: elgg.action could probably just fire all of these hooks automagically?
			elgg.action(action, {
				data: data,
				beforeSend: function() { elgg.trigger_hook('action:before',   action, { data: data }); },
				success:    function() { elgg.trigger_hook('action:success',  action, { data: data }); },
				error:      function() { elgg.trigger_hook('action:error',    action, { data: data }); },
				complete:   function() { elgg.trigger_hook('action:complete', action, { data: data }); }
			});

			return false;
		}		
	}
	
	elgg.register_hook_handler('ajaxify', 'actions', function(hook, type, event, actions) {
		return $.extend(actions, {
			'admin/menu/save': true,
			'admin/site/update_basic': true,
			'admin/site/update_advanced': true,
			'developers/settings': true,
			'plugins/settings/save': true,
			'useradd': true
		});
	});

	elgg.register_hook_handler('action:success', 'useradd', function(hook, type, vars) {
		$('.elgg-form-useradd').resetForm();
	});

	$('a[href]').live('click', function(event) {
		if (isEventAjaxable(event) && isUrlAjaxable(event.target.href)) {
			if (isUrlAction(event.target.href)) {
				var action = getActionFromUrl(event.target.href);
				var data = event.target.search.substr(1); // Strip off initial '?'
				return maybeSendAjaxAction(action, data, event);
			} else {
				return elgg.trigger_hook('navigate', 'window', event, event.target);
			}
		}
	});
	
	$('form[method=POST][action]').live('submit', function(event) {
		// Get the name of the action in a url
		var action = getActionFromUrl(this.action);
		
		// TODO: Convert data to json instead of serialized query string.
		var data = $(this).formSerialize();
		
		return maybeSendAjaxAction(action, data, event);
	});
	
	elgg.register_hook_handler('navigate', 'window', function(hook, type, event, url) {
		var views = [
			'admin/statistics/server',
			'admin/statistics/overview',
			'admin/settings/basic',
			'admin/settings/advanced',
			'admin/appearance/menu_items',
			'admin/appearance/profile_fields',
			'admin/appearance/customcss',
			'admin/appearance/customlogo',
			'admin/users/add',
			'admin/develop_tools/unit_tests',
			'admin/develop_tools/preview',
			'admin/developers/settings'
		];

		var supported = false;
		
		$.each(views, function(i, view) {
			supported = supported || url.pathname == '/' + view;
		});
		
		if (supported) {
			var contentUrl = elgg.config.wwwroot + 'ajax/view' + url.pathname;
			
			var $main = $('.elgg-main');
			
			// Update title
			var segments = url.pathname.split('/');
			segments.shift();
			segments.shift();
			var title = i18n('admin:' + segments[0]) + ' : ' + i18n('admin:' + segments.join(':'));
			$main.html('<div class="elgg-head"><h2>' + title + '</h2></div>');
			document.title = title;
			
			// Display a loader while we wait for the content to show up
			var $loader = $('<div class="elgg-ajax-loader"></div>');
			$main.append($loader);
			
			// Refresh content area.
			require(['text!' + contentUrl], function(content) {
				$loader.remove();
				$main.append(content);
			});
			
			// Update sidebar menu to reflect current page selection
			$('.elgg-menu-page li').removeClass('elgg-state-selected');
			
			$('.elgg-menu-page a[href="' + url + '"]').parents('.elgg-menu-page li').addClass('elgg-state-selected');
			
			window.history.pushState({}, '', url.toString());
			return false;
		}
	});
});