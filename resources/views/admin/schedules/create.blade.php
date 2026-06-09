<x-app-layout>
    <x-slot name="header">
        <div class="topbar-title">{{ __('app.new_schedule') }}</div>
        <div class="topbar-subtitle">{{ __('app.new_schedule_sub') }}</div>
    </x-slot>

    <div class="py-6 animate-fade-in">
        <div class="max-w-2xl">
            <div class="dark-card rounded-3xl overflow-hidden border border-white/5">
                <div class="p-6 bg-[#17192a]/30 border-b border-white/5">
                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                        <span class="w-2.5 h-2.5 bg-[#8b5cf6] rounded-full animate-pulse"></span>
                        {{ __('app.new_schedule') }}
                    </h3>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.schedules.store') }}">
                        @csrf
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="group_id" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">{{ __('app.group') }}</label>
                                <select id="group_id" name="group_id" class="w-full bg-[#0d1220] border border-white/10 text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-[#8b5cf6] transition">
                                    @foreach($groups as $group)
                                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="module_id" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">{{ __('app.module') }}</label>
                                <select id="module_id" name="module_id" class="w-full bg-[#0d1220] border border-white/10 text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-[#8b5cf6] transition">
                                    @foreach($modules as $module)
                                        <option value="{{ $module->id }}">{{ $module->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="professor_id" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">{{ __('app.professor_section') }}</label>
                                <select id="professor_id" name="professor_id" class="w-full bg-[#0d1220] border border-white/10 text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-[#8b5cf6] transition">
                                    @foreach($professors as $professor)
                                        <option value="{{ $professor->id }}">{{ $professor->user->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="room_id" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">{{ __('app.room') }}</label>
                                <select id="room_id" name="room_id" class="w-full bg-[#0d1220] border border-white/10 text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-[#8b5cf6] transition">
                                    @foreach($rooms as $room)
                                        <option value="{{ $room->id }}">{{ $room->name }} ({{ $room->capacity }} {{ __('app.capacity') }})</option>
                                    @endforeach
                                </select>
                                @error('room_id')<p class="text-[#d946ef] text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="day" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">{{ __('app.day') }}</label>
                                <select id="day" name="day" class="w-full bg-[#0d1220] border border-white/10 text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-[#8b5cf6] transition">
                                    @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'] as $day)
                                        <option value="{{ $day }}">{{ __('app.day_' . strtolower($day)) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label for="start_time" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">{{ __('app.start_time') }}</label>
                                    <input id="start_time" type="time" name="start_time" required
                                        class="w-full bg-white/5 border border-white/10 text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-[#8b5cf6] transition">
                                </div>
                                <div>
                                    <label for="end_time" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">{{ __('app.end_time') }}</label>
                                    <input id="end_time" type="time" name="end_time" required
                                        class="w-full bg-white/5 border border-white/10 text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-[#8b5cf6] transition">
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end mt-6">
                            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-[#8b5cf6] to-[#d946ef] hover:opacity-90 text-white text-sm font-bold rounded-xl shadow transition">
                                {{ __('app.create_schedule') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>