elgg.provide('elgg.ajaxify.thewire');

elgg.ajaxify.thewire.init = function() {
	$('#thewire-form-add').ajaxForm({
		beforeSubmit: function() {
				elgg.trigger_hook('create:submit', 'thewire', {type: 'thewire/add'}, null);
		},
		success: function(responseText) {
				elgg.trigger_hook('create:success', 'thewire', {type: 'thewire/add'}, responseText);
		},
	});
	$('.elgg-menu-item-reply').toggle(function() {
		elgg.ajaxify.thewire.show_replyForm(this);
		$(this).find('a').html('Close');
	}, function() {
		$(this).find('a').html('Reply');
		$(this).closest('.elgg-list-item').find('div[id^=elgg-reply-div]').slideUp('fast');
	});
};

/**
* Handlers - There are the hooks for which the handlers can be bound: (create|update|delete):(submit|success|error|complete), thewire
* @example 
* elgg.ajaxify.thewire.success = function(hook, type, params, value) {
* 		//Check for type of success (Successful post or reply or anything else)
* 		//Update DOMs accordingly
* }
*
*/

elgg.ajaxify.thewire.create_success = function(hook, type, params, value) {
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
				elgg.ajaxify.ajaxLoader.remove();
				elgg.thewire.textCounter($('#thewire-textarea'), $('#thewire-characters-remaining span'), 140);
			},
		});
	}
	if (params.type == 'thewire/reply') {
		elgg.view('entities/getentity', {
			cache: false,
			data: {
				limit: '1',
				guid: value.responseText.output.guid,	
				subtype: 'thewire',
			},
			success: function(entities_list) {
				var entities = $(entities_list).find('.elgg-list-item');
				$('.elgg-entity-list').prepend(entities);
				$(value.replyDiv).remove();
				elgg.ajaxify.ajaxLoader.remove();
				$(value.replyAnchor).html('Reply');
			},
		});
	}
};

elgg.ajaxify.thewire.create_submit = function(hook, type, params, value) {
	if (params.type === 'thewire/add') {
		$('.elgg-entity-list').prepend(elgg.ajaxify.ajaxLoader);
	}
	if (params.type === 'thewire/reply') {
		$(value.replyDiv).before(elgg.ajaxify.ajaxLoader);
		$(value.replyDiv).hide('fast');
	}
};

elgg.ajaxify.thewire.create_error = function(hook, type, params, value) {
	if (params.type === 'thewire/reply') {
		elgg.ajaxify.ajaxLoader.remove();
		elgg.register_error(value.reqStatus);
		$(value.replyDiv).show('fast');
	}

};


elgg.ajaxify.thewire.show_replyForm = function(item) {
	var urlParts = $(item).find('a').attr('href').split('/');
	var parent_guid = urlParts[urlParts.length - 1];
	
	elgg.view('thewire/thewire_reply', {
		data: {
			'guid': parent_guid,
		},
		success: function(response) {
			
			//Makeup for jQuery slideDown effect
			var replyDiv = document.createElement('div');
			$(replyDiv).attr('id', 'elgg-reply-div-'+parent_guid);
			$(replyDiv).html(response);
			$(replyDiv).css('display', 'none');
			$(item).closest('.elgg-list-item').append(replyDiv);

			$(replyDiv).slideDown('fast');
			$(replyDiv).find('textarea').focus();

			//Makes the reply form submit via XHR
			$(replyDiv).find('form[id^=thewire-form-reply]').ajaxForm({
				beforeSubmit: function() {
					elgg.trigger_hook('create:submit', 'thewire', {type: 'thewire/reply'}, {replyDiv: $(replyDiv)});
				},
				success: function(responseText) {
					elgg.trigger_hook('create:success', 'thewire', {type: 'thewire/reply'}, {
						responseText: responseText,
						replyDiv: $(replyDiv),
						replyAnchor: item,
					});
				},
				error: function(xhr, reqStatus) {
					elgg.trigger_hook('create:error', 'thewire', {type: 'thewire/reply'}, {
						replyDiv: $(replyDiv),
						reqStatus: reqStatus,
					});
				},
			});
		},
	});
};

elgg.register_hook_handler('create:success', 'thewire', elgg.ajaxify.thewire.create_success); 
elgg.register_hook_handler('create:submit', 'thewire', elgg.ajaxify.thewire.create_submit); 
elgg.register_hook_handler('create:error', 'thewire', elgg.ajaxify.thewire.create_error); 
elgg.register_hook_handler('init', 'system', elgg.ajaxify.thewire.init);
