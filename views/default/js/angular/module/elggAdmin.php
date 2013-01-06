// <script>
define(function(require) {
	var angular = require('angular');

	var elggAdmin = angular.module('elggAdmin', []);
	
	elggAdmin.service('elggAjaxify', require('elgg/Ajaxify'));
	elggAdmin.config(function($routeProvider, $locationProvider) {
		$locationProvider.html5Mode(true);
		$routeProvider.otherwise({
			template: '<div data-ng-bind-html-unsafe="content"></div>',
			controller: function($scope, $rootScope, elggPage) {
				$rootScope.elggPage = elggPage;
				$scope.content = elggPage.body.content;
			},
			resolve: {
				elggPage: require('angular/resolve/elggPage')
			}
		});
	});
	
	return elggAdmin;
})
