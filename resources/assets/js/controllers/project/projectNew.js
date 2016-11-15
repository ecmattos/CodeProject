angular.module('app.controllers')
	.controller('ProjectNewController', 
		['$scope', '$location', '$cookies', 'Project', 'Client', 'appConfig', 
			function($scope, $location, $cookies, Project, Client, appConfig)
			{
				$scope.project = new Project();
				$scope.clients = Client.query();
				$scope.status = appConfig.project.status;
				
				$scope.save = function()
				{
					if($scope.form.$valid)
					{
						$scope.project.owner_id = $cookies.getObject('user').id;

						$scope.project.$save().then(function()
						{
							$location.path('/projects');
						});
					}
				};

				$scope.formatName = function(client_id)
				{
					if(client_id)
					{
						for(var i in $scope.clients)
						{
							if($scope.clients[i].client_id == client_id)
							{
								return $scope.clients[i].name;
							}
						}
					}
					return "";
				};

				$scope.getClients = function(name)
				{
					return Client.query(
						{
							search: name,
							searchFields: 'name:like' 
						}).$promise;
				};
			}
		]
	);