<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mes Demandes Administratives') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="p-4 bg-green-100 border border-green-400 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- New Request Form --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Soumettre une demande</h3>
                    <form action="{{ route('professor.requests.store') }}" method="POST" id="requestForm">
                        @csrf
                        <div class="mb-4">
                            <x-input-label for="type" :value="__('Type de document')" />
                            <select id="type" name="type" required onchange="toggleMissionFields(this.value)"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">-- Choisir un document --</option>
                                <option value="Attestation de travail" {{ old('type') == 'Attestation de travail' ? 'selected' : '' }}>Attestation de travail</option>
                                <option value="Ordre de mission" {{ old('type') == 'Ordre de mission' ? 'selected' : '' }}>Ordre de mission</option>
                            </select>
                            @error('type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Ordre de mission fields (hidden by default) -->
                        <div id="missionFields" style="display: {{ old('type') == 'Ordre de mission' ? 'block' : 'none' }};" class="border p-4 rounded-lg bg-gray-50 mb-4 space-y-4">
                            <h4 class="font-medium text-gray-700">Détails de l'Ordre de mission</h4>
                            
                            <div>
                                <x-input-label for="destination" :value="__('Destination')" />
                                <x-text-input id="destination" class="block mt-1 w-full" type="text" name="destination" :value="old('destination')" />
                                @error('destination') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="start_date" :value="__('Date de début')" />
                                    <x-text-input id="start_date" class="block mt-1 w-full" type="date" name="start_date" :value="old('start_date')" />
                                    @error('start_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <x-input-label for="end_date" :value="__('Date de fin')" />
                                    <x-text-input id="end_date" class="block mt-1 w-full" type="date" name="end_date" :value="old('end_date')" />
                                    @error('end_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div>
                                <x-input-label for="motif" :value="__('Motif du déplacement')" />
                                <textarea id="motif" name="motif" rows="3" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">{{ old('motif') }}</textarea>
                                @error('motif') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <x-primary-button>Soumettre la demande</x-primary-button>
                    </form>
                </div>
            </div>

            {{-- Requests History --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Historique de mes demandes</h3>
                    @if($requests->isEmpty())
                        <p class="text-gray-500">Aucune demande effectuée.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date de demande</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Document</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($requests as $req)
                                        <tr>
                                            <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                                {{ $req->type }}
                                                @if($req->type === 'Ordre de mission' && $req->reason)
                                                    @php $details = json_decode($req->reason, true); @endphp
                                                    @if($details)
                                                        <div class="text-xs text-gray-500 font-normal mt-1 space-y-0.5">
                                                            <div>📍 Destination: {{ $details['destination'] ?? '' }}</div>
                                                            <div>📅 Dates: du {{ \Carbon\Carbon::parse($details['start_date'] ?? '')->format('d/m/Y') }} au {{ \Carbon\Carbon::parse($details['end_date'] ?? '')->format('d/m/Y') }}</div>
                                                            <div>📝 Motif: {{ $details['motif'] ?? '' }}</div>
                                                        </div>
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $req->created_at->format('d/m/Y') }}</td>
                                            <td class="px-6 py-4">
                                                @if($req->status === 'validated')
                                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Validé</span>
                                                @elseif($req->status === 'rejected')
                                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Refusé</span>
                                                    @if($req->type !== 'Ordre de mission' && $req->reason)
                                                        <p class="text-xs text-red-500 mt-1">{{ $req->reason }}</p>
                                                    @endif
                                                @else
                                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">En attente</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-sm">
                                                @if($req->status === 'validated' && $req->file_path)
                                                    <a href="{{ asset('storage/' . $req->file_path) }}" target="_blank"
                                                       class="inline-flex items-center px-3 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700">
                                                        📥 Télécharger
                                                    </a>
                                                @else
                                                    <span class="text-gray-400 text-xs">—</span>
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
