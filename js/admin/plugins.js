elgg.provide('elgg.plugins');

$(function() {
	elgg.plugins.init();
});

elgg.plugins.init = function() {
	$('a.pluginsettings_link').click(function () {
		$(this).closest('.plugin_details').children(".pluginsettings").slideToggle("fast");
		return false;
	});
	
	$('a.manifest_details').click(function () {
		$(this).closest('.plugin_details').children(".manifest_file").slideToggle("fast");
		return false;
	});

	//Ajaxify plugin enable/disable
	$('.plugin_details').bind('toggle.elgg', function() {
		var button = $(this).find('.admin_plugin_enable_disable a')[0];
		
//		elgg.post(button.href, {
//			data: {},
//			dataType: 'json',
//			success: function(data) {
//				if (data.status) {
//					elgg.register_error(data.system_messages.errors[0]);
//				} else {
//					//swallow system messages
//				}
//			}
//		});
		
		$(this).toggleClass('active').toggleClass('not-active');
		if($(this).hasClass('active')) {
			$(button).text(elgg.echo('enable'));
			button.href = button.href.replace(/disable/, 'enable');
		} else if($(this).hasClass('not-active')) {
			$(button).text(elgg.echo('disable'));
			button.href = button.href.replace(/enable/, 'disable');
		}
		
		return false;
	});
	
	$('.admin_plugin_enable_disable a').click(function() {
		return $(this).closest(".plugin_details").trigger('toggle.elgg');
	});
	
	//Ajaxify plugin reordering -- still have to click save in order to save ordering
	$('#two_column_left_sidebar_maincontent').sortable({
		axis: 'y',
		items: '> .plugin_details',
		scroll: false,
		handle: '> .drag'
	});
	
};