/**
 * ElggObject support
 */
elgg.ElggObject = function(o) {
	elgg.ElggEntity.call(this, o);
};

elgg.inherit(elgg.ElggObject, elgg.ElggEntity);