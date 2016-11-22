'use strict';

/**
 * @ngdoc function
 * @name yoTodoApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the yoTodoApp
 */
angular.module('TodoApp')
  .controller('MainCtrl', function ($scope,localStorageService) {
  // .controller('MainCtrl', function ($scope) {
      $scope.todos = [];
      var todosInStore = localStorageService.get('todos');
      $scope.todos = todosInStore && todosInStore.split('\n') || [];
      $scope.$watch('todos',function () {
          localStorageService.add('todos',$scope.todos.join('\n'));
      },true);
      $scope.addTodo = function () {
          $scope.todos.push($scope.todo);
          $scope.todo = '';
      };
      $scope.removeTodo = function (index) {
          $scope.todos.splice(index,1);
      };
  });
