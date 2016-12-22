@extends('layouts.app')
@section('title','旅行日记')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/travel/main.css') }}">
    <link rel="stylesheet" href="http://api.map.baidu.com/library/SearchInfoWindow/1.5/src/SearchInfoWindow_min.css" />
    <link rel="stylesheet" href="{{ asset('/css/jquery.flexslider.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/travel/travel-detail.css') }}">
@endsection
@section('content')

    <div class="container" >
        {{--导航--}}
        <ol class="breadcrumb col-md-12">
            <li><a href="{{ url('/travel') }}">Travel</a></li>
            <li>{{@$poi->tag}}</li>
            <li class="active">{{@$poi->poi_name}}</li>
            @if(Auth::check())
                <li class="pull-right"><a href="{{ url('admin/poi/edit/'.$poi->id) }}" ><i class="fa fa-pencil"></i> 编辑</a></li>
            @else
            @endif
        </ol>
        {{--主要内容--}}
        <div class="poi-content clearfix">
            <div class="col-md-12 head-box">
                {{--顶部信息--}}
                <div class="poi-detail clearfix">
                    @if(isset($poi->cover_image))
                        <img src='{{ asset($poi->cover_image) }}' alt="..."  class="img-responsive" >
                    @else
                        <img src="{{ asset('/storage/images/travel/1bdd89d6fcb94845b0c89dd83b674dc9.jpeg')}}" class="img-responsive" >
                    @endif
                    {{--上传封面图片--}}
                    @if(Auth::check())
                        <a class="upload-cover-image" role="button" onclick="javascript:$('#modal-upload-image').modal();return false;"><i class="fa fa-camera"></i>上传封面图片</a>
                    @endif
                    <div class="head-content">
                        <h2>{{ @$poi->poi_name }} <small>更新时间：{{ date('y-m-d',time($poi->update_at)) }}</small><small style="margin:0 5px">|</small><small>浏览量：{{ $poi->view_count }}</small></h2>
                        <p>
                            <span class="fa fa-map-marker poi-icons"></span>
                            {{@$poi->address}}
                        </p>
                    </div>
                </div>
            </div>
            {{--左侧板块--}}
            <div class="content-left col-md-9 col-sm-9 col-xs-12">
                {{--基本信息--}}
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
                {{--轮播--}}
                <div class="poi-detail" style="padding: 0">
                    <div class="flexslider">
                        <ul class="slides">
                            @if(isset($img_list[0]))
                                @foreach($img_list as $mun=> $img)
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
                <div class="poi-detail clearfix">
                    <h4><span>旅行杂记</span></h4>
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
            <div class="content-right col-md-3 col-sm-3 col-xs-12">
                @include('travel.widget.side')
            </div>
        </div>

    </div>
    @if(Auth::check())
        <div class="modal fade  " id="modal-upload-image" role="dialog" aria-labelledby="gridSystemModalLabel">
            <div class="alert alert-warning alert-dismissible fade  alert-suc in" role="alert">
                <form action="{{ route('travel.upload.cover_image') }}"
                      role="form" class="form-horizontal" datatype="image"
                      enctype="multipart/form-data" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="image" class="col-xs-2 col-xs-offset-1 control-label">
                            上传到本地：<i class="fa fa-file-image-o fa-lg fa-fw"></i>
                        </label>
                        <div class="col-xs-6">
                            <input id="image" class="form-control" accept="image/*" type="file" name="image">
                            <input type="hidden" name="poi_id" value="{{ @$poi->id }}" >
                            <input type="hidden" name="user_id" value="{{ auth() ->user()->id}}" >
                        </div>
                        <div class="col-xs-2">
                            <button type="submit" class="btn btn-primary">
                                上传
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif
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