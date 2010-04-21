/**
 * ElggUser support
 */
elgg.ElggUser = function(o) {
	elgg.ElggEntity.call(this, o);
};

elgg.inherit(elgg.ElggUser, elgg.ElggEntity);

/**
 * Add the specified user as a friend of this user
 *
 * @param {Number} guid 
 */
elgg.ElggUser.prototype.addFriend = function(guid) {
 	elgg.api('friend.add', {
 		type: 'post',
 		data: {
 			guid: guid
 		}
 	});
};

/**
 * Remove the specified user as a friend of this user
 *
 * @param {Number} guid 
 */
elgg.ElggUser.prototype.removeFriend = function(guid) {
 	elgg.api('friend.remove', {
 		type: 'post',
 		data: {
 			guid: guid
 		}
 	});
};