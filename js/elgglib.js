/**
 * @author Evan Winslow
 * 
 * $Id$
 */

/**
 * @namespace Namespace for elgg javascript functions
 */
var elgg = elgg || {};

/**
 * Initialise Elgg
 * @todo Should we init other things here too, or make them initialise themselves?
 */
elgg.init = function() {
	//if the user clicks a system message, make it disappear
	$('.elgg_system_message').live('click', function() {
		$(this).stop().fadeOut('fast');
	});
};

//Initialise Elgg
$(function() {
	elgg.init();
});

/**
 * Pointer to the global context
 * {@see elgg.require} and {@see elgg.provide}
 */
elgg.global = this;

/**
 * @param {String} pkg The required package (e.g., elgg.package)
 */
elgg.require = function(pkg) {
	var parts = pkg.split('.'),
		cur = elgg.global,
		part;

	for (var i = 0; i < parts.length; i++) {
		part = parts[i];
		cur = cur[part];
		if(typeof cur == 'undefined') {
			throw new Error("Missing package: " + pkg);
		}
	}
};

/**
 * Generate the skeleton for pkg.
 * 
 * <pre>
 * elgg.provide('elgg.package.subpackage');
 * </pre>
 * 
 * is equivalent to
 * 
 * <pre>
 * elgg = elgg || {};
 * elgg.package = elgg.package || {};
 * elgg.package.subpackage = elgg.package.subpackage || {};
 * </pre>
 */
elgg.provide = function(pkg) {
	var parts = pkg.split('.'),
		cur = elgg.global,
		part;
	
	for (var i = 0; i < parts.length; i++) {
		part = parts[i];
		cur[part] = cur[part] || {};
		cur = cur[part];
	}
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
 */
elgg.implement = function(obj, iface) {
	for (var member in iface) {
		if (typeof iface[member] == 'function') {
			obj.prototype[member] = iface[member];
		}
	}
};

/** @const */ elgg.ACCESS_PUBLIC = 2;
/** @const */ elgg.ACCESS_LOGGED_IN = 1;
/** @const */ elgg.ACCESS_PRIVATE = 0;
/** @const */ elgg.ACCESS_DEFAULT = -1;
/** @const */ elgg.ACCESS_FRIENDS = -2;

/** @const */ elgg.ENTITIES_ANY_VALUE = null;
/** @const */ elgg.ENTITIES_NO_VALUE = 0;

/**
 * Prepend elgg.config.wwwroot to a url if the url doesn't already have it.
 * 
 * @param {String} url The url to extend
 * @return {String} The extended url
 * @private
 */
elgg.extendUrl = function(url) {
	url = url || '';
	if(url.indexOf(elgg.config.wwwroot) == -1) {
		url = elgg.config.wwwroot + url;
	}
	
	return url;
};

/**
 * Displays system messages via javascript rather than php.
 * 
 * @param {String} msgs The message we want to display
 * @param {Number} delay The amount of time to display the message in milliseconds. Defaults to 6 seconds.
 * @param {String} type The type of message (typically 'error' or 'message')
 * @private
 */
elgg.system_messages = function(msgs, delay, type) {
	//validate delay.  Must be a positive integer. 
	delay = parseInt(delay);
	if (isNaN(delay) || delay <= 0) {
		delay = 6000;
	}
	
	var messages_class = 'messages';
	if (type == 'error') {
		messages_class = 'messages_error';
	}

	//Handle non-arrays
	if (msgs.constructor.toString().indexOf("Array") == -1) {
		msgs = [msgs];
	}
	
	var messages_html = '<div class="' + messages_class + '">' 
		+ '<span class="closeMessages">'
			+ '<a href="#">' 
				+ elgg.echo('systemmessages:dismiss')
			+ '</a>'
		+ '</span>'
		+ '<p>' + msgs.join('</p><p>') + '</p>'
	+ '</div>';
	
	$(messages_html).insertAfter('#layout_header').click(function () {
		$(this).stop().fadeOut('slow');
		return false;
	}).show().animate({opacity:'1.0'},delay).fadeOut('slow');
};

/**
 * Wrapper function for system_messages. Specifies "messages" as the type of message
 * @param {String} msg The message to display
 * @param {Number} delay How long to display the message (milliseconds)
 */
elgg.system_message = function(msg, delay) {
	elgg.system_messages(msg, delay, "message");
};

/**
 * Wrapper function for system_messages.  Specifies "errors" as the type of message
 * @param {String} error The error message to display
 * @param {Number} delay How long to dispaly the error message (milliseconds)
 */
elgg.register_error = function(error, delay) {
	elgg.system_messages(error, delay, "error");
};

/**
 * Meant to mimic the php forward() function by simply redirecting the
 * user to another page.
 * 
 * @param {String} url The url to forward to
 */
elgg.forward = function(url) {
	location.href = elgg.extendUrl(url);
};

/**
 * Cache stuff here
 */
elgg.provide('elgg.cache');

/**
 * Hold configuration data here
 */
elgg.provide('elgg.config');

/**
 * Allow plugins to extend it
 * @todo not sure which to use
 */
elgg.provide('elgg.mod');
elgg.provide('elgg.plugins');