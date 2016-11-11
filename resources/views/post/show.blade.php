@extends('layouts.app')
@section('description',$post->description)
@section('keywords',$post->category->name)
@section('title',$post->title)
@section('content')
    <div class="container">
        <div id="post-detail-wrap" class="row">
            <div class="col-md-10 col-md-offset-1 col-sm-12 col-sm-12-no-padding">
                <div class="post-detail">
                    @can('update',$post)
                        <div class="btn-group pull-right" style="margin-top: -25px">
                            <a class="btn" href="{{ route('post.edit',$post->id) }}"><i class="fa fa-pencil"></i></a>
                            <a class="btn" role="button"
                               data-method="delete"
                               data-url="{{ route('post.destroy',$post->id) }}"
                               data-modal-target="{{ $post->title }}">
                                <i class="fa fa-trash-o"></i>
                            </a>
                        </div>
                    @endcan
                    <div class="center-block">
                        <div class="post-detail-title">{{ $post->title }}</div>
                        <div class="post-meta">
                           <span class="post-time">
                           <i class="fa fa-calendar-o"></i>
                           <time datetime="{{ $post->created_at->tz('UTC')->toAtomString() }}">
                           {{ $post->published_at==null?'Un Published':$post->created_at->format('Y-m-d H:i') }}
                           </time>
                           </span>
                            <span class="post-category">
                           &nbsp;|&nbsp;
                           <i class="fa fa-folder-o"></i>
                           <a href="{{ route('category.show',$post->category->name) }}">
                           {{ $post->category->name }}
                           </a>
                           </span>
                            <span class="post-comments-count">
                           &nbsp;|&nbsp;
                           <i class="fa fa-comment-o" aria-hidden="true"></i>
                           <span>{{ $post->comments_count }}</span>
                           </span>
                            <span>
                           &nbsp;|&nbsp;
                           <i class="fa fa-eye"></i>
                           <span>{{ $post->view_count }}</span>
                           </span>
                        </div>
                    </div>
                    <br>
                    <div class="post-detail-content">
                        {!! $post->html_content !!}
                    </div>
                    <div class="tag-list">
                        <i class="fa fa-tags"></i>
                        @foreach($post->tags as $tag)
                            <a class="tag" href="{{ route('tag.show',$tag->name) }}">{{ $tag->name }}</a>
                        @endforeach
                    </div>
                    <div class="creative-commons">
                        <i class="fa fa-fw fa-creative-commons"></i>自由转载-非商用-非衍生-保持署名（<a
                                href="https://creativecommons.org/licenses/by-nc-nd/3.0/deed.zh">创意共享3.0许可证</a>）
                    </div>
                </div>
            </div>
        </div>

        @if(!(isset($preview) && $preview))
            <?php
            $configuration = $post->configuration ? $post->configuration->config : null;
            if (!$configuration) {
                $configuration = [];
                $configuration['comment_info'] = 'default';
                $configuration['comment_type'] = 'default';
            }
            ?>
            @if($configuration['comment_info'] != 'force_disable' && ($configuration['comment_info'] == 'force_enable' || !isset($comment_type) || $comment_type != 'none'))
                <div class="row mt-30">
                    <div id="comment-wrap" class="col-md-10 col-md-offset-1 col-sm-12 col-sm-12-no-padding">
                        @include('widget.comment',[
                        'comment_key'=>$post->slug,
                        'comment_title'=>$post->title,
                        'comment_url'=>route('post.show',$post->slug),
                        'commentable'=>$post,
                        'commentable_config'=>$configuration['comment_type'],
                        'redirect'=>request()->fullUrl(),
                         'commentable_type'=>'App\Post'])
                    </div>
                </div>
            @endif
        @endif
    </div>
@endsection