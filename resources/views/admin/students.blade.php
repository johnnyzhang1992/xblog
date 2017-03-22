@extends('admin.layouts.app')
@section('title','用户')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="widget widget-default">
                <div class="widget-header">
                    <h6>
                        <i class="fa fa-user fa-fw"></i>用户
                        <a href="#"></a>
                        <a id="create_btn" class="btn pull-right" href="#create-student-modal" data-toggle="modal" data-target="#create-student-modal">
                            <i class="fa fa-user"></i>  添加新的用户数据
                        </a>
                    </h6>
                </div>
                <div class="widget-body">
                    <table class="table table-hover table-bordered table-responsive">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>姓名</th>
                            <th>学校</th>
                            <th>电话</th>
                            <th>兼职经历</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($students as $student)
                            <tr>
                                <td>{{ $student->id }}</td>
                                <td >{{ $student->name }}</td>
                                <td>{{ $student->school }}</td>
                                <td>{{ $student->phone }}</td>
                                <td>{!! substr($student->experience,0,30) !!}</td>
                                <td data-id="{{ $student->id }}" data-name="{{ $student->name }}" data-school="{{ $student->school }}"
                                    data-phone="{{ $student->phone }}" data-content="{!! $student->experience !!}">
                                    <div>
                                        <a href="#edit-student-modal" data-toggle="modal" data-target="#edit-student-modal"
                                           title="编辑" class="btn btn-info" target="_blank" onclick="edit(this)">
                                            <i class="fa fa-pencil fa-fw"></i>
                                        </a>
                                        <button class="btn btn-danger" data-toggle="modal" data-id="{{ $student->id }}"
                                                data-placement="top" title="删除"
                                                data-target="#delete-book-modal" onclick="_delete(this)">
                                            <i class="fa fa-trash-o  fa-fw"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $students->links() }}
                </div>
            </div>
        </div>
    </div>
    {{-- modal --}}
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
                    <form id="delete-form" action="{{ url('/admin/student/delete') }}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="post">
                        <input id="delete-id" type="hidden" name="id" value="">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        <button id="confirm-btn" type="submit" class="btn btn-primary">确定</button>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <div class="modal fade" id="create-student-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">兼职学生信息添加</h4>
                </div>
                <div class="modal-body">
                    请填写以下信息<span id="span-title"></span>
                </div>
                <div class="modal-footer">
                    <form action="{{ url('admin/student/create') }}" id="delete-form" method="post">
                        {{ csrf_field() }}
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label" for="name">姓名: <span style="color:red">*</span></label>
                            <div class="col-sm-10">
                                <input  type="text" id="name" name="_student[name]" placeholder="姓名"  class="form-control">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label" for="school">学校: <span style="color:red">*</span></label>
                            <div class="col-sm-10">
                                <input  type="text" id="school" name="_student[school]" placeholder="学校"  class="form-control">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label" for="phone">电话: <span style="color:red">*</span></label>
                            <div class="col-sm-10">
                                <input  type="text" id="phone" name="_student[phone]" placeholder="电话"  class="form-control">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label" for="experience">兼职经历:</label>
                            <div class="col-sm-10">
                                <textarea  rows="3" id="experience" name="_student[experience]"  class="summernote form-control"></textarea>
                            </div>
                        </div>
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        <button id="confirm-btn" type="submit" class="btn btn-primary">确定</button>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade" id="edit-student-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">兼职学生信息编辑</h4>
                </div>
                <div class="modal-body">
                    请填写以下信息<span id="span-title"></span>
                </div>
                <div class="modal-footer">
                    <form action="{{ url('admin/student/edit') }}" id="delete-form" method="post">
                        {{ csrf_field() }}
                        <input id="edit-id" type="hidden" name="id" value="">
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label" for="edit-name">姓名: <span style="color:red">*</span></label>
                            <div class="col-sm-10">
                                <input  type="text" id="edit-name" name="_student[name]" placeholder="姓名"  class="form-control">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label" for="edit-school">学校: <span style="color:red">*</span></label>
                            <div class="col-sm-10">
                                <input  type="text" id="edit-school" name="_student[school]" placeholder="学校"  class="form-control">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label" for="edit-phone">电话: <span style="color:red">*</span></label>
                            <div class="col-sm-10">
                                <input  type="text" id="edit-phone" name="_student[phone]" placeholder="电话"  class="form-control">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="col-sm-2 control-label" for="edit-experience">兼职经历:</label>
                            <div class="col-sm-10">
                                <textarea  rows="3" id="edit-experience" name="_student[experience]"  class=" form-control"></textarea>
                            </div>
                        </div>
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        <button id="confirm-btn" type="submit" class="btn btn-primary">确定</button>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('/css/summernote.css') }}">
    <style>
        .form-group{
            margin-bottom: 10px;
        }
        @media (min-width: 768px){
            .modal-dialog {
                width: 768px;
                margin: 30px auto;
            }
        }
        .note-popover .popover-content, .panel-heading.note-toolbar {
            text-align: left;
        }
        .note-editor.note-frame .note-editing-area .note-editable {
            text-align: left;
        }
    </style>
@endsection

@section('script')
    <script src="{{ asset('/js/summernote.min.js') }}"></script>
    <script>
        $(".summernote").summernote({
            height: 100 ,
            placeholder: '请输入内容...'
        });
        function edit(th) {
            var id = $(th).parent().parent().attr('data-id');
            var name = $(th).parent().parent().attr('data-name');
            var school = $(th).parent().parent().attr('data-school');
            var phone = $(th).parent().parent().attr('data-phone');
            var experience = $(th).parent().parent().attr('data-content');
            $('#edit-id').attr('value',id);
            $('#edit-name').val(name);
            $('#edit-school').val(school);
            $('#edit-phone').val(phone);
            $('#edit-experience').html(experience);
            $("#edit-experience").summernote({
                height: 100 ,
                placeholder: '请输入内容...'
            });
        }
        function _delete(th) {
            var id = $(th).attr('data-id');
            $('#delete-id').attr('value',id);
        }
    </script>
@endsection