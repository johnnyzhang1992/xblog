'use strict';

/**
 * @ngdoc function
 * @name baidumapApp.controller:OthersCtrl
 * @description
 * # OthersCtrl
 * Controller of the baidumapApp
 */
angular.module('baidumapApp')
  .controller('OthersCtrl', function ($scope,$http) {
      $http.get('data/data.json')
          .success(function(response) {
              $scope.records = response.poi_data;
              $scope.title = "success";
          });
  });
