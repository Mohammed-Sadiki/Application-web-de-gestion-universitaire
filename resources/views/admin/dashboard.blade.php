<x-app-layout>
    <x-slot name="header">
        <div class="topbar-title">{{ __('app.admin_general_title') }}</div>
        <div class="topbar-subtitle">{{ __('app.admin_general_subtitle') }}</div>
    </x-slot>

    <div class="py-12 animate-fade-in">
        @if(session('success'))
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4">
                <div class="bg-green-500/10 border border-green-500/20 text-green-400 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
                    <span>✅</span> {{ session('success') }}
                </div>
            </div>
        @endif
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" x-data="{
            openValidationModal(actionUrl, userName, requestType) {
                this.action = actionUrl;
                this.userName = userName;
                this.requestType = requestType;
                $dispatch('open-modal', 'validate-document-modal');
            },
            action: '',
            userName: '',
            requestType: ''
        }">
            <!-- Stats Grid -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-5 mb-10">
                @foreach($stats as $key => $value)
                    @php
                        $label = __('app.' . $key);
                        if ($key === 'pending_requests') {
                            $textColor = 'text-neon-pink';
                        } elseif ($key === 'users') {
                            $textColor = 'text-neon-cyan';
                        } else {
                            $textColor = 'text-neon-purple';
                        }
                    @endphp
                    <div class="dark-card p-5 rounded-3xl border border-white/5 flex flex-col items-center justify-center text-center transition-transform duration-300 hover:-translate-y-1">
                        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">
                            {{ $label }}
                        </div>
                        <div class="text-3xl font-black {{ $textColor }}">
                            {{ $value }}
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Content Panel -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left area: Pending Requests Table -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="dark-card rounded-3xl overflow-hidden border border-white/5">
                        <div class="p-6 border-b border-white/5 flex justify-between items-center bg-[#17192a]/50">
                            <h3 class="text-lg font-bold text-white flex items-center">
                                <span class="w-2.5 h-2.5 bg-[#d946ef] rounded-full mr-2.5 animate-pulse"></span>
                                {{ __('app.pending_requests_title') }}
                            </h3>
                        </div>
                        <div class="p-6 bg-transparent">
                            @if($pendingRequests->isEmpty())
                                <div class="text-center py-12">
                                    <span class="text-5xl">👋</span>
                                    <p class="text-gray-400 italic mt-4 text-sm">{{ __('app.no_pending_requests') }}</p>
                                </div>
                            @else
                                <div class="overflow-x-auto">
                                    <table class="min-w-full">
                                        <thead>
                                            <tr class="text-left text-xs font-bold text-gray-400 uppercase tracking-wider border-b border-white/5">
                                                <th class="pb-3">{{ __('app.user') }}</th>
                                                <th class="pb-3">{{ __('app.type') }}</th>
                                                <th class="pb-3 text-right">{{ __('app.actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-sm divide-y divide-white/5">
                                            @foreach($pendingRequests as $req)
                                                <tr>
                                                    <td class="py-4 font-bold text-white">{{ $req->user->name }}</td>
                                                    <td class="py-4">
                                                        <span class="px-2.5 py-1 bg-[#8b5cf6]/10 border border-[#8b5cf6]/20 rounded-full text-xs font-semibold text-[#8b5cf6]">
                                                            {{ $req->type }}
                                                        </span>
                                                    </td>
                                                    <td class="py-4 text-right space-x-2">
                                                        <button type="button" 
                                                                @click="openValidationModal('{{ route('admin.requests.upload', $req) }}', '{{ addslashes($req->user->name) }}', '{{ addslashes($req->type) }}')"
                                                                class="bg-[#06b6d4]/10 hover:bg-[#06b6d4]/20 border border-[#06b6d4]/20 text-[#06b6d4] px-3 py-1 rounded-xl text-xs font-bold transition">
                                                            {{ __('app.validate') }}
                                                        </button>
                                                        <form action="{{ route('admin.requests.validate', $req) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="rejected">
                                                            <button type="submit" class="bg-[#d946ef]/10 hover:bg-[#d946ef]/20 border border-[#d946ef]/20 text-[#d946ef] px-3 py-1 rounded-xl text-xs font-bold transition">
                                                                {{ __('app.reject') }}
                                                            </button>
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

                <!-- Right area: Notifications / Activities (Placeholder) -->
                <div class="space-y-6">
                    <div class="dark-card rounded-3xl p-6 border border-white/5">
                        <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-4">{{ __('app.actions') }}</h3>
                        <div class="grid grid-cols-1 gap-3">
                            <a href="{{ route('admin.users.create') }}" class="flex items-center p-3 rounded-2xl bg-[#8b5cf6]/5 border border-[#8b5cf6]/10 hover:bg-[#8b5cf6]/10 transition group">
                                <div class="w-8 h-8 rounded-lg bg-[#8b5cf6]/20 flex items-center justify-center mr-3 text-[#8b5cf6]">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M12 4v16m8-8H4"/></svg>
                                </div>
                                <span class="text-xs font-bold text-gray-300 group-hover:text-white">{{ __('app.add_user') }}</span>
                            </a>
                            <a href="{{ route('admin.departments.create') }}" class="flex items-center p-3 rounded-2xl bg-[#06b6d4]/5 border border-[#06b6d4]/10 hover:bg-[#06b6d4]/10 transition group">
                                <div class="w-8 h-8 rounded-lg bg-[#06b6d4]/20 flex items-center justify-center mr-3 text-[#06b6d4]">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M12 4v16m8-8H4"/></svg>
                                </div>
                                <span class="text-xs font-bold text-gray-300 group-hover:text-white">{{ __('app.add_department') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
    <!-- Modal for Document Upload/Validation -->
    <x-modal name="validate-document-modal" focusable>
        <div class="p-8">
            <h2 class="text-xl font-bold text-white mb-2">
                {{ __('app.validate') }} : <span x-text="requestType" class="text-[#8b5cf6]"></span>
            </h2>
            <p class="text-gray-400 text-sm mb-6">
                {{ __('app.user') }} : <span x-text="userName" class="font-bold text-white"></span>
            </p>

            <form method="post" :action="action" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="status" value="approved">

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">
                            {{ __('app.upload') }} (PDF)
                        </label>
                        <input type="file" name="document" accept=".pdf" required
                               class="w-full bg-white/5 border border-white/10 text-white rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-[#8b5cf6] transition">
                    </div>
                </div>

                <div class="mt-8 flex justify-end gap-3">
                    <button type="button" x-on:click="$dispatch('close')" class="px-5 py-2.5 rounded-xl text-xs font-bold text-gray-400 hover:text-white transition">
                        {{ __('app.cancel') }}
                    </button>
                    <button type="submit" class="bg-gradient-to-r from-[#8b5cf6] to-[#d946ef] text-white px-6 py-2.5 rounded-xl text-xs font-bold shadow-lg shadow-purple-900/30 transition hover:opacity-90">
                        {{ __('app.confirm') }}
                    </button>
                </div>
            </form>
        </div>
    </x-modal>
        </div>
    </div>
</x-app-layout>
