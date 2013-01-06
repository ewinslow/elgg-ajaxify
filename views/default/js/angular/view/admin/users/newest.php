// <script>
define(function(require) {
	return {
		template: require('text!./newest/template.html'),
		controller: function($rootScope, elggPage) { 
			$rootScope.elggPage = elggPage;
		},
		resolve: require('./newest/resolve')
	};
});
