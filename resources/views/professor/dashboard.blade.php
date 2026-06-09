<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <div>
                <div class="topbar-title">{{ __('app.professor_space_title') }}</div>
                <div class="topbar-subtitle">{{ __('app.professor_space_subtitle') }}</div>
            </div>
        </div>
    </x-slot>

    <div class="py-12 animate-fade-in">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                @foreach($stats as $key => $value)
                    @php
                        if (str_contains($key, 'absences')) {
                            $label = __('app.reported_absences');
                            $cardStyle = 'bg-gradient-to-r from-[#d946ef] to-[#8b5cf6] text-white shadow-lg shadow-purple-900/30';
                            $badgeText = __('app.alert_badge');
                            $badgeStyle = 'bg-white/20';
                            $footerText = __('app.active_attendance');
                            $iconPath = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>';
                        } elseif (str_contains($key, 'schedules') || str_contains($key, 'emploi')) {
                            $label = __('app.today_sessions');
                            $cardStyle = 'bg-gradient-to-r from-[#06b6d4] to-[#3b82f6] text-white shadow-lg shadow-cyan-900/30';
                            $badgeText = __('app.today_badge');
                            $badgeStyle = 'bg-white/20';
                            $footerText = __('app.edt_synced');
                            $iconPath = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>';
                        } else {
                            $label = __('app.taught_modules');
                            $cardStyle = 'dark-card';
                            $badgeText = __('app.specialty_badge');
                            $badgeStyle = 'bg-[#8b5cf6]/20 text-[#8b5cf6]';
                            $footerText = __('app.syllabus_validated');
                            $iconPath = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.168.477 4 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.168.477-4 1.253"/>';
                        }
                    @endphp
                    <div class="{{ $cardStyle }} rounded-3xl p-6 relative overflow-hidden transition-transform duration-300 hover:-translate-y-1">
                        <div class="absolute -right-6 -bottom-6 opacity-10">
                            <svg class="w-32 h-32" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                {!! $iconPath !!}
                            </svg>
                        </div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-xs font-bold uppercase tracking-wider opacity-90">{{ $label }}</span>
                            <span class="px-2 py-0.5 text-[10px] rounded-full font-bold {{ $badgeStyle }}">{{ $badgeText }}</span>
                        </div>
                        <div class="text-4xl font-black">{{ $value }}</div>
                        <div class="text-xs opacity-90 mt-2 flex items-center">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-400 mr-1.5 animate-pulse"></span> {{ $footerText }}
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Content: Schedule -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="dark-card rounded-3xl overflow-hidden border border-white/5">
                        <div class="p-6 border-b border-white/5 flex justify-between items-center bg-[#17192a]/50">
                            <h3 class="text-lg font-bold text-white flex items-center">
                                <span class="w-2.5 h-2.5 bg-[#06b6d4] rounded-full mr-2.5 animate-pulse"></span>
                                {{ __('app.today_schedule') }}
                            </h3>
                            <span class="text-xs bg-[#06b6d4]/15 text-[#06b6d4] px-3 py-1 rounded-full font-semibold">{{ now()->translatedFormat('d/m/Y') }}</span>
                        </div>
                        <div class="p-6">
                            @if($todaySchedules->isEmpty())
                                <div class="text-center py-12">
                                    <span class="text-5xl">☕</span>
                                    <p class="text-gray-400 italic mt-4 text-sm">{{ __('app.no_sessions_today') }}</p>
                                </div>
                            @else
                                <div class="space-y-4">
                                    @foreach($todaySchedules as $session)
                                        <div class="flex items-center justify-between p-5 border border-white/5 rounded-2xl bg-[#17192a]/30 hover:border-[#8b5cf6]/40 hover:bg-[#8b5cf6]/5 transition-all duration-300">
                                            <div class="space-y-1">
                                                <div class="flex items-center space-x-2">
                                                    <span class="text-xs font-bold text-[#8b5cf6] uppercase tracking-wider bg-[#8b5cf6]/10 px-2.5 py-0.5 rounded whitespace-nowrap">
                                                        {{ substr($session->start_time, 0, 5) }} - {{ substr($session->end_time, 0, 5) }}
                                                    </span>
                                                    <span class="text-xs text-gray-400">📍 {{ __('app.room_label') }} : {{ $session->room->name }}</span>
                                                    <span class="text-xs text-gray-400">👥 {{ __('app.group_label') }} : {{ $session->group->name }}</span>
                                                </div>
                                                <h4 class="text-base font-bold text-white">{{ $session->module->name }}</h4>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <a href="{{ route('professor.absences.create', $session->module) }}" 
                                                   class="inline-flex items-center px-3.5 py-2 bg-[#d946ef]/10 hover:bg-[#d946ef]/20 border border-[#d946ef]/20 text-[#d946ef] text-xs font-bold rounded-xl transition duration-150">
                                                    📋 {{ __('app.attendance_button') }}
                                                </a>
                                                <a href="{{ route('professor.lesson_logs.create') }}" 
                                                   class="inline-flex items-center px-3.5 py-2 bg-[#06b6d4]/10 hover:bg-[#06b6d4]/20 border border-[#06b6d4]/20 text-[#06b6d4] text-xs font-bold rounded-xl transition duration-150">
                                                    ✍️ {{ __('app.logbook_button') }}
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Content: Actions & Info -->
                <div class="space-y-6">
                    <div class="dark-card rounded-3xl p-6 border border-white/5">
                        <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-4">{{ __('app.actions') }}</h3>
                        <div class="space-y-3">
                            <a href="{{ route('professor.materials.create') }}" class="flex items-center p-4 rounded-2xl bg-[#8b5cf6]/5 border border-[#8b5cf6]/10 hover:bg-[#8b5cf6]/10 transition-all group">
                                <div class="w-10 h-10 rounded-xl bg-[#8b5cf6]/20 flex items-center justify-center mr-4 text-[#8b5cf6]">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                </div>
                                <span class="text-sm font-bold text-gray-300 group-hover:text-white">{{ __('app.add_material') }}</span>
                            </a>
                            <a href="{{ route('professor.announcements.create') }}" class="flex items-center p-4 rounded-2xl bg-[#06b6d4]/5 border border-[#06b6d4]/10 hover:bg-[#06b6d4]/10 transition-all group">
                                <div class="w-10 h-10 rounded-xl bg-[#06b6d4]/20 flex items-center justify-center mr-4 text-[#06b6d4]">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                                </div>
                                <span class="text-sm font-bold text-gray-300 group-hover:text-white">{{ __('app.add_announcement') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
