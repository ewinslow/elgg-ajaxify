ElggLanguagesTest = TestCase("ElggLanguagesTest");

ElggLanguagesTest.prototype.setUp = function() {
	this.ajax = $.ajax;
	
	//Immediately call the success handler instead of sending ajax request
	$.ajax = function(settings) {
		settings.success({'language':settings.data.language});
	};
};

ElggLanguagesTest.prototype.tearDown = function() {
	$.ajax = this.ajax;
	
	//clear translations
	elgg.config.translations['en'] = undefined;
	elgg.config.translations['aa'] = undefined;
};

ElggLanguagesTest.prototype.testLoadTranslations = function() {
	assertUndefined(elgg.config.translations['en']);
	assertUndefined(elgg.config.translations['aa']);
	
	elgg.config.translations.load();
	elgg.config.translations.load('aa');
	
	assertNotUndefined(elgg.config.translations['en']['language']);
	assertNotUndefined(elgg.config.translations['aa']['language']);
};

ElggLanguagesTest.prototype.testElggEchoTranslates = function() {
	elgg.config.translations.load('en');
	elgg.config.translations.load('aa');
	
	assertEquals('en', elgg.echo('language'));
	assertEquals('aa', elgg.echo('language', 'aa'));
};

ElggLanguagesTest.prototype.testElggEchoFallsBackToDefaultLanguage = function() {
	elgg.config.translations.load('en');
	assertEquals('en', elgg.echo('language', 'aa'));
};

