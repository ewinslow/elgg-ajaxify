ElggAjaxTest = TestCase("ElggAjaxTest");

ElggAjaxTest.prototype.testHandleOptionsAcceptsNoArgs = function() {
	assertNotUndefined(elgg.ajax.handleOptions());
	
};

ElggAjaxTest.prototype.testHandleOptionsAcceptsUrl = function() {
	var url = 'url',
		result = elgg.ajax.handleOptions(url);
	
	assertEquals(url, result.url);
};

ElggAjaxTest.prototype.testHandleOptionsAcceptsDataOnly = function() {
	var options = {},
		result = elgg.ajax.handleOptions(options);
	
	assertEquals(options, result.data);
};

ElggAjaxTest.prototype.testHandleOptionsAcceptsOptions = function() {
	var options = {data:{arg:1}},
		result = elgg.ajax.handleOptions(options);
	
	assertEquals(options, result);
};

ElggAjaxTest.prototype.testHandleOptionsAcceptsUrlThenDataOnly = function() {
	var url = 'url',
		options = {arg:1},
		result = elgg.ajax.handleOptions(url, options);
	
	assertEquals(url, result.url);
	assertEquals(options, result.data);
};

ElggAjaxTest.prototype.testHandleOptionsAcceptsUrlThenOptions = function() {
	var url = 'url',
	options = {data:{arg:1}},
	result = elgg.ajax.handleOptions(url, options);
	
	assertEquals(url, result.url);
	assertEquals(options.data, result.data);
};