'use strict';

/**
 * @ngdoc overview
 * @name yoTodoApp
 * @description
 * # yoTodoApp
 *
 * Main module of the application.
 */
angular
  .module('TodoApp', [
      'ngAnimate',
      'ngCookies',
      'ngMessages',
      'ngResource',
      'ngRoute',
      'ngSanitize',
      'ngTouch',
      'ui.sortable',
      'LocalStorageModule'
  ])
    .config(['localStorageServiceProvider',function (localStorageServiceProvider) {
        localStorageServiceProvider.setPrefix('ls');
    }])
    .config(function ($routeProvider) {
        $routeProvider
            .when('/', {
                templateUrl: '/views/main.html',
                controller: 'MainCtrl',
                controllerAs: 'main'
            })
            .when('/about',{
                templateUrl: 'views/about.html',
                controller: 'aboutController'
            })
            .otherwise({
                redirectTo: '/'
            });
    });

