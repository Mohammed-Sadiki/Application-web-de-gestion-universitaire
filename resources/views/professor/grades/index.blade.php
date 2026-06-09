<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <div>
                <div class="topbar-title">Gestion des Notes</div>
                <div class="topbar-subtitle">Saisie et modification des notes pour vos modules attribués</div>
            </div>
        </div>
    </x-slot>

    <div class="py-6 animate-fade-in">
        <div class="dark-card rounded-3xl overflow-hidden border border-white/5">
            <div class="p-6 bg-[#17192a]/30 border-b border-white/5">
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <span class="w-2.5 h-2.5 bg-[#8b5cf6] rounded-full animate-pulse"></span>
                    Mes Modules
                </h3>
            </div>
            <div class="p-6">
                @if($modules->isEmpty())
                    <p class="text-gray-400 italic text-center py-6">Aucun module assigné pour le moment.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($modules as $module)
                            <div class="border border-white/5 rounded-2xl p-5 bg-[#17192a]/30 hover:border-[#8b5cf6]/40 hover:bg-[#8b5cf6]/5 transition-all duration-300 flex flex-col justify-between">
                                <div>
                                    <h4 class="font-bold text-white text-lg mb-1">{{ $module->name }}</h4>
                                    <p class="text-sm text-gray-400 mb-4">{{ $module->department->name }}</p>
                                </div>
                                <a href="{{ route('professor.grades.edit', $module) }}" class="inline-flex justify-center items-center px-4 py-2.5 bg-gradient-to-r from-[#8b5cf6] to-[#d946ef] hover:opacity-90 text-white text-sm font-bold rounded-xl shadow-md transition duration-200">
                                    Saisir les notes
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>