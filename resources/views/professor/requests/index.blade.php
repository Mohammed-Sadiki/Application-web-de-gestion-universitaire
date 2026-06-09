<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <div>
                <div class="topbar-title">Mes Demandes Administratives</div>
                <div class="topbar-subtitle">Soumettez des demandes de documents et suivez leur statut de traitement</div>
            </div>
        </div>
    </x-slot>

    <div class="py-6 animate-fade-in space-y-6">
        @if(session('success'))
            <div class="bg-green-500/10 border border-green-500/20 text-green-400 px-4 py-3 rounded-xl text-sm">
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- New Request Form --}}
        <div class="dark-card rounded-3xl overflow-hidden border border-white/5">
            <div class="p-6 bg-[#17192a]/30 border-b border-white/5">
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <span class="w-2.5 h-2.5 bg-[#8b5cf6] rounded-full animate-pulse"></span>
                    Soumettre une demande
                </h3>
            </div>
            <div class="p-6">
                <form action="{{ route('professor.requests.store') }}" method="POST" id="requestForm">
                    @csrf
                    <div class="mb-5">
                        <label for="type" class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Type de document</label>
                        <select id="type" name="type" required onchange="toggleMissionFields(this.value)"
                            class="w-full bg-[#0d1220] border border-white/10 text-white rounded-xl px-4 py-2.5 focus:border-[#8b5cf6] focus:ring-1 focus:ring-[#8b5cf6]">
                            <option value="" class="bg-[#17192a] text-gray-400">-- Choisir un document --</option>
                            <option value="Attestation de travail" {{ old('type') == 'Attestation de travail' ? 'selected' : '' }} class="bg-[#17192a] text-white">Attestation de travail</option>
                            <option value="Ordre de mission" {{ old('type') == 'Ordre de mission' ? 'selected' : '' }} class="bg-[#17192a] text-white">Ordre de mission</option>
                        </select>
                        @error('type') <p class="text-[#d946ef] text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Ordre de mission fields (hidden by default) -->
                    <div id="missionFields" style="display: {{ old('type') == 'Ordre de mission' ? 'block' : 'none' }};" class="border border-white/5 p-5 rounded-2xl bg-[#17192a]/30 mb-5 space-y-4">
                        <h4 class="font-bold text-white text-sm">Détails de l'Ordre de mission</h4>
                        
                        <div>
                            <label for="destination" class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Destination</label>
                            <input id="destination" class="w-full bg-[#0d1220] border border-white/10 text-white rounded-xl px-4 py-2.5 focus:border-[#8b5cf6] focus:ring-1 focus:ring-[#8b5cf6]" type="text" name="destination" value="{{ old('destination') }}" />
                            @error('destination') <p class="text-[#d946ef] text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="start_date" class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Date de début</label>
                                <input id="start_date" class="w-full bg-[#0d1220] border border-white/10 text-white rounded-xl px-4 py-2.5 focus:border-[#8b5cf6] focus:ring-1 focus:ring-[#8b5cf6]" type="date" name="start_date" value="{{ old('start_date') }}" />
                                @error('start_date') <p class="text-[#d946ef] text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="end_date" class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Date de fin</label>
                                <input id="end_date" class="w-full bg-[#0d1220] border border-white/10 text-white rounded-xl px-4 py-2.5 focus:border-[#8b5cf6] focus:ring-1 focus:ring-[#8b5cf6]" type="date" name="end_date" value="{{ old('end_date') }}" />
                                @error('end_date') <p class="text-[#d946ef] text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label for="motif" class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Motif du déplacement</label>
                            <textarea id="motif" name="motif" rows="3" class="w-full bg-white/5 border border-white/10 text-white rounded-xl px-4 py-2.5 focus:border-[#8b5cf6] focus:ring-1 focus:ring-[#8b5cf6]">{{ old('motif') }}</textarea>
                            @error('motif') <p class="text-[#d946ef] text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-[#8b5cf6] to-[#d946ef] hover:opacity-90 text-white text-xs font-bold rounded-xl shadow-md transition duration-200">
                        Soumettre la demande
                    </button>
                </form>
            </div>
        </div>

        {{-- Requests History --}}
        <div class="dark-card rounded-3xl overflow-hidden border border-white/5">
            <div class="p-6 bg-[#17192a]/30 border-b border-white/5">
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <span class="w-2.5 h-2.5 bg-[#8b5cf6] rounded-full animate-pulse"></span>
                    Historique de mes demandes
                </h3>
            </div>
            <div class="p-6">
                @if($requests->isEmpty())
                    <p class="text-gray-400 italic text-center py-6">Aucune demande effectuée.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-white/5">
                            <thead>
                                <tr class="text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                                    <th class="pb-3 text-left">Type</th>
                                    <th class="pb-3 text-left">Date de demande</th>
                                    <th class="pb-3 text-left">Statut</th>
                                    <th class="pb-3 text-right">Document</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-white/5 text-gray-300">
                                @foreach($requests as $req)
                                    <tr class="hover:bg-white/[0.02] transition-colors">
                                        <td class="py-4 font-semibold text-white whitespace-nowrap">
                                            {{ $req->type }}
                                            @if($req->type === 'Ordre de mission' && $req->reason)
                                                @php $details = json_decode($req->reason, true); @endphp
                                                @if($details)
                                                    <div class="text-xs text-gray-400 font-normal mt-2.5 space-y-1 bg-white/5 p-3 rounded-xl border border-white/5 max-w-sm">
                                                        <div>📍 Destination: <span class="text-white font-semibold">{{ $details['destination'] ?? '' }}</span></div>
                                                        <div>📅 Dates: du <span class="text-white font-semibold">{{ \Carbon\Carbon::parse($details['start_date'] ?? '')->format('d/m/Y') }}</span> au <span class="text-white font-semibold">{{ \Carbon\Carbon::parse($details['end_date'] ?? '')->format('d/m/Y') }}</span></div>
                                                        <div>📝 Motif: <span class="text-white font-semibold">{{ $details['motif'] ?? '' }}</span></div>
                                                    </div>
                                                @endif
                                            @endif
                                        </td>
                                        <td class="py-4 whitespace-nowrap text-gray-400">{{ $req->created_at->format('d/m/Y') }}</td>
                                        <td class="py-4 whitespace-nowrap">
                                            @if($req->status === 'validated')
                                                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-[#06b6d4]/10 border border-[#06b6d4]/20 text-[#06b6d4]">✅ Validé</span>
                                            @elseif($req->status === 'rejected')
                                                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-[#d946ef]/10 border border-[#d946ef]/20 text-[#d946ef]">❌ Refusé</span>
                                                @if($req->type !== 'Ordre de mission' && $req->reason)
                                                    <p class="text-xs text-[#d946ef] mt-1">{{ $req->reason }}</p>
                                                @endif
                                            @elseif($req->status === 'transferred')
                                                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-orange-500/10 border border-orange-500/20 text-orange-400">📨 En cours de traitement</span>
                                                <p class="text-[11px] text-gray-500 mt-1">En cours de validation par le service concerné</p>
                                            @else
                                                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-yellow-500/10 border border-yellow-500/20 text-yellow-400">⏳ En attente</span>
                                            @endif
                                        </td>
                                        <td class="py-4 text-right whitespace-nowrap text-sm">
                                            @if($req->status === 'validated' && $req->file_path)
                                                <a href="{{ asset('storage/' . $req->file_path) }}" target="_blank"
                                                   class="inline-flex items-center gap-1.5 px-3 py-1 bg-[#06b6d4]/10 hover:bg-[#06b6d4]/20 border border-[#06b6d4]/20 text-[#06b6d4] text-xs font-bold rounded-xl transition">
                                                    📥 Télécharger
                                                </a>
                                            @else
                                                <span class="text-gray-500 text-xs">—</span>
                                            @endif
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

    <script>
        function toggleMissionFields(type) {
            const fields = document.getElementById('missionFields');
            const destination = document.getElementById('destination');
            const start_date = document.getElementById('start_date');
            const end_date = document.getElementById('end_date');
            const motif = document.getElementById('motif');
            
            if (type === 'Ordre de mission') {
                fields.style.display = 'block';
                destination.setAttribute('required', 'required');
                start_date.setAttribute('required', 'required');
                end_date.setAttribute('required', 'required');
                motif.setAttribute('required', 'required');
            } else {
                fields.style.display = 'none';
                destination.removeAttribute('required');
                start_date.removeAttribute('required');
                end_date.removeAttribute('required');
                motif.removeAttribute('required');
            }
        }
    </script>
</x-app-layout>
