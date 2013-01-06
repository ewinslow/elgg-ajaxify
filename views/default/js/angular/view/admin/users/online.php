// <script>
define(function(require) {
	return {
		template: require('text!./online/template.html'),
		controller: function($rootScope, elggPage) {
			$rootScope.elggPage = elggPage;
		},
		resolve: {
			elggPage: function() {
				return {
					title: 'Users: Currently Online'
				};
			}
		}
	};
});
