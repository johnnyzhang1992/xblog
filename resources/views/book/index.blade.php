@extends('layouts.app')
@section('title','书籍')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="posts-count">共{{ @$books_count }}本书</div>
                <div id="cd-timeline" class="cd-container" style="margin: 0 0">
                    @foreach($books as $book)
                        <div class="cd-timeline-block">
                            <div class="cd-timeline-img cd-picture">
                            </div>
                            <div class="cd-timeline-content">
                                <div class="cover-image">
                                    <img src="{{ asset(@$book->cover_image) }}" alt="" class="img-responsive">
                                </div>
                                <a href="#">
                                    <div class="title">{{ @$book->book_name }}<br> <small style="font-size: 70%">作者： {{ @$book->book_author }}</small></div>
                                </a>
                                <span class="cd-date">{{ @$book->created_at}}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="dot"></div>
            </div>
            <div class="col-md-4">
                <div class="slide">
                 往年历史
                </div>
            </div>
        </div>
    </div>
@endsection
