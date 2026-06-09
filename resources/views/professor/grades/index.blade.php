<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <div>
                <div class="topbar-title">{{ __('app.grades') }}</div>
                <div class="topbar-subtitle">{{ __('app.grades_management_sub') }}</div>
            </div>
        </div>
    </x-slot>

    <div class="py-6 animate-fade-in">
        <div class="dark-card rounded-3xl p-8 border border-white/5">
            <div class="flex items-center gap-3 mb-6">
                <span class="w-2.5 h-2.5 bg-[#8b5cf6] rounded-full animate-pulse"></span>
                <h2 class="text-lg font-bold text-white">{{ __('app.my_modules') }}</h2>
            </div>
            <div>
                @if($modules->isEmpty())
                    <p class="text-gray-400 italic text-center py-6">{{ __('app.no_assigned_modules') }}</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($modules as $module)
                            <div class="dark-card rounded-2xl p-6 border border-white/5 flex flex-col justify-between min-h-[180px] hover:-translate-y-1 transition-transform duration-300">
                                <div>
                                    <h4 class="font-bold text-white text-lg mb-1">{{ $module->name }}</h4>
                                    <p class="text-sm text-gray-400 mb-4">{{ $module->department->name }}</p>
                                </div>
                                <div>
                                    <a href="{{ route('professor.grades.edit', $module) }}"
                                       class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-[#8b5cf6] to-[#d946ef] hover:opacity-90 text-white text-sm font-bold rounded-xl shadow-md transition duration-200">
                                        {{ __('app.enter_grades') }}
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>