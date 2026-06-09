<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <div>
                <div class="topbar-title">Espace Enseignant</div>
                <div class="topbar-subtitle">Suivi des cours, des absences et des notes</div>
            </div>
        </div>
    </x-slot>

    <div class="py-12 animate-fade-in">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                @foreach($stats as $key => $value)
                    @php
                        $label = str_replace('_', ' ', $key);
                        if (str_contains($key, 'absences')) {
                            $label = 'Absences Signalées';
                            $cardStyle = 'bg-gradient-to-r from-[#d946ef] to-[#8b5cf6] text-white shadow-lg shadow-purple-900/30';
                            $badgeText = 'Alerte';
                            $badgeStyle = 'bg-white/20';
                            $footerText = 'Suivi d\'assiduité actif';
                            $iconPath = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>';
                        } elseif (str_contains($key, 'schedules') || str_contains($key, 'emploi')) {
                            $label = 'Séances du Jour';
                            $cardStyle = 'bg-gradient-to-r from-[#06b6d4] to-[#3b82f6] text-white shadow-lg shadow-cyan-900/30';
                            $badgeText = 'Aujourd\'hui';
                            $badgeStyle = 'bg-white/20';
                            $footerText = 'EDT synchronisé';
                            $iconPath = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>';
                        } else {
                            $label = 'Modules Enseignés';
                            $cardStyle = 'dark-card';
                            $badgeText = 'Spécialité';
                            $badgeStyle = 'bg-[#8b5cf6]/20 text-[#8b5cf6]';
                            $footerText = 'Plan de cours validé';
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
                                Mon emploi du temps d'aujourd'hui
                            </h3>
                            <span class="text-xs bg-[#06b6d4]/15 text-[#06b6d4] px-3 py-1 rounded-full font-semibold">{{ date('d/m/Y') }}</span>
                        </div>
                        <div class="p-6">
                            @if($todaySchedules->isEmpty())
                                <div class="text-center py-12">
                                    <span class="text-5xl">☕</span>
                                    <p class="text-gray-400 italic mt-4 text-sm">Aucune séance prévue pour aujourd'hui.</p>
                                </div>
                            @else
                                <div class="space-y-4">
                                    @foreach($todaySchedules as $session)
                                        <div class="flex items-center justify-between p-5 border border-white/5 rounded-2xl bg-[#17192a]/30 hover:border-[#8b5cf6]/40 hover:bg-[#8b5cf6]/5 transition-all duration-300">
                                            <div class="space-y-1">
                                                <div class="flex items-center space-x-2">
                                                    <span class="text-xs font-bold text-[#8b5cf6] uppercase tracking-wider bg-[#8b5cf6]/10 px-2.5 py-0.5 rounded">
                                                        {{ substr($session->start_time, 0, 5) }} - {{ substr($session->end_time, 0, 5) }}
                                                    </span>
                                                    <span class="text-xs text-gray-400">📍 Salle : {{ $session->room->name }}</span>
                                                    <span class="text-xs text-gray-400">👥 Groupe : {{ $session->group->name }}</span>
                                                </div>
                                                <h4 class="text-base font-bold text-white">{{ $session->module->name }}</h4>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <a href="{{ route('professor.absences.create', $session->module) }}" 
                                                   class="inline-flex items-center px-3.5 py-2 bg-[#d946ef]/10 hover:bg-[#d946ef]/20 border border-[#d946ef]/20 text-[#d946ef] text-xs font-bold rounded-xl transition duration-150">
                                                    📋 Appel
                                                </a>
                                                <a href="{{ route('professor.lesson_logs.create') }}" 
                                                   class="inline-flex items-center px-3.5 py-2 bg-[#06b6d4]/10 hover:bg-[#06b6d4]/20 border border-[#06b6d4]/20 text-[#06b6d4] text-xs font-bold rounded-xl transition duration-150">
                                                    ✍️ Cahier
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Content: Sidebar widgets -->
                <div class="space-y-6">
                    <div class="dark-card rounded-3xl p-6 relative overflow-hidden bg-gradient-to-b from-[#151726] to-[#0e101f] border border-white/5">
                        <div class="absolute -right-10 -bottom-10 opacity-5 text-[#8b5cf6]">
                            <svg class="w-40 h-40" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 3L1 9L12 15L21 9L12 3M5 13.18V17.18L12 21L19 17.18V13.18L12 17L5 13.18Z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2">Actions Enseignant</h3>
                        <p class="text-xs text-gray-400 mb-6">Gérez vos classes, notes et documents administratifs.</p>
                        
                        <div class="space-y-3">
                            <a href="{{ route('professor.grades.index') }}" class="flex items-center justify-between p-3.5 bg-white/[0.03] hover:bg-white/[0.08] border border-white/5 hover:border-[#8b5cf6]/30 rounded-xl text-sm font-semibold text-white transition duration-200">
                                <span class="flex items-center"><span class="text-base mr-2">📊</span> Remplir les notes</span>
                                <span class="text-[#8b5cf6]">&rarr;</span>
                            </a>
                            <a href="{{ route('professor.materials.create') }}" class="flex items-center justify-between p-3.5 bg-white/[0.03] hover:bg-white/[0.08] border border-white/5 hover:border-[#d946ef]/30 rounded-xl text-sm font-semibold text-white transition duration-200">
                                <span class="flex items-center"><span class="text-base mr-2">📤</span> Publier un support</span>
                                <span class="text-[#d946ef]">&rarr;</span>
                            </a>
                            <a href="{{ route('professor.reservations.create') }}" class="flex items-center justify-between p-3.5 bg-white/[0.03] hover:bg-white/[0.08] border border-white/5 hover:border-[#06b6d4]/30 rounded-xl text-sm font-semibold text-white transition duration-200">
                                <span class="flex items-center"><span class="text-base mr-2">🏫</span> Réserver une salle</span>
                                <span class="text-[#06b6d4]">&rarr;</span>
                            </a>
                            <a href="{{ route('professor.requests.index') }}" class="flex items-center justify-between p-3.5 bg-white/[0.03] hover:bg-white/[0.08] border border-white/5 hover:border-[#8b5cf6]/30 rounded-xl text-sm font-semibold text-white transition duration-200">
                                <span class="flex items-center"><span class="text-base mr-2">📄</span> Demander un document</span>
                                <span class="text-[#8b5cf6]">&rarr;</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>