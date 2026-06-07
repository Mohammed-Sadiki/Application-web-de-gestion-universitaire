<x-app-layout>
    <x-slot name="header">
        <div class="topbar-title">Gestion des Réservations</div>
        <div class="topbar-subtitle">Supervisez toutes les réservations de salles de l'établissement</div>
    </x-slot>

    <div class="py-6 animate-fade-in">
        @if(session('success'))
            <div class="bg-green-500/10 border border-green-500/20 text-green-400 px-4 py-3 rounded-xl mb-6 text-sm">{{ session('success') }}</div>
        @endif

        <div class="dark-card rounded-3xl overflow-hidden border border-white/5">
            <div class="p-6 bg-[#17192a]/30 border-b border-white/5">
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <span class="w-2.5 h-2.5 bg-[#3b82f6] rounded-full animate-pulse"></span>
                    Toutes les réservations de salles
                </h3>
            </div>
            <div class="p-6">
                @if($reservations->isEmpty())
                    <div class="text-center py-10">
                        <span class="text-4xl">🏫</span>
                        <p class="text-gray-400 italic mt-3 text-sm">Aucune réservation de salle pour le moment.</p>
                    </div>
                @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-white/5">
                        <thead>
                            <tr class="text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                                <th class="pb-3">Salle</th>
                                <th class="pb-3">Professeur</th>
                                <th class="pb-3">Date</th>
                                <th class="pb-3">Créneau</th>
                                <th class="pb-3">Motif</th>
                                <th class="pb-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-white/5 text-gray-300">
                            @foreach($reservations as $reservation)
                            <tr class="hover:bg-white/[0.02] transition-colors">
                                <td class="py-4 font-semibold text-[#8b5cf6]">{{ $reservation->room->name }}</td>
                                <td class="py-4 font-semibold text-white">{{ $reservation->professor->user->name }}</td>
                                <td class="py-4">{{ \Carbon\Carbon::parse($reservation->date)->format('d/m/Y') }}</td>
                                <td class="py-4">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-[#06b6d4]/10 border border-[#06b6d4]/20 text-[#06b6d4]">
                                        {{ \Carbon\Carbon::parse($reservation->start_time)->format('H:i') }} – {{ \Carbon\Carbon::parse($reservation->end_time)->format('H:i') }}
                                    </span>
                                </td>
                                <td class="py-4 text-gray-400 max-w-xs truncate">{{ $reservation->reason ?? '—' }}</td>
                                <td class="py-4 text-right space-x-2">
                                    <a href="{{ route('admin.reservations.edit', $reservation) }}" class="inline-flex items-center px-3 py-1 bg-[#8b5cf6]/10 hover:bg-[#8b5cf6]/20 border border-[#8b5cf6]/20 text-[#8b5cf6] text-xs font-bold rounded-xl transition">Modifier</a>
                                    <form method="POST" action="{{ route('admin.reservations.destroy', $reservation) }}" class="inline" onsubmit="return confirm('Annuler cette réservation ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-3 py-1 bg-[#d946ef]/10 hover:bg-[#d946ef]/20 border border-[#d946ef]/20 text-[#d946ef] text-xs font-bold rounded-xl transition">Annuler</button>
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
