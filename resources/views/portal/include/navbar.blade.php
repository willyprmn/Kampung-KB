<nav class="navbar navbar-expand-md navbar-light bg-white">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('images/bkkbn.png') }}" alt="Logo BKKBN" height="50" width="120.19">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('portal.kampung.index') }}">Jelajahi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('portal.percontohan') }}">Percontohan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('portal.statistik.index') }}">Statistik</a>
                </li>
            </ul>

            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <div class="input-group">
                        {!! Form::open(['route' => ['portal.kampung.index'], 'method' => 'GET', 'style' => 'margin: 0;']) !!}
                            {{ Form::text('cari', null, [
                                'id' => 'search',
                                'class' => 'form-control border-end-0 border rounded-pill',
                                'placeholder' => 'Cari nama kampung'
                            ]) }}
                        {!! Form::close() !!}
                    </div>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <!-- Authentication Links -->

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('portal.tentang') }}">Tentang Kampung KB</a>
                    </li>
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <strong>Login as </strong> {{ Auth::user()->email }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('admin.kampungs.index') }}">Admin</a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>