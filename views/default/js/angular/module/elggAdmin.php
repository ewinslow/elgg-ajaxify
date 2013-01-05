// <script>
define(function(require) {
	var angular = require('angular');

	var elggAdmin = angular.module('elggAdmin', []);
	
	elggAdmin.config(function($routeProvider, $locationProvider) {
		$locationProvider.html5Mode(true);
		$routeProvider.when('/admin/statistics/overview', require('angular/view/admin/statistics/overview/route'));
		$routeProvider.when('/admin/statistics/server', require('angular/view/admin/statistics/server/route'));
		$routeProvider.when('/admin/users/add', require('angular/view/admin/users/add/route'));
		$routeProvider.otherwise({ template: 'Hello, World!', controller: function() {}});
	});
	
	return elggAdmin;
})
