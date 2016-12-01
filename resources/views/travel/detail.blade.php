@extends('layouts.app')
@section('title','旅行日记')
@section('content')

    <div class="container" >
        <div class="col-md-offset-1 col-md-10 col-xs-12" style="padding-top: 60px">
            <div class="panel panel-default">
                @if(Auth::check())
                <div class="panel-heading">
                    <h4 class="panel-title">{{@$poi->poi_name}}</h4>
                </div>
                <div class="panel-body">
                    <form role="form"  class="form-horizontal">
                        <!--标签（Tag）-->
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="tag">标签(Tag)</label>
                            <div class="col-sm-10">
                                <input  type="text" id="tag" ng-model="tag" placeholder="{{@$poi->tag}}" class="form-control">
                            </div>
                        </div>
                        <!--经纬度（LatLng）-->
                        <div class="form-group">
                            <div class="col-sm-6">
                                <label class="col-sm-4 control-label" for="lat">经度(Lat)</label>
                                <div class="col-sm-8">
                                    <input  type="text" id="lat" ng-model="lat" placeholder="{{@$poi->lat}}" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="col-sm-4 control-label" for="lng">纬度(Lng)</label>
                                <div class="col-sm-8">
                                    <input  type="text" id="lng" ng-model="lng" placeholder="{{@$poi->lng}}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <!--名称-->
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="name">名称(Name)</label>
                            <div class="col-sm-10">
                                <input  type="text" id="name" ng-model="name" placeholder="{{@$poi->poi_name}}" class="form-control">
                            </div>
                        </div>
                        <!--地址(Address)-->
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="address">地址(Address)</label>
                            <div class="col-sm-10">
                                <input  type="text" id="address" ng-model="address " placeholder="{{@$poi->address}}" class="form-control">
                            </div>
                        </div>
                        <!--描述-->
                        <div class="form-group">
                            <label class="col-sm-2 " for="description">描述(Description)</label>
                            <div class="col-sm-10">
                                <textarea  rows="3" id="description" ng-model="description" placeholder="{{@$poi->description}}" class="form-control"></textarea>
                            </div>
                        </div>
                        <button type="submit"  ng-click="savePoi()" class="btn btn-success btn-lg" style="width: 100%;">保存</button>
                    </form>
                </div>
                @else
                    <div class="panel-heading">
                        <p class="panel-title">{{@$poi->poi_name}}</p>
                    </div>
                    <div class="panel-body">
                        <!--标签（Tag）-->
                        <div class="col-md-12 col-sm-12">
                            <p class="col-sm-2 ">标签(Tag)</p>
                            <div class="col-sm-10">
                                <p>{{@$poi->tag}}</p>
                            </div>
                        </div>
                        <!--经纬度（LatLng）-->
                        <div class="col-md-12 col-sm-12">
                            <div class="col-sm-6">
                                <p class="col-sm-4 ">经度(Lat)</p>
                                <div class="col-sm-8">
                                    <p>{{@$poi->lat}}</p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <p class="col-sm-4 ">纬度(Lng)</p>
                                <div class="col-sm-8">
                                    <p>{{@$poi->lng}}</p>
                                </div>
                            </div>
                        </div>
                        <!--名称-->
                        <div class="col-md-12 col-sm-12">
                            <p class="col-sm-2 ">名称(Name)</p>
                            <div class="col-sm-10">
                                <p>{{@$poi->poi_name}}</p>
                            </div>
                        </div>
                        <!--地址(Address)-->
                        <div class="col-md-12 col-sm-12">
                            <p class="col-sm-2 " >地址(Address)</p>
                            <div class="col-sm-10">
                                <p>{{@$poi->address}}</p>
                            </div>
                        </div>
                        <!--描述-->
                        <div class="col-md-12 col-sm-12">
                            <p class="col-sm-2">描述(Description)</p>
                            <div class="col-sm-10">
                                <p>{!! @$poi->description !!}</p>
                            </div>
                        </div>

                    </div>
                @endif
                <div class="panel-footer">
                    <a href="{{ url('/travel') }}">返回首页</a>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/travel/main.css') }}">
    <link rel="stylesheet" href="http://api.map.baidu.com/library/SearchInfoWindow/1.5/src/SearchInfoWindow_min.css" />
@endsection

@section('script')

@endsection