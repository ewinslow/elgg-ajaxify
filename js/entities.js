/**
 * Defines based ElggEntity objects
 * 
 * @param o
 */
elgg.ElggEntity = function(o) {
	for (var member in o) {
		this[member] = o[member];
	}
};

elgg.ElggEntity.prototype.update = function() {
	//update this entity with the latest data from the server
};

/**
 * Gets the human-readable subtype of this entity
 * @return {string} The subtype
 */
elgg.ElggEntity.prototype.getSubtype = function() {
	return elgg.subtypes[this.subtype];
};

elgg.implement(elgg.ElggEntity, elgg.Notable);

elgg.cache.entities = {};

//$(function() {
//	var result = {"object":[[{"guid":"2"}]]};
//
//	for (var type in result) {
//		var subtypes = result[type];
//		for (var subtype in subtypes) {
//			var entities = subtypes[subtype];
//			for (var i in entities) {
//				var className = elgg.getClass(type, subtype);
//				alert(className);
//				var entity = entities[i];
//				elgg.cache.entities[entity.guid] = new elgg[className](entity);
//			}
//		}
//	}
//
//	alert(elgg.cache.entities[2]);
//});

elgg.get_entity = function(guid) {
	var cached = elgg.cache.entities[guid];
	if (cached instanceof ElggEntity && !cached.isExpired()) {
		return cached;
	}
	
		
		
	var found = false;
	$.getJSON(elgg.config.wwwroot + 'export/json/' + guid, function(result) {
		if(result.exceptions) {
			for (var e in result.exceptions) {
				console.log(e);
			}
		} else {
			found = true;
			for (var type in result) {
				
			}
		}
	});
	//if pull from API succeeds
		//cache returned entity
		//return returned entity
		
	//return failure
};

/**
 * Delete an entity
 * 
 * @param guid The guid of the entity we want to delete
 * @return false Always make this the last action
 */
elgg.delete_entity = function(guid) {
	if (!confirm('Are you sure you want to delete this? There is no undo!')) {
		return false;
	}
	
	$entity = $('.entity.editable[data-guid='+guid+']');
	
	$entity.slideUp();
	
	elgg.ajax({
	    type: 'post',
	    url: elgg.config.wwwroot + 'action/ajax/entity/delete',
	    data: {
		    guid: guid
		},
		action: true,
		success: function(data) {
			elgg.system_message(data);
		},
		error: function(xhr) { // oops
			$entity.slideDown();
			elgg.register_error(xhr.responseText);
		}
	});

	return false;
};


$(function() {
	var feed = $('#announcements');
	
	$.getJSON(elgg.config.wwwroot + 'services/api/rest/json/', {
		method: 'announcements.get',
		opts: {
			container_guid: elgg.page_owner_guid,
			order_by: 'time_created ASC'
		}
	}, function(data) {
		var entities = data.result;
		for(var i in entities) {
			feed.prepend(entities[i].description);
		}
	});
});