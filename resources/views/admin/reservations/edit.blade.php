<x-app-layout>
    <x-slot name="header">
        <div class="topbar-title">Modifier la Réservation</div>
        <div class="topbar-subtitle">Mettre à jour les détails de cette réservation de salle</div>
    </x-slot>

    <div class="py-6 animate-fade-in">
        <div class="max-w-xl">
            <div class="dark-card rounded-3xl overflow-hidden border border-white/5">
                <div class="p-6 bg-[#17192a]/30 border-b border-white/5">
                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                        <span class="w-2.5 h-2.5 bg-[#3b82f6] rounded-full animate-pulse"></span>
                        Modifier la Réservation
                    </h3>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.reservations.update', $reservation) }}">
                        @csrf
                        @method('PATCH')
                        <div class="space-y-4">
                            <div>
                                <label for="room_id" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Salle</label>
                                <select id="room_id" name="room_id" required
                                    class="w-full bg-[#0d1220] border border-white/10 text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-[#8b5cf6] transition">
                                    @foreach($rooms as $room)
                                        <option value="{{ $room->id }}" {{ old('room_id', $reservation->room_id) == $room->id ? 'selected' : '' }}>
                                            {{ $room->name }} ({{ $room->capacity }} places)
                                        </option>
                                    @endforeach
                                </select>
                                @error('room_id')<p class="text-[#d946ef] text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="date" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Date</label>
                                <input id="date" type="date" name="date" value="{{ old('date', $reservation->date) }}" required
                                    class="w-full bg-white/5 border border-white/10 text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-[#8b5cf6] transition">
                                @error('date')<p class="text-[#d946ef] text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label for="start_time" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Heure début</label>
                                    <input id="start_time" type="time" name="start_time" value="{{ old('start_time', substr($reservation->start_time, 0, 5)) }}" required
                                        class="w-full bg-white/5 border border-white/10 text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-[#8b5cf6] transition">
                                    @error('start_time')<p class="text-[#d946ef] text-xs mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="end_time" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Heure fin</label>
                                    <input id="end_time" type="time" name="end_time" value="{{ old('end_time', substr($reservation->end_time, 0, 5)) }}" required
                                        class="w-full bg-white/5 border border-white/10 text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-[#8b5cf6] transition">
                                    @error('end_time')<p class="text-[#d946ef] text-xs mt-1">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            <div>
                                <label for="reason" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Motif</label>
                                <input id="reason" type="text" name="reason" value="{{ old('reason', $reservation->reason) }}"
                                    class="w-full bg-white/5 border border-white/10 text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-[#8b5cf6] transition placeholder-gray-600" placeholder="Motif optionnel...">
                                @error('reason')<p class="text-[#d946ef] text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div class="flex justify-between items-center mt-6">
                            <a href="{{ route('admin.reservations.index') }}" class="text-sm text-gray-400 hover:text-white transition">← Retour</a>
                            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-[#3b82f6] to-[#8b5cf6] hover:opacity-90 text-white text-sm font-bold rounded-xl shadow transition">
                                Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
