/**
 * @author Evan Winslow
 * 
 * $Id$
 */
var elgg = elgg || {};

/**
 * @private
 */
elgg.translations_ = {
	'delete:confirm': 'Are you sure you want to delete that? There is no undo!'
};

elgg.cache = elgg.cache || {};

/**
 * Translates a string
 * 
 * @param {String} str The string to translate
 * @return The translation
 * @type {String}
 */
elgg.echo = function(str) {
	translation = elgg.translations_[str];
	return (translation != undefined) ? translation : str;
};

/**
 * Inherit the prototype methods from one constructor into another.
 * Stolen shamelessly from Google's Closure Library.
 * 
 * Usage:
 * <pre>
 * function ParentClass(a, b) { }
 * ParentClass.prototype.foo = function(a) { }
 *
 * function ChildClass(a, b, c) {
 *     ParentClass.call(this, a, b);
 * }
 *
 * elgg.inherit(ChildClass, ParentClass);
 *
 * var child = new ChildClass('a', 'b', 'see');
 * child.foo(); // works
 * </pre>
 *
 * In addition, a superclass' implementation of a method can be invoked
 * as follows:
 *
 * <pre>
 * ChildClass.prototype.foo = function(a) {
 *     ChildClass.superClass_.foo.call(this, a);
 *     // other code
 * };
 * </pre>
 *
 * @param {Function} childCtor Child class.
 * @param {Function} parentCtor Parent class.
 * @return void
 */
elgg.inherit = function(childCtor, parentCtor) {
	function tempCtor() {}
	tempCtor.prototype = parentCtor.prototype;
	childCtor.superClass_ = parentCtor.prototype;
	childCtor.prototype = new tempCtor();
	childCtor.prototype.constructor = childCtor;
};

/**
 * Implement an interface
 * 
 * @param {Function} obj The inheriting class
 * @param {Object} iface The interface to implement
 * @return void
 */
elgg.implement = function(obj, iface) {
	for (var member in iface) {
		if (typeof iface[member] == 'function') {
			obj.prototype[member] = iface[member];
		}
	}
};

/**
 * Hold configuration data here
 */
elgg.config = {
	wwwroot: '/',
	lastcache: 0
};

//object for holding security-related methods/data
elgg.security = {};

/**
 * Make the action tokens available from js.
 */
elgg.security.token = {};

/**
 * Security tokens time out, so lets refresh those every so often
 * 
 * @return void
 */
elgg.security.refreshtoken = function() {
	elgg.post('action/ajax/securitytoken', {}, function(data) {
		//update the convenience object
		elgg.security.token = data;
		
		//also update all forms
		$('[name=__elgg_ts]').val(data.__elgg_ts);
		$('[name=__elgg_token]').val(data.__elgg_token);
	}, 'json');
};

/**
 * Add elgg action tokens to an object
 * 
 * @param {Object} data The data object to add the action tokens to
 * @return The new data object including action tokens
 * @type {Object}
 * @private
 */
elgg.security.addToken_ = function(data) {
	if (typeof data == 'object') {
		$.extend(data, elgg.security.token);
	} else if (typeof data == 'string') {
		throw new TypeError("Function elgg.security.addToken_ does not accept string input yet");
	}
	
	return data;
};

/**
 * Prepend elgg.config.wwwroot to a url if the url doesn't already have it.
 * 
 * @param {String} url The url to extend
 * @return The extended url
 * @type {String}
 * @private
 */
elgg.extendUrl_ = function(url) {
	if(!(new RegExp(elgg.config.wwwroot).test(url))) {
		url = elgg.config.wwwroot + url;
	}
	
	return url;
};

/**
 * Wrapper function for jQuery.ajax which provides an extra setting 'action.'
 * 
 * If 'action' is true, adds the elgg security tokens to the request data
 * Note that settings.data must be an object for this to work.
 * 
 * @param settings {@see jQuery#ajax}
 * 		{Boolean} settings[action] Whether to add elgg security tokens to request data
 * @return XmlHttpRequest
 */
elgg.ajax = function(settings) {
	if (settings.action) {
		settings.data = elgg.security.addToken_(settings.data || {});
	}
	
	settings.url = elgg.extendUrl_(settings.url);
	
	return $.ajax(settings);
};



/**
 * Wrapper function for jQuery.post which automatically
 * adds elgg securitytokens to the request
 * 
 * Note that this function does not have as much flexibility as jQuery.post.
 * You cannot skip parameters.  The data param must be an object, not a string
 * 
 * @param {String} url See jQuery.post
 * @param {Object} data See jQuery.post
 * @param {Function} success See jQuery.post
 * @param {String} dataType See jQuery.post
 * 
 * @return XmlHttpRequest
 */
elgg.post = function(url, data, success, dataType) {
	url = elgg.extendUrl_(url);
	data = elgg.security.addToken_(data || {});
	return $.post(url, data, success, dataType);
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
 * @param {Object} options {@see elgg.ajax}
 * 	{String} options[dataType] defaults to 'json'
 * @return {XmlHttpRequest} The XHR object
 */
elgg.api = function(method, options) {
	options = options || {};
	options.dataType = options.dataType || 'json';
	options.url = 'services/api/rest/' + options.dataType + '/';
	options.data = (options.data || {}).method = method;
	return elgg.ajax(options);
};

/**
 * Displays system messages via javascript rather than php.
 * 
 * @param {String} msg The message we want to display
 * @param {Number} delay The amount of time to display the message in milliseconds
 * @param {String} type The type of message (typically 'error' or 'message')
 * @return The jquery object of the new system message
 * @type {jQuery}
 * @private
 */
elgg.system_messages = function(msg, delay, type) {
	//validate delay.  Must be a positive integer. Default to 3 seconds.
	delay = parseInt(delay);
	if (isNaN(delay) || delay <= 0) {
		delay = 3000;
	}
	
	return $("<div/>", {
		'class': 'elgg_system_message ' + type,
		'html': msg
	}).appendTo('#elgg_system_messages').show()
	.animate({opacity:'1.0'},delay).fadeOut('slow');
};

/**
 * Wrapper function for system_messages. Specifies "messages" as the type of message
 * @param {String} msg The message to display
 * @param {String} delay How long to display the message (milliseconds)
 * @return The jQuery object of the message
 * @type {jQuery}
 */
elgg.system_message = function(msg, delay) {
	return elgg.system_messages(msg, delay, "message");
};

/**
 * Wrapper function for system_messages.  Specifies "errors" as the type of message
 * @param {String} error The error message to display
 * @param {Number} delay How long to dispaly the error message (milliseconds)
 * @return The jQuery object of the error message
 * @type {jQuery}
 */
elgg.register_error = function(error, delay) {
	return elgg.system_messages(error, delay, "error");
};

/**
 * Deletes an annotation
 * 
 * @param id The id of the annotation to delete
 * @return false Forces this to be the last action that occurs.
 */
elgg.delete_annotation = function(id) {
	if (!confirm(elgg.echo('delete:confirm'))) {
		return false;
	}
	
	$annotation = $('.annotation.editable[data-id='+id+']');
	
	$annotation.slideUp();
	
	elgg.ajax({
		type: 'post',
		url: 'action/ajax/annotation/delete',
		data: {
			annotation_id: id
		},
		action: true,
		success: function(data) {
			elgg.system_message(data);
		},
		error: function(xhr) { // oops
			$annotation.slideDown();
			elgg.register_error(xhr.responseText);
		}
	});
	
	return false;
};

/**
 * Meant to mimic the php forward() function by simply redirecting the
 * user to another page.
 * 
 * @param {String} url The url to forward to
 * @return void
 */
elgg.forward = function(url) {
	location.href = elgg.extendUrl_(url);
};

/**
 * Allow plugins to extend it
 */
elgg.mod = {};

/**
 * Initialise Elgg
 * @return void
 */
elgg.init = function() {
	//refresh security token every 5 minutes
	setInterval(elgg.security.refreshtoken, 5 * 60 * 1000);
	
	//if the user clicks a system message, make it disappear
	$('#elgg_system_messages').delegate('.elgg_system_message', 'click', function() {
		$(this).stop().fadeOut('fast');
	});
};

$(function() {
	elgg.init();
});