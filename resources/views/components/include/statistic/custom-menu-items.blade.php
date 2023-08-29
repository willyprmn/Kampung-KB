@foreach($items as $item)
    <li class="{{ $item->hasChildren() ? 'dropdown' : 'statistik__menu' }}">

        @if($item->hasChildren())
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
        @else
            <a href="{!! $item->url() !!}" data-toggle="tooltip" data-placement="top" title="{!! $item->attributes['tooltip'] ?? '' !!}">
                {!! $item->title !!}
            </a>
        @endif

    </li>
@endforeach