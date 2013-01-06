// <script>
define(function(require) {
	return {
		template: require('text!./overview/template.html'),
		controller: function($rootScope, elggPage) {
			$rootScope.elggPage = elggPage;
		},
		resolve: require('./overview/resolve')
	};
});
