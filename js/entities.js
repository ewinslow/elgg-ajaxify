/**
 * Defines base ElggEntity objects
 * 
 * @param o
 */
elgg.ElggEntity = function(o) {
	for (var member in o) {
		this[member] = o[member];
	}
};

elgg.implement(elgg.ElggEntity, elgg.Notable);

/**
 * ElggEntity.update
 * Update this entity with the latest data from the server
 * 
 * @return void
 */
elgg.ElggEntity.prototype.update = function() {
	//TODO
};

/**
 * ElggEntity.deleteEntity
 * Delete this entity
 * 
 * @return void
 */
elgg.ElggEntity.prototype.deleteEntity = function() {
	return elgg.delete_entity(this.guid);
};

elgg.cache.entities = {};

elgg.get_entity = function(guid) {
	throw new Error("Not yet implemented");
	
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
	if (!confirm(elgg.echo('delete:confirm'))) {
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