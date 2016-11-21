@extends('admin.layouts.app')
@section('title','浏览统计')
@section('content')
    <div class="row">
        <div class="widget widget-default">
            <div class="widget-header">
                <h6><i class="fa fa-file-image-o fa-fw"></i>浏览量（{{ $visitors_count }}）</h6>
            </div>
            <div class="widget-body">
                <table>
                    <tr>
                        <td>name</td>
                        <td>from_url</td>
                        <td>IP</td>
                        <td>系统以及版本</td>
                        <td>浏览器以及版本</td>
                        <td>Robot</td>
                        <td>时间</td>
                    </tr>

                @for($i=0; $i<count($visitors); $i++)
                    @if(empty($visitors[$i]->robot))
                            <tr>
                                <td>{!! $visitors[$i]->username?$visitors[$i]->username:($visitors[$i]->robot?'<i class="fa fa-bug"></i>':'游客') !!}</td>
                                <td style="max-width: 250px;text-overflow: clip">{{ $visitors[$i]->from_url}}</td>
                                <td>{{ $visitors[$i]->ip }}</td>
                                <td>{{ $visitors[$i]->os.' '.$visitors[$i]->os_version }}</td>
                                <td>{{ $visitors[$i]->browser.' '.$visitors[$i]->browser_version }}</td>
                                <td>{{ $visitors[$i]->robot }}</td>
                                <td>{{ $visitors[$i]->created_at }}</td>
                            </tr>
                        @endif
                @endfor
                </table>
            </div>
        </div>
    </div>

@endsection
@section('script')

@endsection