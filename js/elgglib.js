/**
 * @author Evan Winslow
 * 
 * $Id$
 */

/**
 * @namespace Namespace for elgg javascript functions
 */
var elgg = elgg || {};

elgg.ACCESS_PUBLIC = 2;
elgg.ACCESS_LOGGED_IN = 1;
elgg.ACCESS_PRIVATE = 0;
elgg.ACCESS_DEFAULT = -1;
elgg.ACCESS_FRIENDS = -2;

elgg.ENTITIES_ANY_VALUE = null;
elgg.ENTITIES_NO_VALUE = 0;

elgg.cache = {};

/**
 * Hold configuration data here
 */
elgg.config = {};
elgg.config.wwwroot;
elgg.config.lastcache;

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

//object for holding security-related methods/data
elgg.security = {};
elgg.security.token = {};
elgg.security.interval = 5 * 60 * 1000;

/**
 * Security tokens time out, so lets refresh those every so often
 * 
 * @return void
 */
elgg.security.refreshtoken = function() {
	elgg.action('ajax/securitytoken', {
		success: function(json) {
			//update the convenience object
			elgg.security.token = json;
			
			//also update all forms
			$('[name=__elgg_ts]').val(json.__elgg_ts);
			$('[name=__elgg_token]').val(json.__elgg_token);
		}
	});
};

/**
 * Add elgg action tokens to an object
 * 
 * @param {Object} data The data object to add the action tokens to
 * @return {Object} The new data object including action tokens
 * @private
 */
elgg.security.addToken = function(data) {
	if (typeof data == 'object') {
		$.extend(data, elgg.security.token);
	} else if (typeof data == 'string') {
		throw new TypeError("Function elgg.security.addToken does not accept string input yet");
	}
	
	return data;
};

/**
 * Prepend elgg.config.wwwroot to a url if the url doesn't already have it.
 * 
 * @param {String} url The url to extend
 * @return {String} The extended url
 * @private
 */
elgg.extendUrl = function(url) {
	if(url.indexOf(elgg.config.wwwroot) == -1) {
		url = elgg.config.wwwroot + url;
	}
	
	return url;
};

/**
 * Displays system messages via javascript rather than php.
 * 
 * @param {string} msg The message we want to display
 * @param {number} delay The amount of time to display the message in milliseconds
 * @param {string} type The type of message (typically 'error' or 'message')
 * @return void
 * @private
 */
elgg.system_messages = function(msg, delay, type) {
	//validate delay.  Must be a positive integer. Default to 3 seconds.
	delay = parseInt(delay);
	if (isNaN(delay) || delay <= 0) {
		delay = 3000;
	}
	
	$("<div/>", {
		'class': 'elgg_system_message ' + type,
		'html': msg
	}).appendTo('#elgg_system_messages').show()
	.animate({opacity:'1.0'},delay).fadeOut('slow');
};

/**
 * Wrapper function for system_messages. Specifies "messages" as the type of message
 * @param {String} msg The message to display
 * @param {number} delay How long to display the message (milliseconds)
 * @return void
 */
elgg.system_message = function(msg, delay) {
	return elgg.system_messages(msg, delay, "message");
};

/**
 * Wrapper function for system_messages.  Specifies "errors" as the type of message
 * @param {String} error The error message to display
 * @param {number} delay How long to dispaly the error message (milliseconds)
 * @return void
 */
elgg.register_error = function(error, delay) {
	return elgg.system_messages(error, delay, "error");
};

/**
 * Meant to mimic the php forward() function by simply redirecting the
 * user to another page.
 * 
 * @param {String} url The url to forward to
 * @return void
 */
elgg.forward = function(url) {
	location.href = elgg.extendUrl(url);
};

/**
 * Allow plugins to extend it
 */
elgg.mod = {};

elgg.plugins = [];

/**
 * Initialise Elgg
 * @return void
 */
elgg.init = function() {
	elgg.load_translations();
	
	//refresh security token every 5 minutes
	setInterval(elgg.security.refreshtoken, elgg.security.interval);
	
	//if the user clicks a system message, make it disappear
	$('#elgg_system_messages').delegate('.elgg_system_message', 'click', function() {
		$(this).stop().fadeOut('fast');
	});
	
	for (var i in elgg.plugins) {
		elgg.plugins[i].init();
	}
};

//Initialise Elgg
$(elgg.init);