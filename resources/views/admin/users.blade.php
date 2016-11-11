@extends('admin.layouts.app')
@section('title','用户')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="widget widget-default">
                <div class="widget-header">
                    <h6><i class="fa fa-user fa-fw"></i>用户</h6>
                </div>
                <div class="widget-body">
                    <table class="table table-hover table-bordered table-responsive">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>名称</th>
                            <th>日期</th>
                            <th>邮箱</th>
                            <th>文章</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td><a href="{{ route('user.show',$user->name) }}">{{ $user->name }}</a></td>
                                <td>{{ $user->created_at }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->posts()->count() }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
