define(function() {
	return function(elggAjaxify, $location) {
		return elggAjaxify.getPage($location.url());
	};
});
