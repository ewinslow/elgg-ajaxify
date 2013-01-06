// <script>
define(function(require) {
	return {
		template: require('text!./add/template.html'),
		controller: function($rootScope, elggPage) {
			$rootScope.elggPage = elggPage;
		},
		resolve: {
			elggPage: function() {
				return {
					title: 'Users: Add New User'
				};
			}
		}
	};
});
