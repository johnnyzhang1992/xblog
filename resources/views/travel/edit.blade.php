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
                    <form action="{{ route('travel.upload.images') }}"
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
                    <div class="flexslider">
                        <ul class="slides">
                            @if(isset($img_list[0]))
                                @foreach($img_list as $mun=>  $img)
                                    <li>
                                        <img src='{{ asset($img->uri) }}' alt="...">
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
                        <div class="form-group">
                            <label for="comment_info" class="control-label">评论信息</label>
                            <select style="margin-top: 5px" id="comment_info" name="comment_info" class="form-control">
                                <?php $comment_info = isset($poi) && $poi->configuration ? $poi->configuration->config['comment_info'] : ''?>
                                <option value="default" {{ $comment_info=='default'?' selected' : '' }}>默认</option>
                                <option value="force_disable" {{ $comment_info=='force_disable'?' selected' : '' }}>强制关闭</option>
                                <option value="force_enable" {{ $comment_info=='force_enable'?' selected' : '' }}>强制开启</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="comment_type" class="control-label">评论类型</label>
                            <select id="comment_type" name="comment_type" class="form-control">
                                <?php $comment_type = isset($poi) && $poi->configuration ? $poi->configuration->config['comment_type'] : ''?>
                                <option value="default" {{ $comment_type=='default'?' selected' : '' }}>默认</option>
                                <option value="raw" {{ $comment_type=='raw'?' selected' : '' }}>自带评论</option>
                                <option value="disqus" {{ $comment_type=='disqus'?' selected' : '' }}>Disqus</option>
                                <option value="duoshuo" {{ $comment_type=='duoshuo'?' selected' : '' }}>多说</option>
                            </select>
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
    <link rel="stylesheet" href="{{ asset('/css/jquery.flexslider.css') }}">
    <style>
        @media (min-width: 768px){
            .form-horizontal .control-label {
                text-align: left;
                margin-bottom: 0;
                padding-top: 7px;
            }
        }
        .flexslider{
            margin-bottom: 20px;
        }

    </style>
@endsection

@section('script')
    <script src="{{ asset('/js/summernote.min.js') }}"></script>
    <script src="{{ asset('/js/jquery.flexslider.min.js') }}"></script>
    <script>
        $("#description").summernote({
            height: 100 ,
            placeholder: '请输入内容...'
        });
        //轮播图
        $('.flexslider').flexslider({
            animation: "slide",
            start: function (slider) {
//           $('body').removeClass('loading');
            }
        });
    </script>
@endsection