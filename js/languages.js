/**
 * Provides language-related functionality
 */
elgg.provide('elgg.config.translations');

elgg.config.language = 'en';

$(function() {
	elgg.config.translations.init();
});

elgg.config.translations.init = function() {
	elgg.config.translations.load();
};

/**
 * Load the translations for the given language.
 * 
 * If no language is specified, the default language is used.
 * @param {string} language
 * @return {XMLHttpRequest}
 */
elgg.config.translations.load = function(language) {
	var lang = language || elgg.get_language();
	elgg.get('_css/languages/' + lang + '.default.' + elgg.config.lastcache + '.js');
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
	var translations,
		dlang = elgg.get_language();
	
	language = language || dlang;
	
	translations = elgg.config.translations[language];
	if (translations && translations[key]) {
		return translations[key];
	}
	
	if (language == dlang) {
		return undefined;
	}
	
	translations = elgg.config.translations[dlang];
	if (translations && translations[key]) {
		return translations[key];
	}
	
	return undefined;
};