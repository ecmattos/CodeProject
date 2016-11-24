angular.module('app.controllers')
.controller('ProjectListController', [
	'$scope', '$routeParams', 'Project', 'appConfig',
	function($scope, $routeParams, Project, appConfig)
	{
		$scope.projects = Project.query();
		$scope.status = appConfig.project.status
	}
]);
