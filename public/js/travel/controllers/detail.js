/**
 * Created by zq199 on 2016/9/4.
 * Detail.html controller
 */
'use strict';
angular.module('baidumapApp')
    .controller('DetailCtrl',function ($scope, $http,$routeParams) {
        $http.get("data/data.json")
            .success(
                function(response) {
                    $scope.poi_data = response.poi_data;
                    $scope.poi = response.poi_data[$routeParams.id];
                }
            );
        var newPoi = {
            "id":$scope.id,
            "lat":$scope.lat,
            "lng":$scope.lng,
            "name":$scope.name,
            "address":$scope.address,
            "tag":$scope.tag,
            "description":$scope.description
        };
        $scope.savePoi = function () {
            $http.post('data/data.json',newPoi)
                .success(function(){
                    console.log("success!");
                })
                .error(function(){
                    console.log("error");
                });
        };

    });