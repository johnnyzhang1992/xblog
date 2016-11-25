@extends('layouts.app')
@section('title','任务清单')
@section('content')
    <div class="container">
        {{--{{ auth()->user()->name  }}{{ auth()->user()->id }}--}}
        <div class="container clearfix" >
            <div class="col-md-12 container">
                <h2 class="text-center">任务清单</h2>
                <form role="form"  action="{{ route('list.store') }}" method="post">
                    <div class="list-items">
                        <div class="input-group list-item-title">
                            <input type="text" placeholder="title" name="list_item['title']" class="form-control">
                        </div>
                        <div class="input-group list-item-content">
                            <input type="hidden" id="list_item_id" name="_activity_sale[id][]" value="-1">
                            <input type="text" placeholder="What needs to be done?" class="form-control">
                            <span class="input-group-btn">
                                <input type="button" value="+" class="btn btn-primary  add-item">
                            </span>
                        </div>
                        <div ui-sortable class="list-item">
                            <p ui-sortable  class="input-group" style="padding: 5px 10px; cursor: move">
                                <input type="text" class="form-control" name="list_item['item'][]" placeholder="">
                                <span class="input-group-btn">
                                    <input type="button" value="-" class="btn btn-danger  del-item">
                                </span>
                            </p>
                        </div>
                    </div>
                </form>

            </div>
        </div>
        <div class="container clearfix">
            <div class="list-item col-md-12 container">
                <div class="item col-md-4">
                    <div class="widget widget-default">
                        <div class="widget-header">
                            <h4 class="item-title">
                                这是标题
                            </h4>
                        </div>
                        <div class="item-content widget-body ">
                            <p ui-sortable  style="padding: 5px 10px; cursor: move"></p>
                        </div>
                        <div class="widget-footer"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('/bower_components/bootstrap/dist/css/bootstrap.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/list.css') }}">
@endsection

@section('script')
    <script src="{{ asset('bower_components/jquery/dist/jquery.js') }} "></script>
    <script>
        $(".list-item").on( 'click', 'input.add_item' , function () {
            var par=$(this).parent().parent();

            var counts=1;
            $('body').find(".activity_sales_count").each(function(){
                counts++;
            });
            counts=counts*-1;
            var childdiv='<div class="form-group row activity_sales_count add-'+counts+' " >'+par.html()+'</div>';
            var xxx=par.parent().append(childdiv);
//                xxx.find("#ticket_type_ids").attr('value',counts);
            xxx.find(".add-"+counts).find("#list_item_id").attr('value',counts);

        });

        $(".list-item").on( 'click', 'input.del_item' , function () {
            var par=$(this).parent().parent();
            var id=par.find('#list_item_id').attr('value');
            if(id<-1){
                par.parent().append('<input type="hidden" id="ticket_type_del" name="ticket_type_del[]" value="'+id+'">');
                par.remove();
            }
        });
    </script>

    <script src="{{ asset('bower_components/angular/angular.js') }}"></script>
    <script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.js') }}"></script>
    <script src="{{ asset('bower_components/angular-animate/angular-animate.js') }}"></script>
    <script src="{{ asset('bower_components/angular-cookies/angular-cookies.js') }}"></script>
    <script src="{{ asset('bower_components/angular-messages/angular-messages.js') }}"></script>
    <script src="{{ asset('bower_components/angular-resource/angular-resource.js') }}"></script>
    <script src="{{ asset('bower_components/angular-route/angular-route.js') }}"></script>
    <script src="{{ asset('bower_components/angular-sanitize/angular-sanitize.js') }}"></script>
    <script src="{{ asset('bower_components/angular-touch/angular-touch.js') }}"></script>
    <script src="{{ asset('bower_components/jquery-ui/jquery-ui.js') }}"></script>
    <script src="{{ asset('bower_components/angular-ui-sortable/sortable.js') }}"></script>
    <script src="{{ asset('bower_components/angular-local-storage/dist/angular-local-storage.js') }}"></script>

    <script src="{{ asset('js/list/app.js') }}"></script>
    <script src="{{ asset('js/list/controllers/main.js') }}"></script>

@endsection