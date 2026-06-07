<x-app-layout>
    <x-slot name="header">
        <div class="topbar-title">Modifier la Séance</div>
        <div class="topbar-subtitle">Mettre à jour les informations de ce créneau</div>
    </x-slot>

    <div class="py-6 animate-fade-in">
        <div class="max-w-2xl">
            <div class="dark-card rounded-3xl overflow-hidden border border-white/5">
                <div class="p-6 bg-[#17192a]/30 border-b border-white/5">
                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                        <span class="w-2.5 h-2.5 bg-[#8b5cf6] rounded-full animate-pulse"></span>
                        Modifier la Séance
                    </h3>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.schedules.update', $schedule) }}">
                        @csrf
                        @method('PATCH')
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="group_id" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Groupe</label>
                                <select id="group_id" name="group_id" class="w-full bg-[#0d1220] border border-white/10 text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-[#8b5cf6] transition">
                                    @foreach($groups as $group)
                                        <option value="{{ $group->id }}" {{ $schedule->group_id == $group->id ? 'selected' : '' }}>{{ $group->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="module_id" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Module</label>
                                <select id="module_id" name="module_id" class="w-full bg-[#0d1220] border border-white/10 text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-[#8b5cf6] transition">
                                    @foreach($modules as $module)
                                        <option value="{{ $module->id }}" {{ $schedule->module_id == $module->id ? 'selected' : '' }}>{{ $module->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="professor_id" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Professeur</label>
                                <select id="professor_id" name="professor_id" class="w-full bg-[#0d1220] border border-white/10 text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-[#8b5cf6] transition">
                                    @foreach($professors as $professor)
                                        <option value="{{ $professor->id }}" {{ $schedule->professor_id == $professor->id ? 'selected' : '' }}>{{ $professor->user->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="room_id" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Salle</label>
                                <select id="room_id" name="room_id" class="w-full bg-[#0d1220] border border-white/10 text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-[#8b5cf6] transition">
                                    @foreach($rooms as $room)
                                        <option value="{{ $room->id }}" {{ $schedule->room_id == $room->id ? 'selected' : '' }}>{{ $room->name }} ({{ $room->capacity }} places)</option>
                                    @endforeach
                                </select>
                                @error('room_id')<p class="text-[#d946ef] text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="day" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Jour</label>
                                <select id="day" name="day" class="w-full bg-[#0d1220] border border-white/10 text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-[#8b5cf6] transition">
                                    @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day)
                                        <option value="{{ $day }}" {{ $schedule->day == $day ? 'selected' : '' }}>{{ $day }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label for="start_time" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Heure début</label>
                                    <input id="start_time" type="time" name="start_time" value="{{ substr($schedule->start_time, 0, 5) }}" required
                                        class="w-full bg-white/5 border border-white/10 text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-[#8b5cf6] transition">
                                </div>
                                <div>
                                    <label for="end_time" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Heure fin</label>
                                    <input id="end_time" type="time" name="end_time" value="{{ substr($schedule->end_time, 0, 5) }}" required
                                        class="w-full bg-white/5 border border-white/10 text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-[#8b5cf6] transition">
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end mt-6">
                            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-[#8b5cf6] to-[#d946ef] hover:opacity-90 text-white text-sm font-bold rounded-xl shadow transition">
                                Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
