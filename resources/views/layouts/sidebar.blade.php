
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ asset('dist/img/logo.jpg') }}"
             alt="Logo"
             class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">Smart Exam System</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Logged-in User -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('dist/img/man.png') }}"
                     class="img-circle elevation-2"
                     alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                <small class="text-light">
                    {{ ucfirst(Auth::user()->role) }}
                </small>
            </div>
        </div>

        <!-- Sidebar Search -->
        <div class="form-inline sidebar-menu-search">
            <div class="input-group">
                <input id="sidebar-menu-search"
                       class="form-control form-control-sidebar"
                       type="search"
                       placeholder="Search menu"
                       autocomplete="off"
                       aria-label="Search menu">
                <div class="input-group-append">
                    <button class="btn btn-sidebar" type="button" id="sidebar-menu-search-btn">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
            <div id="sidebar-menu-search-results" class="sidebar-menu-search-results" hidden></div>
        </div>

        <style>
            .sidebar-menu-search {
                position: relative;
                width: 100%;
            }
            .sidebar-menu-search .input-group {
                width: 100%;
            }
            .sidebar-menu-search-results {
                position: absolute;
                left: 0;
                right: 0;
                top: 100%;
                z-index: 1050;
                margin-top: 2px;
                background: #343a40;
                border: 1px solid #4b545c;
                border-radius: 0 0 .25rem .25rem;
                max-height: 280px;
                overflow-y: auto;
            }
            .sidebar-menu-search-results a,
            .sidebar-menu-search-results .empty {
                display: block;
                padding: .5rem .75rem;
                color: #c2c7d0;
                text-decoration: none;
                border-bottom: 1px solid #4b545c;
            }
            .sidebar-menu-search-results a:last-child,
            .sidebar-menu-search-results .empty:last-child {
                border-bottom: 0;
            }
            .sidebar-menu-search-results a:hover,
            .sidebar-menu-search-results a.active {
                background: #007bff;
                color: #fff;
            }
            .sidebar-menu-search-results .empty {
                color: #adb5bd;
                font-size: .875rem;
            }
            .sidebar-menu-search-results .search-path {
                display: block;
                font-size: 75%;
                opacity: .75;
            }
        </style>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column"
                data-widget="treeview"
                role="menu"
                data-accordion="false">

                <!-- Dashboard: All Roles -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                @if(Auth::user()->role === 'admin')

                    <!-- Academic Management -->
                    <li class="nav-header">ACADEMIC MANAGEMENT</li>

                    <li class="nav-item {{ request()->routeIs('departments.*', 'students.*', 'staff.*', 'subjects.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('departments.*', 'students.*', 'staff.*', 'subjects.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-graduation-cap"></i>
                            <p>
                                Academic 
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('departments.index') }}" class="nav-link {{ request()->routeIs('departments.*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Departments</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('students.index') }}" class="nav-link {{ request()->routeIs('students.*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Students</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('staff.index') }}" class="nav-link {{ request()->routeIs('staff.*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Staff</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('subjects.index') }}" class="nav-link {{ request()->routeIs('subjects.*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Subjects</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Examination Management -->
                    <li class="nav-header">EXAMINATION MANAGEMENT</li>

                    <li class="nav-item {{ request()->routeIs('exams.*', 'exam-registrations.*', 'exam-halls.*', 'hall-seats.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('exams.*', 'exam-registrations.*', 'exam-halls.*', 'hall-seats.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>
                                Examination
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('exams.index') }}" class="nav-link {{ request()->routeIs('exams.*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Exams</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('exam-registrations.index') }}" class="nav-link {{ request()->routeIs('exam-registrations.*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Exam Registrations</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('exam-halls.index') }}" class="nav-link {{ request()->routeIs('exam-halls.*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Exam Halls</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('hall-seats.index') }}" class="nav-link {{ request()->routeIs('hall-seats.*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Hall Seats</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Seating Management -->
                    <li class="nav-header">SEATING MANAGEMENT</li>

                    <li class="nav-item {{ request()->routeIs('seating-arrangements.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('seating-arrangements.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chair"></i>
                            <p>
                                Seating 
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('seating-arrangements.create') }}" class="nav-link {{ request()->routeIs('seating-arrangements.create') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Generate / Assign</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('seating-arrangements.index') }}" class="nav-link {{ request()->routeIs('seating-arrangements.index') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Arrangements</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Conflict Management -->
                    <li class="nav-item">
                        <a href="{{ route('conflicts.index') }}" class="nav-link {{ request()->routeIs('conflicts.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-exclamation-triangle"></i>
                            <p>Conflict Management</p>
                        </a>
                    </li>

                    <!-- User Management -->
                    <li class="nav-header">USER MANAGEMENT</li>

                    <li class="nav-item">
                        <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users-cog"></i>
                            <p>Users</p>
                        </a>
                    </li>

                    <!-- System -->
                    <li class="nav-item">
                        <a href="{{ route('settings.index') }}" class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>Settings</p>
                        </a>
                    </li>

                @elseif(Auth::user()->role === 'staff')

                    <!-- Staff Menu -->
                    <li class="nav-header">STAFF PORTAL</li>

                    <li class="nav-item">
                        <a href="{{ route('staff.exam-duties') }}" class="nav-link {{ request()->routeIs('staff.exam-duties*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-clipboard-list"></i>
                            <p>Exam Duties</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('staff.seating') }}" class="nav-link {{ request()->routeIs('staff.seating') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chair"></i>
                            <p>Seating Arrangements</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('staff.conflicts.index') }}" class="nav-link {{ request()->routeIs('staff.conflicts.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-exclamation-triangle"></i>
                            <p>Report Conflicts</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('staff.profile') }}" class="nav-link {{ request()->routeIs('staff.profile') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user"></i>
                            <p>My Profile</p>
                        </a>
                    </li>

                @elseif(Auth::user()->role === 'student')

                    <!-- Student Menu -->
                    <li class="nav-header">STUDENT PORTAL</li>

                    <li class="nav-item">
                        <a href="{{ route('student.exams') }}" class="nav-link {{ request()->routeIs('student.exams') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-calendar-alt"></i>
                            <p>My Exams</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('student.seating') }}" class="nav-link {{ request()->routeIs('student.seating') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chair"></i>
                            <p>My Seating Arrangement</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('student.profile') }}" class="nav-link {{ request()->routeIs('student.profile') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user"></i>
                            <p>My Profile</p>
                        </a>
                    </li>

                @endif

                <!-- Logout: All Roles -->
                <li class="nav-header">ACCOUNT</li>

                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="nav-link btn btn-link text-left w-100">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Logout</p>
                        </button>
                    </form>
                </li>

            </ul>
        </nav>
    </div>
</aside>
