<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
    <label for="name" class="control-label">页面uri*</label>

    <input id="name" type="text" class="form-control" name="name"
           value="{{ isset($page) ? $page->name : old('name') }}"
           autofocus>

    @if ($errors->has('name'))
        <span class="help-block">
            <strong>{{ $errors->first('name') }}</strong>
        </span>
    @endif
</div>


<div class="form-group{{ $errors->has('display_name') ? ' has-error' : '' }}">
    <label for="display_name" class="control-label">页面名称*</label>

    <input id="display_name" type="text" class="form-control" name="display_name"
           value="{{ isset($page) ? $page->display_name : old('display_name') }}">

    @if ($errors->has('display_name'))
        <span class="help-block">
            <strong>{{ $errors->first('display_name') }}</strong>
        </span>
    @endif
</div>
{{ csrf_field() }}

<div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
    <label for="content" class="control-label">页面内容*</label>

    <textarea spellcheck="false" id="content" type="text" class="form-control" name="content"
              rows="25"
              style="line-height: 1.85em; resize: vertical">{{ isset($page) ? $page->content : old('content') }}</textarea>
    @if ($errors->has('content'))
        <span class="help-block">
            <strong>{{ $errors->first('content') }}</strong>
        </span>
    @endif
</div>
<div class="form-group">
    <label for="comment_info" class="control-label">评论信息</label>
    <select style="margin-top: 5px" id="comment_info" name="comment_info" class="form-control">
        <?php $comment_info = isset($page) && $page->configuration ? $page->configuration->config['comment_info'] : ''?>
        <option value="default" {{ $comment_info=='default'?' selected' : '' }}>默认</option>
        <option value="force_disable" {{ $comment_info=='force_disable'?' selected' : '' }}>强制关闭</option>
        <option value="force_enable" {{ $comment_info=='force_enable'?' selected' : '' }}>强制开启</option>
    </select>
</div>
<div class="form-group">
    <label for="comment_type" class="control-label">评论类型</label>
    <select id="comment_type" name="comment_type" class="form-control">
        <?php $comment_type = isset($page) && $page->configuration ? $page->configuration->config['comment_type'] : ''?>
        <option value="default" {{ $comment_type=='default'?' selected' : '' }}>默认</option>
        <option value="raw" {{ $comment_type=='raw'?' selected' : '' }}>自带评论</option>
        <option value="disqus" {{ $comment_type=='disqus'?' selected' : '' }}>Disqus</option>
        <option value="duoshuo" {{ $comment_type=='duoshuo'?' selected' : '' }}>多说</option>
    </select>
</div>

<div class="form-group">
    <?php $display = isset($page) && $page->configuration ? $page->configuration->config['display'] : 'false'?>
    <div class="radio radio-inline">
        <label>
            <input type="radio"
                   {{ (isset($page)) && $display == 'true' ? ' checked ':'' }}
                   name="display"
                   value="true">显示在主页
        </label>
    </div>
    <div class="radio radio-inline">
        <label>
            <input type="radio"
                   {{ (!isset($page)) || $display == 'false' ? ' checked ':'' }}
                   name="display"
                   value="false">不显示在主页
        </label>
    </div>
</div>

<div class="form-group">
    <?php $sort_order = isset($page) && $page->configuration ? $page->configuration->config['sort_order'] : '1'?>
    <label for="sort_order" class="control-label">顺序</label>
    <input id="sort_order" type="number" class="form-control" name="sort_order"
           value="{{ $sort_order }}">
</div>
