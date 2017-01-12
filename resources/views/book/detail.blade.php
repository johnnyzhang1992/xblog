@extends('layouts.app')
@section('title','读书')

@section('css')
    <style>
        .breadcrumb{
            margin-bottom: 0;
        }
        .book-content,.content-left,.book-detail{
            padding:0;
        }
        .book-name{
            padding: 0 15px;
        }
        .book_cover_image{
            float: left;
        }
        .book_cover_image img{
            width: 150px;
        }
        .book-info{
            float: left;
            padding-left:15px ;
        }
        .book-detail h4 {
            color: #42c37b;
            font-size: 20px;
            border-left: 4px solid #43ce7b;
            padding-left: 10px;
        }
        .rating-content{
            border-left: 1px solid #ddd;
        }
        .book-douban-rating{
            font-size: 25px;
            margin-left: 10px;
        }
        .comment-content,#comment-wrap{
            padding: 0;
        }

        @media(max-width:768px){
            .rating-content{
                margin-top: 20px;
            }
        }
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
                <div id="book-detail" class="book-detail col-md-12 clearfix">
                    <h4 class="book-name"><span>{{ @$book->book_name }}</span></h4>
                    <div class="col-md-8 col-xs-12">
                        <div class="book_cover_image">
                            <img id="cover_image" src="{{ asset(@$book->cover_image) }}" alt="{{ @$book->book_name."封面" }}"  class="img-responsive" >
                        </div>
                        <div class="book-info">
                            <p class="p1">
                                 作者: <a  href="#" class="book-douban-url"><span class="book-author">[英]克莱儿·麦克福尔</span></a>
                            </p>
                            <p class="pl">出版社: <span class="book-publisher">百花洲文艺出版社</span></p>
                            <p class="pl">原作名: <span class="origin-title">Ferryman</span></p>
                            <p>
                                <span class="pl"> 译者</span>:
                                <span class="book-translator">付强</span>
                            </p>
                            <p class="pl">出版年: <span class="book-pubdate">2015-6-1</span></p>
                            <p class="pl">页数: <span class="book-pages">280</span></p>
                            <p class="pl">ISBN: <span class="book-isbn">9787550013247</span></p>
                        </div>
                    </div>
                    <div class="col-md-4 rating-content col-xs-12">
                        <div class="head-content">
                            <div class="rating-logo">豆瓣评分</div>
                            <div class="rating-self"><span class="book-douban-rating">7</span></div>
                            <small>更新时间：{{ date('y-m-d',time($book->updated_at)) }}</small>
                            <small style="margin:0 5px">|</small>
                            <small>浏览量：{{ $book->view_count }}</small>
                        </div>
                    </div>
                </div>
                <div class="book-detail col-md-12 col-xs-12 clearfix">
                    <h4><span>内容简介</span> &nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·</h4>
                    <div id="book-summary" class="book-detail-content"></div>
                    <h4><span>作者简介</span> &nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·</h4>
                    <div id="author_intro" class="book-detail-content"></div>
                    <h4><span>读书杂记</span> &nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·</h4>
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
                        <div class="comment-content col-md-12 col-xs-12 clearfix">
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
    <script> window.douban_id = '{{ @$book->douban_id }}'</script>
    <script>
        //使用豆瓣API拿指定iD書籍的信息
//        var douban_id = window.douban_id;
//        $.ajax({
//            type: "get",
//            url: "https://api.douban.com/v2/book/"+douban_id,//最後一位是書籍id
//            data: $(this).serialize(),
//            async: false,
//            dataType:'jsonp',
//            jsonp: 'callback',
//            success: function(data){
//                $('#cover_image').attr('src',data.image);
//                $('.book-author').html(data.author);
//                $('.book-douban-url').attr('href',data.alt);
//                $('.origin-title').html(data.origin_title);
//                $('.book-pages').html(data.pages);
//                $('.book-isbn').html(data.isbn13);
//                $('.book-publisher').html(data.publisher);
//                $('.book-pubdate').html(data.pubdate);
//                $('.book-translator').html(data.translator);
//                $('.book-douban-rating').html(data.rating.average);
//                $('#author_intro').html(data.author_intro);
//                $('#book-summary').html(data.summary);
////                console.info(JSON.stringify("alt_title:"+data.alt_title));
//            },
//            error: function (xhr,status,error) {
//                console.info('获取豆瓣图书内容失败！');
//            }
//        });
    </script>

@endsection