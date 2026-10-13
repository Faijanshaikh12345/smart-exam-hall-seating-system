<!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{ asset('dist/img/logo.jpg') }}" alt="Logo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button" title="Toggle sidebar">
          <i class="fas fa-bars"></i>
        </a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('dashboard') }}" class="nav-link">Home</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search (searches sidebar menu pages) -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button" title="Search pages">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline" id="navbar-menu-search-form" action="{{ route('dashboard') }}" method="get">
            <div class="input-group input-group-sm">
              <input id="navbar-menu-search"
                     class="form-control form-control-navbar"
                     type="search"
                     placeholder="Search pages (Exams, Students, Seating...)"
                     autocomplete="off"
                     aria-label="Search pages">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit" title="Go to matching page">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search" title="Close search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

      <!-- Notifications -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" title="Notifications">
          <i class="far fa-bell"></i>
          @if(count($headerNotifications ?? []))
            <span class="badge badge-warning navbar-badge">{{ count($headerNotifications) }}</span>
          @endif
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">
            @if(count($headerNotifications ?? []))
              {{ count($headerNotifications) }} Notification{{ count($headerNotifications) === 1 ? '' : 's' }}
            @else
              No new notifications
            @endif
          </span>
          @forelse($headerNotifications ?? [] as $notification)
            <div class="dropdown-divider"></div>
            <a href="{{ $notification['url'] }}" class="dropdown-item">
              <i class="{{ $notification['icon'] }} mr-2"></i>
              {{ $notification['text'] }}
            </a>
          @empty
            <div class="dropdown-divider"></div>
            <span class="dropdown-item text-muted text-sm">
              You are all caught up.
            </span>
          @endforelse
          <div class="dropdown-divider"></div>
          <a href="{{ route('dashboard') }}" class="dropdown-item dropdown-footer">Go to Dashboard</a>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button" title="Fullscreen">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>

      <!-- Account -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" title="Account">
          <i class="far fa-user"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
          <span class="dropdown-item dropdown-header">
            {{ Auth::user()->name }}
            <div class="text-muted text-sm font-weight-normal">{{ ucfirst(Auth::user()->role) }}</div>
          </span>
          <div class="dropdown-divider"></div>
          @if(Auth::user()->role === 'student')
            <a href="{{ route('student.profile') }}" class="dropdown-item">
              <i class="fas fa-id-card mr-2"></i> My Profile
            </a>
          @elseif(Auth::user()->role === 'staff')
            <a href="{{ route('staff.profile') }}" class="dropdown-item">
              <i class="fas fa-id-card mr-2"></i> My Profile
            </a>
          @else
            <a href="{{ route('dashboard') }}" class="dropdown-item">
              <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
            </a>
          @endif
          <div class="dropdown-divider"></div>
          <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="dropdown-item text-danger">
              <i class="fas fa-sign-out-alt mr-2"></i> Logout
            </button>
          </form>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->
