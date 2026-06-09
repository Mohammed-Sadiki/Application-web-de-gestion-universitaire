<x-app-layout>
    <x-slot name="header">
        <div class="topbar-title">Administration Générale</div>
        <div class="topbar-subtitle">Vue d'ensemble et gestion des ressources de l'établissement</div>
    </x-slot>

    <div class="py-12 animate-fade-in">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-5 mb-10">
                @foreach($stats as $key => $value)
                    @php
                        $label = str_replace('_', ' ', $key);
                        if ($key === 'pending_requests') {
                            $label = 'Demandes En Attente';
                            $textColor = 'text-neon-pink';
                        } elseif ($key === 'users') {
                            $label = 'Utilisateurs';
                            $textColor = 'text-neon-cyan';
                        } else {
                            $textColor = 'text-neon-purple';
                        }
                    @endphp
                    <div class="dark-card p-5 rounded-3xl border border-white/5 flex flex-col items-center justify-center text-center transition-transform duration-300 hover:-translate-y-1">
                        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">
                            {{ $label }}
                        </div>
                        <div class="text-3xl font-black {{ $textColor }}">
                            {{ $value }}
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Content Panel -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left area: Pending Requests Table -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="dark-card rounded-3xl overflow-hidden border border-white/5">
                        <div class="p-6 border-b border-white/5 flex justify-between items-center bg-[#17192a]/50">
                            <h3 class="text-lg font-bold text-white flex items-center">
                                <span class="w-2.5 h-2.5 bg-[#d946ef] rounded-full mr-2.5 animate-pulse"></span>
                                Demandes administratives en attente
                            </h3>
                        </div>
                        <div class="p-6 bg-transparent">
                            @if($pendingRequests->isEmpty())
                                <div class="text-center py-12">
                                    <span class="text-5xl">👋</span>
                                    <p class="text-gray-400 italic mt-4 text-sm">Aucune demande en attente pour le moment.</p>
                                </div>
                            @else
                                <div class="overflow-x-auto">
                                    <table class="min-w-full">
                                        <thead>
                                            <tr class="text-left text-xs font-bold text-gray-400 uppercase tracking-wider border-b border-white/5">
                                                <th class="pb-3">Utilisateur</th>
                                                <th class="pb-3">Type</th>
                                                <th class="pb-3 text-right">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-sm divide-y divide-white/5">
                                            @foreach($pendingRequests as $req)
                                                <tr>
                                                    <td class="py-4 font-bold text-white">{{ $req->user->name }}</td>
                                                    <td class="py-4">
                                                        <span class="px-2.5 py-1 bg-[#8b5cf6]/10 border border-[#8b5cf6]/20 rounded-full text-xs font-semibold text-[#8b5cf6]">
                                                            {{ $req->type }}
                                                        </span>
                                                    </td>
                                                    <td class="py-4 text-right space-x-2">
                                                        <form action="{{ route('admin.requests.validate', $req) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="validated">
                                                            <button type="submit" class="bg-[#06b6d4]/10 hover:bg-[#06b6d4]/20 border border-[#06b6d4]/20 text-[#06b6d4] px-3 py-1 rounded-xl text-xs font-bold transition">
                                                                Valider
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('admin.requests.validate', $req) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="rejected">
                                                            <button type="submit" class="bg-[#d946ef]/10 hover:bg-[#d946ef]/20 border border-[#d946ef]/20 text-[#d946ef] px-3 py-1 rounded-xl text-xs font-bold transition">
                                                                Rejeter
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

                <!-- Right area: Admin Quick links -->
                <div class="space-y-6">
                    <div class="dark-card rounded-3xl p-6 relative overflow-hidden bg-gradient-to-b from-[#151726] to-[#0e101f] border border-white/5">
                        <div class="absolute -right-10 -bottom-10 opacity-5 text-[#8b5cf6]">
                            <svg class="w-40 h-40" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 3L1 9L12 15L21 9L12 3M5 13.18V17.18L12 21L19 17.18V13.18L12 17L5 13.18Z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2">Ressources Globales</h3>
                        <p class="text-xs text-gray-400 mb-6">Administrez l'ensemble des données et des ressources académiques.</p>
                        
                        <div class="space-y-3">
                            <a href="{{ route('admin.users.index') }}" class="flex items-center justify-between p-3.5 bg-white/[0.03] hover:bg-white/[0.08] border border-white/5 hover:border-[#8b5cf6]/30 rounded-xl text-sm font-semibold text-white transition duration-200">
                                <span class="flex items-center"><span class="text-base mr-2">👥</span> Utilisateurs</span>
                                <span class="text-[#8b5cf6]">&rarr;</span>
                            </a>
                            <a href="{{ route('admin.departments.index') }}" class="flex items-center justify-between p-3.5 bg-white/[0.03] hover:bg-white/[0.08] border border-white/5 hover:border-[#d946ef]/30 rounded-xl text-sm font-semibold text-white transition duration-200">
                                <span class="flex items-center"><span class="text-base mr-2">🏫</span> Filières / Départements</span>
                                <span class="text-[#d946ef]">&rarr;</span>
                            </a>
                            <a href="{{ route('admin.groups.index') }}" class="flex items-center justify-between p-3.5 bg-white/[0.03] hover:bg-white/[0.08] border border-white/5 hover:border-[#06b6d4]/30 rounded-xl text-sm font-semibold text-white transition duration-200">
                                <span class="flex items-center"><span class="text-base mr-2">🎓</span> Groupes de classe</span>
                                <span class="text-[#06b6d4]">&rarr;</span>
                            </a>
                            <a href="{{ route('admin.modules.index') }}" class="flex items-center justify-between p-3.5 bg-white/[0.03] hover:bg-white/[0.08] border border-white/5 hover:border-[#8b5cf6]/30 rounded-xl text-sm font-semibold text-white transition duration-200">
                                <span class="flex items-center"><span class="text-base mr-2">📚</span> Modules</span>
                                <span class="text-[#8b5cf6]">&rarr;</span>
                            </a>
                            <a href="{{ route('admin.rooms.index') }}" class="flex items-center justify-between p-3.5 bg-white/[0.03] hover:bg-white/[0.08] border border-white/5 hover:border-[#d946ef]/30 rounded-xl text-sm font-semibold text-white transition duration-200">
                                <span class="flex items-center"><span class="text-base mr-2">📍</span> Salles de cours</span>
                                <span class="text-[#d946ef]">&rarr;</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>