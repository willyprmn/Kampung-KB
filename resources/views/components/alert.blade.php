<div class="alert alert-{{ $variant }} alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h5>
        <i class="icon fas
            @switch($variant)
                @case('success')
                    fa-check
                    @break
                @case('warning')
                    fa-exclamation-triangle
                    @break
                @case('info')
                    fa-info
                    @break
                @case('danger')
                    fa-ban
                    @break
            @endswitch
        "></i>
        {{ $title }}
    </h5>
    {{ $message }}
</div>