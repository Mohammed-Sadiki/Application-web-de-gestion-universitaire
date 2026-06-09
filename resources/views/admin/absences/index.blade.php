<x-app-layout>
    <x-slot name="header">
        <div class="topbar-title">{{ __('app.absences_management') }}</div>
        <div class="topbar-subtitle">{{ __('app.absences_subtitle') }}</div>
    </x-slot>

    <div class="py-6 animate-fade-in">
        @if(session('success'))
            <div class="bg-green-500/10 border border-green-500/20 text-green-400 px-4 py-3 rounded-xl mb-6 text-sm">{{ session('success') }}</div>
        @endif

        <div class="dark-card rounded-3xl overflow-hidden border border-white/5">
            <div class="p-6 bg-[#17192a]/30 border-b border-white/5">
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <span class="w-2.5 h-2.5 bg-[#d946ef] rounded-full animate-pulse"></span>
                    {{ __('app.absences_management') }}
                </h3>
            </div>
            <div class="p-6">
                @if($absences->isEmpty())
                    <div class="text-center py-10">
                        <span class="text-4xl">✅</span>
                        <p class="text-gray-400 italic mt-3 text-sm">{{ __('app.no_absences') }}</p>
                    </div>
                @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-white/5">
                        <thead>
                            <tr class="text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                                <th class="pb-3">{{ __('app.student') }}</th>
                                <th class="pb-3">{{ __('app.module') }}</th>
                                <th class="pb-3">{{ __('app.date') }}</th>
                                <th class="pb-3">{{ __('app.justified') }}</th>
                                <th class="pb-3">{{ __('app.status') }}</th>
                                <th class="pb-3 text-right">{{ __('app.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-white/5 text-gray-300">
                            @foreach($absences as $absence)
                            <tr class="hover:bg-white/[0.02] transition-colors">
                                <td class="py-4 font-semibold text-white">{{ $absence->student->user->name }}</td>
                                <td class="py-4">{{ $absence->module->name }}</td>
                                <td class="py-4 text-gray-400">{{ \Carbon\Carbon::parse($absence->date)->format('d/m/Y') }}</td>
                                <td class="py-4">
                                    @if($absence->justification_path)
                                        <a href="{{ Storage::url($absence->justification_path) }}" target="_blank"
                                            class="inline-flex items-center gap-1 px-2.5 py-1 bg-[#3b82f6]/10 border border-[#3b82f6]/20 text-[#3b82f6] text-xs font-bold rounded-lg hover:bg-[#3b82f6]/20 transition">
                                            📄 {{ __('app.view') }}
                                        </a>
                                    @else
                                        <span class="text-gray-600 text-xs">—</span>
                                    @endif
                                </td>
                                <td class="py-4">
                                    @if($absence->status === 'validated')
                                        <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-green-500/10 border border-green-500/20 text-green-400">{{ __('app.validated') }}</span>
                                    @elseif($absence->status === 'rejected')
                                        <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-[#d946ef]/10 border border-[#d946ef]/20 text-[#d946ef]">{{ __('app.rejected') }}</span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-yellow-500/10 border border-yellow-500/20 text-yellow-400">{{ __('app.pending') }}</span>
                                    @endif
                                </td>
                                <td class="py-4 text-right space-x-2">
                                    @if($absence->status === 'pending')
                                        <form method="POST" action="{{ route('admin.absences.update', $absence) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="validated">
                                            <button type="submit" class="inline-flex items-center px-3 py-1 bg-green-500/10 hover:bg-green-500/20 border border-green-500/20 text-green-400 text-xs font-bold rounded-xl transition">{{ __('app.validate') }}</button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.absences.update', $absence) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="inline-flex items-center px-3 py-1 bg-[#d946ef]/10 hover:bg-[#d946ef]/20 border border-[#d946ef]/20 text-[#d946ef] text-xs font-bold rounded-xl transition">{{ __('app.reject') }}</button>
                                        </form>
                                    @else
                                        <span class="text-gray-600 text-xs">—</span>
                                    @endif
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
