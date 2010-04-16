/**
 * @author Evan Winslow
 */
var elgg = elgg || {};

/**
 * @private
 */
elgg.translations_ = {
	'delete:confirm': 'Are you sure you want to delete that? There is no undo!'
};

/**
 * 
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
 */
elgg.inherit = function(childCtor, parentCtor) {
	/** @constructor */
	function tempCtor() {};
	tempCtor.prototype = parentCtor.prototype;
	childCtor.superClass_ = parentCtor.prototype;
	childCtor.prototype = new tempCtor();
	childCtor.prototype.constructor = childCtor;
};

/**
 * Implement an interface
 * 
 * @param {Function} obj Inheriting class
 * @param {Object} iface Interface to implement
 */
elgg.implement = function(obj, iface) {
	for (var member in iface) {
		if (typeof iface[member] == 'function') {
			obj.prototype[member] = iface[member];
		}
	}
};

/**
 * Hold configuration data here (e.g. wwwroot)
 */
elgg.config = {
	wwwroot: '/',
	lastcache: 0
};

//fill in the actual value later
elgg.config.wwwroot = '/';

//object for holding security-related methods/data
elgg.security = {};

/**
 * Make the action tokens available from js.
 * This is filled by js/securitytoken.php
 */
elgg.security.token = {};

/**
 * Security tokens time out, so lets refresh those every so often
 */
elgg.security.refreshtoken = function() {
	elgg.ajax({
		type: 'post',
		url: elgg.config.wwwroot + 'action/ajax/securitytoken',
		action: true, //need tokens to generate tokens
		dataType: 'json',
		success: function(data) {
			//update the convenience object
			elgg.security.token = data;
			
			//also update all forms
			$('[name=__elgg_ts]').val(data.__elgg_ts);
			$('[name=__elgg_token]').val(data.__elgg_token);
		}
	});
};

/**
 * Wrapper function for $.ajax which provides an extra setting 'action.'
 * 
 * If 'action' is true, adds the elgg security tokens to the request data
 * Note that settings.data must be an object for this to work.
 * 
 * @param settings See $.ajax
 * 		[boolean] 'action' If true, adds elgg security tokens to request data
 * @return XmlHttpRequest
 */
elgg.ajax = function(settings) {
	if (settings.action) {
		settings.data = settings.data || {};
		$.extend(settings.data, elgg.security.token);
	}
	return $.ajax(settings);
};

/**
 * Wrapper function for jQuery.post which automatically
 * adds elgg securitytokens to the request
 * 
 * Note that this function does not have as much flexibility as jQuery.post.
 * You cannot skip parameters.  data must be an object, not a string
 * 
 * @param url [string] See jQuery.post
 * @param data [object] See jQuery.post
 * @param success [function] See jQuery.post
 * @param dataType [string] See jQuery.post
 * 
 * @return XmlHttpRequest
 */
elgg.post = function(url, data, success, dataType) {
	data = data || {};
	$.extend(data, elgg.security.token);
	return $.post(url, data, success, dataType);
};

/**
 * Displays system messages via javascript rather than php.
 * 
 * @param msg The message we want to display
 * @param delay The amount of time to display the message in milliseconds
 * @param type The type of message (typically 'error' or 'message')
 * @return jQuery The jquery object of the new system message
 */
elgg.system_messages = function(msg, delay, type) {
	//validate delay.  Must be a positive integer. Default to 3 seconds.
	delay = parseInt(delay);
	if(isNaN(delay) || delay <= 0) { delay = 3000; }
	
	return $("<div/>", {
		'class': 'elgg_system_message ' + type
	}).append(msg)
	.appendTo('#elgg_system_messages')
	.show()
	.animate({opacity:'1.0'},delay)
	.fadeOut('slow');
};

/**
 * Wrapper function for system_messages. Specifies "messages" as the type of message
 * @param msg See elgg.system_messages
 * @param delay See elgg.system_messages
 * @return true
 */
elgg.system_message = function(msg, delay) {
	return elgg.system_messages(msg, delay, "message");
};

/**
 * Wrapper function for system_messages.  Specifies "errors" as the type of message
 * @param error See elgg.system_messages
 * @param delay See elgg.system_messages
 * @return true
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
		url: elgg.config.wwwroot + 'action/ajax/annotation/delete',
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
 * @param url The url to forward to
 */
elgg.forward = function(url) {
	location.href = url;
};

/**
 * Allow plugins to extend it
 */
elgg.mod = {};

/**
 * Initialise Elgg
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