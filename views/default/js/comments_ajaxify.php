elgg.provide('elgg.ajaxify.comments');
elgg.ajaxify.comments.init = function() {
	$('form[id^=comments-add-]').ajaxForm({
		beforeSubmit: function(arr, formObj, options) {
			elgg.trigger_hook('create:submit', 'comments', {'type': 'river'}, {
				'arr': arr,
				'formObj': formObj,
				'options': options,
			});
		},
		success: function(responseText, statusText, xhr, formObj) {
			elgg.trigger_hook('create:success', 'comments', {'type': 'river'}, {
				'responseText': responseText,
				'statusText': statusText,
				'xhr': xhr,
				'formObj': formObj,
			});
		},
		error: function(xhr, reqStatus) {
			elgg.trigger_hook('create:error', 'comments', {'type': 'river'}, {
				'reqStatus': reqStatus,
				'xhr': xhr,
			});
		},
	});
	$('form[name=elgg_add_comment]').ajaxForm({
		beforeSubmit: function(arr, formObj, options) {
			elgg.trigger_hook('create:submit', 'comments', {'type': 'plugin'}, {
				'arr': arr,
				'formObj': formObj,
				'options': options,
			});
		},
		success: function(responseText, statusText, xhr, formObj) {
			elgg.trigger_hook('create:success', 'comments', {'type': 'plugin'}, {
				'responseText': responseText,
				'statusText': statusText,
				'xhr': xhr,
				'formObj': formObj,
			});
		},
		error: function(xhr, reqStatus) {
			elgg.trigger_hook('create:error', 'comments', {'type': 'plugin'}, {
				'reqStatus': reqStatus,
				'xhr': xhr,
			});
		},
	});
};

elgg.ajaxify.comments.create_submit = function(hook, type, params, value) {
	if (params.type === 'river') {
		$(value.formObj).before(elgg.ajaxify.ajaxLoader);
		$(value.formObj).hide('fast');
	}
	if (params.type === 'plugin') {
		$(value.formObj).before(elgg.ajaxify.ajaxLoader);
	}
};

elgg.ajaxify.comments.create_success = function(hook, type, params, value) {
	if (params.type === 'river') {
		var guid = $(value.formObj).find('input[name=entity_guid]').val();
		elgg.view('annotations/getannotations', {
			cache: false,
			data: {
				'limit': 1,
				'annotation_name': 'generic_comment',
				'guid': guid,
			},
			success: function(response) {
				var comments_list = $(value.formObj).prevUntil('', 'ul.elgg-river-comments');
				var comments_len = $(comments_list).children().length;
				var annotations = $(response).find('.elgg-list-item');
				elgg.ajaxify.ajaxLoader.remove();
				if (comments_len) {
					if (comments_len < 3) {
						$(comments_list).append(annotations);
					} else {
						//Update the more counter
						var more_counter = $(value.formObj).prev('.elgg-river-more').find('a');
						if (more_counter.length !== 0) {
							var count  = parseInt($(more_counter).html().match(/\+(\d+)/)[1]) + 1;
							$(more_counter).html($(more_counter).html().replace(/\d+/, String(count)));
							$(comments_list).find('li:first').slideUp('fast');
							$(comments_list).find('li:first').remove();
						}
						$(comments_list).append(annotations);
					}
				} else {
					annotations = $(response);
					$(annotations).first().addClass('elgg-river-comments');
					$(value.formObj).before(annotations);
				}
				//Reset the form
				$(value.formObj).resetForm();
			},
		});
	}
	if (params.type === 'plugin') {
		var guid = $(value.formObj).find('input[name=entity_guid]').val();
		elgg.view('annotations/getannotations', {
			cache: false,
			data: {
				'limit': 1,
				'annotation_name': 'generic_comment',
				'guid': guid,
			},
			success: function(response) {
				var comments_list = $(value.formObj).prevUntil('', 'ul.elgg-annotation-list');
				var comments_len = $(comments_list).children().length;
				var annotations = $(response).find('.elgg-list-item');
				elgg.ajaxify.ajaxLoader.remove();
				if (comments_len) {
					$(comments_list).append(annotations);
				} else {
					annotations = $(response);
					$(value.formObj).before(annotations);
				}
				//Reset the form
				$(value.formObj).resetForm();
			}
		});
	}
};

elgg.ajaxify.comments.create_error = function(hook, type, params, value) {
	if (params.type === 'river') {
		//Restore the form for user to retry 
		$(elgg.ajaxify.ajaxLoader).next().show('fast');
		elgg.register_error(value.reqStatus);
		elgg.ajaxify.ajaxLoader.remove();
	}
};

elgg.register_hook_handler('init', 'system', elgg.ajaxify.comments.init);
elgg.register_hook_handler('create:success', 'comments', elgg.ajaxify.comments.create_success); 
elgg.register_hook_handler('create:submit', 'comments', elgg.ajaxify.comments.create_submit); 
elgg.register_hook_handler('create:error', 'comments', elgg.ajaxify.comments.create_error); 
