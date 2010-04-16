/**
 * ElggGroup support
 */
elgg.ElggGroup = function(o) {
	elgg.ElggEntity.call(this, o);
};

elgg.inherit(elgg.ElggGroup, elgg.ElggEntity);