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
                        <td>ID</td>
                        <td>name</td>
                        <td>from_url</td>
                        <td>IP</td>
                        <td>系统以及版本</td>
                        <td>浏览器以及版本</td>
                        <td>Robot</td>
                        <td>时间</td>
                    </tr>

                @for($i=0; $i<count($visitors); $i++)
                    <?php $visitor = $visitors[$i]; ?>
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{!! $visitor->username?$visitor->username:($visitor->robot?'<i class="fa fa-bug"></i>':'游客') !!}</td>
                        <td style="max-width: 250px;text-overflow: clip">{{ $visitor->from_url}}</td>
                        <td>{{ $visitor->ip }}</td>
                        <td>{{ $visitor->os.' '.$visitor->os_version }}</td>
                        <td>{{ $visitor->browser.' '.$visitor->browser_version }}</td>
                        <td>{{ $visitor->robot }}</td>
                        <td>{{ $visitor->created_at }}</td>
                    </tr>
                @endfor
                </table>
            </div>
        </div>
    </div>

@endsection
@section('script')

@endsection