@extends('admin.layouts.app')
@section('title','图片')
@section('content')
    <div class="row">
        <div class="widget widget-default">
            <div class="widget-header">
                <h6><i class="fa fa-file-image-o fa-fw"></i>图片({{ $image_count }})</h6>
            </div>
            <div class="widget-body">
                <form role="form" class="form-horizontal" action="{{ route('upload.image') }}"
                      datatype="image"
                      required=""
                      enctype="multipart/form-data" method="post">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="image" class="col-xs-2 col-xs-offset-1 control-label">
                            上传到七牛：<i class="fa fa-file-image-o fa-lg fa-fw"></i>
                        </label>
                        <div class="col-xs-6">
                            <input id="image" class="form-control" accept="image/*" type="file" name="image">
                        </div>
                        <div class="col-xs-2">
                            <button type="submit" class="btn btn-primary">
                                上传
                            </button>
                        </div>
                    </div>
                </form>
                <form role="form" class="form-horizontal" action="{{ route('upload.image.local') }}"
                      datatype="image"
                      required=""
                      enctype="multipart/form-data" method="post">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="image" class="col-xs-2 col-xs-offset-1 control-label">
                            上传到本地：<i class="fa fa-file-image-o fa-lg fa-fw"></i>
                        </label>
                        <div class="col-xs-6">
                            <input id="image" class="form-control" accept="image/*" type="file" name="image">
                        </div>
                        <div class="col-xs-2">
                            <button type="submit" class="btn btn-primary">
                                上传
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        @forelse($images as $image)
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="widget widget-default">
                    <div class="js-imgLiquid" style="width: 100% ;height: 250px;">
                        @if($image->from == 'local')
                            <img class="img-responsive" src="{{ asset($image->key) }}" style="width: 250px">
                        @else
                            <img class="img-responsive" src="{{ getImageViewUrl($image->key,null,250) }}">
                        @endif
                    </div>
                    <div class="widget-footer">
                        <div class="widget-meta">
                            @if($image->from == 'local')
                                <button id="clipboard-btn" class="btn btn-default"
                                        type="button"
                                        data-clipboard-text="{{ asset($image->key) }}"
                                        data-toggle="tooltip"
                                        data-placement="left"
                                        title="Copied">
                                    <i class="fa fa-copy fa-fw"></i>
                                </button>
                                <a  class="btn btn-primary"
                                    href="{{ asset($image->key) }}"
                                    target="_blank">
                                    <i class="fa fa-eye fa-fw"></i>
                                </a>
                                <button class="btn btn-danger"
                                        data-method="delete"
                                        data-modal-target="{{ $image->key }}"
                                        data-url="{{ route('delete.local_file').'?key='.$image->key.'&type=image' }}"
                                        data-key="{{ $image->key }}">
                                    <i class="fa fa-trash-o fa-fw"></i>
                                </button>
                            @else
                                <button id="clipboard-btn" class="btn btn-default"
                                        type="button"
                                        data-clipboard-text="{{ getUrlByFileName($image->key) }}"
                                        data-toggle="tooltip"
                                        data-placement="left"
                                        title="Copied">
                                    <i class="fa fa-copy fa-fw"></i>
                                </button>
                                <a  class="btn btn-primary"
                                    href="{{ getUrlByFileName($image->key) }}"
                                    target="_blank">
                                    <i class="fa fa-eye fa-fw"></i>
                                </a>
                                <button class="btn btn-danger"
                                        data-method="delete"
                                        data-modal-target="{{ $image->key }}"
                                        data-url="{{ route('delete.file').'?key='.$image->key.'&type=image' }}"
                                        data-key="{{ $image->key }}">
                                    <i class="fa fa-trash-o fa-fw"></i>
                                </button>
                            @endif

                            {{ formatBytes($image->size) }}
                            <i class="fa fa-clock-o fa-fw"></i>
                            {{ $image->created_at->format('Y-m-d') }}
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <h3 class="center-block meta-item">没有图片</h3>
        @endforelse
    </div>
    @if($images->lastPage() > 1)
        <div class="row">
            <div class="col-md-12">
                {{ $images->links() }}
            </div>
        </div>
    @endif
@endsection
@section('script')
    <script src="//cdn.bootcss.com/clipboard.js/1.5.12/clipboard.min.js"></script>
    <script>
        new Clipboard('.btn');
        $('.btn').tooltip({
            trigger: 'click',
        });
    </script>
@endsection