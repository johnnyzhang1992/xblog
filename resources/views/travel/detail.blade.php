@extends('layouts.app')
@section('title','旅行日记')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/travel/main.css') }}">
    <link rel="stylesheet" href="http://api.map.baidu.com/library/SearchInfoWindow/1.5/src/SearchInfoWindow_min.css" />
    <link rel="stylesheet" href="{{ asset('/css/jquery.flexslider.css') }}">
    <style>
        .flexslider{
            margin-bottom: 20px;
        }
        .poi-detail{
            background: #fff;
            padding: 20px 15px;
            margin-bottom: 15px;
            border-radius:5px ;
            position: relative;
            box-shadow: 1px 1px 3px #666;
            -moz-box-shadow: 1px 1px 3px #666;
            -webkit-box-shadow: 1px 1px 3px #666;
        }
        .poi-detail h2{
            margin-top: 5px;
            margin-bottom: 10px;
        }
        .poi-detail h4 span{
            margin-top: 5px;
            border-left: 3px solid #43ce7b;
            padding-left: 10px;
        }
        .poi-icons{
            margin-right: 5px;
        }
    </style>
@endsection
@section('content')

    <div class="container" >
        <div class="col-md-12 col-xs-12">
            <div class="col-xs-12">
                <ol class="breadcrumb col-md-12">
                    <li><a href="{{ url('/travel') }}">Travel</a></li>
                    <li>{{@$poi->tag}}</li>
                    <li class="active">{{@$poi->poi_name}}</li>
                    @if(Auth::check())
                        <li class="pull-right"><a href="{{ url('admin/poi/edit/'.$poi->id) }}" ><i class="fa fa-pencil"></i> 编辑</a></li>
                    @else
                    @endif
                </ol>
                <div class="poi-content clearfix">
                    <div class="col-md-12">
                        <div class="poi-detail clearfix">
                            <h2>{{ @$poi->poi_name }}</h2>
                            <p>
                                <span class="fa fa-map-marker poi-icons"></span>
                                {{@$poi->address}}
                            </p>
                        </div>
                        <div class="poi-detail" style="padding: 0">
                            <div class="flexslider">
                                <ul class="slides">
                                    @if(isset($img_list[0]))
                                        @foreach($img_list as $mun=>  $img)
                                            <li>
                                                <img src='{{ asset($img->uri) }}' alt="..."  class="img-responsive" >
                                            </li>
                                        @endforeach
                                    @else
                                        <li>
                                            <img src="{{ asset('/storage/images/travel//1bdd89d6fcb94845b0c89dd83b674dc9.jpeg')}}" class="img-responsive" >
                                        </li>
                                        <li>
                                            <img src="{{ asset('/storage/images/4784572e91c0c539e7141598b483d523.jpeg')}}" class="img-responsive">
                                        </li>
                                        <li>
                                            <img src="{{ asset('/storage/images/3ed735417518e1f7e7964c091607e27c.jpeg')}}" class="img-responsive">
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="content-left col-md-9 com-sm-9 col-xs-12">
                        <div class="poi-detail clearfix">
                            <h4><span>基本信息</span></h4>
                            <div class="col-md-6 col-xs-12">
                                <table class="table table-striped table-hover">
                                    <tr>
                                        <td >经度(Lat)</td>
                                        <td>{{@$poi->lat}}</td>
                                    </tr>
                                    <tr>
                                        <td>纬度(Lng)</td>
                                        <td>{{@$poi->lng}}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="poi-detail clearfix">
                            <h4><span>基本介绍</span></h4>
                            <!--描述-->
                            <div class="col-md-12 col-sm-12">
                                <div class="col-sm-10">
                                    @if(!empty($poi->description))
                                        <p>{!! @$poi->description !!}</p>
                                    @else
                                        <p>暂无内容</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection


@section('script')
    <script src="{{ asset('/js/jquery.flexslider.min.js') }}"></script>
    <script>
        //轮播图
        $('.flexslider').flexslider({
            animation: "slide",
            start: function (slider) {
//           $('body').removeClass('loading');
            }
        });
    </script>
@endsection