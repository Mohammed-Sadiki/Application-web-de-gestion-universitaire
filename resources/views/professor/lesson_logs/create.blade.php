<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mettre à jour le Cahier de Textes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('professor.lesson_logs.store') }}">
                        @csrf

                        <!-- Module -->
                        <div class="mb-4">
                            <x-input-label for="module_id" :value="__('Module')" />
                            <select id="module_id" name="module_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                                <option value="">Choisir un module</option>
                                @foreach($modules as $module)
                                    <option value="{{ $module->id }}" {{ old('module_id') == $module->id ? 'selected' : '' }}>
                                        {{ $module->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('module_id')" class="mt-2" />
                        </div>

                        <!-- Date (Automatic & Read-Only) -->
                        <div class="mb-4">
                            <x-input-label for="date_display" :value="__('Date')" />
                            <x-text-input id="date_display" class="block mt-1 w-full bg-gray-100 cursor-not-allowed" type="date" value="{{ date('Y-m-d') }}" disabled />
                            <input type="hidden" name="date" value="{{ date('Y-m-d') }}" />
                            <span class="text-xs text-gray-500 mt-1 block">La date est automatiquement définie sur celle d'aujourd'hui.</span>
                            <x-input-error :messages="$errors->get('date')" class="mt-2" />
                        </div>

                        <!-- Type of Session -->
                        <div class="mb-4">
                            <x-input-label for="type" :value="__('Type de séance')" />
                            <select id="type" name="type" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                                <option value="Cours" {{ old('type') == 'Cours' ? 'selected' : '' }}>Cours</option>
                                <option value="TD" {{ old('type') == 'TD' ? 'selected' : '' }}>Travaux Dirigés (TD)</option>
                                <option value="TP" {{ old('type') == 'TP' ? 'selected' : '' }}>Travaux Pratiques (TP)</option>
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <!-- Start Time -->
                            <div class="mb-4">
                                <x-input-label for="start_time" :value="__('Heure de début')" />
                                <x-text-input id="start_time" class="block mt-1 w-full" type="time" name="start_time" :value="old('start_time')" required />
                                <x-input-error :messages="$errors->get('start_time')" class="mt-2" />
                            </div>

                            <!-- End Time -->
                            <div class="mb-4">
                                <x-input-label for="end_time" :value="__('Heure de fin')" />
                                <x-text-input id="end_time" class="block mt-1 w-full" type="time" name="end_time" :value="old('end_time')" required />
                                <x-input-error :messages="$errors->get('end_time')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Objective / Content -->
                        <div class="mb-6">
                            <x-input-label for="objective" :value="__('Objectifs & Description du cours')" />
                            <textarea id="objective" name="objective" rows="4" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>{{ old('objective') }}</textarea>
                            <x-input-error :messages="$errors->get('objective')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end">
                            <a href="{{ route('professor.lesson_logs.index') }}" class="mr-4 text-sm text-gray-600 hover:text-gray-900 underline">
                                Annuler
                            </a>
                            <x-primary-button>
                                {{ __('Enregistrer') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
