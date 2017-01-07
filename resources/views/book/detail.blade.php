@extends('layouts.app')
@section('title','旅行日记')

@section('css')
    <style>

    </style>
@endsection
@section('content')

    <div class="container" >
        {{--导航--}}
        <ol class="breadcrumb col-md-10 col-md-offset-1 col-xs-12">
            <li><a href="{{ url('/book') }}">书籍</a></li>
            {{--<li>{{@$book->tag}}</li>--}}
            <li class="active">{{@$book->book_name}}</li>
            @if(Auth::check())
                <li class="pull-right"><a href="{{ url('admin/book/edit/'.$book->id) }}" ><i class="fa fa-pencil"></i> 编辑</a></li>
            @endif
        </ol>
        {{--主要内容--}}
        <div class="book-content col-md-10 col-md-offset-1 col-xs-12 clearfix">
            {{--左侧板块--}}
            <div class="content-left col-md-12  col-sm-12 col-xs-12">
                {{--基本信息--}}
                <div class="book-detail col-md-12 clearfix">
                    <h4><span>基本信息</span></h4>
                    <div class="col-md-6 col-xs-12">
                        @if(isset($book->cover_image))
                            <img src='{{ asset(@$book->cover_image) }}' alt="{{ @$book->book_name."封面" }}"  class="img-responsive" >
                        @endif
                        {{--上传封面图片--}}
                        @if(Auth::check())
                            <a class="upload-cover-image" role="button" onclick="javascript:$('#modal-upload-image').modal();return false;"><i class="fa fa-camera"></i>上传封面图片</a>
                        @endif
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <div class="head-content">
                            <h2>{{ @$book->book_name }} <small>更新时间：{{ date('y-m-d',time($book->updated_at)) }}</small><small style="margin:0 5px">|</small><small>浏览量：{{ $book->view_count }}</small></h2>

                        </div>
                    </div>
                </div>
                <div class="book-detail clearfix">
                    <h4><span>读书杂记</span></h4>
                    <!--描述-->
                    <div class="book-detail-content">
                        {!! @$book->content !!}
                    </div>
                </div>
                @if(!(isset($preview) && $preview))
                    <?php
                    $configuration =  null;
                    if (!$configuration) {
                        $configuration = [];
                        $configuration['comment_info'] = 'default';
                        $configuration['comment_type'] = 'default';
                    }
                    ?>
                    @if($configuration['comment_info'] != 'force_disable' && ($configuration['comment_info'] == 'force_enable' || !isset($comment_type) || $comment_type != 'none'))
                        <div class="row">
                            <div id="comment-wrap" class="col-md-12  col-sm-12 col-sm-12-no-padding">
                                @include('widget.comment',[
                                'comment_key'=>$book->book_name,
                                'comment_title'=>$book->book_name,
                                'comment_url'=>url("/book/".$book->id),
                                'commentable'=>$book,
                                'commentable_config'=>$configuration['comment_type'],
                                'redirect'=>request()->fullUrl(),
                                 'commentable_type'=>'App\Book'])
                            </div>
                        </div>
                    @endif
                @endif
            </div>
            {{--<div class="content-right col-md-3 col-sm-3 col-xs-12">--}}

            {{--</div>--}}
        </div>

    </div>
    @if(Auth::check())
        <div class="modal fade  " id="modal-upload-image" role="dialog" aria-labelledby="gridSystemModalLabel">
            <div class="alert alert-warning alert-dismissible fade  alert-suc in" role="alert">
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
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id}}" >
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