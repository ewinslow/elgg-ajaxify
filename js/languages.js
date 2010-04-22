/**
 * Provides javascript functionality related to languages
 */

elgg.config.language = 'en';
elgg.config.translations = {};

/**
 * Get the current language
 * @return {String}
 */
elgg.get_language = function() {
	var user = elgg.get_loggedin_user();
	return user.language || elgg.config.language;
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

/**
 * Convenience function for lazy loading the translations
 */
elgg.load_translations = function() {
	elgg.api('translations.get', {
		success: function(json) {
			var language = elgg.get_language();
			elgg.config.translations[language] = json.result;
		}
	});
};