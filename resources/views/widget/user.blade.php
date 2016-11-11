<div class="widget widget-user" style="overflow: hidden">
    <?php
    if (isset($profile_image) && $profile_image)
        $style = "background: url($profile_image) center center;";
    else
        $style = "background-color: #607D8B;";
    ?>
    <div class="widget-user-header" style="{{ $style }}">
        <h3 class="widget-user-username">lufficc</h3>
        <h5 class="widget-user-desc">{{ $description or 'description' }}</h5>
    </div>
    <div class="widget-user-image">
        <img class="img-circle" src="{{ $avatar or '' }}" alt="User Avatar">
    </div>
    <div class="widget-user-footer">
        <div class="row">
            <?php $count = count(config('social'))?>
            @foreach(config('social') as $key => $value)
                <div class="col-xs-{{ intval(12 / $count) }} border-right center-block">
                    <div class="description-block">
                        <a href="{{ $value['url'] }}" title="{{ ucfirst($key) }}" class="description-header"><i
                                    class="{{ $value['fa'].' fa-lg' }}"
                                    aria-hidden="true"></i></a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>