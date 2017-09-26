@extends('layouts.plain')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/taketori.css') }}">
    <style>
        body {
            background: #8f9442 url(../images/32.jpg) top left fixed;
            background-size: cover;
        }
        .links ul{
            list-style: none;
        }
        .links ul li{
            text-align: left;
        }
        dl {
            border-top: solid 1px #CCC;
            border-left: solid 1px #CCC;
            border-right: solid 1px #CCC;
            _border: solid 1px #CCC;
        }
        dt {
            background-color: #F3F3F3;
        }
        dt,dd {
            margin: 0!important;
            padding: 0.7em 1em!important;
            border-bottom: solid 1px #CCC!important;
        }
        .home-box h2, .home-box h3 {
            color: #333;
        }
        .home-box{
            background: none;
            color: #333;
        }
    </style>
@endsection
@section('content')
    {{--<div class="home-color-bg"></div>--}}
    <div class="home-box" id="text">
        @if(isset($avatar) && $avatar)
        <h2 style="margin: 0">
            <a aria-hidden="true" href="{{ route('post.index') }}">
                <img class="img-circle" src="{{ $avatar or '' }}" alt="{{ $author or 'author' }}">
            </a>
        </h2>
        @endif
        <h2 title="{{ $site_title or 'title' }}" style="margin: 0;">
            {{ $site_title or 'title' }}
        </h2>
        <h3 title="{{ $description or 'description' }}" aria-hidden="true" style="margin: 0">
            {{ $description or 'description' }}
        </h3>
        <p class="links">
            {{--<font aria-hidden="true">»</font>--}}
            <a href="{{ route('post.index') }}" aria-label="点击查看博客文章列表">博客</a><font aria-hidden="true">・</font>
            <a href="{{ route('projects') }}" aria-label="点击查看项目列表">项目</a>
            @foreach($pages as $page)
                <font aria-hidden="true">・</font>
                <a href="{{ route('page.show',$page->name) }}" aria-label="查看{{ $author or 'author' }}的{{ $page->display_name }}">{{$page->display_name }}</a>

            @endforeach

        </p>
        <p class="links">
            {{--<font aria-hidden="true">»</font>--}}
            @foreach(config('social') as $key => $value)
                <a href="{{ $value['url'] }}" target="_blank"
                   aria-label="{{ $author or 'author' }} 的 {{ ucfirst($key) }} 地址">
                    <i class="{{ $value['fa'] }}" title="{{ ucfirst($key) }}"></i>
                </a>
            @endforeach
        </p>
            {{--<dl>--}}
                {{--<dt>対応ブラウザ</dt>--}}
                {{--<dd>日本語・中国語・韓国語</dd>--}}
            {{--</dl>--}}
    </div>
@endsection

@section('script')
    <script src="{{ asset('/js/taketori.js') }}"></script>
    <script>
        // 文字竖排插件
        //<![CDATA[
        (new Taketori()).set({
            fontFamily:'serif',
            togglable:true,
            multiColumnEnabled:false,
            height:'250px'
        }).element('text').toVertical();
        //]]>
    </script>
@endsection