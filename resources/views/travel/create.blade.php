@extends('admin.layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="widget widget-default">
                <div class="widget-header">
                    <h6><i class="fa fa-pencil  fa-fw"></i>写文章</h6>
                </div>
                <div class="widget-body edit-form">
                    @include('travel.form-content')
                </div>
            </div>
        </div>
    </div>
@endsection