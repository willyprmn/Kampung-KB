<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">Home</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

        <!-- Notifications Dropdown Menu -->
        {{-- <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-user"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">Action</span>
          <div class="dropdown-divider"></div>
          {{ Form::open(['route' => ['logout'], 'method' => 'POST']) }}
        <button type="submit" class="dropdown-item">
            <i class="fas fa-sign-out-alt"></i> Logout
        </button>
        {{ Form::close() }}
        </div>
        </li> --}}

        <li class="nav-item" style="padding-right:20px;">
            <button class="btn btn-secondary">
                <i class="fas fa-book-reader"></i>
                <a href="https://drive.google.com/file/d/1HiBnhYaxS_2sQ1iZZ3YvWnJF4raNwDLS/view?usp=sharing" style="color:white;" target="_blank">
                    User Manual
                </a>
            </button>
        </li>

        <li class="nav-item">
            {{ Form::open(['route' => ['logout'], 'method' => 'POST']) }}
            <button type="submit" class="btn btn-secondary">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
            {{ Form::close() }}
        </li>

    </ul>
</nav>
<!-- /.navbar -->
