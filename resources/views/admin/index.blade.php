@extends('admin.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-3 col-sm-4 col-xs-6">
            <a href="{{ route('admin.users') }}">
                <div class="info-box">
                    <div class="row">
                        <div class="col-xs-4">
                            <div class="info-icon">
                                <i class="fa fa-user fa-fw"></i>
                            </div>
                        </div>
                        <div class="col-xs-8">
                            <span>用户</span>
                            <div class="info-title">{{ $info['user_count'] }}</div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3 col-sm-4 col-xs-6">
            <a href="{{ route('admin.pages') }}">
                <div class="info-box">
                    <div class="row">
                        <div class="col-xs-4">
                            <div class="info-icon">
                                <i class="fa fa-file fa-fw"></i>
                            </div>
                        </div>
                        <div class="col-xs-8">
                            <span>页面</span>
                            <div class="info-title">{{ $info['page_count'] }}</div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3 col-sm-4 col-xs-6">
            <a href="{{ route('admin.posts') }}">
                <div class="info-box">
                    <div class="row">
                        <div class="col-xs-4">
                            <div class="info-icon">
                                <i class="fa fa-sticky-note fa-fw"></i>
                            </div>
                        </div>
                        <div class="col-xs-8">
                            <span>文章</span>
                            <div class="info-title">{{ $info['post_count'] }}</div>
                        </div>
                    </div>
                </div>
            </a>
        </div>


        <div class="col-md-3 col-sm-4 col-xs-6">
            <a href="{{ route('admin.comments') }}">
                <div class="info-box">
                    <div class="row">
                        <div class="col-xs-4">
                            <div class="info-icon">
                                <i class="fa fa-comments fa-fw"></i>
                            </div>
                        </div>
                        <div class="col-xs-8">
                            <span>评论</span>
                            <div class="info-title">{{ $info['comment_count'] }}</div>
                        </div>
                    </div>
                </div>
            </a>
        </div>


        <div class="col-md-3 col-sm-4 col-xs-6">
            <a href="{{ route('admin.tags') }}">
                <div class="info-box">
                    <div class="row">
                        <div class="col-xs-4">
                            <div class="info-icon">
                                <i class="fa fa-tags fa-fw"></i>
                            </div>
                        </div>
                        <div class="col-xs-8">
                            <span>标签</span>
                            <div class="info-title">{{ $info['tag_count'] }}</div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3 col-sm-4 col-xs-6">
            <a href="{{ route('admin.categories') }}">
                <div class="info-box">
                    <div class="row">
                        <div class="col-xs-4">
                            <div class="info-icon">
                                <i class="fa fa-folder fa-fw"></i>
                            </div>
                        </div>
                        <div class="col-xs-8">
                            <span>分类</span>
                            <div class="info-title">{{ $info['category_count'] }}</div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3 col-sm-4 col-xs-6">
            <a href="{{ route('admin.images') }}">
                <div class="info-box">
                    <div class="row">
                        <div class="col-xs-4">
                            <div class="info-icon">
                                <i class="fa fa-image fa-fw"></i>
                            </div>
                        </div>
                        <div class="col-xs-8">
                            <span>图片</span>
                            <div class="info-title">{{ $info['image_count'] }}</div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3 col-sm-4 col-xs-6">
            <a href="{{ route('admin.pois') }}">
                <div class="info-box">
                    <div class="row">
                        <div class="col-xs-4">
                            <div class="info-icon">
                                <i class="fa fa-fort-awesome fa-fw"></i>
                            </div>
                        </div>
                        <div class="col-xs-8">
                            <span>去过的地方</span>
                            <div class="info-title">{{ @$info['pois_count'] }}</div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3 col-sm-4 col-xs-6">
            <a href="{{ route('admin.books') }}">
                <div class="info-box">
                    <div class="row">
                        <div class="col-xs-4">
                            <div class="info-icon">
                                <i class="fa fa-book fa-fw"></i>
                            </div>
                        </div>
                        <div class="col-xs-8">
                            <span>书籍总数</span>
                            <div class="info-title">{{ @$info['books_count'] }}</div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3 col-sm-4 col-xs-6">
            <a href="{{ route('admin.visitors') }}">
                <div class="info-box">
                    <div class="row">
                        <div class="col-xs-4">
                            <div class="info-icon">
                                <i class="fa fa-bar-chart fa-fw"></i>
                            </div>
                        </div>
                        <div class="col-xs-8">
                            <span>浏览统计</span>
                            <div class="info-title">{{ @$info['visitors_count'] }}</div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        {{--<div class="col-md-3 col-sm-4 col-xs-6">--}}
            {{--<a href="{{ route('admin.students') }}">--}}
                {{--<div class="info-box">--}}
                    {{--<div class="row">--}}
                        {{--<div class="col-xs-4">--}}
                            {{--<div class="info-icon">--}}
                                {{--<i class="fa fa-bar-chart fa-fw"></i>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="col-xs-8">--}}
                            {{--<span>豌豆兼职学生信息管理</span>--}}
                            {{--<div class="info-title">{{ @$info['students_count'] }}</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</a>--}}
        {{--</div>--}}

    </div>
@endsection
