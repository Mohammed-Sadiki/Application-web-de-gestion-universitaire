<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <div>
                <div class="topbar-title">{{ __('app.student_space_title') }}</div>
                <div class="topbar-subtitle">{{ __('app.student_space_subtitle') }}</div>
            </div>
        </div>
    </x-slot>

    <div class="py-12 animate-fade-in">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <!-- Stat 1: GPA with Pink/Purple Gradient -->
                <div class="relative overflow-hidden rounded-3xl p-6 bg-gradient-to-r from-[#d946ef] to-[#8b5cf6] text-white shadow-lg shadow-purple-900/30 transition-transform duration-300 hover:-translate-y-1">
                    <div class="absolute -right-6 -bottom-6 opacity-10">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 3L1 9L12 15L21 9L12 3M5 13.18V17.18L12 21L19 17.18V13.18L12 17L5 13.18Z"/>
                        </svg>
                    </div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-bold uppercase tracking-wider text-purple-100">{{ __('app.gpa') }}</span>
                        <span class="px-2 py-0.5 text-[10px] bg-white/20 rounded-full font-bold">{{ __('app.current_session') }}</span>
                    </div>
                    <div class="text-4xl font-black">{{ number_format($stats['moyenne_generale'], 2) }} <span class="text-lg font-medium text-purple-200">/ 20</span></div>
                    <div class="text-xs text-purple-100 mt-2 flex items-center">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-300 mr-1.5"></span> {{ __('app.excellent_track') }}
                    </div>
                </div>

                <!-- Stat 2: Absences with Cyan/Blue Gradient -->
                <div class="relative overflow-hidden rounded-3xl p-6 bg-gradient-to-r from-[#06b6d4] to-[#3b82f6] text-white shadow-lg shadow-cyan-900/30 transition-transform duration-300 hover:-translate-y-1">
                    <div class="absolute -right-6 -bottom-6 opacity-10">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-bold uppercase tracking-wider text-cyan-100">{{ __('app.total_absences_stat') }}</span>
                        <span class="px-2 py-0.5 text-[10px] bg-white/20 rounded-full font-bold">{{ __('app.this_semester') }}</span>
                    </div>
                    <div class="text-4xl font-black">{{ $stats['absences_totales'] }} <span class="text-lg font-medium text-cyan-100">{{ __('app.hours') }}</span></div>
                    <div class="text-xs text-cyan-100 mt-2 flex items-center">
                        <span class="w-1.5 h-1.5 rounded-full bg-yellow-300 mr-1.5"></span> {{ __('app.real_time_followup') }}
                    </div>
                </div>

                <!-- Stat 3: Modules with Dark Premium Card -->
                <div class="dark-card rounded-3xl p-6 relative overflow-hidden transition-transform duration-300 hover:-translate-y-1">
                    <div class="absolute -right-6 -bottom-6 opacity-5 text-gray-500">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.168.477 4 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.168.477-4 1.253"/>
                        </svg>
                    </div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-bold uppercase tracking-wider text-gray-400">{{ __('app.followed_modules') }}</span>
                        <span class="px-2 py-0.5 text-[10px] bg-purple-500/20 text-[#8b5cf6] rounded-full font-bold">{{ __('app.active') }}</span>
                    </div>
                    <div class="text-4xl font-black text-white">{{ $stats['modules_suivis'] }} <span class="text-lg font-medium text-gray-400">{{ __('app.courses_count') }}</span></div>
                    <div class="text-xs text-[#06b6d4] mt-2 flex items-center">
                        <span class="w-1.5 h-1.5 rounded-full bg-cyan-400 mr-1.5 animate-pulse"></span> {{ __('app.complete_program') }}
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Area: Next Sessions -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="dark-card rounded-3xl overflow-hidden border border-white/5">
                        <div class="p-6 border-b border-white/5 flex justify-between items-center bg-[#17192a]/50">
                            <h3 class="text-lg font-bold text-white flex items-center">
                                <span class="w-2.5 h-2.5 bg-[#d946ef] rounded-full mr-2.5 animate-pulse"></span>
                                {{ __('app.today_schedule') }}
                            </h3>
                            <span class="text-xs bg-[#d946ef]/15 text-[#d946ef] px-3 py-1 rounded-full font-medium">{{ now()->translatedFormat('d/m/Y') }}</span>
                        </div>
                        <div class="p-6">
                            @if($nextSessions->isEmpty())
                                <div class="text-center py-12">
                                    <span class="text-5xl">🎉</span>
                                    <p class="text-gray-400 italic mt-4 text-sm">{{ __('app.no_more_courses') }}</p>
                                </div>
                            @else
                                <div class="space-y-4">
                                    @foreach($nextSessions as $session)
                                        <div class="flex items-center justify-between p-5 border border-white/5 rounded-2xl bg-[#17192a]/30 hover:border-[#8b5cf6]/40 hover:bg-[#8b5cf6]/5 transition-all duration-300">
                                            <div class="space-y-1">
                                                <div class="flex items-center space-x-2">
                                                    <span class="text-xs font-semibold text-[#06b6d4] uppercase tracking-wider bg-[#06b6d4]/10 px-2 py-0.5 rounded whitespace-nowrap">
                                                        {{ substr($session->start_time,0,5) }} - {{ substr($session->end_time,0,5) }}
                                                    </span>
                                                    <span class="text-xs text-gray-400">📍 {{ $session->room->name }}</span>
                                                </div>
                                                <h4 class="text-base font-bold text-white">{{ $session->module->name }}</h4>
                                                <p class="text-xs text-gray-400 font-medium">{{ __('app.professors') }} : {{ $session->professor->user->name }}</p>
                                            </div>
                                            <a href="{{ route('courses.show', $session->module) }}" 
                                               class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-[#8b5cf6] to-[#d946ef] hover:from-[#7c3aed] hover:to-[#c084fc] text-white text-xs font-bold rounded-xl shadow-md transition duration-200">
                                                {{ __('app.view') }}
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Area: Profile / Quick Links -->
                <div class="space-y-6">
                    <div class="dark-card rounded-3xl p-6 border border-white/5">
                        <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-4">{{ __('app.actions') }}</h3>
                        <div class="space-y-3">
                            <a href="{{ route('student.requests.index') }}" class="flex items-center p-4 rounded-2xl bg-[#8b5cf6]/5 border border-[#8b5cf6]/10 hover:bg-[#8b5cf6]/10 transition-all group">
                                <div class="w-10 h-10 rounded-xl bg-[#8b5cf6]/20 flex items-center justify-center mr-4 text-[#8b5cf6]">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <span class="text-sm font-bold text-gray-300 group-hover:text-white">{{ __('app.requests') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
