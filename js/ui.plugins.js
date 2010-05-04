elgg.provide('elgg.ui.plugins');

$(function() {
	elgg.ui.plugins.init();
});

elgg.ui.plugins.init = function() {
//	$('a.pluginsettings_link').click(elgg.ui.plugins.toggleSettings);
//	$('a.manifest_details').click(elgg.ui.plugins.toggleDetails);
	
	//Ajaxify plugin enable/disable
	$('.plugin_details').bind('toggle.elgg', function() {
		var button = $(this).find('.admin_plugin_enable_disable a')[0];
		
		elgg.post(button.href, {
			dataType: 'json',
			success: function(data) {
				if (data.status) {
					elgg.register_error(data.system_messages.errors[0]);
				} else {
					//swallow system messages
				}
			}
		});
		
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
		scroll: false
	});
	
};

// toggle plugin's settings and more info on admin tools admin
elgg.ui.plugins.toggleSettings = function () {
	$(this.parentNode.parentNode).children(".pluginsettings").slideToggle("fast");
	return false;
};

elgg.ui.plugins.toggleDetails = function () {
	$(this.parentNode.parentNode).children(".manifest_file").slideToggle("fast");
	return false;
};