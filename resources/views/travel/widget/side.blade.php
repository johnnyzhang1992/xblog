<div class="poi-side-main">
    <div class="side-head">热门内容</div>
    <div class="side-content clearfix">
        @if(isset($side_poi))
            <div class="side-item-list clearfix">
                @foreach($side_poi as $side)
                   <div class="item col-md-12 col-xs-12 clearfix">
                       <div class="col-md-6 col-xs-6 item-left">
                           @if(!empty($side->cover_image))
                               <img src="{{ asset($side->cover_image) }}" alt="" class="img-responsive">
                           @else
                               <img src="{{ asset('storage/images/travel/1bdd89d6fcb94845b0c89dd83b674dc9.jpeg') }}" alt="" class="img-responsive">
                           @endif
                       </div>
                       <div class="col-md-6 col-xs-6 item-right clearfix">
                           <div class="item-title col-md-12 col-xs-12"><a href="{{ url('/travel/poi/'.$side->id) }}" target="_blank">{{@$side->poi_name }}</a></div>
                           <div class="item-view-count col-md-12 col-xs-12">浏览量：{{ @$side->view_count }}</div>
                           {{--<div class="item-address">{{ @$side->address }}</div>--}}
                       </div>
                   </div>
                @endforeach
            </div>
        @else
            暂无内容
        @endif
    </div>
</div>