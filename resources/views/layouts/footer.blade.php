@include('partials.delete_modal')
<footer class="footer" id="footer">
    <div class="copyright">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <span>Copyright © <a href="{{ route('index') }}">{{ $site_title or '' }}</a></span> |
                    <span> 鲁ICP备15006514号-3</span> |
                    <span><a href="https://github.com/johnnyzhang1992/xblog"><i class="fa fa-github fa-fw"></i></a> </span>
                </div>
            </div>
        </div>
    </div>
</footer>
<!--返回顶部-->
<div id="topon" style="display: block;">
    <div class="fa fa-arrow-up to_top"></div>
</div>