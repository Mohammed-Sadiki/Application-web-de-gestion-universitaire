<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <div>
                <div class="topbar-title">{{ __('Gestion de l\'Emploi du Temps') }}</div>
                <div class="topbar-subtitle">Gérez l'ensemble des créneaux et affectations de salles</div>
            </div>
            <a href="{{ route('admin.schedules.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-[#8b5cf6] to-[#d946ef] hover:from-[#7c3aed] hover:to-[#c084fc] text-white text-xs font-bold rounded-xl shadow-md transition duration-200">
                ➕ Ajouter une seance
            </a>
        </div>
    </x-slot>

    <div class="py-6 animate-fade-in">
        @if(session('success'))
            <div class="bg-green-500/10 border border-green-500/20 text-green-400 px-4 py-3 rounded-xl relative mb-6 text-sm" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="dark-card rounded-3xl overflow-hidden border border-white/5">
            <div class="p-6 bg-[#17192a]/30 border-b border-white/5">
                <h3 class="text-lg font-bold text-white flex items-center">
                    <span class="w-2.5 h-2.5 bg-[#8b5cf6] rounded-full mr-2.5 animate-pulse"></span>
                    Liste des seances planifiees
                </h3>
            </div>
            <div class="p-6 bg-transparent">
                @if($schedules->isEmpty())
                    <p class="text-gray-400 italic text-center py-6">Aucune seance planifiee pour le moment.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-white/5">
                            <thead>
                                <tr class="text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                                    <th class="pb-3">Jour</th>
                                    <th class="pb-3">Creneau</th>
                                    <th class="pb-3">Groupe</th>
                                    <th class="pb-3">Module</th>
                                    <th class="pb-3">Professeur</th>
                                    <th class="pb-3">Salle</th>
                                    <th class="pb-3 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-white/5 text-gray-300">
                                @foreach($schedules as $schedule)
                                    <tr class="hover:bg-white/[0.02] transition-colors">
                                        <td class="py-4 font-bold text-white">{{ $schedule->day }}</td>
                                        <td class="py-4">
                                            <span class="px-2.5 py-1 bg-[#06b6d4]/10 border border-[#06b6d4]/20 rounded-full text-xs font-semibold text-[#06b6d4]">
                                                {{ substr($schedule->start_time, 0, 5) }} - {{ substr($schedule->end_time, 0, 5) }}
                                            </span>
                                        </td>
                                        <td class="py-4">{{ $schedule->group->name }}</td>
                                        <td class="py-4 font-semibold text-white">{{ $schedule->module->name }}</td>
                                        <td class="py-4">{{ $schedule->professor->user->name }}</td>
                                        <td class="py-4 font-semibold text-[#8b5cf6]">{{ $schedule->room->name }}</td>
                                        <td class="py-4 text-right space-x-2">
                                            <a href="{{ route('admin.schedules.edit', $schedule) }}" class="inline-flex items-center px-3 py-1 bg-[#8b5cf6]/10 hover:bg-[#8b5cf6]/20 border border-[#8b5cf6]/20 text-[#8b5cf6] text-xs font-bold rounded-xl transition">
                                                Modifier
                                            </a>
                                            <form action="{{ route('admin.schedules.destroy', $schedule) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-3 py-1 bg-[#d946ef]/10 hover:bg-[#d946ef]/20 border border-[#d946ef]/20 text-[#d946ef] text-xs font-bold rounded-xl transition" onclick="return confirm('Êtes-vous sûr ?')">
                                                    Supprimer
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>