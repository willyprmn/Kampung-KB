<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('portal.home') }}" class="brand-link">
        <img src="{{ asset('images/logo-bkkbn.jpeg') }}" alt="Kampung KB" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">Kampung KB</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('/images/user.png') }}" class="img-circle elevation-2" alt="{{ Auth::user()->email }}">
            </div>
            <div class="info">
                <a href="{{ route('admin.profile') }}" class="d-block">{{ Auth::user()->email }}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @foreach ($menus as $menu)
                    @php
                        $activeParent = $menu->children
                            ->contains(function ($item, $key) {
                                return array_slice(explode('.', $item->name), 0, 2)
                                ===
                                array_slice(explode('.', request()->route()->getName()), 0, 2);
                            })
                    @endphp
                    <li class="nav-item {{ $activeParent ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ $activeParent ? 'active' : '' }}">
                            <i class="nav-icon fas fa-{{ $menu->icon }}"></i>
                            <p>
                                {{ $menu->label }}
                                @if ($menu->children->isNotEmpty())
                                    <i class="right fas fa-angle-left"></i>
                                @endif
                            </p>
                        </a>

                        @if ($menu->children->isNotEmpty())
                            <ul class="nav nav-treeview">
                                @foreach ($menu->children as $submenu)
                                    <li class="nav-item">
                                        <a href="{{ route($submenu->name) }}" class="nav-link {{
                                            array_slice(explode('.', request()->route()->getName()) , 0, 2)
                                            ===
                                            array_slice(explode('.', $submenu->name), 0, 2) ? 'active' : ''
                                        }}">
                                            <i class="far fa-{{ $submenu->icon }} nav-icon"></i>
                                            <p>{{ $submenu->label }}</p>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>
</aside>
