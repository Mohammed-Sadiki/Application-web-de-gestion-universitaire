<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <div>
                <div class="topbar-title">{{ __('app.student_requests_title') }}</div>
                <div class="topbar-subtitle">{{ __('app.student_requests_sub') }}</div>
            </div>
        </div>
    </x-slot>

    <div class="py-6 animate-fade-in space-y-6">
        @if(session('success'))
            <div class="bg-green-500/10 border border-green-500/20 text-green-400 px-4 py-3 rounded-xl text-sm">
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- New Request Form --}}
        <div class="dark-card rounded-3xl overflow-hidden border border-white/5">
            <div class="p-6 bg-[#17192a]/30 border-b border-white/5">
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <span class="w-2.5 h-2.5 bg-[#8b5cf6] rounded-full animate-pulse"></span>
                    {{ __('app.new_request') }}
                </h3>
            </div>
            <div class="p-6">
                <form action="{{ route('student.requests.store') }}" method="POST">
                    @csrf
                    <div class="mb-5">
                        <label for="type" class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">{{ __('app.request_type_lbl') }}</label>
                        <select id="type" name="type" required
                            class="w-full bg-[#0d1220] border border-white/10 text-white rounded-xl px-4 py-2.5 focus:border-[#8b5cf6] focus:ring-1 focus:ring-[#8b5cf6]">
                            <option value="" class="bg-[#17192a] text-gray-400">-- {{ __('app.back') }} --</option>
                            <option value="Attestation de scolarité" class="bg-[#17192a] text-white">{{ __('app.request_enrollment') }}</option>
                            <option value="Relevé de notes" class="bg-[#17192a] text-white">{{ __('app.request_transcript') }}</option>
                            <option value="Certificat d\'inscription" class="bg-[#17192a] text-white">{{ __('app.request_enrollment') }} (Certificat)</option>
                        </select>
                        @error('type') <p class="text-[#d946ef] text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-[#8b5cf6] to-[#d946ef] hover:opacity-90 text-white text-xs font-bold rounded-xl shadow-md transition duration-200">
                        {{ __('app.submit_request') }}
                    </button>
                </form>
            </div>
        </div>

        {{-- Requests History --}}
        <div class="dark-card rounded-3xl overflow-hidden border border-white/5">
            <div class="p-6 bg-[#17192a]/30 border-b border-white/5">
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <span class="w-2.5 h-2.5 bg-[#8b5cf6] rounded-full animate-pulse"></span>
                    {{ __('app.student_requests_title') }}
                </h3>
            </div>
            <div class="p-6">
                @if($requests->isEmpty())
                    <p class="text-gray-400 italic text-center py-6">{{ __('app.no_requests') }}</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-white/5">
                            <thead>
                                <tr class="text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                                    <th class="pb-3 text-left">{{ __('app.type') }}</th>
                                    <th class="pb-3 text-left">{{ __('app.date') }}</th>
                                    <th class="pb-3 text-left">{{ __('app.status') }}</th>
                                    <th class="pb-3 text-right">Document</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-white/5 text-gray-300">
                                @foreach($requests as $req)
                                    <tr class="hover:bg-white/[0.02] transition-colors">
                                        <td class="py-4 font-semibold text-white whitespace-nowrap">{{ $req->type }}</td>
                                        <td class="py-4 whitespace-nowrap text-gray-400">{{ $req->created_at->format('d/m/Y') }}</td>
                                        <td class="py-4 whitespace-nowrap">
                                            @if($req->status === 'validated')
                                                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-[#06b6d4]/10 border border-[#06b6d4]/20 text-[#06b6d4]">✅ {{ __('app.validated') }}</span>
                                            @elseif($req->status === 'rejected')
                                                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-[#d946ef]/10 border border-[#d946ef]/20 text-[#d946ef]">❌ {{ __('app.rejected') }}</span>
                                                @if($req->reason)
                                                    <p class="text-xs text-[#d946ef] mt-1">{{ $req->reason }}</p>
                                                @endif
                                            @elseif($req->status === 'transferred')
                                                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-orange-500/10 border border-orange-500/20 text-orange-400">📨 {{ __('app.transferred') }}</span>
                                                <p class="text-[11px] text-gray-500 mt-1">Transmise au professeur concerné</p>
                                            @else
                                                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-yellow-500/10 border border-yellow-500/20 text-yellow-400">⏳ {{ __('app.pending') }}</span>
                                            @endif
                                        </td>
                                        <td class="py-4 text-right whitespace-nowrap text-sm">
                                            @if($req->status === 'validated' && $req->file_path)
                                                <a href="{{ asset('storage/' . $req->file_path) }}" target="_blank"
                                                   class="inline-flex items-center gap-1.5 px-3 py-1 bg-[#06b6d4]/10 hover:bg-[#06b6d4]/20 border border-[#06b6d4]/20 text-[#06b6d4] text-xs font-bold rounded-xl transition">
                                                    📥 {{ __('app.download') }}
                                                </a>
                                            @else
                                                <span class="text-gray-500 text-xs">—</span>
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
