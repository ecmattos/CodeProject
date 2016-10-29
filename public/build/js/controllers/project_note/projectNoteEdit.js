angular.module('app.controllers')
.controller('ProjectNoteEditController', 
	['$scope', '$location', '$routeParams', 'ProjectNote', 
	function($scope, $location, $routeParams, ProjectNote)
	{
		$scope.projectNote = ProjectNote.get({id: $routeParams.idNote});

		$scope.save = function()
		{
			if($scope.form.$valid)
			{
				ProjectNote.update({id: $scope.projectNote.id}, $scope.projectNote, function()
				{
					$location.path('/project/' + $scope.projectNote.project_id + '/notes');
				});
			}
		}
	}]);