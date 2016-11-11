@extends('admin.layouts.app')
@section('title','评论')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="widget widget-default">
                <div class="widget-header">
                    <h6><i class="fa fa-comments fa-fw"></i>评论</h6>
                </div>
                <div class="widget-body">
                    <table class="table table-hover table-bordered table-responsive">
                        <thead>
                        <tr>
                            <th>用户</th>
                            <th>Email</th>
                            <th>地址</th>
                            <th>内容</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($comments as $comment)

                            <?php $commentableData = $comment->getCommentableData();?>

                            <tr class="{{ $comment->trashed() ? 'danger':'' }}">
                                <td>
                                    @if($comment->user_id)
                                        <a href="{{ route('user.show',$comment->username) }}">{{ $comment->username }}</a>
                                    @else
                                        {{ $comment->username }}
                                    @endif
                                </td>
                                <td><a href="mailto:{{ $comment->email }}">{{ $comment->email }}</a></td>
                                <td>
                                    @if($comment->trashed())
                                        {{ $commentableData['title'] }}
                                    @else
                                        <a target="_blank"
                                           href="{{ $commentableData['url'] }}">{{$commentableData['title'] }}
                                        </a>
                                    @endif
                                </td>
                                <td data-toggle="tooltip" data-placement="top"
                                    title="{{ $comment->content }}">{!! $comment->html_content !!}</td>
                                <td>
                                    @if($comment->trashed())
                                        <button type="submit"
                                                class="btn btn-danger"
                                                data-modal-target="这条评论(永久)"
                                                data-url="{{ route('comment.destroy',[$comment->id,'force'=>'true']) }}"
                                                data-method="delete"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="永久删除">
                                            <i class="fa fa-trash-o fa-fw"></i>
                                        </button>
                                        <form style="display: inline-block" method="post"
                                              action="{{ route('comment.restore',$comment->id) }}">
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-primary"
                                                    data-toggle="tooltip" data-placement="top" title="恢复">
                                                <i class="fa fa-repeat fa-fw"></i>
                                            </button>
                                        </form>

                                    @else
                                        <button type="submit"
                                                class="btn btn-danger"
                                                data-modal-target="这条评论"
                                                data-url="{{ route('comment.destroy',$comment->id) }}"
                                                data-method="delete"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="删除">
                                            <i class="fa fa-trash-o fa-fw"></i>
                                        </button>
                                        <a class="btn btn-info"
                                           href="{{ route('comment.edit',[$comment->id,'redirect'=>request()->fullUrl()]) }}">
                                            <i class="fa fa-pencil fa-fw"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $comments->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
