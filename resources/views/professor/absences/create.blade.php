<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Liste de présence — {{ $module->name }}
            </h2>
            <a href="{{ route('professor.absences.index') }}" class="text-sm text-blue-600 hover:underline">← Retour</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('professor.absences.store', $module) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <x-input-label for="date" :value="__('Date de la séance')" />
                            <x-text-input id="date" class="block mt-1 w-48" type="date" name="date"
                                value="{{ date('Y-m-d') }}" required />
                            @error('date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <p class="text-sm text-gray-600 mb-3">Cochez les étudiants <strong>absents</strong> :</p>

                        @if($students->isEmpty())
                            <p class="text-gray-500">Aucun étudiant trouvé pour ce module.</p>
                        @else
                            <div class="border rounded-lg divide-y">
                                @foreach($students as $student)
                                    <label class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 cursor-pointer">
                                        <input type="checkbox" name="absent_students[]" value="{{ $student->id }}"
                                               class="w-4 h-4 text-red-600 border-gray-300 rounded">
                                        <span class="text-sm font-medium text-gray-900">{{ $student->user->name }}</span>
                                        <span class="text-xs text-gray-500">{{ $student->student_number ?? '' }}</span>
                                    </label>
                                @endforeach
                            </div>

                            <div class="mt-6 flex justify-end">
                                <x-primary-button>💾 Enregistrer les absences</x-primary-button>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
