<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <div>
                <div class="topbar-title">Mon Emploi du Temps</div>
                <div class="topbar-subtitle">Consultez votre planning hebdomadaire de cours</div>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        @if($schedules->isEmpty())
            <div class="dark-card rounded-3xl p-12 text-center">
                <span class="text-5xl">📅</span>
                <p class="text-gray-400 italic mt-4">Aucun emploi du temps disponible pour votre groupe.</p>
            </div>
        @else
            @php
                $days = ['Monday'=>'Lundi','Tuesday'=>'Mardi','Wednesday'=>'Mercredi','Thursday'=>'Jeudi','Friday'=>'Vendredi','Saturday'=>'Samedi'];
                $colors = ['Monday'=>'#8b5cf6','Tuesday'=>'#06b6d4','Wednesday'=>'#d946ef','Thursday'=>'#3b82f6','Friday'=>'#10b981','Saturday'=>'#f59e0b'];
            @endphp

            <div class="space-y-8">
                @foreach($days as $dayEn => $dayFr)
                    @php $daySchedules = $schedules->where('day', $dayEn)->sortBy('start_time'); @endphp
                    @if($daySchedules->isNotEmpty())
                        <div class="animate-fade-in">
                            <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full" style="background: {{ $colors[$dayEn] }}; box-shadow: 0 0 10px {{ $colors[$dayEn] }}"></span>
                                {{ $dayFr }}
                            </h3>
                            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                                @foreach($daySchedules as $schedule)
                                    <div class="dark-card rounded-3xl p-5 border border-white/5 relative overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:border-white/10">
                                        <div class="absolute -right-4 -bottom-4 opacity-5" style="color: {{ $colors[$dayEn] }}">
                                            <svg class="w-24 h-24" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                            </svg>
                                        </div>
                                        <div class="flex items-center justify-between mb-3">
                                            <span class="text-xs font-bold uppercase tracking-wider px-2.5 py-0.5 rounded-full" style="background: {{ $colors[$dayEn] }}15; color: {{ $colors[$dayEn] }}; border: 1px solid {{ $colors[$dayEn] }}25;">
                                                {{ substr($schedule->start_time,0,5) }} – {{ substr($schedule->end_time,0,5) }}
                                            </span>
                                            <span class="text-xs text-gray-400 font-semibold flex items-center gap-1">
                                                📍 {{ $schedule->room->name }}
                                            </span>
                                        </div>
                                        <h4 class="text-base font-bold text-white mb-2">{{ $schedule->module->name }}</h4>
                                        <div class="text-xs text-gray-400 flex items-center gap-1.5 mt-2">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-400"></span>
                                            Enseignant : <strong class="text-gray-300">{{ $schedule->professor->user->name }}</strong>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
