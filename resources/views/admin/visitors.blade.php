@extends('admin.layouts.app')
@section('title','浏览统计')
@section('content')
    <div class="row">
        <div class="widget widget-default">
            <div class="widget-header">
                <h6><i class="fa fa-file-image-o fa-fw"></i>浏览量（）</h6>
            </div>
            <div class="widget-body">
                @for($i=0; $i<count($visitors); $i++)
                    <?php
                    $visitor = $visitors[$i];
                    $geoinfo = \json_decode($visitor->geoinfo);
                    ?>
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{!! $visitor->username?$visitor->username:($visitor->robot?'<i class="fa fa-bug"></i>':'游客') !!}</td>
                        <td>{{ $visitor->email }}</td>
                        <td>{{ $visitor->ip }}</td>
                        <td>{{ @$geoinfo->city .','. @$geoinfo->country_name.' '. @$geoinfo->postal_code }}</td>
                        <td>{{ $visitor->device }}</td>
                        <td>{{ $visitor->os.' '.$visitor->os_version }}</td>
                        <td>{{ $visitor->browser.' '.$visitor->browser_version }}</td>
                        <td>{{ $visitor->robot }}</td>
                        <td>{{ $visitor->created_at }}</td>
                    </tr>
                @endfor
            </div>
        </div>
    </div>

@endsection
@section('script')

@endsection