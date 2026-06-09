<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <div>
                <div class="topbar-title">Mettre à jour le Cahier de Textes</div>
                <div class="topbar-subtitle">Consignez le contenu, les objectifs et le créneau horaire de votre cours</div>
            </div>
            <a href="{{ route('professor.lesson_logs.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 text-white text-xs font-bold rounded-xl transition">
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
                        Nouveau compte-rendu de cours
                    </h3>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('professor.lesson_logs.store') }}">
                        @csrf

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

                        <!-- Date (Automatic & Read-Only) -->
                        <div class="mb-5">
                            <label for="date_display" class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Date de la séance</label>
                            <input id="date_display" class="w-full bg-white/5 border border-white/5 text-gray-400 rounded-xl px-4 py-2.5 cursor-not-allowed" type="date" value="{{ date('Y-m-d') }}" disabled />
                            <input type="hidden" name="date" value="{{ date('Y-m-d') }}" />
                            <span class="text-xs text-gray-500 mt-1 block">La date est automatiquement définie sur aujourd'hui.</span>
                            @error('date') <p class="text-[#d946ef] text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Type of Session -->
                        <div class="mb-5">
                            <label for="type" class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Type de séance</label>
                            <select id="type" name="type" class="w-full bg-[#0d1220] border border-white/10 text-white rounded-xl px-4 py-2.5 focus:border-[#8b5cf6] focus:ring-1 focus:ring-[#8b5cf6]" required>
                                <option value="Cours" {{ old('type') == 'Cours' ? 'selected' : '' }} class="bg-[#17192a] text-white">Cours</option>
                                <option value="TD" {{ old('type') == 'TD' ? 'selected' : '' }} class="bg-[#17192a] text-white">Travaux Dirigés (TD)</option>
                                <option value="TP" {{ old('type') == 'TP' ? 'selected' : '' }} class="bg-[#17192a] text-white">Travaux Pratiques (TP)</option>
                            </select>
                            @error('type') <p class="text-[#d946ef] text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <!-- Start Time -->
                            <div class="mb-5">
                                <label for="start_time" class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Heure de début</label>
                                <input id="start_time" type="time" name="start_time" value="{{ old('start_time') }}" class="w-full bg-[#0d1220] border border-white/10 text-white rounded-xl px-4 py-2.5 focus:border-[#8b5cf6] focus:ring-1 focus:ring-[#8b5cf6]" required />
                                @error('start_time') <p class="text-[#d946ef] text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- End Time -->
                            <div class="mb-5">
                                <label for="end_time" class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Heure de fin</label>
                                <input id="end_time" type="time" name="end_time" value="{{ old('end_time') }}" class="w-full bg-[#0d1220] border border-white/10 text-white rounded-xl px-4 py-2.5 focus:border-[#8b5cf6] focus:ring-1 focus:ring-[#8b5cf6]" required />
                                @error('end_time') <p class="text-[#d946ef] text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Objective / Content -->
                        <div class="mb-6">
                            <label for="objective" class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Objectifs & Description du cours</label>
                            <textarea id="objective" name="objective" rows="4" class="w-full bg-white/5 border border-white/10 text-white rounded-xl px-4 py-2.5 focus:border-[#8b5cf6] focus:ring-1 focus:ring-[#8b5cf6]" placeholder="Indiquez les chapitres abordés, TP effectués, devoirs donnés, etc." required>{{ old('objective') }}</textarea>
                            @error('objective') <p class="text-[#d946ef] text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('professor.lesson_logs.index') }}" class="text-sm text-gray-400 hover:text-white transition">
                                Annuler
                            </a>
                            <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-[#8b5cf6] to-[#d946ef] hover:opacity-90 text-white text-xs font-bold rounded-xl shadow-md transition duration-200">
                                Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
