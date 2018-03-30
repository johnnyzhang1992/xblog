@if(!isAdmin(Auth::user()) && isset($google_analytics) && $google_analytics == 'true')
    {{--<script>--}}
        {{--(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){--}}
                    {{--(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),--}}
                {{--m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)--}}
        {{--})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');--}}
        {{--ga('create', '{{ $google_trace_id or '' }}', 'auto');--}}
        {{--ga('send', 'pageview');--}}

    {{--</script>--}}
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $google_trace_id or '' }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', '{{ $google_trace_id or '' }}');
    </script>

@endif