@extends('admin.layouts.app')
@section('title','旅行日记-目的地')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="widget widget-default">
                <div class="widget-header">
                    <h6><i class="fa fa-sticky-note fa-fw"></i>目的地</h6>
                </div>
                <div class="widget-body">
                    <table class="table table-hover table-bordered table-responsive">
                        <thead>
                        <tr>
                            <th>景点名称</th>
                            <th>状态</th>
                            {{--<th>slug</th>--}}
                            <th>action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($pois as $poi)
                            <?php
                            $class = '';
                            $status = 'Un published';
                            if ($poi->status == 'active') {
                                $class = 'success';
                                $status = 'Published';
                            } else if ($poi->status == 'delete') {
                                $class = 'danger';
                                $status = 'Deleted';
                            }
                            ?>
                            <tr class="{{ $class }}">
                                <td>{{ $poi->poi_name }}</td>
                                <td>{{ $status }}</td>
                                <td>
                                    <div>
                                        <a {{ $poi->status == 'delete'?'disabled':'' }} href="{{ $poi->status == 'delete'?'javascript:void(0)':url('travel/poi/edit',$poi->id) }}"
                                           data-toggle="tooltip" data-placement="top" title="编辑"
                                           class="btn btn-info">
                                            <i class="fa fa-pencil fa-fw"></i>
                                        </a>
                                        @if($poi->status == 'delete')
                                            <form style="display: inline" method="post" action="{{ url('travel/poi/restore',$poi->id) }}">
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="恢复">
                                                    <i class="fa fa-repeat fa-fw"></i>
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ url('travel/poi/preview',$poi->id) }}"  data-toggle="tooltip" data-placement="top" title="预览"
                                               class="btn btn-default">
                                                <i class="fa fa-eye fa-fw"></i>
                                            </a>
                                            {{--<form style="display: inline" method="post" action="{{ url('travel/poi/publish',$poi->id) }}">--}}
                                                {{--{{ csrf_field() }}--}}
                                                {{--<button type="submit" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="发布">--}}
                                                    {{--<i class="fa fa-send-o fa-fw"></i>--}}
                                                {{--</button>--}}
                                            {{--</form>--}}
                                        @endif
                                        <button class="btn btn-danger" data-toggle="modal" data-title="{{ $poi->poi_name }}"
                                                data-toggle="tooltip" data-placement="top" title="删除"
                                                data-url="{{ url('travel/poi/destroy',$poi->id) }}"
                                                data-force="{{ $poi->status == 'delete' }}"
                                                data-target="#delete-poi-modal">
                                            <i class="fa fa-trash-o  fa-fw"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $pois->links() }}
                </div>
            </div>
        </div>
    </div>
    {{-- modal --}}
    <div class="modal fade" id="delete-poi-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
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
                    <form id="delete-form" method="poi">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="redirect" value="/admin/pois">
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
        $('#delete-poi-modal').on('show.bs.modal', function (e) {
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