<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <div>
                <div class="topbar-title">Mes Absences</div>
                <div class="topbar-subtitle">Suivi de vos absences et dépôt de justificatifs</div>
            </div>
        </div>
    </x-slot>

    <div class="py-6 animate-fade-in">
        @if(session('success'))
            <div class="bg-green-500/10 border border-green-500/20 text-green-400 px-4 py-3 rounded-xl relative mb-6 text-sm" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(!$absences->isEmpty())
            <!-- Summary Stats Header -->
            <div class="grid grid-cols-3 gap-6 mb-6">
                <div class="dark-card rounded-3xl p-5 text-center border border-white/5">
                    <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total</div>
                    <div class="text-3xl font-black text-white mt-1">{{ $absences->count() }} h</div>
                </div>
                <div class="dark-card rounded-3xl p-5 text-center border border-white/5 border-l-4 border-l-[#10b981]">
                    <div class="text-xs font-bold text-gray-400 uppercase tracking-wider text-[#10b981]">Justifiées</div>
                    <div class="text-3xl font-black text-[#10b981] mt-1">{{ $absences->where('justified', true)->count() }} h</div>
                </div>
                <div class="dark-card rounded-3xl p-5 text-center border border-white/5 border-l-4 border-l-[#ef4444]">
                    <div class="text-xs font-bold text-gray-400 uppercase tracking-wider text-[#ef4444]">Non Justifiées</div>
                    <div class="text-3xl font-black text-[#ef4444] mt-1">{{ $absences->where('justified', false)->count() }} h</div>
                </div>
            </div>
        @endif

        @if($absences->isEmpty())
            <div class="dark-card rounded-3xl p-12 text-center">
                <span class="text-5xl">🎉</span>
                <p class="text-gray-400 italic mt-4">Aucune absence enregistrée. Excellent travail !</p>
            </div>
        @else
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @php
                    $colors = ['validated'=>'#10b981', 'pending'=>'#fbbf24', 'rejected'=>'#ef4444', 'unjustified'=>'#64748b'];
                @endphp
                @foreach($absences as $absence)
                    @php
                        if ($absence->justified) {
                            $status = $absence->status;
                            $statusFr = $absence->status === 'validated' ? 'Validé' : ($absence->status === 'rejected' ? 'Refusé' : 'En attente');
                        } else {
                            $status = 'unjustified';
                            $statusFr = 'Non justifiée';
                        }
                        $color = $colors[$status] ?? '#64748b';
                    @endphp
                    <div class="dark-card rounded-3xl p-5 border border-white/5 relative overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:border-white/10">
                        <div class="flex items-center justify-between mb-3 border-b border-white/5 pb-2">
                            <span class="text-xs font-semibold text-gray-400">📅 {{ \Carbon\Carbon::parse($absence->date)->format('d/m/Y') }}</span>
                            <span class="px-2.5 py-0.5 text-[10px] font-bold rounded-full uppercase" style="background: {{ $color }}15; color: {{ $color }}; border: 1px solid {{ $color }}25;">
                                {{ $statusFr }}
                            </span>
                        </div>
                        
                        <h4 class="text-base font-bold text-white mb-4">{{ $absence->module->name }}</h4>

                        <div class="mt-4 pt-3 border-t border-white/5">
                            @if(!$absence->justified)
                                <form action="{{ route('student.absences.update', $absence) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                                    @csrf
                                    @method('PATCH')
                                    <div class="text-xs text-gray-400 font-semibold mb-1">Déposer un justificatif :</div>
                                    <div class="flex items-center gap-2">
                                        <input type="file" name="justification" accept=".pdf,.jpg,.png" class="block w-full text-xs text-gray-400 file:mr-2 file:py-1 file:px-2 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-white/10 file:text-white hover:file:bg-white/20" required>
                                        <button type="submit" class="px-3.5 py-2 bg-gradient-to-r from-[#8b5cf6] to-[#d946ef] hover:opacity-90 text-white text-xs font-bold rounded-xl shadow-md transition duration-200">Déposer</button>
                                    </div>
                                </form>
                                @error('justification')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            @elseif($absence->justification_path)
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-gray-400">Justificatif fourni</span>
                                    <a href="{{ asset('storage/' . $absence->justification_path) }}" target="_blank" class="inline-flex items-center text-xs text-[#06b6d4] hover:underline gap-1">
                                        Voir le justificatif &rarr;
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
