<x-app-layout>
    <x-slot name="header">
        <div class="topbar-title">{{ __('app.new_room') }}</div>
        <div class="topbar-subtitle">{{ __('app.new_room_sub') }}</div>
    </x-slot>

    <div class="py-6 animate-fade-in">
        <div class="max-w-xl">
            <div class="dark-card rounded-3xl overflow-hidden border border-white/5">
                <div class="p-6 bg-[#17192a]/30 border-b border-white/5">
                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                        <span class="w-2.5 h-2.5 bg-[#3b82f6] rounded-full animate-pulse"></span>
                        {{ __('app.new_room') }}
                    </h3>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.rooms.store') }}">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label for="name" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">{{ __('app.room_name') }}</label>
                                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                                    class="w-full bg-white/5 border border-white/10 text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-[#8b5cf6] transition">
                                @error('name')<p class="text-[#d946ef] text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="capacity" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">{{ __('app.capacity_places') }}</label>
                                <input id="capacity" type="number" name="capacity" value="{{ old('capacity') }}" required min="1"
                                    class="w-full bg-white/5 border border-white/10 text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-[#8b5cf6] transition">
                                @error('capacity')<p class="text-[#d946ef] text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="type" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">{{ __('app.type') }}</label>
                                <select id="type" name="type"
                                    class="w-full bg-[#0d1220] border border-white/10 text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-[#8b5cf6] transition">
                                    <option value="Cours">{{ __('app.room_type_course') }}</option>
                                    <option value="Labo">{{ __('app.room_type_lab') }}</option>
                                </select>
                                @error('type')<p class="text-[#d946ef] text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>
                        <div class="flex justify-end mt-6">
                            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-[#3b82f6] to-[#8b5cf6] hover:opacity-90 text-white text-sm font-bold rounded-xl shadow transition">
                                {{ __('app.create_room') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>