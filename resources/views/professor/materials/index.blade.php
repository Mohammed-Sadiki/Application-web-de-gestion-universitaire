<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <div>
                <div class="topbar-title">Mes Supports de Cours</div>
                <div class="topbar-subtitle">Partagez et organisez vos documents pédagogiques et supports de cours</div>
            </div>
            <a href="{{ route('professor.materials.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-[#8b5cf6] to-[#d946ef] hover:opacity-90 text-white text-xs font-bold rounded-xl shadow-md transition duration-200">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Uploader un Support
            </a>
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
                    <span class="w-2.5 h-2.5 bg-[#8b5cf6] rounded-full animate-pulse"></span>
                    Liste des documents partagés
                </h3>
            </div>
            <div class="p-6">
                @if($materials->isEmpty())
                    <p class="text-gray-400 italic text-center py-6">Aucun support de cours disponible pour le moment.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-white/5">
                            <thead>
                                <tr class="text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                                    <th class="pb-3 text-left">Titre</th>
                                    <th class="pb-3 text-left">Module</th>
                                    <th class="pb-3 text-left">Type de fichier</th>
                                    <th class="pb-3 text-left">Lien</th>
                                    <th class="pb-3 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-white/5 text-gray-300">
                                @foreach($materials as $material)
                                    <tr class="hover:bg-white/[0.02] transition-colors">
                                        <td class="py-4 font-semibold text-white whitespace-nowrap">
                                            {{ $material->title }}
                                        </td>
                                        <td class="py-4 font-semibold text-white whitespace-nowrap">
                                            {{ $material->module->name }}
                                        </td>
                                        <td class="py-4 whitespace-nowrap">
                                            <span class="px-2.5 py-1 bg-[#8b5cf6]/10 border border-[#8b5cf6]/20 text-[#8b5cf6] rounded-xl text-xs font-bold">
                                                {{ $material->type }}
                                            </span>
                                        </td>
                                        <td class="py-4 whitespace-nowrap text-sm text-[#06b6d4]">
                                            <a href="{{ Storage::url($material->file_path) }}" target="_blank" class="inline-flex items-center gap-1.5 hover:underline font-semibold">
                                                📥 Télécharger
                                            </a>
                                        </td>
                                        <td class="py-4 text-right whitespace-nowrap">
                                            <form method="POST" action="{{ route('professor.materials.destroy', $material) }}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce support de cours ?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-3 py-1 bg-[#d946ef]/10 hover:bg-[#d946ef]/20 border border-[#d946ef]/20 text-[#d946ef] text-xs font-bold rounded-xl transition">
                                                    Supprimer
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
