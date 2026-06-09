<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <div>
                <div class="topbar-title">{{ __('app.groups_management') }}</div>
                <div class="topbar-subtitle">{{ __('app.groups_subtitle') }}</div>
            </div>
            <a href="{{ route('admin.groups.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-[#8b5cf6] to-[#d946ef] hover:opacity-90 text-white text-xs font-bold rounded-xl shadow-md transition duration-200">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                {{ __('app.add_group') }}
            </a>
        </div>
    </x-slot>

    <div class="py-6 animate-fade-in">
        @if(session('success'))
            <div class="bg-green-500/10 border border-green-500/20 text-green-400 px-4 py-3 rounded-xl mb-6 text-sm">{{ session('success') }}</div>
        @endif

        <div class="dark-card rounded-3xl overflow-hidden border border-white/5">
            <div class="p-6 bg-[#17192a]/30 border-b border-white/5">
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <span class="w-2.5 h-2.5 bg-[#06b6d4] rounded-full animate-pulse"></span>
                    {{ __('app.groups_list') }}
                </h3>
            </div>
            <div class="p-6">
                @if($groups->isEmpty())
                    <p class="text-gray-400 italic text-center py-6">{{ __('app.no_groups') }}</p>
                @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-white/5">
                        <thead>
                            <tr class="text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                                <th class="pb-3">{{ __('app.name') }}</th>
                                <th class="pb-3">{{ __('app.department') }}</th>
                                <th class="pb-3 text-right">{{ __('app.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-white/5 text-gray-300">
                            @foreach($groups as $group)
                            <tr class="hover:bg-white/[0.02] transition-colors">
                                <td class="py-4 font-semibold text-white">{{ $group->name }}</td>
                                <td class="py-4">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-[#06b6d4]/10 border border-[#06b6d4]/20 text-[#06b6d4]">{{ $group->department->name }}</span>
                                </td>
                                <td class="py-4 text-right space-x-2 whitespace-nowrap">
                                    <a href="{{ route('admin.groups.edit', $group) }}" class="inline-flex items-center px-3 py-1 bg-[#8b5cf6]/10 hover:bg-[#8b5cf6]/20 border border-[#8b5cf6]/20 text-[#8b5cf6] text-xs font-bold rounded-xl transition">{{ __('app.edit') }}</a>
                                    <form action="{{ route('admin.groups.destroy', $group) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-3 py-1 bg-[#d946ef]/10 hover:bg-[#d946ef]/20 border border-[#d946ef]/20 text-[#d946ef] text-xs font-bold rounded-xl transition" onclick="return confirm('{{ __('app.confirm_delete') }}')">{{ __('app.delete') }}</button>
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
