/**
 * Create a new ElggObject
 *
 * @param {Object} o
 * @extends ElggEntity
 * @class Represents an ElggObject
 * @property {string} title
 * @property {string} description
 */
elgg.ElggObject = function(guid) {
	elgg.ElggEntity.call(this, o);
};

elgg.inherit(elgg.ElggObject, elgg.ElggEntity);