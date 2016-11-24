@extends('layouts.app')
@section('title','任务清单')
@section('content')
    <div class="container">
        {{--{{ auth()->user()->name  }}{{ auth()->user()->id }}--}}
        <div class="clearfix" >
            <div class="col-md-12 container">
                <h2>任务清单</h2>
                <form role="form"  action="{{ route('list.store') }}" method="post">
                    <div class="row">
                        <div class="input-group">
                            <input type="text" placeholder="What needs to be done?" name="list_title" class="form-control">
                            <span class="input-group-btn">
                                <input type="submit" value="Add" class="btn btn-primary">
                            </span>
                        </div>
                    </div>
                </form>
                <div ui-sortable>
                    <p ui-sortable  class="input-group" style="padding: 5px 10px; cursor: move">
                        <input type="text" ng-model="todo" class="form-control">
                        <span class="input-group-btn">
                            <button class="btn btn-danger" aria-label="Remove">X</button>
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
                            </h4>
                        </div>
                        <div class="item-content widget-body ">
                            <p ui-sortable  style="padding: 5px 10px; cursor: move"></p>
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
    <script>
    </script>
@endsection