/**
 * Defines based ElggEntity objects
 * 
 * @param o
 */
elgg.ElggEntity = function(o) {

};

elgg.implement(elgg.ElggEntity, elgg.Notable);

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