elgg.config.site;

/**
 * Create a new ElggSite
 *
 * @param {number|Object} guid
 * @extends ElggEntity
 * @class Represents an ElggSite
 * @property {string} name
 * @property {string} description
 * @property {string} url
 */
elgg.ElggSite = function(guid) {
	elgg.ElggEntity.call(this, guid);
};

elgg.inherit(elgg.ElggSite, elgg.ElggEntity);

