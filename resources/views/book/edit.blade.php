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
                                <input id="image" class="form-control" accept="image/gif,image/jpeg,image/jpg,image/png,image/svg" type="file" name="image">
                                <input type="hidden" name="book_id" value="{{ @$book->id }}" >
                                <input type="hidden" name="user_id" value="{{ auth() ->user()->id}}" >
                            </div>
                            <div class="col-xs-2">
                                <button type="submit" class="btn btn-primary">
                                    上传
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="book_cover_image center" style="text-align: center">
                        <img src="{{ asset(@$book->cover_image) }}" alt="{{ @$book->book_name }}">
                    </div>
                    <form role="form"  class="form-horizontal" action="/book/{{ @$book->id }}/update" method="post">
                        {{ csrf_field() }}
                        <!--名称-->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="name">书籍名称(Name)</label>
                                <div class="col-sm-10">
                                    <input  type="text" id="name" name="_book[book_name]" value="{{ @$book->book_name }}" class="form-control">
                                </div>
                            </div>
                            <!--作者-->
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="name">书籍作者</label>
                                <div class="col-sm-10">
                                    <input  type="text" id="name" name="_book[book_author]" value="{{ @$book->book_author }}" class="form-control">
                                </div>
                            </div>
                            <!--标签（Tag）-->
                            <div class="form-group">
                                <div class="col-sm-6" style="padding-left: 0">
                                    <label class="col-sm-4 control-label" for="tag">标签(Tag)</label>
                                    <div class="col-sm-8">
                                        <input  type="text" id="tag" name="_book[tag]" value="{{ @$book->tag }}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6" style="padding-left: 0">
                                    <label class="col-sm-4 control-label" for="tag">豆瓣书籍ID</label>
                                    <div class="col-sm-8">
                                        <input  type="text" id="tag" name="_book[douban_id]" value="{{ @$book->douban_id }}"  class="form-control">
                                    </div>
                                </div>
                            </div>
                            <!--地址-->
                            <div class="form-group">
                                <div class="col-sm-6" style="padding-left: 0">
                                    <label class="col-sm-4 control-label" for="lat">豆瓣地址</label>
                                    <div class="col-sm-8">
                                        <input  type="text" id="lat"  name="_book[douban_url]" value="{{ @$book->douban_url }}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6" style="padding-left: 0">
                                    <label class="col-sm-4 control-label" for="lng">Kindle地址</label>
                                    <div class="col-sm-8">
                                        <input  type="text" id="lng"  name="_book[kindle_url]"  value="{{ @$book->kindle_url }}" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="year">读书年份</label>
                                <div class="col-sm-4">
                                    <input  type="text" id="year" name="_book[year]"   value="{{ @$book->year }}"  class="form-control">
                                </div>
                                <label class="col-sm-2 control-label" for="status">读书进度</label>
                                <div class="col-sm-4">
                                    <select id="status" name="_book[status]" class="form-control">
                                        <option value="finish" {{ $book->status =='finish'?' selected' : '' }}>完成</option>
                                        <option value="active" {{ $book->status =='active'?' selected' : '' }}>进行中</option>
                                        <option value="abandon"{{ $book->status =='abandon'?' selected' : '' }}>放弃</option>
                                    </select>
                                </div>
                            </div>
                            {{--评论--}}
                            <div class="form-group">
                                <label for="comment_info" class="control-label col-sm-2">评论信息</label>
                                <div class="col-sm-4">
                                    <select style="margin-top: 5px" id="comment_info" name="comment_info" class="form-control ">
                                        <option value="default" >默认</option>
                                        <option value="force_disable" >强制关闭</option>
                                        <option value="force_enable" >强制开启</option>
                                    </select>
                                </div>
                                <label for="comment_type" class="control-label col-sm-2">评论类型</label>
                                <div class="col-md-4">
                                    <select id="comment_type" name="comment_type" class="form-control">
                                        <option value="default">默认</option>
                                        <option value="raw">自带评论</option>
                                        <option value="disqus">Disqus</option>
                                        <option value="duoshuo">多说</option>
                                    </select>
                                </div>
                            </div>
                            <!--描述-->
                            <div class="form-group">
                                <label class="control-label col-sm-2 " for="description">笔记</label>
                                <div class="col-sm-10">
                                    <textarea  rows="3" id="description"  name="_book[content]" class="form-control">{!! @$book->content !!}</textarea>
                                </div>
                            </div>
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
    <link rel="stylesheet" href="{{ asset('/css/summernote.css') }}">
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
    <script>
        $("#description").summernote({
            height: 100 ,
            placeholder: '请输入内容...'
        });
    </script>
@endsection