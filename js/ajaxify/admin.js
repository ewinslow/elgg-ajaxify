define(function(require) {
	var $ = require('jquery');
	var elgg = require('elgg');
	var i18n = require('elgg/i18n');
	
	function isSameOrigin(url1, url2) {
		return url1.hostname == url2.hostname &&
               url1.protocol == url2.protocol &&
               url1.port == url2.port;
	}
	
	function isClickAjaxable(event) {
		return event.target.href && !event.metaKey && !event.ctrlKey && isSameOrigin(location, event.target);
	}
	
	$('a').live('click', function(event) {
		if (isClickAjaxable(event)) {
			return elgg.trigger_hook('navigate', 'window', event, event.target);
		}
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