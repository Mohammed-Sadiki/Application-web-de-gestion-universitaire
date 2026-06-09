<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <div>
                <div class="topbar-title">{{ __('app.new_reservation_btn') }}</div>
                <div class="topbar-subtitle">{{ __('app.reservations_subtitle') }}</div>
            </div>
            <a href="{{ route('professor.reservations.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 text-white text-xs font-bold rounded-xl transition">
                &larr; {{ __('app.cancel') }}
            </a>
        </div>
    </x-slot>

    <div class="py-6 animate-fade-in">
        <div class="max-w-3xl mx-auto">
            <div class="dark-card rounded-3xl overflow-hidden border border-white/5">
                <div class="p-6 bg-[#17192a]/30 border-b border-white/5">
                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                        <span class="w-2.5 h-2.5 bg-[#06b6d4] rounded-full animate-pulse"></span>
                        {{ __('app.reservation_form') }}
                    </h3>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('professor.reservations.store') }}">
                        @csrf

                        <div class="mb-5">
                            <label for="room_id" class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">{{ __('app.room') }}</label>
                            <select id="room_id" name="room_id" class="w-full bg-[#0d1220] border border-white/10 text-white rounded-xl px-4 py-2.5 focus:border-[#8b5cf6] focus:ring-1 focus:ring-[#8b5cf6]" required>
                                <option value="" class="bg-[#17192a] text-gray-400">{{ __('app.select_room') }}</option>
                                @foreach($rooms as $room)
                                    <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }} class="bg-[#17192a] text-white">
                                        {{ $room->name }} ({{ __('app.capacity') }}: {{ $room->capacity }})
                                    </option>
                                @endforeach
                            </select>
                            @error('room_id') <p class="text-[#d946ef] text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-5">
                            <label for="date" class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">{{ __('app.date') }}</label>
                            <input id="date" class="w-full bg-[#0d1220] border border-white/10 text-white rounded-xl px-4 py-2.5 focus:border-[#8b5cf6] focus:ring-1 focus:ring-[#8b5cf6]" type="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required min="{{ date('Y-m-d') }}" />
                            @error('date') <p class="text-[#d946ef] text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="mb-5">
                                <label for="start_time" class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">{{ __('app.start_time') }}</label>
                                <input id="start_time" type="time" name="start_time" value="{{ old('start_time') }}" class="w-full bg-[#0d1220] border border-white/10 text-white rounded-xl px-4 py-2.5 focus:border-[#8b5cf6] focus:ring-1 focus:ring-[#8b5cf6]" required />
                                @error('start_time') <p class="text-[#d946ef] text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="mb-5">
                                <label for="end_time" class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">{{ __('app.end_time') }}</label>
                                <input id="end_time" type="time" name="end_time" value="{{ old('end_time') }}" class="w-full bg-[#0d1220] border border-white/10 text-white rounded-xl px-4 py-2.5 focus:border-[#8b5cf6] focus:ring-1 focus:ring-[#8b5cf6]" required />
                                @error('end_time') <p class="text-[#d946ef] text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="reason" class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">{{ __('app.reason') }}</label>
                            <input id="reason" class="w-full bg-[#0d1220] border border-white/10 text-white rounded-xl px-4 py-2.5 focus:border-[#8b5cf6] focus:ring-1 focus:ring-[#8b5cf6]" type="text" name="reason" value="{{ old('reason') }}" />
                            @error('reason') <p class="text-[#d946ef] text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('professor.reservations.index') }}" class="text-sm text-gray-400 hover:text-white transition">
                                {{ __('app.cancel') }}
                            </a>
                            <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-[#8b5cf6] to-[#d946ef] hover:opacity-90 text-white text-xs font-bold rounded-xl shadow-md transition duration-200">
                                {{ __('app.reserve') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
