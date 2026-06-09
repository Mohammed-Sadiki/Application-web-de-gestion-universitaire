<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <div>
                <div class="topbar-title">{{ $module->name }} — Classroom</div>
                <div class="topbar-subtitle">Consultez les supports et les annonces de ce module</div>
            </div>
            <a href="{{ route('courses.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 text-white text-xs font-bold rounded-xl transition">
                &larr; Retour
            </a>
        </div>
    </x-slot>

    <div class="py-6 animate-fade-in space-y-6">

        {{-- Course Materials --}}
        <div class="dark-card rounded-3xl overflow-hidden border border-white/5">
            <div class="p-6 bg-[#17192a]/30 border-b border-white/5">
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <span class="w-2.5 h-2.5 bg-[#8b5cf6] rounded-full animate-pulse"></span>
                    📄 Supports de cours
                </h3>
            </div>
            <div class="p-6">
                @if($materials->isEmpty())
                    <p class="text-gray-400 italic text-center py-4">Aucun support disponible pour ce module.</p>
                @else
                    <div class="grid gap-4 sm:grid-cols-2">
                        @foreach($materials as $material)
                            <a href="{{ asset('storage/' . $material->file_path) }}" target="_blank"
                               class="flex items-center gap-4 p-4 border border-white/5 rounded-2xl bg-[#17192a]/30 hover:border-[#8b5cf6]/40 hover:bg-[#8b5cf6]/5 transition duration-300">
                                <div class="w-12 h-12 bg-[#d946ef]/10 border border-[#d946ef]/20 rounded-2xl flex items-center justify-center text-[#d946ef] font-bold text-xs">
                                    {{ strtoupper(pathinfo($material->file_path, PATHINFO_EXTENSION) ?: 'FILE') }}
                                </div>
                                <div>
                                    <p class="font-bold text-sm text-white">{{ $material->title }}</p>
                                    <p class="text-xs text-gray-400 mt-1">Publié le {{ $material->created_at->format('d/m/Y') }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- Announcements & Comments --}}
        <div class="dark-card rounded-3xl overflow-hidden border border-white/5">
            <div class="p-6 bg-[#17192a]/30 border-b border-white/5">
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <span class="w-2.5 h-2.5 bg-[#8b5cf6] rounded-full animate-pulse"></span>
                    📢 Annonces
                </h3>
            </div>
            <div class="p-6">
                @if(session('success'))
                    <div class="bg-green-500/10 border border-green-500/20 text-green-400 px-4 py-3 rounded-xl mb-6 text-sm">
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if($announcements->isEmpty())
                    <p class="text-gray-400 italic text-center py-4">Aucune annonce pour ce module.</p>
                @else
                    <div class="space-y-6">
                        @foreach($announcements as $announcement)
                            <div class="border border-white/5 rounded-2xl p-5 bg-[#17192a]/10">
                                <div class="flex items-start justify-between mb-3">
                                    <div>
                                        <h4 class="font-bold text-white text-base leading-snug">{{ $announcement->title }}</h4>
                                        <p class="text-xs text-gray-400 mt-1">Par <strong class="text-gray-300">{{ $announcement->professor->user->name }}</strong> — {{ $announcement->created_at->format('d/m/Y') }}</p>
                                    </div>
                                </div>
                                <p class="text-gray-300 text-sm mb-5 leading-relaxed">{{ $announcement->content }}</p>

                                {{-- Comments --}}
                                @if($announcement->comments->isNotEmpty())
                                    <div class="border-t border-white/5 pt-4 space-y-3">
                                        <h5 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Commentaires</h5>
                                        @foreach($announcement->comments as $comment)
                                            <div class="bg-white/5 border border-white/5 rounded-2xl p-3 text-sm">
                                                <div class="flex items-center justify-between mb-1">
                                                    <span class="font-semibold text-[#8b5cf6]">{{ $comment->user->name }}</span>
                                                    <span class="text-gray-500 text-xs">{{ $comment->created_at->diffForHumans() }}</span>
                                                </div>
                                                <p class="text-gray-300 mt-1 leading-relaxed">{{ $comment->content }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                {{-- Add comment form --}}
                                <form action="{{ route('courses.comment', $announcement) }}" method="POST" class="mt-4 flex gap-3">
                                    @csrf
                                    <input type="text" name="content" placeholder="Ajouter un commentaire..." required
                                           class="flex-1 bg-[#0d1220] border border-white/10 text-white rounded-xl px-4 py-2 text-sm focus:border-[#8b5cf6] focus:ring-1 focus:ring-[#8b5cf6]">
                                    <button type="submit" class="px-4 py-2 bg-gradient-to-r from-[#8b5cf6] to-[#d946ef] hover:opacity-90 text-white text-xs font-bold rounded-xl shadow-md transition duration-200">Commenter</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

    </div>
</x-app-layout>
