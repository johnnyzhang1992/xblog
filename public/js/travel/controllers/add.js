'use strict';

/**
 * @ngdoc function
 * @name baidumapApp.controller:EditCtrl
 * @description
 * # EditCtrl
 * Controller of the baidumapApp
 */
angular.module('baidumapApp')
  .controller('AddCtrl', function ($scope, $http) {
      $http.get("data/data.json")
          .success(
              function(response) {
                  $scope.poi_data = response.poi_data;
                  $scope.id = response.poi_data.length+1;
              }
          );
      $scope.title = "添加一个新的足迹";
      $scope.addNewPoi = function () {
          var newPoi = {
              id:$scope.id,
              lat:$scope.lat,
              lng:$scope.lng,
              name:$scope.name,
              address:$scope.address,
              tag:$scope.tag,
              description:$scope.description
          };
              $http.post('/data/data.json',newPoi).success(function(){
                  console.log("success!");
              }).error(function(){
                  console.log("error");
              });
              // $http.post("data/data.json")
              //     .success(
              //         function(response) {
              //             $scope.poi_data = response.poi_data;
              //             $scope.poi = response.poi_data[$routeParams.id];
              //         }
              //     );
          };
  });
