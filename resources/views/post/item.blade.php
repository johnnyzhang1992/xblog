<article class="post">
    <!-- post header -->
    <div class="post-header">
        <h1 class="post-title">
            <a href="{{ route('post.show',$post->slug) }}">{{ $post->title }}</a>
        </h1>
        <div class="post-meta">
                           <span class="post-time">
                           <i class="fa fa-calendar-o"></i>
                           <time datetime="2016-08-05T00:10:14+08:00">
                           {{ $post->created_at->format('Y-m-d') }}
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
        </div>
    </div>
    <!-- post content -->
    <div class="post-description">
        <p class="markdown-target" data-markdown="{{ $post->description }}">
        </p>
    </div>
    <!-- read more -->
    <div class="post-permalink">
        <a href="{{ route('post.show',$post->slug) }}" class="btn btn-more">阅读全文</a>
    </div>
    <!-- post footer -->
    <div class="post-footer clearfix">
        <div class="pull-left tag-list">
            <i class="fa fa-tags"></i>
            @foreach($post->tags as $tag)
                <a  class="tag" href="{{ route('tag.show',$tag->name) }}">{{ $tag->name }}</a>
            @endforeach
        </div>
    </div>
</article>