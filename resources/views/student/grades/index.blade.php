<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-2xl text-white leading-tight">
                {{ __('Mes Notes') }}
            </h2>
            <div class="text-xs text-gray-400 mt-1">Suivi de vos evaluations et notes finales par module</div>
        </div>
    </x-slot>

    <div class="py-6">
        @if($grades->isEmpty())
            <div class="dark-card rounded-3xl p-12 text-center">
                <span class="text-5xl">📊</span>
                <p class="text-gray-400 italic mt-4">Aucune note n'a encore ete saisie pour vos modules.</p>
            </div>
        @else
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($grades as $grade)
                    @php
                        $isPassing = $grade->final_grade >= 10;
                        $glowColor = $isPassing ? 'rgba(16, 185, 129, 0.08)' : 'rgba(239, 68, 68, 0.08)';
                        $textColor = $isPassing ? 'text-[#10b981]' : 'text-[#ef4444]';
                    @endphp
                    <div class="dark-card rounded-2xl p-5 border border-white/5 relative overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:border-white/10" style="box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2), 0 0 15px {{ $glowColor }}">
                        
                        <div class="flex items-center justify-between mb-4 border-b border-white/5 pb-3">
                            <h4 class="text-base font-bold text-white leading-snug">{{ $grade->module->name }}</h4>
                        </div>

                        <div class="grid grid-cols-3 gap-3 text-center mb-4">
                            <div class="bg-white/5 rounded-xl p-2">
                                <div class="text-[10px] uppercase font-bold text-gray-400">CC1</div>
                                <div class="text-sm font-extrabold text-white mt-1">{{ $grade->cc1 ?? '-' }}</div>
                            </div>
                            <div class="bg-white/5 rounded-xl p-2">
                                <div class="text-[10px] uppercase font-bold text-gray-400">CC2</div>
                                <div class="text-sm font-extrabold text-white mt-1">{{ $grade->cc2 ?? '-' }}</div>
                            </div>
                            <div class="bg-white/5 rounded-xl p-2">
                                <div class="text-[10px] uppercase font-bold text-gray-400">Examen</div>
                                <div class="text-sm font-extrabold text-white mt-1">{{ $grade->exam ?? '-' }}</div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-2">
                            <span class="text-xs text-gray-400 font-semibold">Note Finale</span>
                            <div class="text-2xl font-black {{ $textColor }}">
                                {{ $grade->final_grade ?? '-' }} <span class="text-xs font-semibold text-gray-500">/ 20</span>
                            </div>
                        </div>

                        <div class="absolute right-3 top-3">
                            <span class="px-2 py-0.5 text-[9px] font-bold rounded-full uppercase" style="background: {{ $isPassing ? 'rgba(16,185,129,.12)' : 'rgba(239,68,68,.12)' }}; color: {{ $isPassing ? '#34d399' : '#f87171' }}; border: 1px solid {{ $isPassing ? 'rgba(16,185,129,.2)' : 'rgba(239,68,68,.2)' }}">
                                {{ $isPassing ? 'Valide' : 'Rattrapage' }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>