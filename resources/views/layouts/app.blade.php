<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PFM University') }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Scripts & Tailwind/Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        if (localStorage.getItem('theme') !== 'dark') {
            document.documentElement.classList.add('light-theme');
        }
    </script>
</head>

<body class="font-sans antialiased text-gray-200 bg-[#070b14] overflow-hidden">
    <script>
        if (localStorage.getItem('theme') !== 'dark') {
            document.body.classList.add('light-theme');
        }
    </script>

    <!-- Background Blobs -->
    <div class="bg-blob blob-1"></div>
    <div class="bg-blob blob-2"></div>
    <div class="bg-blob blob-3"></div>

    <div class="app-wrapper" x-data="{ sidebarCollapsed: false, mobileSidebarOpen: false }">

        <!-- Sidebar overlay for mobile -->
        <div class="sidebar-overlay" :class="{ 'open': mobileSidebarOpen }" @click="mobileSidebarOpen = false"></div>

        <!-- ═══════════ SIDEBAR LATÉRALE ═══════════ -->
        <aside class="sidebar" :class="{ 'collapsed': sidebarCollapsed, 'open': mobileSidebarOpen }">
            <div class="sidebar-header">
                <div class="logo-icon">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2.5">
                        <path d="M12 3L1 9L12 15L21 9L12 3M5 13.18V17.18L12 21L19 17.18V13.18L12 17L5 13.18Z" />
                    </svg>
                </div>
                <span class="logo-text">PFM Analytics</span>
            </div>

            <nav class="sidebar-nav">
                @if(auth()->user()->isAdmin())
                    <span class="nav-section-label">{{ __('app.dashboard') }}</span>
                    <a href="{{ route('dashboard') }}"
                        class="sidebar-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <rect x="3" y="3" width="7" height="7" rx="1" />
                                <rect x="14" y="3" width="7" height="7" rx="1" />
                                <rect x="3" y="14" width="7" height="7" rx="1" />
                                <rect x="14" y="14" width="7" height="7" rx="1" />
                            </svg>
                        </span>
                        <span class="nav-label">{{ __('app.crm_dashboard') }}</span>
                    </a>
                @endif

                <!-- Links for ADMIN -->
                @if(auth()->user()->isAdmin())
                    <span class="nav-section-label" style="margin-top:8px;">{{ __('app.administration') }}</span>

                    <a href="{{ route('admin.dashboard') }}"
                        class="sidebar-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                        </span>
                        <span class="nav-label">{{ __('app.admin_general') }}</span>
                    </a>

                    <a href="{{ route('admin.users.index') }}"
                        class="sidebar-nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                            </svg>
                        </span>
                        <span class="nav-label">{{ __('app.users') }}</span>
                    </a>

                    <a href="{{ route('admin.departments.index') }}"
                        class="sidebar-nav-link {{ request()->routeIs('admin.departments.*') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                                <polyline points="9,22 9,12 15,12 15,22" />
                            </svg>
                        </span>
                        <span class="nav-label">{{ __('app.departments') }}</span>
                    </a>

                    <a href="{{ route('admin.groups.index') }}"
                        class="sidebar-nav-link {{ request()->routeIs('admin.groups.*') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="2" y1="12" x2="22" y2="12" />
                                <path
                                    d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" />
                            </svg>
                        </span>
                        <span class="nav-label">{{ __('app.groups') }}</span>
                    </a>

                    <a href="{{ route('admin.modules.index') }}"
                        class="sidebar-nav-link {{ request()->routeIs('admin.modules.*') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5z" />
                                <path d="M8 7h8M8 11h8M8 15h5" />
                            </svg>
                        </span>
                        <span class="nav-label">{{ __('app.modules') }}</span>
                    </a>

                    <a href="{{ route('admin.rooms.index') }}"
                        class="sidebar-nav-link {{ request()->routeIs('admin.rooms.*') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                                <line x1="9" y1="3" x2="9" y2="21" />
                            </svg>
                        </span>
                        <span class="nav-label">{{ __('app.rooms') }}</span>
                    </a>

                    <a href="{{ route('admin.schedules.index') }}"
                        class="sidebar-nav-link {{ request()->routeIs('admin.schedules.*') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2" />
                                <line x1="16" y1="2" x2="16" y2="6" />
                                <line x1="8" y1="2" x2="8" y2="6" />
                                <line x1="3" y1="10" x2="21" y2="10" />
                            </svg>
                        </span>
                        <span class="nav-label">{{ __('app.schedules') }}</span>
                    </a>

                    <a href="{{ route('admin.absences.index') }}"
                        class="sidebar-nav-link {{ request()->routeIs('admin.absences.*') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path
                                    d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                                <line x1="12" y1="9" x2="12" y2="13" />
                                <line x1="12" y1="17" x2="12.01" y2="17" />
                            </svg>
                        </span>
                        <span class="nav-label">{{ __('app.absences') }}</span>
                    </a>

                    <a href="{{ route('admin.lesson_logs.index') }}"
                        class="sidebar-nav-link {{ request()->routeIs('admin.lesson_logs.*') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <polyline points="14 2 14 8 20 8" />
                                <line x1="16" y1="13" x2="8" y2="13" />
                                <line x1="16" y1="17" x2="8" y2="17" />
                                <polyline points="10 9 9 9 8 9" />
                            </svg>
                        </span>
                        <span class="nav-label">{{ __('app.lesson_logs') }}</span>
                    </a>

                    <a href="{{ route('admin.reservations.index') }}"
                        class="sidebar-nav-link {{ request()->routeIs('admin.reservations.*') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                <line x1="16" y1="2" x2="16" y2="6" />
                                <line x1="8" y1="2" x2="8" y2="6" />
                                <line x1="3" y1="10" x2="21" y2="10" />
                            </svg>
                        </span>
                        <span class="nav-label">{{ __('app.reservations') }}</span>
                    </a>

                    <!-- Links for PROFESSOR -->
                @elseif(auth()->user()->isProfessor())
                    <span class="nav-section-label" style="margin-top:8px;">{{ __('app.professor_section') }}</span>

                    <a href="{{ route('professor.dashboard') }}"
                        class="sidebar-nav-link {{ request()->routeIs('professor.dashboard') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
                            </svg>
                        </span>
                        <span class="nav-label">{{ __('app.my_space') }}</span>
                    </a>

                    <a href="{{ route('professor.grades.index') }}"
                        class="sidebar-nav-link {{ request()->routeIs('professor.grades.*') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <line x1="18" y1="20" x2="18" y2="10" />
                                <line x1="12" y1="20" x2="12" y2="4" />
                                <line x1="6" y1="20" x2="6" y2="14" />
                            </svg>
                        </span>
                        <span class="nav-label">{{ __('app.grades') }}</span>
                    </a>

                    <a href="{{ route('professor.absences.index') }}"
                        class="sidebar-nav-link {{ request()->routeIs('professor.absences.*') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path d="M9 11l3 3L22 4" />
                                <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11" />
                            </svg>
                        </span>
                        <span class="nav-label">{{ __('app.absences') }}</span>
                    </a>

                    <a href="{{ route('professor.lesson_logs.index') }}"
                        class="sidebar-nav-link {{ request()->routeIs('professor.lesson_logs.*') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path d="M12 20h9" />
                                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
                            </svg>
                        </span>
                        <span class="nav-label">{{ __('app.lesson_log') }}</span>
                    </a>

                    <a href="{{ route('professor.materials.index') }}"
                        class="sidebar-nav-link {{ request()->routeIs('professor.materials.*') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5z" />
                            </svg>
                        </span>
                        <span class="nav-label">{{ __('app.materials') }}</span>
                    </a>

                    <a href="{{ route('professor.announcements.index') }}"
                        class="sidebar-nav-link {{ request()->routeIs('professor.announcements.*') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path
                                    d="M10.3 21a1.94 1.94 0 0 0 3.4 0M18.3 17A16.14 16.14 0 0 0 19 8a7 7 0 0 0-14 0 16.14 16.14 0 0 0 .7 9m1.6 0h12" />
                            </svg>
                        </span>
                        <span class="nav-label">{{ __('app.announcements') }}</span>
                    </a>

                    <a href="{{ route('professor.reservations.index') }}"
                        class="sidebar-nav-link {{ request()->routeIs('professor.reservations.*') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                <line x1="16" y1="2" x2="16" y2="6" />
                                <line x1="8" y1="2" x2="8" y2="6" />
                                <line x1="3" y1="10" x2="21" y2="10" />
                            </svg>
                        </span>
                        <span class="nav-label">{{ __('app.reservations') }}</span>
                    </a>

                    <a href="{{ route('professor.schedules.index') }}"
                        class="sidebar-nav-link {{ request()->routeIs('professor.schedules.*') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2" />
                                <line x1="16" y1="2" x2="16" y2="6" />
                                <line x1="8" y1="2" x2="8" y2="6" />
                                <line x1="3" y1="10" x2="21" y2="10" />
                            </svg>
                        </span>
                        <span class="nav-label">{{ __('app.my_schedule') }}</span>
                    </a>

                    <a href="{{ route('professor.requests.index') }}"
                        class="sidebar-nav-link {{ request()->routeIs('professor.requests.*') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <polyline points="14 2 14 8 20 8" />
                                <line x1="16" y1="13" x2="8" y2="13" />
                                <line x1="16" y1="17" x2="8" y2="17" />
                                <polyline points="10 9 9 9 8 9" />
                            </svg>
                        </span>
                        <span class="nav-label">{{ __('app.my_requests') }}</span>
                    </a>

                    <a href="{{ route('courses.index') }}"
                        class="sidebar-nav-link {{ request()->routeIs('courses.*') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5z" />
                            </svg>
                        </span>
                        <span class="nav-label">{{ __('app.classroom') }}</span>
                    </a>

                    <!-- Links for STUDENT -->
                @elseif(auth()->user()->isStudent())
                    <span class="nav-section-label" style="margin-top:8px;">{{ __('app.student_section') }}</span>

                    <a href="{{ route('student.dashboard') }}"
                        class="sidebar-nav-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
                            </svg>
                        </span>
                        <span class="nav-label">{{ __('app.my_space') }}</span>
                    </a>

                    <a href="{{ route('student.grades.index') }}"
                        class="sidebar-nav-link {{ request()->routeIs('student.grades.*') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <line x1="18" y1="20" x2="18" y2="10" />
                                <line x1="12" y1="20" x2="12" y2="4" />
                                <line x1="6" y1="20" x2="6" y2="14" />
                            </svg>
                        </span>
                        <span class="nav-label">{{ __('app.my_grades') }}</span>
                    </a>

                    <a href="{{ route('student.absences.index') }}"
                        class="sidebar-nav-link {{ request()->routeIs('student.absences.*') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path
                                    d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                                <line x1="12" y1="9" x2="12" y2="13" />
                                <line x1="12" y1="17" x2="12.01" y2="17" />
                            </svg>
                        </span>
                        <span class="nav-label">{{ __('app.absences') }}</span>
                    </a>

                    <a href="{{ route('student.schedules.index') }}"
                        class="sidebar-nav-link {{ request()->routeIs('student.schedules.*') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2" />
                                <line x1="16" y1="2" x2="16" y2="6" />
                                <line x1="8" y1="2" x2="8" y2="6" />
                                <line x1="3" y1="10" x2="21" y2="10" />
                            </svg>
                        </span>
                        <span class="nav-label">{{ __('app.my_schedule') }}</span>
                    </a>

                    <a href="{{ route('courses.index') }}"
                        class="sidebar-nav-link {{ request()->routeIs('courses.*') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5z" />
                            </svg>
                        </span>
                        <span class="nav-label">{{ __('app.classroom') }}</span>
                    </a>

                    <a href="{{ route('student.requests.index') }}"
                        class="sidebar-nav-link {{ request()->routeIs('student.requests.*') ? 'active' : '' }}">
                        <span class="nav-icon">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <polyline points="14 2 14 8 20 8" />
                                <line x1="16" y1="13" x2="8" y2="13" />
                                <line x1="16" y1="17" x2="8" y2="17" />
                                <polyline points="10 9 9 9 8 9" />
                            </svg>
                        </span>
                        <span class="nav-label">{{ __('app.requests') }}</span>
                    </a>
                @endif

                <!-- Profile Link (Common) -->
                <span class="nav-section-label" style="margin-top:8px;">{{ __('app.system') }}</span>
                <a href="{{ route('profile.edit') }}"
                    class="sidebar-nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <circle cx="12" cy="8" r="4" />
                            <path d="M20 21a8 8 0 1 0-16 0" />
                        </svg>
                    </span>
                    <span class="nav-label">{{ __('app.my_profile') }}</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <div class="user-info">
                    <div class="user-avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
                    <div class="user-details">
                        <div class="user-name">{{ auth()->user()->name }}</div>
                        <div class="user-role">{{ ucfirst(auth()->user()->role) }}</div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- ═══════════ MAIN CONTENT ═══════════ -->
        <div class="main-content">

            <!-- TOP BAR -->
            <header class="topbar">
                <div class="topbar-left">
                    <button class="toggle-btn" @click="if (window.innerWidth < 1024) { mobileSidebarOpen = !mobileSidebarOpen } else { sidebarCollapsed = !sidebarCollapsed }">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2.5">
                            <line x1="3" y1="6" x2="21" y2="6" />
                            <line x1="3" y1="12" x2="21" y2="12" />
                            <line x1="3" y1="18" x2="21" y2="18" />
                        </svg>
                    </button>
                    <div>
                        @isset($header)
                            {{ $header }}
                        @else
                            <div class="topbar-title">{{ __('app.dashboard') }}</div>
                            <div class="topbar-subtitle">{{ __('app.welcome') }}, <strong
                                    class="text-neon-purple">{{ auth()->user()->name }}</strong> —
                                {{ now()->translatedFormat('l d F Y') }}</div>
                        @endisset
                    </div>
                </div>

                <div class="topbar-right">
                    <!-- Language Switcher -->
                    <div class="lang-switcher">
                        <a href="{{ route('set-locale', 'fr') }}"
                           class="lang-btn {{ app()->getLocale() == 'fr' ? 'lang-active' : '' }}"
                           title="Français">
                            <span class="lang-flag">🇫🇷</span>
                            <span class="lang-code">FR</span>
                        </a>
                        <a href="{{ route('set-locale', 'en') }}"
                           class="lang-btn {{ app()->getLocale() == 'en' ? 'lang-active' : '' }}"
                           title="English">
                            <span class="lang-flag">🇬🇧</span>
                            <span class="lang-code">EN</span>
                        </a>
                        <a href="{{ route('set-locale', 'ar') }}"
                           class="lang-btn {{ app()->getLocale() == 'ar' ? 'lang-active' : '' }}"
                           title="العربية">
                            <span class="lang-flag">🇩🇿</span>
                            <span class="lang-code">AR</span>
                        </a>
                    </div>

                    <!-- Theme Toggle -->
                    <button onclick="toggleTheme()" class="topbar-icon-btn" title="Toggle theme">
                        <svg id="theme-icon-moon" class="hidden" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                        <svg id="theme-icon-sun" class="hidden" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="5" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42" />
                        </svg>
                    </button>

                    <!-- Notifications -->
                    <div class="topbar-icon-btn">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                            <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                        </svg>
                        <div class="notif-dot"></div>
                    </div>

                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="topbar-icon-btn" title="Déconnexion">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                <polyline points="16 17 21 12 16 7" />
                                <line x1="21" y1="12" x2="9" y2="12" />
                            </svg>
                        </button>
                    </form>
                </div>
            </header>

            <!-- PAGE CONTENT SCROLL CONTAINER -->
            <main class="page-body-container">
                {{ $slot }}
            </main>
        </div>
    </div>

    <script>
        // Theme Management
        function updateThemeIcons() {
            const isLight = document.body.classList.contains('light-theme');
            const moon = document.getElementById('theme-icon-moon');
            const sun = document.getElementById('theme-icon-sun');
            if (isLight) {
                if (moon) moon.classList.remove('hidden');
                if (sun) sun.classList.add('hidden');
            } else {
                if (moon) moon.classList.add('hidden');
                if (sun) sun.classList.remove('hidden');
            }
        }

        function toggleTheme() {
            if (document.body.classList.contains('light-theme')) {
                document.body.classList.remove('light-theme');
                document.documentElement.classList.remove('light-theme');
                localStorage.setItem('theme', 'dark');
            } else {
                document.body.classList.add('light-theme');
                document.documentElement.classList.add('light-theme');
                localStorage.setItem('theme', 'light');
            }
            updateThemeIcons();
        }

        // Live clock for topbar
        function updateTopbarTime() {
            const now = new Date();
            const h = String(now.getHours()).padStart(2, '0');
            const m = String(now.getMinutes()).padStart(2, '0');
            const el = document.getElementById('live-time-topbar');
            if (el) el.textContent = h + ':' + m;
        }

        document.addEventListener('DOMContentLoaded', () => {
            updateThemeIcons();
            setInterval(updateTopbarTime, 1000);
            updateTopbarTime();
        });
    </script>
</body>

</html>