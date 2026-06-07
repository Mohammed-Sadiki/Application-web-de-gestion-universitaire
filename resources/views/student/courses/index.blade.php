<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mes Cours - Classroom') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($modules->isEmpty())
                        <p class="text-gray-500">Aucun module disponible.</p>
                    @else
                        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach($modules as $module)
                                <a href="{{ route('student.courses.show', $module) }}" class="block bg-gradient-to-br from-indigo-50 to-blue-100 border border-indigo-200 rounded-xl p-5 hover:shadow-md transition-shadow">
                                    <div class="flex items-center gap-3 mb-3">
                                        <div class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-bold text-lg">
                                            {{ strtoupper(substr($module->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-gray-900">{{ $module->name }}</h3>
                                            <p class="text-xs text-gray-500">{{ $module->department->name ?? '' }}</p>
                                        </div>
                                    </div>
                                    <div class="flex gap-4 text-xs text-gray-600">
                                        <span>📄 {{ $module->courseMaterials->count() }} supports</span>
                                        <span>📢 {{ $module->announcements->count() }} annonces</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
