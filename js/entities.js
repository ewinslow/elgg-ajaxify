/**
 * 
 */
elgg.provide('elgg.cache.entities');

/**
 * Create a new ElggEntity
 * 
 * @class Represents an ElggEntity
 * @property {number} guid
 * @property {string} type
 * @property {string} subtype
 * @property {number} owner_guid
 * @property {number} site_guid
 * @property {number} container_guid
 * @property {number} access_id
 * @property {number} time_created
 * @property {number} time_updated
 * @property {number} last_action
 * @property {string} enabled
 * 
 */
elgg.ElggEntity = function(guid) {
	this.guid = 0;
	this.type = "";
	this.subtype = "";
	this.owner_guid = elgg.get_loggedin_userid();
	this.site_guid = 0;
	this.container_guid = elgg.get_loggedin_userid();
	this.access_id = elgg.ACCESS_PRIVATE;
	this.time_created = 0;
	this.time_updated = 0;
	this.last_action = 0;
	this.enabled = '';

	if (guid) {
		this.load(guid);
	}
};

elgg.implement(elgg.ElggEntity, elgg.Notable);

/**
 * Load the entity's data from a json object
 */
elgg.ElggEntity.prototype.load = function() {
	//TODO Implement
	throw new Error("Not yet implemented.");
};

/**
 * Update this entity with the latest data from the server
 */
elgg.ElggEntity.prototype.update = function() {
	//TODO Implement
	throw new Error("Not yet implemented.");
};

/**
 * Push local data to the server for saving
 */
elgg.ElggEntity.prototype.save = function() {
	//TODO Implement
	throw new Error("Not yet implemented.");
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

elgg.get_entity = function(guid) {
	throw new Error("Not yet implemented");
	
	var cached = elgg.cache.entities[guid];
	if (cached instanceof ElggEntity && !cached.isExpired()) {
		return cached;
	}
	
		
		
	var found = false;
	elgg.getJSON('export/json/' + guid, function(result) {
		if(result.exceptions) {
			for (var e in result.exceptions) {
				console.log(result.exceptions[e]);
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
 * @return {XMLHttpRequest}
 */
elgg.delete_entity = function(guid) {
	if (guid < 1 || !confirm(elgg.echo('deleteconfirm'))) {
		return false;
	}
	
	$('.entity[data-guid='+guid+']').slideUp();
	
	return elgg.action('entity/delete', {guid: guid});
};