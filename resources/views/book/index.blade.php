@extends('layouts.app')
@section('title','书籍')
@section('content')
    <div class="container">

        <div class="dot"></div>
        <div class="row">
            <div class="col-md-8">
                <div class="posts-count">共{{ $books_count }}篇文章</div>
                <div id="cd-timeline" class="cd-container" style="margin: 0 0">
                    @foreach($books as $book)
                        <div class="cd-timeline-block">
                            <div class="cd-timeline-img cd-picture">
                            </div>
                            <div class="cd-timeline-content">
                                <a href="#">
                                    <div class="title">{{ $book->book_name }}</div>
                                </a>
                                <span class="cd-date">{{ $book->created_at}}</span>
                            </div>
                        </div>
                    @endforeach
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
