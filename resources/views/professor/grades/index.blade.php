<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestion des Notes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Mes Modules</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach($modules as $module)
                            <div class="border rounded-lg p-4 hover:bg-gray-50">
                                <h4 class="font-bold text-indigo-600">{{ $module->name }}</h4>
                                <p class="text-sm text-gray-500">{{ $module->department->name }}</p>
                                <a href="{{ route('professor.grades.edit', $module) }}" class="mt-4 inline-block bg-indigo-500 text-white px-4 py-2 rounded text-sm">
                                    Saisir les notes
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>