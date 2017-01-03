@extends('layouts.app')
@section('title','书籍-'.@$book->book_name)
@section('content')

    <div class="container" >
        <div class="col-md-12 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">{{@$book->book_name}}</h4>
                </div>
                <div class="panel-body">
                    <form action="{{ route('book.upload.cover_image') }}"
                          role="form" class="form-horizontal" datatype="image"
                          enctype="multipart/form-data" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="image" class="col-xs-2 col-xs-offset-1 control-label">
                                上传到本地：<i class="fa fa-file-image-o fa-lg fa-fw"></i>
                            </label>
                            <div class="col-xs-6">
                                <input id="image" class="form-control" accept="image/*" type="file" name="image">
                                <input type="hidden" name="poi_id" value="{{ @$book->id }}" >
                                <input type="hidden" name="user_id" value="{{ auth() ->user()->id}}" >
                            </div>
                            <div class="col-xs-2">
                                <button type="submit" class="btn btn-primary">
                                    上传
                                </button>
                            </div>
                        </div>
                    </form>
                    <form role="form"  class="form-horizontal" action="/book/{{ @$book->id }}/update" method="post">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-success btn-lg" style="width: 100%;">保存</button>
                    </form>
                </div>
                <div class="panel-footer">
                    <a href="{{ url('/book') }}">返回首页</a>
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