angular.module('app.controller')
.controller('LoginController', ['$scope', '$location', 'OAuth', function($scope, $location, OAuth)
{
	$scope.user = {
		username: '',
		password: ''
	};

	$scope.login = function()
	{
		OAuth.getAccessToken($scope.user).then(function()
		{
			$location.path('home');
		}, function()
		{
			alert('Login inválido !');
		});
	};
}]);