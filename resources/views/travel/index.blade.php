@extends('layouts.app')
@section('title','旅行日记')
@section('content')
    <div ng-app="baidumapApp" ng-controller="MainCtrl">
        <div id="map">

        </div>
        <div id="searchbox" class="clearfix">
            <div id="searchbox-container" ng-show="searchbox_toggle">
                <div id="sole-searchbox-content" class="searchbox-content">
                    <input id="sole-input" ng-model="sole_input" ng-change="input_change()" class="searchbox-content-common" type="text" name="word" autocomplete="off" maxlength="256" placeholder="搜地点、查公交、找路线" value="">
                    <div class="input-clear" ng-if="clear" ng-click="clear_input()" title="清空"></div>
                    <div ng-click="route_toggle()" class="searchbox-content-button right-button route-button loading-button" data-title="路线">
                    </div>
                </div>
                <div id="searchResultPanel" style="border:1px solid #C0C0C0;width:150px;height:auto; display:none;"></div>
            </div>
            <button id="search-button" data-title="搜索"></button>
            <div id="toast-wrapper">
                <div id="toast">
                    <img class="info-tip-img" src="http://webmap2.map.bdstatic.com/wolfman/static/common/images/transparent.gif" alt="">
                    <span class="info-tip-text"></span>
                </div>
            </div>
            <div id="route-searchbox-content" ng-class="route_type" class="searchbox-content route-searchbox-content"  ng-show="route_searchbox">
                <div class="route-header">
                    <div class="searchbox-content-common route-tabs">
                        <div class="tab-item bus-tab" data-index="bus" ng-click="show_bus()">
                            <i></i><span>公交</span>
                        </div>
                        <div class="tab-item drive-tab" data-index="drive"  ng-click="show_drive()">
                            <i></i><span>驾车</span>
                        </div>
                        <div class="tab-item walk-tab" data-index="walk"  ng-click="show_walk()">
                            <i></i><span>步行</span>
                        </div>
                        <div class="tab-item bike-tab" data-index="bike"  ng-click="show_bike()">
                            <i></i><span>骑行</span>
                        </div>
                        <div class="arrow-wrap"></div>
                    </div>
                    <div class="searchbox-content-button right-button cancel-button loading-button" data-title="关闭路线" data-tooltip="1" ng-click="route_toggle()">
                    </div>
                </div>
                <div class="routebox">
                    <div class="searchbox-content-common routebox-content">
                        <div class="routebox-revert" title="切换起终点" ng-click="route_revert()">
                            <div class="routebox-revert-icon">
                            </div>
                        </div>
                        <div class="routebox-inputs">
                            <div class="routebox-input route-start" >
                                <div class="route-input-icon"></div>
                                <input autocomplete="off" maxlength="256"  ng-change="start_input_change()" placeholder="输入起点或在图区上选点" id="route-start-input" type="text" value="" ng-model="route_start">
                                <div class="input-clear" title="清空" ng-if="route_start_clear" ng-click="clear_start_input()" ></div>
                                <div class="route-input-add-icon"></div>
                            </div>
                            <div class="routebox-input route-end" >
                                <div class="route-input-icon"></div>
                                <input autocomplete="off" maxlength="256" ng-change="end_input_change()" placeholder="输入终点" id="route-end-input" type="text" value="" ng-model="route_end">
                                <div class="input-clear" title="清空" ng-if="route_end_clear" ng-click="clear_end_input()"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="r-result"></div>
            </div>
        </div>

        {{--<div class="boxopt mark-active" ng-click="tool_toogle_box()">--}}
            {{--<span id="util_control" class="boxutils boxicon" ></span>--}}
            {{--<i class="boxtext" >工具</i><em class="active"></em>--}}
        {{--</div>--}}
        {{--<div class="detail-box"  ng-show="box_show">--}}
            {{--<ul id="boxul" class="boxinfo">--}}
                {{--<li class="map-measure" ng-click="measure()">--}}
                    {{--<span class="last measure"></span><i>测距</i>--}}
                {{--</li>--}}
                {{--<li class="map-measure" ng-click="get_latlng()">--}}
                    {{--<span class="latlng">+</span><i>获取坐标</i>--}}
                {{--</li>--}}
                <!--<li class="map-mark" ng-click="mark">-->
                <!--<span class="last mark"></span><i>标记</i>-->
                <!--</li>-->
                <!--<li class="map-share" ng-click="share"><span class="last share">-->
                <!--</span><i>分享</i>-->
                <!--</li>-->
            {{--</ul>--}}
        {{--</div>--}}
        <!--显示坐标-->
        {{--<div class="show-latlng" style="position:absolute ;bottom: 100px;right: 100px;" ng-hide="remove_latlng">--}}
        {{--<p>--}}
        {{--<span id="current_lat">纬度: {{current_lat}}</span>--}}
        {{--<span id="current_lng">经度: {{current_lng}}</span>--}}
        {{--<span class="remove_latlng" ng-click="hide_latlng()">--}}
        {{--<i class="glyphicon glyphicon-remove-circle"></i>--}}
        {{--</span>--}}
        {{--</p>--}}
        {{--</div>--}}
    </div>

@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/travel/main.css') }}">
    <link rel="stylesheet" href="https://api.map.baidu.com/library/SearchInfoWindow/1.5/src/SearchInfoWindow_min.css" />
    <style>
        .main-header{
            margin-bottom: 0;
        }
    </style>
@endsection

@section('script')
    {{--baidumap--}}
    <script type="text/javascript " src="https://api.map.baidu.com/api?v=2.0&ak=V5YM1CIwjDz2OEFTs4EAoPpv"></script>
    <script type="text/javascript" src="https://api.map.baidu.com/library/SearchInfoWindow/1.5/src/SearchInfoWindow_min.js"></script>
    <script src="/bower_components/angular/angular.js"></script>
    <script src="/bower_components/angular-animate/angular-animate.js"></script>
    <script src="/bower_components/angular-cookies/angular-cookies.js"></script>
    <script src="/bower_components/angular-resource/angular-resource.js"></script>
    <script src="/bower_components/angular-route/angular-route.js"></script>
    <script src="/bower_components/angular-sanitize/angular-sanitize.js"></script>
    <script src="/bower_components/jquery/dist/jquery.min.js"></script>

    <script src="{{ asset('/js/travel/map_config.js') }}"></script>
    <script src="{{ asset('/js/travel/controllers/main.js') }}"></script>
    {{--endbaidumap--}}
@endsection