@foreach($items as $item)
    <div class="bd-toc-item active">
        <a class="bd-toc-link" href="#" data-toggle="tooltip" data-placement="top" title="{!! $item->attributes['tooltip'] ?? '' !!}">
            {{ $item->title }}
        </a>
        @if($item->hasChildren())
            <ul class="nav bd-sidenav">
                @include('components.include.statistic.custom-menu-items', ['items' => $item->children()])
            </ul>
        @endif
    </div>
@endforeach
