<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <div>
                <div class="topbar-title">{{ __('app.lesson_logs_admin_title') }}</div>
                <div class="topbar-subtitle">{{ __('app.lesson_logs_admin_sub') }}</div>
            </div>
        </div>
    </x-slot>

    <div class="py-6 animate-fade-in">
        <div class="dark-card rounded-3xl overflow-hidden border border-white/5">
            <div class="p-6 bg-[#17192a]/30 border-b border-white/5">
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <span class="w-2.5 h-2.5 bg-[#8b5cf6] rounded-full animate-pulse"></span>
                    {{ __('app.lesson_log_register') }}
                </h3>
            </div>
            <div class="p-6">
                @if($logs->isEmpty())
                    <div class="text-center py-10">
                        <span class="text-4xl">📋</span>
                        <p class="text-gray-400 italic mt-3 text-sm">{{ __('app.no_lesson_logs_admin') }}</p>
                    </div>
                @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-white/5">
                        <thead>
                            <tr class="text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                                <th class="pb-3">{{ __('app.date') }}</th>
                                <th class="pb-3">{{ __('app.professor_section') }}</th>
                                <th class="pb-3">{{ __('app.module') }}</th>
                                <th class="pb-3">{{ __('app.type') }}</th>
                                <th class="pb-3">{{ __('app.time') }}</th>
                                <th class="pb-3">{{ __('app.objective') }}</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-white/5 text-gray-300">
                            @foreach($logs as $log)
                            <tr class="hover:bg-white/[0.02] transition-colors">
                                <td class="py-4 font-semibold text-white">{{ \Carbon\Carbon::parse($log->date)->format('d/m/Y') }}</td>
                                <td class="py-4">{{ $log->professor->user->name }}</td>
                                <td class="py-4 font-semibold text-[#06b6d4]">{{ $log->module->name }}</td>
                                <td class="py-4">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-bold
                                        {{ $log->type === 'Cours' ? 'bg-[#3b82f6]/10 border border-[#3b82f6]/20 text-[#3b82f6]' : ($log->type === 'TD' ? 'bg-green-500/10 border border-green-500/20 text-green-400' : 'bg-[#8b5cf6]/10 border border-[#8b5cf6]/20 text-[#8b5cf6]') }}">
                                        {{ $log->type }}
                                    </span>
                                </td>
                                <td class="py-4 text-gray-400">
                                    {{ \Carbon\Carbon::parse($log->start_time)->format('H:i') }} – {{ \Carbon\Carbon::parse($log->end_time)->format('H:i') }}
                                </td>
                                <td class="py-4 text-gray-400 max-w-xs truncate">{{ $log->objective }}</td>
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
