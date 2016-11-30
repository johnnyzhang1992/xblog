/**
 * Created by zq199 on 2016/9/4.
 */
'use strict';
angular.module('baidumapApp')
    .controller('HeaderCtrl',function ($scope) {
        // $scope.hactive = true;
        // $scope.lactive = false;
        // $scope.cactive = false;
        $scope.h_active = function () {
            $scope.hactive = true;
            $scope.lactive = false;
            $scope.cactive = false;
        };
        $scope.l_active = function () {
            $scope.hactive = false;
            $scope.lactive = true;
            $scope.cactive = false;
        };
        $scope.c_active = function () {
            $scope.hactive = false;
            $scope.lactive = false;
            $scope.cactive = true;
        }
    });