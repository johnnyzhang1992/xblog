'use strict';

/**
 * @ngdoc function
 * @name baidumapApp.controller:ListCtrl
 * @description
 * # ListCtrl
 * Controller of the baidumapApp
 */
angular.module('baidumapApp')
    .controller('ListCtrl',function ($scope, $http) {
        $scope.hactive = false;
        $scope.lactive = true;
        $scope.cactive = false;
        $scope.orderProp = '';
        $http.get("data/data.json")
            .success(function(response) {$scope.poi_data = response.poi_data;});
  });
