/**
 * Create a new group
 * 
 * @param {number} guid
 * @class Represents a group
 * @extends ElggEntity
 * @property {string} name
 * @property {string} description
 */
elgg.ElggGroup = function(guid) {
	elgg.ElggEntity.call(this, guid);
};

elgg.inherit(elgg.ElggGroup, elgg.ElggEntity);


/**
 * Join the specified user to this group
 * @param {number} user_guid
 */
elgg.ElggGroup.prototype.join = function(user_guid) {
	return elgg.action('groups/join', {
		data: {
			group_guid: this.guid,
			user_guid: user_guid
		}
	});
};

/**
 * Make the logged in user leave the group
 */
elgg.ElggGroup.prototype.leave = function() {
	//TODO Implement
	throw new Error("Not yet implemented.");
};