<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <div>
                <div class="topbar-title">{{ __('app.reservations_title') }}</div>
                <div class="topbar-subtitle">{{ __('app.reservations_subtitle') }}</div>
            </div>
            <a href="{{ route('professor.reservations.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-[#8b5cf6] to-[#d946ef] hover:opacity-90 text-white text-xs font-bold rounded-xl shadow-md transition duration-200">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                {{ __('app.new_reservation_btn') }}
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
                    <span class="w-2.5 h-2.5 bg-[#06b6d4] rounded-full animate-pulse"></span>
                    {{ __('app.my_reservations') }}
                </h3>
            </div>
            <div class="p-6">
                @if($reservations->isEmpty())
                    <p class="text-gray-400 italic text-center py-6">{{ __('app.no_reservations') }}</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-white/5">
                            <thead>
                                <tr class="text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                                    <th class="pb-3 text-left">{{ __('app.room') }}</th>
                                    <th class="pb-3 text-left">{{ __('app.capacity_places') }}</th>
                                    <th class="pb-3 text-left">{{ __('app.date') }}</th>
                                    <th class="pb-3 text-left">{{ __('app.time') }}</th>
                                    <th class="pb-3 text-left">{{ __('app.reason') }}</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-white/5 text-gray-300">
                                @foreach($reservations as $reservation)
                                    <tr class="hover:bg-white/[0.02] transition-colors">
                                        <td class="py-4 font-semibold text-white whitespace-nowrap">{{ $reservation->room->name }}</td>
                                        <td class="py-4 text-gray-400 whitespace-nowrap">{{ $reservation->room->capacity }}</td>
                                        <td class="py-4 font-semibold text-white whitespace-nowrap">{{ \Carbon\Carbon::parse($reservation->date)->format('d/m/Y') }}</td>
                                        <td class="py-4 text-gray-400 whitespace-nowrap">
                                            {{ \Carbon\Carbon::parse($reservation->start_time)->format('H:i') }} – {{ \Carbon\Carbon::parse($reservation->end_time)->format('H:i') }}
                                        </td>
                                        <td class="py-4 text-gray-400">{{ $reservation->reason ?? '—' }}</td>
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
