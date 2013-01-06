define(function() {
	function Ajaxify($http) {
		this.$http = $http;
	}

	Ajaxify.prototype.getPage = function(url) {
		return this.$http.get(url, {
			params: {
				'view': 'ajaxify'
			}
		}).then(function(result) {
			return result.data;
		});
	};

	return Ajaxify;
});
