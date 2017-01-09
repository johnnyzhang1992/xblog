@extends('layouts.app')
@section('title','读书')

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
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <div class="head-content">
                            <h2>{{ @$book->book_name }} <small>更新时间：{{ date('y-m-d',time($book->updated_at)) }}</small><small style="margin:0 5px">|</small><small>浏览量：{{ $book->view_count }}</small></h2>
                        </div>
                    </div>
                </div>
                <div class="book-detail col-md-12 col-xs-12 clearfix">
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
@endsection

@section('script')
    <script>
        //使用豆瓣API拿指定iD書籍的信息
        $.ajax({
            type: "get",
            url: "https://api.douban.com/v2/book/26356948",//最後一位是書籍id
            data: $(this).serialize(),
            async: false,
            dataType:'jsonp',
            jsonp: 'callback',
            success: function(data){
                console.info(JSON.stringify("id:"+data.id));
                console.info(JSON.stringify("alt:"+data.alt));
                console.info(JSON.stringify("alt_title:"+data.alt_title));
                console.info(JSON.stringify("title:"+data.title));
                console.info(JSON.stringify("原作名origin_title:"+data.origin_title));
                console.info(JSON.stringify("cover_image:"+data.image));
                console.info(JSON.stringify("author:"+data.author_intro));
                console.info(JSON.stringify("author_intro:"+data.author));
                console.info(JSON.stringify("简介summary:"+data.summary));
                console.info(JSON.stringify("序言catalog:"+data.catalog));
                console.info(JSON.stringify("pages:"+data.pages));
                console.info(JSON.stringify("translator:"+data.translator));
                console.info(JSON.stringify("评分:"+data.rating.average));
            },
            error: function (xhr,status,error) {
                console.info('');
            }
        });
    </script>

@endsection