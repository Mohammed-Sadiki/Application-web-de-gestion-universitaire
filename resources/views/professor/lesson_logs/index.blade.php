<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <div>
                <div class="topbar-title">{{ __('app.lesson_log_title') }}</div>
                <div class="topbar-subtitle">{{ __('app.lesson_log_subtitle') }}</div>
            </div>
            <a href="{{ route('professor.lesson_logs.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-[#8b5cf6] to-[#d946ef] hover:opacity-90 text-white text-xs font-bold rounded-xl shadow-md transition duration-200">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                {{ __('app.new_lesson_log') }}
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
                    {{ __('app.my_lesson_logs') }}
                </h3>
            </div>
            <div class="p-6">
                @if($logs->isEmpty())
                    <p class="text-gray-400 italic text-center py-6">{{ __('app.no_lesson_logs') }}</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-white/5">
                            <thead>
                                <tr class="text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                                    <th class="pb-3 text-left">{{ __('app.date') }}</th>
                                    <th class="pb-3 text-left">{{ __('app.module') }}</th>
                                    <th class="pb-3 text-left">{{ __('app.type') }}</th>
                                    <th class="pb-3 text-left">{{ __('app.time') }}</th>
                                    <th class="pb-3 text-left">{{ __('app.log_content_lbl') }}</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-white/5 text-gray-300">
                                @foreach($logs as $log)
                                    <tr class="hover:bg-white/[0.02] transition-colors">
                                        <td class="py-4 font-semibold text-white whitespace-nowrap">
                                            {{ \Carbon\Carbon::parse($log->date)->format('d/m/Y') }}
                                        </td>
                                        <td class="py-4 font-semibold text-white whitespace-nowrap">
                                            {{ $log->module->name }}
                                        </td>
                                        <td class="py-4 whitespace-nowrap">
                                            <span class="px-2.5 py-1 rounded-full text-xs font-bold
                                                {{ $log->type === 'Cours' ? 'bg-[#3b82f6]/10 border border-[#3b82f6]/20 text-[#3b82f6]' : ($log->type === 'TD' ? 'bg-[#06b6d4]/10 border border-[#06b6d4]/20 text-[#06b6d4]' : 'bg-[#d946ef]/10 border border-[#d946ef]/20 text-[#d946ef]') }}">
                                                {{ $log->type }}
                                            </span>
                                        </td>
                                        <td class="py-4 text-gray-400 whitespace-nowrap">
                                            {{ \Carbon\Carbon::parse($log->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($log->end_time)->format('H:i') }}
                                        </td>
                                        <td class="py-4 text-gray-400">
                                            {{ $log->objective }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
