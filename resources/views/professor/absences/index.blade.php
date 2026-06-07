<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestion des Absences') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-800 rounded">{{ session('success') }}</div>
            @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Sélectionnez un module pour enregistrer les absences</h3>
                    @if($modules->isEmpty())
                        <p class="text-gray-500">Aucun module assigné.</p>
                    @else
                        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach($modules as $module)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-sm transition">
                                    <h4 class="font-semibold text-gray-900 mb-2">{{ $module->name }}</h4>
                                    <a href="{{ route('professor.absences.create', $module) }}"
                                       class="inline-block px-4 py-2 bg-indigo-600 text-white text-sm rounded hover:bg-indigo-700">
                                        📋 Faire la liste de présence
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
