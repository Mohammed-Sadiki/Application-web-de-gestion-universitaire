<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <div>
                <div class="topbar-title">{{ __('app.absences_title') }}</div>
                <div class="topbar-subtitle">{{ __('app.prof_absences_sub') }}</div>
            </div>
        </div>
    </x-slot>

    <div class="py-6 animate-fade-in">
        @if(session('success'))
            <div class="bg-green-500/10 border border-green-500/20 text-green-400 px-4 py-3 rounded-xl mb-6 text-sm">
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="dark-card rounded-3xl overflow-hidden border border-white/5">
            <div class="p-6 bg-[#17192a]/30 border-b border-white/5">
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <span class="w-2.5 h-2.5 bg-[#d946ef] rounded-full animate-pulse"></span>
                    {{ __('app.select_module') }}
                </h3>
            </div>
            <div class="p-6">
                @if($modules->isEmpty())
                    <p class="text-gray-400 italic text-center py-6">{{ __('app.no_assigned_modules') }}</p>
                @else
                    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach($modules as $module)
                            <div class="border border-white/5 rounded-2xl p-5 bg-[#17192a]/30 hover:border-[#d946ef]/40 hover:bg-[#d946ef]/5 transition-all duration-300 flex flex-col justify-between">
                                <h4 class="font-bold text-white text-lg mb-4">{{ $module->name }}</h4>
                                <a href="{{ route('professor.absences.create', $module) }}"
                                   class="inline-flex justify-center items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-[#d946ef] to-[#8b5cf6] hover:opacity-90 text-white text-xs font-bold rounded-xl shadow-md transition duration-200">
                                    📋 {{ __('app.record_absence') }}
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
