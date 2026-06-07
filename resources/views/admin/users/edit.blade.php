<x-app-layout>
    <x-slot name="header">
        <div class="topbar-title">Modifier l'Utilisateur</div>
        <div class="topbar-subtitle">Mettre à jour les informations de {{ $user->name }}</div>
    </x-slot>

    <div class="py-6 animate-fade-in">
        <div class="max-w-xl">
            <div class="dark-card rounded-3xl overflow-hidden border border-white/5">
                <div class="p-6 bg-[#17192a]/30 border-b border-white/5">
                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                        <span class="w-2.5 h-2.5 bg-[#06b6d4] rounded-full animate-pulse"></span>
                        Modifier le Compte
                    </h3>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.users.update', $user) }}">
                        @csrf
                        @method('PATCH')

                        <div class="space-y-4">
                            <div>
                                <label for="name" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Nom complet</label>
                                <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required autofocus
                                    class="w-full bg-white/5 border border-white/10 text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-[#8b5cf6] transition">
                                @error('name')<p class="text-[#d946ef] text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="email" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Email</label>
                                <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required
                                    class="w-full bg-white/5 border border-white/10 text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-[#8b5cf6] transition">
                                @error('email')<p class="text-[#d946ef] text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="role" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Rôle</label>
                                <select id="role" name="role"
                                    class="w-full bg-[#0d1220] border border-white/10 text-white rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-[#8b5cf6] transition">
                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Administrateur</option>
                                    <option value="professor" {{ $user->role === 'professor' ? 'selected' : '' }}>Professeur</option>
                                    <option value="student" {{ $user->role === 'student' ? 'selected' : '' }}>Étudiant</option>
                                </select>
                                @error('role')<p class="text-[#d946ef] text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div class="flex justify-end mt-6">
                            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-[#06b6d4] to-[#8b5cf6] hover:opacity-90 text-white text-sm font-bold rounded-xl shadow transition">
                                Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>