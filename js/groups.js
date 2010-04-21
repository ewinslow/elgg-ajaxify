/**
 * ElggGroup
 * 
 * @param {Object} o
 * @base ElggEntity
 * @constructor
 */
elgg.ElggGroup = function(o) {
	elgg.ElggEntity.call(this,o);
};

elgg.inherit(elgg.ElggGroup, elgg.ElggEntity);


/**
 * Join the logged in user to a group
 */
elgg.ElggGroup.prototype.join = function() {
	var _this = this;
 	elgg.api('group.join', {
 		type: 'post',
 		data: {
	 		guid: _this.guid
 		}
 	});
};

/**
 * Make the logged in user leave the group
 */
elgg.ElggGroup.prototype.leave = function() {
	var _this = this;
 	elgg.api('group.leave', {
 		type: 'post',
 		data: {
	 		guid: _this.guid
 		}
 	});
};