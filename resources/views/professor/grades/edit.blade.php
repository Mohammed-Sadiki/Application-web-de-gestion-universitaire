<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <div>
                <div class="topbar-title">Saisie des notes : {{ $module->name }}</div>
                <div class="topbar-subtitle">Saisissez les notes de contrôle continu (CC) et d'examen pour chaque étudiant</div>
            </div>
            <a href="{{ route('professor.grades.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 text-white text-xs font-bold rounded-xl transition">
                &larr; Retour
            </a>
        </div>
    </x-slot>

    <div class="py-6 animate-fade-in">
        <div class="dark-card rounded-3xl overflow-hidden border border-white/5">
            <div class="p-6 bg-[#17192a]/30 border-b border-white/5">
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <span class="w-2.5 h-2.5 bg-[#8b5cf6] rounded-full animate-pulse"></span>
                    Liste des étudiants - {{ $module->name }}
                </h3>
            </div>
            <div class="p-6">
                <form method="POST" action="{{ route('professor.grades.update', $module) }}">
                    @csrf
                    @method('PATCH')

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-white/5">
                            <thead>
                                <tr class="text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                                    <th class="pb-3 text-left">Étudiant</th>
                                    <th class="pb-3 text-left">CC1 (40%)</th>
                                    <th class="pb-3 text-left">CC2 (40%)</th>
                                    <th class="pb-3 text-left">Examen (60%)</th>
                                    <th class="pb-3 text-left">Note Finale</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-white/5 text-gray-300">
                                @foreach($students as $index => $student)
                                    @php
                                        $grade = $student->grades()->where('module_id', $module->id)->first();
                                    @endphp
                                    <tr class="hover:bg-white/[0.02] transition-colors">
                                        <td class="py-4 font-semibold text-white whitespace-nowrap">
                                            {{ $student->user->name }}
                                            <input type="hidden" name="grades[{{ $index }}][student_id]" value="{{ $student->id }}">
                                        </td>
                                        <td class="py-4 whitespace-nowrap">
                                            <input type="number" step="0.01" name="grades[{{ $index }}][cc1]" value="{{ $grade->cc1 ?? '' }}" class="w-24 bg-white/5 border border-white/10 text-white rounded-xl px-3 py-1.5 focus:border-[#8b5cf6] focus:ring-1 focus:ring-[#8b5cf6]">
                                        </td>
                                        <td class="py-4 whitespace-nowrap">
                                            <input type="number" step="0.01" name="grades[{{ $index }}][cc2]" value="{{ $grade->cc2 ?? '' }}" class="w-24 bg-white/5 border border-white/10 text-white rounded-xl px-3 py-1.5 focus:border-[#8b5cf6] focus:ring-1 focus:ring-[#8b5cf6]">
                                        </td>
                                        <td class="py-4 whitespace-nowrap">
                                            <input type="number" step="0.01" name="grades[{{ $index }}][exam]" value="{{ $grade->exam ?? '' }}" class="w-24 bg-white/5 border border-white/10 text-white rounded-xl px-3 py-1.5 focus:border-[#8b5cf6] focus:ring-1 focus:ring-[#8b5cf6]">
                                        </td>
                                        <td class="py-4 whitespace-nowrap font-bold text-[#06b6d4]">
                                            {{ $grade->final_grade ?? '-' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="flex items-center justify-end mt-6 pt-6 border-t border-white/5">
                        <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-[#8b5cf6] to-[#d946ef] hover:opacity-90 text-white text-xs font-bold rounded-xl shadow-md transition duration-200">
                            Enregistrer les notes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>