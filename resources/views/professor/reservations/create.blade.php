<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <div>
                <div class="topbar-title">Réserver une Salle</div>
                <div class="topbar-subtitle">Planifiez l'occupation temporaire d'une salle de cours</div>
            </div>
            <a href="{{ route('professor.reservations.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 text-white text-xs font-bold rounded-xl transition">
                &larr; Annuler
            </a>
        </div>
    </x-slot>

    <div class="py-6 animate-fade-in">
        <div class="max-w-3xl mx-auto">
            <div class="dark-card rounded-3xl overflow-hidden border border-white/5">
                <div class="p-6 bg-[#17192a]/30 border-b border-white/5">
                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                        <span class="w-2.5 h-2.5 bg-[#06b6d4] rounded-full animate-pulse"></span>
                        Formulaire de réservation
                    </h3>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('professor.reservations.store') }}">
                        @csrf

                        <!-- Room Selection -->
                        <div class="mb-5">
                            <label for="room_id" class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Salle</label>
                            <select id="room_id" name="room_id" class="w-full bg-[#0d1220] border border-white/10 text-white rounded-xl px-4 py-2.5 focus:border-[#8b5cf6] focus:ring-1 focus:ring-[#8b5cf6]" required>
                                <option value="" class="bg-[#17192a] text-gray-400">Choisir une salle</option>
                                @foreach($rooms as $room)
                                    <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }} class="bg-[#17192a] text-white">
                                        {{ $room->name }} (Capacité: {{ $room->capacity }} places)
                                    </option>
                                @endforeach
                            </select>
                            @error('room_id') <p class="text-[#d946ef] text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Date -->
                        <div class="mb-5">
                            <label for="date" class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Date</label>
                            <input id="date" class="w-full bg-[#0d1220] border border-white/10 text-white rounded-xl px-4 py-2.5 focus:border-[#8b5cf6] focus:ring-1 focus:ring-[#8b5cf6]" type="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required min="{{ date('Y-m-d') }}" />
                            @error('date') <p class="text-[#d946ef] text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <!-- Start Time -->
                            <div class="mb-5">
                                <label for="start_time" class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Heure de début</label>
                                <input id="start_time" type="time" name="start_time" value="{{ old('start_time') }}" class="w-full bg-[#0d1220] border border-white/10 text-white rounded-xl px-4 py-2.5 focus:border-[#8b5cf6] focus:ring-1 focus:ring-[#8b5cf6]" required />
                                @error('start_time') <p class="text-[#d946ef] text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- End Time -->
                            <div class="mb-5">
                                <label for="end_time" class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Heure de fin</label>
                                <input id="end_time" type="time" name="end_time" value="{{ old('end_time') }}" class="w-full bg-[#0d1220] border border-white/10 text-white rounded-xl px-4 py-2.5 focus:border-[#8b5cf6] focus:ring-1 focus:ring-[#8b5cf6]" required />
                                @error('end_time') <p class="text-[#d946ef] text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Reason -->
                        <div class="mb-6">
                            <label for="reason" class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Motif de la réservation</label>
                            <input id="reason" class="w-full bg-[#0d1220] border border-white/10 text-white rounded-xl px-4 py-2.5 focus:border-[#8b5cf6] focus:ring-1 focus:ring-[#8b5cf6]" type="text" name="reason" value="{{ old('reason') }}" placeholder="Ex: Séance de rattrapage, réunion de département..." />
                            @error('reason') <p class="text-[#d946ef] text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('professor.reservations.index') }}" class="text-sm text-gray-400 hover:text-white transition">
                                Annuler
                            </a>
                            <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-[#8b5cf6] to-[#d946ef] hover:opacity-90 text-white text-xs font-bold rounded-xl shadow-md transition duration-200">
                                Réserver
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
