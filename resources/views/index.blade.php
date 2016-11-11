@extends('layouts.plain')
@section('content')
    <div class="home-color-bg"></div>
    <div class="home-box">
        <h2 title="{{ $site_title or 'title' }}" style="margin: 0;">
            {{ $site_title or 'title' }}
            <a aria-hidden="true" href="{{ route('post.index') }}">
                <img class="img-circle" src="{{ $avatar or '' }}" alt="{{ $author or 'author' }}">
            </a>
        </h2>
        <h3 title="{{ $description or 'description' }}" aria-hidden="true" style="margin: 0">
            {{ $description or 'description' }}
        </h3>
        <p class="links">
            <font aria-hidden="true">»</font>
            <a href="{{ route('post.index') }}" aria-label="点击查看博客文章列表">博客</a><font aria-hidden="true">/</font>
            <a href="{{ route('projects') }}" aria-label="点击查看项目列表">项目</a>
            @foreach($pages as $page)
                <font aria-hidden="true">/</font>
                <a href="{{ route('page.show',$page->name) }}" aria-label="查看{{ $author or 'author' }}的{{ $page->display_name }}">{{$page->display_name }}</a>

            @endforeach

        </p>
        <p class="links">
            <font aria-hidden="true">»</font>
            @foreach(config('social') as $key => $value)
                <a href="{{ $value['url'] }}" target="_blank"
                   aria-label="{{ $author or 'author' }} 的 {{ ucfirst($key) }} 地址">
                    <i class="{{ $value['fa'] }}" title="{{ ucfirst($key) }}"></i>
                </a>
            @endforeach
        </p>
    </div>
@endsection