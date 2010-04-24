/**
 * Provides language-related functionality
 */
elgg.provide('elgg.config.translations');

elgg.config.language = 'en';

$(function() {
	elgg.config.translations.init();
});

elgg.config.translations.init = function() {
	elgg.getJSON({
		url: '_css/js.php',
		data: {
			js: 'translations',
			language: elgg.get_language(),
			lastcache: elgg.config.lastcache
		},
		success: function(json) {
			var language = elgg.get_language();
			elgg.config.translations[language] = json;
		}
	});
};

/**
 * Get the current language
 * @return {String}
 */
elgg.get_language = function() {
	var user = elgg.get_loggedin_user();
	
	if (user && user.language) {
		return user.language;
	}
	
	return elgg.config.language;
};

/**
 * Translates a string
 * 
 * @param {String} key The string to translate
 * @param {String} language The language to display it in
 * @return {String} The translation
 */
elgg.echo = function(key, language) {
	language = language || elgg.get_language();
	var translations = elgg.config.translations[language];
	return (translations && translations[key]) ? translations[key] : key;
};