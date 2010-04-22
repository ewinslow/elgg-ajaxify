/**
 * Wrapper function for jQuery.ajax which ensures that the url being called
 * is relative to the elgg site root.
 * 
 * @param {Object} options {@see jQuery#ajax}
 * @return {XmlHttpRequest}
 */
elgg.ajax = function(options) {
	options.url = elgg.extendUrl(options.url);
	return $.ajax(options);
};

/**
 * Wrapper function for jQuery.ajax which ensures that the url being called
 * is relative to the elgg site root.
 * 
 * @param {Object} options {@see jQuery#ajax}
 * @return {XmlHttpRequest}
 */
elgg.get = function(options) {
	options.type = 'get';
	return elgg.ajax(options);
};

/**
 * Wrapper function for jQuery.ajax which ensures that the url being called
 * is relative to the elgg site root.
 * 
 * @param {Object} options {@see jQuery#ajax}
 * @return {XmlHttpRequest}
 */
elgg.getJSON = function(options) {
	options.dataType = 'json';
	return elgg.get(options);
};

/**
 * Wrapper function for jQuery.ajax which ensures that the url being called
 * is relative to the elgg site root.
 * 
 * @param {Object} options {@see jQuery#ajax}
 * @return {XmlHttpRequest}
 */
elgg.post = function(options) {
	options.type = 'post';
	return elgg.ajax(options);
};

/**
 * Convenience function which automatically includes elgg action tokens
 * 
 * Usage:
 * <pre>
 * elgg.action('friend/add', {
 *     data: {
 *         friend: some_guid
 *     },
 *     success: function(json) {
 *         //do something
 *     }
 * }
 * </pre>
 * 
 * @param {String} action The action to call.
 * @param {Object} options {@see jQuery#ajax}
 * 
 * @return XmlHttpRequest
 */
elgg.action = function(action, options) {
	options = options || {};
	options.url = 'action/' + action;
	options.data = elgg.security.addToken(options.data || {});
	options.dataType = 'json';
	
	return elgg.post(options);
};

/**
 * Make an API call
 * 
 * Usage:
 * <pre>
 * elgg.api('system.api.list', {
 *     success: function(data) {
 *         alert(data.message);
 *     }
 * });
 * </pre>
 * 
 * @param {String} method The API method to be called
 * @param {Object} options {@see elgg#ajax}
 * @return {XmlHttpRequest} The XHR object
 */
elgg.api = function(method, options) {
	options = options || {};
	options.dataType = options.dataType || 'json';
	options.url = 'services/api/rest/' + options.dataType + '/';
	options.data = options.data || {};
	options.data.method = method;
	
	return elgg.ajax(options);
};