<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Publier une Annonce') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('professor.announcements.store') }}">
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

                        <!-- Content -->
                        <div class="mb-6">
                            <x-input-label for="content" :value="__('Contenu de l\'annonce')" />
                            <textarea id="content" name="content" rows="6" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" placeholder="Écrivez le message de votre annonce ici..." required>{{ old('content') }}</textarea>
                            <x-input-error :messages="$errors->get('content')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end">
                            <a href="{{ route('professor.announcements.index') }}" class="mr-4 text-sm text-gray-600 hover:text-gray-900 underline">
                                Annuler
                            </a>
                            <x-primary-button>
                                {{ __('Publier') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
