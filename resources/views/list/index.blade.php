@extends('layouts.app')
@section('title','任务清单')
@section('content')
    <div class="container" ng-app="TodoApp">
        <div class="clearfix" ng-controller="MainCtrl">
            <div class="col-md-12 container">
                <h2>My todos</h2>
                <!--Todos input-->
                <form role="form" ng-submit="addTodo()">
                    <div class="row">
                        <div class="input-group">
                            <input type="text" ng-model="todo" placeholder="What needs to be done?" class="form-control">
                            <span class="input-group-btn">
                                <input type="submit" value="Add" class="btn btn-primary">
                            </span>
                        </div>
                    </div>
                </form>
                <p></p>
                <!--Todos List-->
                <!--ui-sortable p元素可以在 div ng-model="todos" 内实现移动-->
                <div ui-sortable ng-model="todos">
                    <p ui-sortable ng-repeat="todo in todos" class="input-group" style="padding: 5px 10px; cursor: move">
                        <input type="text" ng-model="todo" class="form-control">
                        <span class="input-group-btn">
                            <button class="btn btn-danger" ng-click="removeTodo($index)" aria-label="Remove">X</button>
                        </span>
                    </p>
                </div>
            </div>
        </div>
        <div class="container clearfix">
            <div class="list-item col-md-12 container">
                <div class="item col-md-4">
                    <div class="widget widget-default">
                        <div class="widget-header">
                            <h4 class="item-title">
                                这是标题
                                <span class="pull-right">
                              <button class="btn btn-success" ng-click="removeTodo($index)" aria-label="Remove"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-danger" ng-click="removeTodo($index)" aria-label="Remove"><i class="fa fa-close"></i></button>
                            </span>
                            </h4>
                        </div>
                        <div class="item-content widget-body " style=" height: 9em;overflow : hidden;text-overflow: ellipsis;display: -webkit-box;-webkit-box-orient: vertical;">
                            <p ui-sortable  class="input-group" style="padding: 5px 10px; cursor: move">
                                <input type="text" ng-model="todo" class="form-control">
                                <span class="input-group-btn">
                                <button class="btn btn-success" ng-click="removeTodo($index)" aria-label="Remove"><i class="fa fa-square-o"></i></button>
                                <button class="btn btn-success" ng-click="removeTodo($index)" aria-label="Remove"><i class="fa fa-check-square-o"></i></button>
                                <button class="btn btn-danger" ng-click="removeTodo($index)" aria-label="Remove"><i class="fa fa-close"></i></button>
                            </span>
                            </p>
                        </div>
                        <div class="widget-footer"></div>
                    </div>
                </div>
                <div class="item col-md-4">
                    <div class="widget widget-default">
                        <div class="widget-header">
                            <h4 class="item-title">
                                这是标题
                                <span class="pull-right">
                              <button class="btn btn-success" ng-click="removeTodo($index)" aria-label="Remove"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-danger" ng-click="removeTodo($index)" aria-label="Remove"><i class="fa fa-close"></i></button>
                            </span>
                            </h4>
                        </div>
                        <div class="item-content widget-body " style=" height: 9em;overflow : hidden;text-overflow: ellipsis;display: -webkit-box;-webkit-box-orient: vertical;">
                            <p ui-sortable  class="input-group" style="padding: 5px 10px; cursor: move">
                                <input type="text" ng-model="todo" class="form-control">
                                <span class="input-group-btn">
                                <button class="btn btn-success" ng-click="removeTodo($index)" aria-label="Remove"><i class="fa fa-square-o"></i></button>
                                <button class="btn btn-success" ng-click="removeTodo($index)" aria-label="Remove"><i class="fa fa-check-square-o"></i></button>
                                <button class="btn btn-danger" ng-click="removeTodo($index)" aria-label="Remove"><i class="fa fa-close"></i></button>
                            </span>
                            </p>
                        </div>
                        <div class="widget-footer"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('/bower_components/bootstrap/dist/css/bootstrap.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/list.css') }}">
@endsection

@section('script')
    <script src="{{ asset('bower_components/jquery/dist/jquery.js') }} "></script>
    <script src="{{ asset('bower_components/angular/angular.js') }}"></script>
    <script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.js') }}"></script>
    <script src="{{ asset('bower_components/angular-animate/angular-animate.js') }}"></script>
    <script src="{{ asset('bower_components/angular-cookies/angular-cookies.js') }}"></script>
    <script src="{{ asset('bower_components/angular-messages/angular-messages.js') }}"></script>
    <script src="{{ asset('bower_components/angular-resource/angular-resource.js') }}"></script>
    <script src="{{ asset('bower_components/angular-route/angular-route.js') }}"></script>
    <script src="{{ asset('bower_components/angular-sanitize/angular-sanitize.js') }}"></script>
    <script src="{{ asset('bower_components/angular-touch/angular-touch.js') }}"></script>
    <script src="{{ asset('bower_components/jquery-ui/jquery-ui.js') }}"></script>
    <script src="{{ asset('bower_components/angular-ui-sortable/sortable.js') }}"></script>
    <script src="{{ asset('bower_components/angular-local-storage/dist/angular-local-storage.js') }}"></script>

    <script src="{{ asset('js/list/app.js') }}"></script>
    <script src="{{ asset('js/list/controllers/main.js') }}"></script>
@endsection