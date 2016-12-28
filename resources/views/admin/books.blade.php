@extends('admin.layouts.app')
@section('title','读书笔记-书单列表')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="widget widget-default">
                <div class="widget-header">
                    <h6><i class="fa fa-book fa-fw"></i>BOOK</h6>
                </div>
                <div class="widget-body">
                    <a class="btn pull-right" href="{{ url('admin/book/create_new') }}">
                        <i class="fa fa-book"></i>  添加新的书籍
                    </a>
                    <table class="table table-hover table-bordered table-responsive">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>书籍名字</th>
                            <th>豆瓣地址</th>
                            <th>亚马逊地址</th>
                            <td>状态</td>
                            {{--<th>slug</th>--}}
                            <th>action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($books as $book)
                            <?php
                            $class = '';
                            $status = 'Un published';
                            if ($book->status == 'active') {
                                $class = 'success';
                                $status = 'Published';
                            } else if ($book->status == 'delete') {
                                $class = 'danger';
                                $status = 'Deleted';
                            }
                            ?>
                            <tr class="{{ $class }}">
                                <td>{{ $book->id }}</td>
                                <td>{{ $book->book_name }}</td>
                                <td>{{ $book->douban_url }}</td>
                                <td>{{ $book->kindle_url }}</td>
                                <td>{{ $status }}</td>
                                <td>
                                    <div>
                                        <a {{ $book->status == 'delete'?'disabled':'' }} href="{{ $book->status == 'delete'?'javascript:void(0)':url('admin/book/edit',$book->id) }}"
                                           data-toggle="tooltip" data-placement="top" title="编辑"
                                           class="btn btn-info" target="_blank">
                                            <i class="fa fa-pencil fa-fw"></i>
                                        </a>
                                        @if($book->status == 'delete')
                                            <form style="display: inline" method="post" action="{{ url('admin/book/restore',$book->id) }}">
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="恢复">
                                                    <i class="fa fa-repeat fa-fw"></i>
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ url('book',$book->id) }}"  data-toggle="tooltip" data-placement="top" title="预览"
                                               class="btn btn-default" target="_blank">
                                                <i class="fa fa-eye fa-fw"></i>
                                            </a>
                                            {{--<form style="display: inline" method="post" action="{{ url('travel/book/publish',$book->id) }}">--}}
                                            {{--{{ csrf_field() }}--}}
                                            {{--<button type="submit" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="发布">--}}
                                            {{--<i class="fa fa-send-o fa-fw"></i>--}}
                                            {{--</button>--}}
                                            {{--</form>--}}
                                        @endif
                                        <button class="btn btn-danger" data-toggle="modal" data-title="{{ $book->book_name }}"
                                                data-toggle="tooltip" data-placement="top" title="删除"
                                                data-url="{{ url('admin/book/destroy',$book->id) }}"
                                                data-force="{{ $book->status == 'delete' }}"
                                                data-target="#delete-book-modal">
                                            <i class="fa fa-trash-o  fa-fw"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $books->links() }}
                </div>
            </div>
        </div>
    </div>
    {{-- modal --}}
    <div class="modal fade" id="delete-book-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">删除</h4>
                </div>
                <div class="modal-body">
                    确定删除<span id="span-title"></span>吗?
                </div>
                <div class="modal-footer">
                    <form id="delete-form" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="redirect" value="/admin/books">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        <button id="confirm-btn" type="submit" class="btn btn-primary">确定</button>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection

@section('script')
    <script>
        $('#delete-book-modal').on('show.bs.modal', function (e) {
            var url = $(e.relatedTarget).data('url');
            var title = $(e.relatedTarget).data('title');
            var force = $(e.relatedTarget).data('force');
            if (force == '1')
            {
                $('#confirm-btn').text('确定(这将永久刪除)');
                $('#confirm-btn').attr('class','btn btn-danger');
            }
            $('#span-title').text(title);
            $('#delete-form').attr('action', url);
        });
    </script>
@endsection