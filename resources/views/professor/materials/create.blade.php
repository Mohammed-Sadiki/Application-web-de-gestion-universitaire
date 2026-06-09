<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <div>
                <div class="topbar-title">Uploader un Support de Cours</div>
                <div class="topbar-subtitle">Partagez un document pédagogique avec vos étudiants</div>
            </div>
            <a href="{{ route('professor.materials.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 text-white text-xs font-bold rounded-xl transition">
                &larr; Annuler
            </a>
        </div>
    </x-slot>

    <div class="py-6 animate-fade-in">
        <div class="max-w-3xl mx-auto">
            <div class="dark-card rounded-3xl overflow-hidden border border-white/5">
                <div class="p-6 bg-[#17192a]/30 border-b border-white/5">
                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                        <span class="w-2.5 h-2.5 bg-[#8b5cf6] rounded-full animate-pulse"></span>
                        Nouveau document
                    </h3>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('professor.materials.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Title -->
                        <div class="mb-5">
                            <label for="title" class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Titre du document</label>
                            <input id="title" class="w-full bg-[#0d1220] border border-white/10 text-white rounded-xl px-4 py-2.5 focus:border-[#8b5cf6] focus:ring-1 focus:ring-[#8b5cf6]" type="text" name="title" :value="old('title')" required autofocus placeholder="Ex: Cours Chapitre 1 - Introduction" />
                            @error('title') <p class="text-[#d946ef] text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Module -->
                        <div class="mb-5">
                            <label for="module_id" class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Module</label>
                            <select id="module_id" name="module_id" class="w-full bg-[#0d1220] border border-white/10 text-white rounded-xl px-4 py-2.5 focus:border-[#8b5cf6] focus:ring-1 focus:ring-[#8b5cf6]" required>
                                <option value="" class="bg-[#17192a] text-gray-400">Choisir un module</option>
                                @foreach($modules as $module)
                                    <option value="{{ $module->id }}" {{ old('module_id') == $module->id ? 'selected' : '' }} class="bg-[#17192a] text-white">
                                        {{ $module->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('module_id') <p class="text-[#d946ef] text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- File upload -->
                        <div class="mb-6">
                            <label for="file" class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Fichier (PDF, PPTX, DOCX, ZIP - Max 10Mo)</label>
                            <input id="file" type="file" name="file" class="block w-full text-sm text-gray-400 border border-white/10 rounded-xl cursor-pointer bg-white/5 focus:outline-none focus:border-[#8b5cf6]" required />
                            @error('file') <p class="text-[#d946ef] text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('professor.materials.index') }}" class="text-sm text-gray-400 hover:text-white transition">
                                Annuler
                            </a>
                            <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-[#8b5cf6] to-[#d946ef] hover:opacity-90 text-white text-xs font-bold rounded-xl shadow-md transition duration-200">
                                Uploader
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
