<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Uploader un Support de Cours') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('professor.materials.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Title -->
                        <div class="mb-4">
                            <x-input-label for="title" :value="__('Titre du document')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus placeholder="Ex: Cours Chapitre 1 - Introduction" />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

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

                        <!-- File upload -->
                        <div class="mb-6">
                            <x-input-label for="file" :value="__('Fichier (PDF, PPTX, DOCX, ZIP - Max 10Mo)')" />
                            <input id="file" type="file" name="file" class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-md cursor-pointer bg-gray-50 focus:outline-none focus:border-indigo-500" required />
                            <x-input-error :messages="$errors->get('file')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end">
                            <a href="{{ route('professor.materials.index') }}" class="mr-4 text-sm text-gray-600 hover:text-gray-900 underline">
                                Annuler
                            </a>
                            <x-primary-button>
                                {{ __('Uploader') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
