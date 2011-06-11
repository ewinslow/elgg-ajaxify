elgg.ajaxify.likes = function(item) {
	var entityGUID = elgg.ajaxify.getGUIDFromMenuItem(item);
	elgg.action(actionURL, {
		success: function() {
			elgg.view('likes/display', {
				data: {
					'guid': entityGUID
				}, 
				target: $(item),
			});
		}
	});
};
