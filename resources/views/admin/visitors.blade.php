@extends('admin.layouts.app')
@section('title','浏览统计')
@section('content')
    <div class="row">
        <div class="widget widget-default">
            <div class="widget-header">
                <h6><i class="fa fa-file-image-o fa-fw"></i>浏览量（）</h6>
            </div>
            <div class="widget-body">
                {{ $content }}
            </div>
        </div>
    </div>

@endsection
@section('script')

@endsection