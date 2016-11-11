@extends('layouts.app')
@section('title',$page->display_name)
@section('keywords',$page->display_name)
@section('description',$page->display_name)
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1 col-sm-12 col-sm-12-no-padding">
                <ol class="breadcrumb">
                    <li><a href="{{ route('post.index') }}">博客</a></li>
                    <li class="active">{{ ucfirst($page->name) }}</li>
                </ol>
                <div class="post-detail">
                    @can('update',$page)
                        <div class="btn-group pull-right" style="margin-top: -25px">
                            <a class="btn" href="{{ route('page.edit',$page->id) }}"><i class="fa fa-pencil"></i></a>
                        </div>
                    @endcan
                    <div class="center-block">
                        <div class="post-detail-title">{{ $page->display_name }}</div>
                    </div>
                    <div class="post-detail-content">
                        {!! $page->html_content !!}
                    </div>
                </div>

                <?php
                $configuration = $page->configuration ? $page->configuration->config : null;
                if (!$configuration) {
                    $configuration = [];
                    $configuration['comment_info'] = 'default';
                    $configuration['comment_type'] = 'default';
                }
                ?>
                @if($configuration['comment_info'] != 'force_disable' && ($configuration['comment_info'] == 'force_enable' || !isset($comment_type) || $comment_type != 'none'))
                    <div class="mt-30">
                        @include('widget.comment',[
                        'comment_key'=>'page.'.$page->name,
                        'comment_title'=>$page->display_name,
                        'comment_url'=>route('page.show',$page->name),
                        'commentable'=>$page,
                        'commentable_config'=>$configuration['comment_type'],
                        'redirect'=>request()->fullUrl(),
                        'commentable_type'=>'App\Page'])
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection