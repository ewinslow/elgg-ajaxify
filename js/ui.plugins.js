elgg.provide('elgg.ui.plugins');

elgg.ui.plugins.init = function() {
	$('a.pluginsettings_link').click(elgg.ui.plugins.toggleSettings);
	$('a.manifest_details').click(elgg.ui.plugins.toggleDetails);
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