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
                <div class="book-detail col-md-12 clearfix">
                    <h4 class="book-name"><span>{{ @$book->book_name }}</span></h4>
                    <div class="col-md-8 col-xs-12">
                        <div class="book_cover_image">
                            @if(isset($book->cover_image))
                                <img src='{{ asset(@$book->cover_image) }}' alt="{{ @$book->book_name."封面" }}"  class="img-responsive" >
                            @endif
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
                            <p class="pl">出版年: <span class="pubdate">2015-6-1</span></p>
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
                    <div class="book-detail-content">
                        单亲女孩迪伦，15岁的世界一片狼藉：与母亲总是无话可说，在学校里经常受到同学的捉弄，唯一谈得来的好友也因为转学离开了。这一切都让迪伦感到无比痛苦。
                        她决定去看望久未谋面的父亲，然而，路上突发交通事故。等她拼命爬出火车残骸之后，却惊恐地发现，自己是唯一的幸存者，而眼前，竟是一片荒原。
                        此时，迪伦看到不远处的山坡上一个男孩的身影。
                        男孩将她带离了事故现场。但是，迪伦很快意识到，男孩并不是偶然出现的路人，他似乎是特意在此等候。
                        命运，从他们相遇的那刻开始，发生了无法预料的转变……
                    </div>
                    <h4><span>作者简介</span> &nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·</h4>
                    <div class="book-detail-content">
                        克莱儿•麦克福尔居住在苏格兰格拉斯哥南部，是英国文坛备受瞩目的实力作家。
                        她的作品往往在出其不意的情节架构中饱含感人至深的真情，贯穿着人生思索和人性独白。
                        《摆渡人》是她最著名的作品，一举摘得五项世界文学大奖，版权销售33个国家，是令千万读者灵魂震颤的心灵治愈小说。
                    </div>
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
                console.info(JSON.stringify("ISBN:"+data.isbn13));
                console.info(JSON.stringify("出版社:"+data.publisher));
                console.info(JSON.stringify("出版时间:"+data.pubdate));
                console.info(JSON.stringify("translator:"+data.translator));
                console.info(JSON.stringify("评分:"+data.rating.average));
            },
            error: function (xhr,status,error) {
                console.info('');
            }
        });
    </script>

@endsection