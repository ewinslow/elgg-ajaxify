elgg.register_hook_handler('actions:success', 'thewire', 'elgg.ajaxify.thewire_success'); 
elgg.register_hook_handler('actions:processing', 'thewire', 'elgg.ajaxify.thewire_processing'); 

/**
* Handlers - There are three hooks for which the handlers can be bound: actions:success, actions:processing, actions:fail
* @example 
* elgg.ajaxify.thewire_success = function(hook, type, params, value) {
* 		//Check for type of success (Successful post or reply or anything else)
* 		//Update DOMs accordingly
* }
*
*/

elgg.ajaxify.thewire_success = function(hook, type, params, value) {
	if (params.type === 'thewire_add') {
		elgg.view('entities/getentity', {
			cache: false,
			data: {
				limit: '1',
				guid: value.entityGUID,
				subtype: 'thewire',
			},
			success: function(entities_list) {
				$('#thewire-textarea').val('');
				var entities = $(entities_list).find('.elgg-list-item');
				$('.elgg-entity-list').prepend(entities);
				elgg.ajaxify.removeLoading();
				$('#thewire-text-remaining span').html('140');
			},
		});
	}
};

elgg.ajaxify.thewire_processing = function(hook, type, params, value) {
	if (params.type === 'thewire_add') {
		elgg.ajaxify.showLoading({
			DOM: $('.elgg-entity-list'),
			manipulationMethod: 'prepend',
			width: '30px',
			height: '30px',
		});
		value.id = 'thewire-adding-post';
	}
};

elgg.ajaxify.thewire_add = function(item) {
	elgg.trigger_hook('actions:processing', 'thewire', {type: 'thewire_add'}, item);
	elgg.action('thewire/add', {
		data: {
			body: $('#thewire-textarea').val()
		},
		success: function(response) {
			elgg.trigger_hook('actions:success', 'thewire', {type: 'thewire_add'}, response);
		},
	});
};

//Incomplete
elgg.ajaxify.thewire_reply = function(item) {
	elgg.view($(item).find('a').attr('href'), {
		targetDOM: $(item).closest('.elgg-list-item'),
		manipulationMethod: 'append',
	});
};

