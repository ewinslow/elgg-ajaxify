define(function(require) {
	var $ = require('jquery');
	var elgg = require('elgg');
	
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
	
	
	
	$(window).bind('popstate', function(event) {
		elgg.trigger_hook('navigate', 'window', event, document.location);
	});
	
	elgg.register_hook_handler('navigate', 'window', function(hook, type, event, url) {
		var views = [
			'admin/statistics/server',
			'admin/statistics/overview',
			'admin/settings/basic',
			'admin/settings/advanced',
			'admin/appearance/menu_items',
			'admin/appearance/profile_fields',
			'admin/appearance/default_widgets',
			'admin/appearance/customcss',
			'admin/appearance/customlogo',
			'admin/users/online',
			'admin/users/add',
			'admin/users/newest',
			'admin/develop_tools/unit_tests',
			'admin/develop_tools/preview',
			'admin/develop_tools/inspect',
			'admin/developers/settings',
			'admin/administer_utilities/logbrowser',
			'admin/administer_utilities/reportedcontent'
		];

		var supported = false;
		
		$.each(views, function(i, view) {
			supported = supported || url.pathname == '/' + view;
		});
		
		if (supported) {
			var contentUrl = elgg.config.wwwroot + 'ajax/view' + url.pathname + '?' + new Date();
			
			// Refresh content area + title
			require(['text!' + contentUrl, 'elgg/i18n'], function(content, i18n) {
				var segments = event.target.pathname.split('/');
				segments.shift();
				segments.shift();
				var title = i18n('admin:' + segments[0]) + ' : ' + i18n('admin:' + segments.join(':'));
				$('.elgg-main').html(content);
				$('.elgg-main').prepend('<div class="elgg-head"><h2>' + title + '</h2></div>');
				
				document.title = title;

				window.history.pushState({}, '', event.target.href);
			});
			
			// Update sidebar menu to reflect current page selection
			$('.elgg-menu-page li').removeClass('elgg-state-selected');
			
			$('.elgg-menu-page a[href="' + url + '"]').parents('.elgg-menu-page li').addClass('elgg-state-selected');
			
			return false;
		}
	});
});