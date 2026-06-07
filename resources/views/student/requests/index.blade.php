<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mes Demandes Administratives') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="p-4 bg-green-100 border border-green-400 text-green-800 rounded">{{ session('success') }}</div>
            @endif

            {{-- New Request Form --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Soumettre une demande</h3>
                    <form action="{{ route('student.requests.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <x-input-label for="type" :value="__('Type de document')" />
                            <select id="type" name="type" required
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">-- Choisir un document --</option>
                                <option value="Attestation de scolarité">Attestation de scolarité</option>
                                <option value="Relevé de notes">Relevé de notes</option>
                                <option value="Certificat d'inscription">Certificat d'inscription</option>
                            </select>
                            @error('type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
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
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Document</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($requests as $req)
                                    <tr>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $req->type }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $req->created_at->format('d/m/Y') }}</td>
                                        <td class="px-6 py-4">
                                            @if($req->status === 'validated')
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Validé</span>
                                            @elseif($req->status === 'rejected')
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Refusé</span>
                                                @if($req->reason)
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
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
