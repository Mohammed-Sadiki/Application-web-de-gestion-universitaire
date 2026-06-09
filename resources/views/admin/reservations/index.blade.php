<x-app-layout>
    <x-slot name="header">
        <div class="topbar-title">{{ __('app.reservations_management') }}</div>
        <div class="topbar-subtitle">{{ __('app.reservations_mgmt_sub') }}</div>
    </x-slot>

    <div class="py-6 animate-fade-in">
        @if(session('success'))
            <div class="bg-green-500/10 border border-green-500/20 text-green-400 px-4 py-3 rounded-xl mb-6 text-sm">{{ session('success') }}</div>
        @endif

        <div class="dark-card rounded-3xl overflow-hidden border border-white/5">
            <div class="p-6 bg-[#17192a]/30 border-b border-white/5">
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <span class="w-2.5 h-2.5 bg-[#3b82f6] rounded-full animate-pulse"></span>
                    {{ __('app.all_reservations') }}
                </h3>
            </div>
            <div class="p-6">
                @if($reservations->isEmpty())
                    <div class="text-center py-10">
                        <span class="text-4xl">🏫</span>
                        <p class="text-gray-400 italic mt-3 text-sm">{{ __('app.no_reservations_admin') }}</p>
                    </div>
                @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-white/5">
                        <thead>
                            <tr class="text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                                <th class="pb-3">{{ __('app.room') }}</th>
                                <th class="pb-3">{{ __('app.professor_section') }}</th>
                                <th class="pb-3">{{ __('app.date') }}</th>
                                <th class="pb-3">{{ __('app.time') }}</th>
                                <th class="pb-3">{{ __('app.reason') }}</th>
                                <th class="pb-3 text-right">{{ __('app.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-white/5 text-gray-300">
                            @foreach($reservations as $reservation)
                            <tr class="hover:bg-white/[0.02] transition-colors">
                                <td class="py-4 font-semibold text-[#8b5cf6]">{{ $reservation->room->name }}</td>
                                <td class="py-4 font-semibold text-white">{{ $reservation->professor->user->name }}</td>
                                <td class="py-4">{{ \Carbon\Carbon::parse($reservation->date)->format('d/m/Y') }}</td>
                                <td class="py-4">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-[#06b6d4]/10 border border-[#06b6d4]/20 text-[#06b6d4] whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($reservation->start_time)->format('H:i') }} – {{ \Carbon\Carbon::parse($reservation->end_time)->format('H:i') }}
                                    </span>
                                </td>
                                <td class="py-4 text-gray-400 max-w-xs truncate">{{ $reservation->reason ?? '—' }}</td>
                                <td class="py-4 text-right space-x-2 whitespace-nowrap">
                                    <a href="{{ route('admin.reservations.edit', $reservation) }}" class="inline-flex items-center px-3 py-1 bg-[#8b5cf6]/10 hover:bg-[#8b5cf6]/20 border border-[#8b5cf6]/20 text-[#8b5cf6] text-xs font-bold rounded-xl transition">{{ __('app.edit') }}</a>
                                    <form method="POST" action="{{ route('admin.reservations.destroy', $reservation) }}" class="inline" onsubmit="return confirm('{{ __('app.confirm_delete') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-3 py-1 bg-[#d946ef]/10 hover:bg-[#d946ef]/20 border border-[#d946ef]/20 text-[#d946ef] text-xs font-bold rounded-xl transition">{{ __('app.cancel') }}</button>
                                    </form>
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
