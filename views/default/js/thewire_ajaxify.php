elgg.provide('elgg.ajaxify.thewire');

/**
* Handlers - There are three hooks for which the handlers can be bound: actions:success, actions:processing, actions:fail
* @example 
* elgg.ajaxify.thewire.success_handler = function(hook, type, params, value) {
* 		//Check for type of success (Successful post or reply or anything else)
* 		//Update DOMs accordingly
* }
*
*/

elgg.ajaxify.thewire.success_handler = function(hook, type, params, value) {
	if (params.type === 'thewire/add') {
		elgg.view('entities/getentity', {
			cache: false,
			data: {
				limit: '1',
				guid: value.output.guid,
				subtype: 'thewire',
			},
			success: function(entities_list) {
				$('#thewire-textarea').val('');
				var entities = $(entities_list).find('.elgg-list-item');
				$('.elgg-entity-list').prepend(entities);
				ajaxLoader.remove();
				elgg.thewire.textCounter($('#thewire-textarea'), $('#thewire-characters-remaining span'), 140);
			},
		});
	}
};

elgg.ajaxify.thewire.processing_handler = function(hook, type, params, value) {
	if (params.type === 'thewire/add') {
		$('.elgg-entity-list').prepend(ajaxLoader);
	}
};

elgg.ajaxify.thewire.add = function(item) {
	elgg.trigger_hook('actions:processing', 'thewire', {type: 'thewire/add'}, null);
	elgg.action('thewire/add', {
		data: {
			body: $('#thewire-textarea').val()
		},
		success: function(response) {
			elgg.trigger_hook('actions:success', 'thewire', {type: 'thewire/add'}, response);
		},
	});
};

//Incomplete
elgg.ajaxify.thewire.reply = function(item) {
	var urlParts = $(item).find('a').attr('href').split('/');
	var guid = urlParts[urlParts.length - 1];
	
	elgg.view('thewire/thewire_reply', {
		data: {
			'guid': guid,
		},
		success: function(response) {
			var replyDiv = document.createElement('div');
			$(replyDiv).attr('id', 'elgg-reply-div-'+guid);
			$(replyDiv).html(response);
			$(replyDiv).css('display', 'none');
			$(item).closest('.elgg-list-item').append(replyDiv);
			$(replyDiv).slideDown('fast');
			$(replyDiv).find('textarea').focus();
		},
	});
};

elgg.register_hook_handler('actions:success', 'thewire', elgg.ajaxify.thewire.success_handler); 
elgg.register_hook_handler('actions:processing', 'thewire', elgg.ajaxify.thewire.processing_handler); 
