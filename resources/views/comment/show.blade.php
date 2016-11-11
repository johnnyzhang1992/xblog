@forelse($comments as $comment)
    <div class="comment">
        <div class="pull-left">
            <?php
            $href = $comment->user ? route('user.show', $comment->username) : 'javascript:void(0);';
            ?>
            <a name="comment{{ $loop->index + 1 }}" href="{{ $href }}">
                <img width="48px" height="48px" class="img-circle"
                     src="{{ $comment->user ? $comment->user->avatar :'https://static.lufficc.com/image/default_avatar.png' }}">
            </a>
        </div>
        <div class="comment-info">
            <div class="comment-head">
                <a href="{{ $href }}">{{ $comment->username }}</a>
                <span class="comment-operation pull-right">
                    @can('manager',$comment)
                        <a href="javascript:void (0)" data-method="delete" data-modal-target="这条评论"
                           data-url="{{ route('comment.destroy',$comment->id) }}">
                            <i class="fa fa-trash-o fa-fw"></i>
                        </a>
                        <a style="text-decoration: none" href="{{ route('comment.edit',[$comment->id,'redirect'=>(isset($redirect) && $redirect.'#'.$loop->index ? $redirect : '')]) }}">
                            <i class="fa fa-pencil fa-fw"></i>
                        </a>
                    @endcan
                    <a href="javascript:void (0);" onclick="replySomeone('{{ $comment->username }}')">
                        <i class="fa fa-reply fa-fw"></i>
                    </a>
            </span>
            </div>
            <div class="comment-time">
                <span>{{ $comment->created_at->format('Y/m/d H:i') }}</span>
            </div>
            <div class="markdown-content">
                {!! $comment->html_content !!}
            </div>
        </div>
        <div class="alone-divider"></div>
    </div>
@empty
    <p class="meta-item center-block">暂无评论~~</p>
@endforelse