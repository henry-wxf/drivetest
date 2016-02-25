'use strict';

var app = angular.module('drivetest', [
  'ngRoute',
  'drivetest.home',
  'drivetest.exam'
]);

app.config(['$routeProvider', '$httpProvider', function($routeProvider, $httpProvider) {
    $routeProvider.when('/login', {
        templateUrl: 'login.html',
        controller: 'NavCtrl'
    }).otherwise({redirectTo: '/exam'});
  
    $httpProvider.defaults.headers.common["X-Requested-With"] = 'XMLHttpRequest';
}]);

app.factory('sessionService', function($http) {
    return $http.get('session.php').then(function(result) {
        return result.data; 
    });
});

app.controller('NavCtrl', ['$route', '$rootScope', '$scope', '$http', '$location', 'sessionService', 
  function($route, $rootScope, $scope, $http, $location, sessionService) {
    $scope.activeTab = function(route) {
        return $route.current && route === $route.current.controller;
    };

    sessionService.then(function(response){
      $rootScope.session = response;
    });
}]);
