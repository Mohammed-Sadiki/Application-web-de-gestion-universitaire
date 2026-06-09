<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <div>
                <div class="topbar-title">{{ __('app.courses_title') }}</div>
                <div class="topbar-subtitle">{{ __('app.courses_subtitle') }}</div>
            </div>
        </div>
    </x-slot>

    <div class="py-6 animate-fade-in">
        <div class="dark-card rounded-3xl overflow-hidden border border-white/5">
            <div class="p-6 bg-[#17192a]/30 border-b border-white/5">
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <span class="w-2.5 h-2.5 bg-[#8b5cf6] rounded-full animate-pulse"></span>
                    {{ __('app.my_academic_modules') }}
                </h3>
            </div>
            <div class="p-6">
                @if($modules->isEmpty())
                    <p class="text-gray-400 italic text-center py-6">{{ __('app.no_courses') }}</p>
                @else
                    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach($modules as $module)
                            <a href="{{ route('courses.show', $module) }}" class="block dark-card rounded-3xl p-5 border border-white/5 hover:border-[#8b5cf6]/40 hover:bg-[#8b5cf6]/5 transition-all duration-300">
                                <div class="flex items-center gap-4 mb-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-[#8b5cf6] to-[#d946ef] rounded-2xl flex items-center justify-center text-white font-bold text-xl shadow-md">
                                        {{ strtoupper(substr($module->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-white text-base leading-snug">{{ $module->name }}</h4>
                                        <p class="text-xs text-gray-400 mt-0.5">{{ $module->department->name ?? '—' }}</p>
                                    </div>
                                </div>
                                <div class="flex gap-4 text-xs text-gray-400 border-t border-white/5 pt-3">
                                    <span class="flex items-center gap-1">📄 <strong class="text-white">{{ $module->courseMaterials->count() }}</strong> {{ __('app.materials_count') }}</span>
                                    <span class="flex items-center gap-1">📢 <strong class="text-white">{{ $module->announcements->count() }}</strong> {{ __('app.announcements_count') }}</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
