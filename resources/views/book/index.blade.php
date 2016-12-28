@extends('layouts.app')
@section('title','书籍')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                书籍列表
                <div>
                    {{ @$books }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="slide">
                 往年历史
                </div>
            </div>
        </div>
    </div>
@endsection
