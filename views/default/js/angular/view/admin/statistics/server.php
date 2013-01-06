// <script>
define(function(require) {
	return {
		template: require('text!./server/template.html'),
		controller: function($rootScope, elggPage) {
			$rootScope.elggPage = elggPage;
		},
		resolve: require('./server/resolve')
	};
});
