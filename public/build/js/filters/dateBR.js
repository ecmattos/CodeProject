angular.module('app.filters').filter('dateBR', ['$filter', function($filter)
{
	return function(input)
	{
		return $filter('date')(input, 'dd/MM/yyyy');
	};
}]);