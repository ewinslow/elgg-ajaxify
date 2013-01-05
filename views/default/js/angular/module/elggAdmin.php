// <script>
define(function(require) {
    var angular = require('angular');
	
	var elggAdmin = angular.module('elggAdmin');
	
	elggAdmin.config(function($routeProvider) {
		$routeProvider.when('/admin/statistics/overview', require('angular/view/admin/statistics/overview/route'));
	});
	
	return elggAdmin;
})