// <script>
define(function(require) {
	return {
		template: require('text!./template.html'),
		controller: function($rootScope) { $rootScope.title = 'Users: Add New User'; }
	};
});
