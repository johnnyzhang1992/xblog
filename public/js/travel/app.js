'use strict';

/**
 * @ngdoc overview
 * @name baidumapApp
 * @description
 * # baidumapApp
 *
 * Main module of the application.
 */
angular
  .module('baidumapApp', [
    'ngAnimate',
    'ngCookies',
    'ngResource',
    'ngRoute',
    'ngSanitize'
  ])
  .config(function ($routeProvider) {
    $routeProvider
        .when('/', {
            templateUrl: 'views/main.html',
            controller: 'MainCtrl',
            controllerAs: 'main'
        })
        .when('/list', {
            templateUrl: 'views/list.html',
            controller: 'ListCtrl',
            controllerAs: 'list'
        })
        .when('/university/:id',{
            templateUrl: 'views/detail.html',
            controller: 'DetailCtrl'
        })
        .when('/spot/:id',{
            templateUrl: 'views/detail.html',
            controller: 'DetailCtrl'
        })
        .when('/add', {
          templateUrl: 'views/add.html',
          controller: 'AddCtrl',
          controllerAs: 'edit'
        })
        .when('/others', {
          templateUrl: 'views/others.html',
          controller: 'OthersCtrl',
          controllerAs: 'others'
        })
        .otherwise({
            redirectTo: '/'
        });
  });