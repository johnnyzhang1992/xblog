@extends('layouts.app')
@section('title','旅行日记')
@section('content')

    <div class="container" >
        <div class="col-md-12 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">{{@$poi->poi_name}}</h4>
                </div>
                <div class="panel-body">
                    <form role="form"  class="form-horizontal" action="/travel/poi/{{ $poi->id }}/update" method="post">
                    {{ csrf_field() }}
                    <!--标签（Tag）-->
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="tag">标签(Tag)</label>
                            <div class="col-sm-10">
                                <input  type="text" id="tag" ng-model="tag" name="_poi[tag]" value="{{@$poi->tag}}" class="form-control">
                            </div>
                        </div>
                        <!--经纬度（LatLng）-->
                        <div class="form-group">
                            <div class="col-sm-6" style="padding-left: 0">
                                <label class="col-sm-4 control-label" for="lat">经度(Lat)</label>
                                <div class="col-sm-8">
                                    <input  type="text" id="lat" ng-model="lat" name="_poi[lat]" value="{{@$poi->lat}}" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6" style="padding-left: 0">
                                <label class="col-sm-4 control-label" for="lng">纬度(Lng)</label>
                                <div class="col-sm-8">
                                    <input  type="text" id="lng" ng-model="lng" name="_poi[lng]" value="{{@$poi->lng}}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <!--名称-->
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="name">名称(Name)</label>
                            <div class="col-sm-10">
                                <input  type="text" id="name" ng-model="name" name="_poi[poi_name]" value="{{@$poi->poi_name}}" class="form-control">
                            </div>
                        </div>
                        <!--地址(Address)-->
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="address">地址(Address)</label>
                            <div class="col-sm-10">
                                <input  type="text" id="address" ng-model="address " name="_poi[address]" value="{{@$poi->address}}" class="form-control">
                            </div>
                        </div>
                        <!--描述-->
                        <div class="form-group">
                            <label class="col-sm-2 " for="description">描述(Description)</label>
                            <div class="col-sm-10">
                                <textarea  rows="3" id="description" ng-model="description" name="_poi[description]" class="form-control">{{@$poi->description}}</textarea>
                            </div>
                        </div>
                        <button type="submit"  ng-click="savePoi()" class="btn btn-success btn-lg" style="width: 100%;">保存</button>
                    </form>
                </div>
                <div class="panel-footer">
                    <a href="{{ url('/travel') }}">返回首页</a>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/travel/main.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/summernote.css') }}">
    <link rel="stylesheet" href="http://api.map.baidu.com/library/SearchInfoWindow/1.5/src/SearchInfoWindow_min.css" />
    <style>
        @media (min-width: 768px){
            .form-horizontal .control-label {
                text-align: left;
                margin-bottom: 0;
                padding-top: 7px;
            }
        }

    </style>
@endsection

@section('script')
    <script src="{{ asset('/js/summernote.min.js') }}"></script>
    <script>
        $("#description").summernote({
            height: 100 ,
            placeholder: '请输入内容...'
        });
    </script>
@endsection