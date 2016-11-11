<div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
    <label for="title" class="control-label">文章标题*</label>
    <input id="title" type="text" class="form-control" name="title"
           value="{{ isset($post) ? $post->title : old('title') }}"
           autofocus>
    @if ($errors->has('title'))
        <span class="help-block">
            <strong>{{ $errors->first('title') }}</strong>
        </span>
    @endif
</div>
<div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
    <label for="description" class="control-label">文章描述*</label>

    <textarea id="post-description-textarea" style="resize: vertical;" rows="3" spellcheck="false"
              id="description" class="form-control autosize-target" placeholder="请使用 Markdown 格式书写"
              name="description">{{ isset($post) ? $post->description : old('description') }}</textarea>

    @if ($errors->has('description'))
        <span class="help-block">
            <strong>{{ $errors->first('description') }}</strong>
        </span>
    @endif
</div>

<div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
    <label for="slug" class="control-label">文章slug*</label>
    <input id="slug" type="text" class="form-control" name="slug"
           value="{{ isset($post) ? $post->slug : old('slug') }}">

    @if ($errors->has('slug'))
        <span class="help-block">
            <strong>{{ $errors->first('slug') }}</strong>
        </span>
    @endif
</div>

<div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
    <label for="categories" class="control-label">文章分类*</label>
    <select name="category_id" class="form-control">
        @foreach($categories as $category)
            @if((isset($post) ? $post->category_id : old('category_id',-1)) == $category->id)
                <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
            @else
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endif
        @endforeach
    </select>

    @if ($errors->has('description'))
        <span class="help-block">
            <strong>{{ $errors->first('description') }}</strong>
        </span>
    @endif
</div>
<div class="form-group{{ $errors->has('tags[]') ? ' has-error' : '' }}">
    <label for="tags[]" class="control-label">文章标签</label>
    <select id="post-tags" name="tags[]" class="form-control" multiple>
        @foreach($tags as $tag)
            @if(isset($post) && $post->tags->contains($tag))
                <option value="{{ $tag->name }}" selected>{{ $tag->name }}</option>
            @else
                <option value="{{ $tag->name }}">{{ $tag->name }}</option>
            @endif
        @endforeach
    </select>

    @if ($errors->has('tags[]'))
        <span class="help-block">
            <strong>{{ $errors->first('tags[]') }}</strong>
        </span>
    @endif
</div>
<div class="form-group{{ $errors->has('content') ? ' has-error ' : ' ' }}">
    <label for="post-content-textarea" class="control-label">文章内容*</label>
    <textarea spellcheck="false" id="post-content-textarea" class="form-control" name="content"
              rows="36"
              placeholder="请使用 Markdown 格式书写"
              style="resize: vertical">{{ isset($post) ? $post->content : old('content') }}</textarea>
    @if($errors->has('content'))
        <span class="help-block">
            <strong>{{ $errors->first('content') }}</strong>
        </span>
    @endif
</div>

<div class="form-group">
    <label for="comment_info" class="control-label">评论信息</label>
    <select style="margin-top: 5px" id="comment_info" name="comment_info" class="form-control">
        <?php $comment_info = isset($post) && $post->configuration ? $post->configuration->config['comment_info'] : ''?>
        <option value="default" {{ $comment_info=='default'?' selected' : '' }}>默认</option>
        <option value="force_disable" {{ $comment_info=='force_disable'?' selected' : '' }}>强制关闭</option>
        <option value="force_enable" {{ $comment_info=='force_enable'?' selected' : '' }}>强制开启</option>
    </select>
</div>
<div class="form-group">
    <label for="comment_type" class="control-label">评论类型</label>
    <select id="comment_type" name="comment_type" class="form-control">
        <?php $comment_type = isset($post) && $post->configuration ? $post->configuration->config['comment_type'] : ''?>
        <option value="default" {{ $comment_type=='default'?' selected' : '' }}>默认</option>
        <option value="raw" {{ $comment_type=='raw'?' selected' : '' }}>自带评论</option>
        <option value="disqus" {{ $comment_type=='disqus'?' selected' : '' }}>Disqus</option>
        <option value="duoshuo" {{ $comment_type=='duoshuo'?' selected' : '' }}>多说</option>
    </select>
</div>

<div class="form-group">
    <div class="radio radio-inline">
        <label>
            <input type="radio"
                   {{ (isset($post)) && $post->status == 1 ? ' checked ':'' }}
                   name="status"
                   value="1">发布
        </label>
    </div>
    <div class="radio radio-inline">
        <label>
            <input type="radio"
                   {{ (!isset($post)) || $post->status == 0 ? ' checked ':'' }}
                   name="status"
                   value="0">草稿
        </label>
    </div>
</div>
{{ csrf_field() }}