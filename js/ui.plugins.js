elgg.provide('elgg.ui.plugins');

$(function() {
	elgg.ui.plugins.init();
});

elgg.ui.plugins.init = function() {
//	$('a.pluginsettings_link').click(elgg.ui.plugins.toggleSettings);
//	$('a.manifest_details').click(elgg.ui.plugins.toggleDetails);
	
	$('.admin_plugin_enable_disable a').click(function() {
		var $plugin = $(this).closest(".plugin_details").toggleClass('active').toggleClass('not-active');
		elgg.post(this.href, {
			dataType: 'json',
			success: function(data) {
				if (data.status) {
					elgg.register_error(data.system_messages.errors[0]);
				} else {
					//swallow system messages
				}

			}
		});
		
		if($plugin.hasClass('active')) {
			$(this).text(elgg.echo('disable'));
			this.href = this.href.replace(/enable/, 'disable');
		} else if($plugin.hasClass('not-active')) {
			$(this).text(elgg.echo('enable'));
			this.href = this.href.replace(/disable/, 'enable');
		}
		
		return false;
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