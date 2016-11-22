@extends('layouts.app')
@section('title','任务清单')
@section('content')
    <div class="container" ng-app="TodoApp">
        <div class="col-md-8" ng-view=""></div>
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