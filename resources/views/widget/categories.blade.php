<div class="widget widget-default">
    <div class="widget-header"><h6><i class="fa fa-folder fa-fw"></i>分类</h6></div>
    <ul class="widget-body list-group">
        @forelse($categories as $category)
            @if(str_contains(urldecode(request()->getPathInfo()),'category/'.$category->name))
                <li href="{{ route('category.show',$category->name) }}"
                    class="list-group-item active">
                    {{ $category->name }}
                    <span class="badge">{{ $category->posts_count }}</span>
                </li>
            @else
                <a href="{{ route('category.show',$category->name) }}"
                   class="list-group-item">
                    {{ $category->name }}
                    <span class="badge">{{ $category->posts_count }}</span>
                </a>
            @endif
        @empty
            <p class="meta-item center-block">No categories.</p>
        @endforelse
    </ul>
</div>