@extends('admin.layouts.app')
@section('title','设置')
@section('content')
    <div class="row">
        <form role="form" id="setting-form" class="form-horizontal" action="{{ route('admin.save-settings') }}"
              method="post">
            <div class="widget widget-default">
                <div class="widget-header">
                    <h6>
                        <i class="fa fa-cog fa-fw"></i>设置
                    </h6>
                </div>
                <div class="widget-body">
                    <div class="form-group">
                        <div class="radio">
                            <label class="col-sm-offset-2">
                                <input type="radio"
                                       {{ isset($google_analytics) && $google_analytics == 'true' ? ' checked ':'' }}
                                       name="google_analytics"
                                       value="true">启用谷歌分析
                            </label>
                        </div>
                        <div class="radio">
                            <label class="col-sm-offset-2">
                                <input type="radio"
                                       {{ isset($google_analytics) && $google_analytics == 'true' ? '':' checked ' }}
                                       name="google_analytics"
                                       value="false">禁用谷歌分析
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="radio">
                            <label class="col-sm-offset-2">
                                <input type="radio"
                                       {{ isset($enable_mail_notification) && $enable_mail_notification == 'true' ? ' checked ':'' }}
                                       name="enable_mail_notification"
                                       value="true">启用邮件通知
                            </label>
                        </div>
                        <div class="radio">
                            <label class="col-sm-offset-2">
                                <input type="radio"
                                       {{ isset($enable_mail_notification) && $enable_mail_notification == 'true' ? '':' checked ' }}
                                       name="enable_mail_notification"
                                       value="false">禁用邮件通知
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="radio">
                            <label class="col-sm-offset-2">
                                <input type="radio"
                                       {{ (isset($comment_type) && $comment_type == 'none') ? ' checked ':'' }}
                                       name="comment_type"
                                       value="none">关闭评论
                            </label>
                        </div>
                        <div class="radio">
                            <label class="col-sm-offset-2">
                                <input type="radio"
                                       {{ (!isset($comment_type) || $comment_type == 'raw') ? ' checked ':'' }}
                                       name="comment_type"
                                       value="raw">自带评论
                            </label>
                        </div>
                        <div class="radio">
                            <label class="col-sm-offset-2">
                                <input type="radio"
                                       {{ isset($comment_type) && $comment_type == 'disqus' ? ' checked':'' }}
                                       name="comment_type"
                                       value="disqus">Disqus
                            </label>
                        </div>
                        <div class="radio">
                            <label class="col-sm-offset-2">
                                <input type="radio"
                                       {{ isset($comment_type) && $comment_type == 'duoshuo' ? ' checked':'' }}
                                       name="comment_type"
                                       value="duoshuo">多说
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="google_trace_id" class="col-sm-2 control-label">跟踪ID</label>
                        <div class="col-sm-8">
                            <input type="text" name="google_trace_id" class="form-control" id="google_trace_id"
                                   placeholder="谷歌跟踪ID"
                                   value="{{ $google_trace_id or ''}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="author" class="col-sm-2 control-label">作者</label>
                        <div class="col-sm-8">
                            <input type="text" name="author" class="form-control" id="author"
                                   value="{{ $author or ''}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description" class="col-sm-2 control-label">描述</label>
                        <div class="col-sm-8">
                            <input type="text" name="description" class="form-control" id="description"
                                   value="{{ $description or ''}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="avatar" class="col-sm-2 control-label">头像</label>
                        <div class="col-sm-8">
                            <input type="text" name="avatar" class="form-control" id="avatar"
                                   value="{{ $avatar or ''}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="avatar" class="col-sm-2 control-label">Disqus ID</label>
                        <div class="col-sm-8">
                            <input type="text" name="disqus_shortname" class="form-control" id="avatar"
                                   value="{{ $disqus_shortname or ''}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="avatar" class="col-sm-2 control-label">多说 ID</label>
                        <div class="col-sm-8">
                            <input type="text" name="duoshuo_shortname" class="form-control" id="avatar"
                                   value="{{ $duoshuo_shortname or ''}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="avatar" class="col-sm-2 control-label">Github用户名</label>
                        <div class="col-sm-8">
                            <input type="text" name="github_username" class="form-control" id="avatar"
                                   value="{{ $github_username or ''}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Js</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" name="site_js"
                                   value="{{ $site_js or ''}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Css</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" name="site_css"
                                   value="{{ $site_css or ''}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">标题</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" name="site_title"
                                   value="{{ $site_title or ''}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">关键字</label>
                        <div class="col-sm-8">
                            <input placeholder="网站关键字" class="form-control" type="text" name="site_keywords"
                                   value="{{ $site_keywords or ''}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">网站描述</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" name="site_description"
                                   value="{{ $site_description or '' }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">每页数量</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="number" name="page_size"
                                   value="{{ $page_size or 7 }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">简介图片</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" name="profile_image"
                                   value="{{ $profile_image or ''}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">背景图片</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" name="background_image"
                                   value="{{ $background_image or ''}}">
                        </div>
                    </div>

                    {{ csrf_field() }}
                    <div class="form-group">
                        <div class="col-sm-8 col-sm-offset-2">
                            <button type="submit" class="btn bg-primary">
                                保存
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

