<div class="poi-side-main">
    <div class="side-head">热门内容</div>
    <div class="side-content">
        @if(isset($poi))
            <div class="side-item-list">
                {{--{{ json_decode($poi) }}--}}
                {{ @$poi->poi_name }}
                {{--@if(count($poi) > 5)--}}
                    {{--@for($i = 0;$i<5;$i++)--}}
                        {{--{{ $poi[$i]->poi_name }}--}}
                    {{--@endfor--}}
                {{--@else--}}
                    {{--@foreach($sides as $poi)--}}
                        {{--{{ $sides->poi_name }} <br>--}}
                    {{--@endforeach--}}
                {{--@endif--}}
            </div>
        @else
            暂无内容
        @endif
    </div>
</div>