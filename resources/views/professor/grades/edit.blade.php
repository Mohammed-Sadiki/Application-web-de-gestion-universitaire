<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Saisie des notes : ') }} {{ $module->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('professor.grades.update', $module) }}">
                        @csrf
                        @method('PATCH')

                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Étudiant</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CC1 (40%)</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CC2 (40%)</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Examen (60%)</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Note Finale</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($students as $index => $student)
                                    @php
                                        $grade = $student->grades()->where('module_id', $module->id)->first();
                                    @endphp
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $student->user->name }}
                                            <input type="hidden" name="grades[{{ $index }}][student_id]" value="{{ $student->id }}">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="number" step="0.01" name="grades[{{ $index }}][cc1]" value="{{ $grade->cc1 ?? '' }}" class="w-20 border-gray-300 rounded-md">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="number" step="0.01" name="grades[{{ $index }}][cc2]" value="{{ $grade->cc2 ?? '' }}" class="w-20 border-gray-300 rounded-md">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="number" step="0.01" name="grades[{{ $index }}][exam]" value="{{ $grade->exam ?? '' }}" class="w-20 border-gray-300 rounded-md">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap font-bold">
                                            {{ $grade->final_grade ?? '-' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Enregistrer les notes') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>