<?php
$comment_type = isset($comment_type) ? $comment_type : 'raw';
$final_comment_type = ($commentable_config == 'default' ? $comment_type : $commentable_config);
?>
@if($final_comment_type == 'raw')
    @include('widget.raw_comment')
@elseif($final_comment_type == 'duoshuo')
    @include('widget.duoshuo_comment')
@elseif($final_comment_type == 'disqus')
    @include('widget.disqus_comment')
@endif