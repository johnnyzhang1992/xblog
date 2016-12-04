@extends('layouts.app')
@section('title','旅行日记')
@section('content')

    <div class="container" >
        <div class="col-md-offset-1 col-md-10 col-xs-12">
            <div class="panel panel-default">
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
                        <div class="col-sm-6" style="padding-left: 0">
                            <p class="col-sm-4 ">经度(Lat)</p>
                            <div class="col-sm-8">
                                <p>{{@$poi->lat}}</p>
                            </div>
                        </div>
                        <div class="col-sm-6" style="padding-left: 0">
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

@endsection