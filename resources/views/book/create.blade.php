@extends('admin.layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="widget widget-default">
                <div class="widget-header">
                    <h6><i class="fa fa-pencil  fa-fw"></i>写文章</h6>
                </div>
                <div class="widget-body edit-form">
                    <form role="form"  class="form-horizontal" action="{{ url('admin/book/create') }}" method="post">
                    {{ csrf_field() }}
                    <!--名称-->
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="name">书籍名称(Name)</label>
                            <div class="col-sm-10">
                                <input  type="text" id="name" ng-model="name" name="_book[book_name]"  class="form-control">
                            </div>
                        </div>
                        <!--名称-->
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="name">书籍作者</label>
                            <div class="col-sm-10">
                                <input  type="text" id="name" ng-model="name" name="_book[book_author]"  class="form-control">
                            </div>
                        </div>
                    <!--标签（Tag）-->
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="tag">标签(Tag)</label>
                            <div class="col-sm-10">
                                <input  type="text" id="tag" ng-model="tag" name="_book[tag]"  class="form-control">
                            </div>
                        </div>
                        <!--地址-->
                        <div class="form-group">
                            <div class="col-sm-6" style="padding-left: 0">
                                <label class="col-sm-4 control-label" for="lat">豆瓣地址</label>
                                <div class="col-sm-8">
                                    <input  type="text" id="lat" ng-model="lat" name="_book[douban_url]"  class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6" style="padding-left: 0">
                                <label class="col-sm-4 control-label" for="lng">Kindle地址</label>
                                <div class="col-sm-8">
                                    <input  type="text" id="lng" ng-model="lng" name="_book[kindle_url]" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="year">读书年份</label>
                            <div class="col-sm-4">
                                <input  type="text" id="year" ng-model="address " name="_book[year]"  class="form-control">
                            </div>
                            <label class="col-sm-2 control-label" for="status">读书进度</label>
                            <div class="col-sm-4">
                                <select id="status" name="_book[status]" class="form-control">
                                    <option value="finish">完成</option>
                                    <option value="active">进行中</option>
                                    <option value="abandon">放弃</option>
                                </select>
                            </div>
                        </div>
                        {{--评论--}}
                        <div class="form-group">
                            <label for="comment_info" class="control-label col-sm-2">评论信息</label>
                            <div class="col-sm-4">
                                <select style="margin-top: 5px" id="comment_info" name="comment_info" class="form-control ">
                                    <option value="default" >默认</option>
                                    <option value="force_disable" >强制关闭</option>
                                    <option value="force_enable" >强制开启</option>
                                </select>
                            </div>
                            <label for="comment_type" class="control-label col-sm-2">评论类型</label>
                            <div class="col-md-4">
                                <select id="comment_type" name="comment_type" class="form-control">
                                    <option value="default">默认</option>
                                    <option value="raw">自带评论</option>
                                    <option value="disqus">Disqus</option>
                                    <option value="duoshuo">多说</option>
                                </select>
                            </div>
                        </div>
                        <!--描述-->
                        <div class="form-group">
                            <label class="control-label col-sm-2 " for="description">笔记</label>
                            <div class="col-sm-10">
                                <textarea  rows="3" id="description" ng-model="description" name="_book[content]" class="form-control"></textarea>
                            </div>
                        </div>
                        <button type="submit"  class="btn btn-success btn-lg" style="width: 100%;">保存</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/summernote.css') }}">
@endsection

@section('script')
    <script src="{{ asset('/js/summernote.min.js') }}"></script>
    <script>
        $("#description").summernote({
            height: 100 ,
            placeholder: '请输入内容...'
        });
    </script>
@endsection