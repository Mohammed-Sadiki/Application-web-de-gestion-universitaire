<nav x-data="{ open: false }" class="dark-nav">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center">
                        <svg class="w-8 h-8 text-[#d946ef] mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 3L1 9L12 15L21 9L12 3M5 13.18V17.18L12 21L19 17.18V13.18L12 17L5 13.18Z"/>
                        </svg>
                        <span class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-[#d946ef] to-[#8b5cf6] tracking-tight">PFM</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @if(auth()->user()->isAdmin())
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            {{ __('Admin Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('crm.dashboard')" :active="request()->routeIs('crm.dashboard')">
                            {{ __('CRM Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')"> {{ __('Utilisateurs') }} </x-nav-link>
                        <x-nav-link :href="route('admin.departments.index')" :active="request()->routeIs('admin.departments.*')"> {{ __('Filières') }} </x-nav-link>
                        <x-nav-link :href="route('admin.groups.index')" :active="request()->routeIs('admin.groups.*')"> {{ __('Groupes') }} </x-nav-link>
                        <x-nav-link :href="route('admin.modules.index')" :active="request()->routeIs('admin.modules.*')"> {{ __('Modules') }} </x-nav-link>
                        <x-nav-link :href="route('admin.rooms.index')" :active="request()->routeIs('admin.rooms.*')"> {{ __('Salles') }} </x-nav-link>
                        <x-nav-link :href="route('admin.schedules.index')" :active="request()->routeIs('admin.schedules.*')"> {{ __('EDT') }} </x-nav-link>
                        <x-nav-link :href="route('admin.absences.index')" :active="request()->routeIs('admin.absences.*')"> {{ __('Absences') }} </x-nav-link>
                        <x-nav-link :href="route('admin.lesson_logs.index')" :active="request()->routeIs('admin.lesson_logs.*')"> {{ __('Cahiers') }} </x-nav-link>
                        <x-nav-link :href="route('admin.reservations.index')" :active="request()->routeIs('admin.reservations.*')"> {{ __('Réservations') }} </x-nav-link>
                    @elseif(auth()->user()->isProfessor())
                        <x-nav-link :href="route('professor.dashboard')" :active="request()->routeIs('professor.dashboard')">
                            {{ __('Prof Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('professor.grades.index')" :active="request()->routeIs('professor.grades.*')"> {{ __('Mes Notes') }} </x-nav-link>
                        <x-nav-link :href="route('professor.absences.index')" :active="request()->routeIs('professor.absences.*')"> {{ __('Absences') }} </x-nav-link>
                        <x-nav-link :href="route('professor.lesson_logs.index')" :active="request()->routeIs('professor.lesson_logs.*')"> {{ __('Cahier de textes') }} </x-nav-link>
                        <x-nav-link :href="route('professor.materials.index')" :active="request()->routeIs('professor.materials.*')"> {{ __('Supports') }} </x-nav-link>
                        <x-nav-link :href="route('professor.announcements.index')" :active="request()->routeIs('professor.announcements.*')"> {{ __('Annonces') }} </x-nav-link>
                        <x-nav-link :href="route('professor.reservations.index')" :active="request()->routeIs('professor.reservations.*')"> {{ __('Réservations') }} </x-nav-link>
                        <x-nav-link :href="route('professor.schedules.index')" :active="request()->routeIs('professor.schedules.*')"> {{ __('Mon EDT') }} </x-nav-link>
                        <x-nav-link :href="route('professor.requests.index')" :active="request()->routeIs('professor.requests.*')"> {{ __('Mes Demandes') }} </x-nav-link>
                    @elseif(auth()->user()->isStudent())
                        <x-nav-link :href="route('student.dashboard')" :active="request()->routeIs('student.dashboard')">
                            {{ __('Mon Espace') }}
                        </x-nav-link>
                        <x-nav-link :href="route('student.grades.index')" :active="request()->routeIs('student.grades.*')"> {{ __('Mes Notes') }} </x-nav-link>
                        <x-nav-link :href="route('student.absences.index')" :active="request()->routeIs('student.absences.*')"> {{ __('Absences') }} </x-nav-link>
                        <x-nav-link :href="route('student.schedules.index')" :active="request()->routeIs('student.schedules.*')"> {{ __('EDT') }} </x-nav-link>
                        <x-nav-link :href="route('student.courses.index')" :active="request()->routeIs('student.courses.*')"> {{ __('Classroom') }} </x-nav-link>
                        <x-nav-link :href="route('student.requests.index')" :active="request()->routeIs('student.requests.*')"> {{ __('Demandes') }} </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-300 bg-transparent hover:text-white focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-lg text-gray-400 hover:text-white hover:bg-white/10 focus:outline-none focus:bg-white/10 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @if(auth()->user()->isAdmin())
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    {{ __('Admin Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('crm.dashboard')" :active="request()->routeIs('crm.dashboard')">
                    {{ __('CRM Dashboard') }}
                </x-responsive-nav-link>
            @elseif(auth()->user()->isProfessor())
                <x-responsive-nav-link :href="route('professor.dashboard')" :active="request()->routeIs('professor.dashboard')">
                    {{ __('Prof Dashboard') }}
                </x-responsive-nav-link>
            @elseif(auth()->user()->isStudent())
                <x-responsive-nav-link :href="route('student.dashboard')" :active="request()->routeIs('student.dashboard')">
                    {{ __('Mon Espace') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-white/5">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-400">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
