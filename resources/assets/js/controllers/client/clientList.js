angular.module('app.controllers')
.controller('ClientListController', ['$scope', 'Client', '$resource', function($scope, Client, $resource)
{
	$scope.clients = Client.query();
}]);