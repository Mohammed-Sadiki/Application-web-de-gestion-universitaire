<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <div>
                <div class="topbar-title">{{ __('app.announcements_title') }}</div>
                <div class="topbar-subtitle">{{ __('app.announcements_subtitle') }}</div>
            </div>
            <a href="{{ route('professor.announcements.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-[#8b5cf6] to-[#d946ef] hover:opacity-90 text-white text-xs font-bold rounded-xl shadow-md transition duration-200">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                {{ __('app.new_announcement') }}
            </a>
        </div>
    </x-slot>

    <div class="py-6 animate-fade-in">
        @if(session('success'))
            <div class="bg-green-500/10 border border-green-500/20 text-green-400 px-4 py-3 rounded-xl mb-6 text-sm">
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="dark-card rounded-3xl overflow-hidden border border-white/5">
            <div class="p-6 bg-[#17192a]/30 border-b border-white/5">
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <span class="w-2.5 h-2.5 bg-[#8b5cf6] rounded-full animate-pulse"></span>
                    {{ __('app.my_announcements') }}
                </h3>
            </div>
            <div class="p-6">
                @if($announcements->isEmpty())
                    <p class="text-gray-400 italic text-center py-6">{{ __('app.no_announcements') }}</p>
                @else
                    <div class="space-y-6">
                        @foreach($announcements as $announcement)
                            <div class="p-5 border border-white/5 rounded-2xl bg-[#17192a]/30 hover:border-white/10 transition duration-300">
                                <div class="flex justify-between items-start">
                                    <div class="flex items-center gap-3">
                                        <span class="px-2.5 py-1 bg-[#8b5cf6]/10 border border-[#8b5cf6]/20 text-[#8b5cf6] rounded-xl text-xs font-bold">
                                            {{ $announcement->module->name }}
                                        </span>
                                        <span class="text-xs text-gray-400">
                                            {{ $announcement->created_at->translatedFormat('d M Y H:i') }}
                                        </span>
                                    </div>
                                    <form method="POST" action="{{ route('professor.announcements.destroy', $announcement) }}" onsubmit="return confirm('{{ __('app.confirm_delete') }}');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-3 py-1 bg-[#d946ef]/10 hover:bg-[#d946ef]/20 border border-[#d946ef]/20 text-[#d946ef] text-xs font-bold rounded-xl transition">
                                            {{ __('app.delete') }}
                                        </button>
                                    </form>
                                </div>
                                <div class="mt-4 text-gray-300 text-sm whitespace-pre-line leading-relaxed">
                                    {{ $announcement->content }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
