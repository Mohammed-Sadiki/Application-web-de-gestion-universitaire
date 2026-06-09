<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <div>
                <div class="topbar-title">{{ __('app.professor_documents') }}</div>
                <div class="topbar-subtitle">{{ __('app.documents_subtitle') }}</div>
            </div>
        </div>
    </x-slot>

    <div class="py-6 animate-fade-in space-y-6">
        @if(session('success'))
            <div class="bg-green-500/10 border border-green-500/20 text-green-400 px-4 py-3 rounded-xl text-sm">
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-xl text-sm">
                @foreach($errors->all() as $err)
                    <div>{{ $err }}</div>
                @endforeach
            </div>
        @endif

        <div class="dark-card rounded-3xl overflow-hidden border border-white/5" x-data="{
            openUploadModal(actionUrl, studentName, docType) {
                this.action = actionUrl;
                this.studentName = studentName;
                this.docType = docType;
                $dispatch('open-modal', 'upload-document-modal');
            },
            action: '',
            studentName: '',
            docType: ''
        }">
            <div class="p-6 bg-[#17192a]/30 border-b border-white/5">
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <span class="w-2.5 h-2.5 bg-[#8b5cf6] rounded-full animate-pulse"></span>
                    {{ __('app.pending_requests') }}
                </h3>
            </div>
            <div class="p-6">
                @if($requests->isEmpty())
                    <div class="text-center py-12">
                        <span class="text-5xl">🎉</span>
                        <p class="text-gray-400 italic mt-4 text-sm">{{ __('app.no_pending_requests') }}</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-white/5">
                            <thead>
                                <tr class="text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                                    <th class="pb-3 text-left">{{ __('app.student') }}</th>
                                    <th class="pb-3 text-left">{{ __('app.request_type_lbl') }}</th>
                                    <th class="pb-3 text-left">{{ __('app.date') }}</th>
                                    <th class="pb-3 text-right">{{ __('app.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-white/5 text-gray-300">
                                @foreach($requests as $req)
                                    <tr class="hover:bg-white/[0.02] transition-colors">
                                        <td class="py-4 font-semibold text-white whitespace-nowrap">
                                            {{ $req->user->name }}
                                        </td>
                                        <td class="py-4 whitespace-nowrap">
                                            <span class="px-2.5 py-1 bg-[#8b5cf6]/10 border border-[#8b5cf6]/20 rounded-full text-xs font-semibold text-[#8b5cf6]">
                                                {{ $req->type }}
                                            </span>
                                        </td>
                                        <td class="py-4 whitespace-nowrap text-gray-400">{{ $req->updated_at->format('d/m/Y H:i') }}</td>
                                        <td class="py-4 text-right whitespace-nowrap text-sm">
                                            <button type="button"
                                                    @click="openUploadModal('{{ route('professor.documents.upload', $req) }}', '{{ addslashes($req->user->name) }}', '{{ addslashes($req->type) }}')"
                                                    class="inline-flex items-center gap-1.5 px-3 py-1 bg-[#06b6d4]/10 hover:bg-[#06b6d4]/20 border border-[#06b6d4]/20 text-[#06b6d4] text-xs font-bold rounded-xl transition cursor-pointer">
                                                📤 {{ __('app.upload') }}
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <!-- Upload Document Modal -->
            <x-modal name="upload-document-modal" focusable>
                <form :action="action" method="POST" enctype="multipart/form-data" class="p-6">
                    @csrf
                    @method('PATCH')
                    
                    <h2 class="text-lg font-bold text-white mb-2 flex items-center">
                        <span class="w-2.5 h-2.5 bg-[#06b6d4] rounded-full mr-2 animate-pulse"></span>
                        {{ __('app.upload_material') }}
                    </h2>
                    
                    <p class="text-sm text-gray-400 mb-6">
                        Veuillez téléverser le document <span class="text-[#8b5cf6] font-semibold" x-text="docType"></span> pour l'étudiant <span class="text-white font-semibold" x-text="studentName"></span>.
                    </p>

                    <!-- Document Upload Input -->
                    <div class="mb-6">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2" for="document">
                            {{ __('app.material_file_lbl') }}
                        </label>
                        <div class="relative group">
                            <input type="file" name="document" id="document" accept=".pdf,.png,.jpg,.jpeg,.doc,.docx" required
                                   class="w-full text-sm text-gray-400 bg-white/5 border border-white/10 rounded-xl px-4 py-3 focus:outline-none focus:border-[#06b6d4] file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#06b6d4]/10 file:text-[#06b6d4] hover:file:bg-[#06b6d4]/20 transition-all cursor-pointer">
                        </div>
                        <p class="text-[11px] text-gray-500 mt-2">
                            Formats autorisés : PDF, PNG, JPG, JPEG, DOC, DOCX. Taille max : 10 Mo.
                        </p>
                    </div>

                    <div class="flex justify-end space-x-3 border-t border-white/5 pt-4">
                        <button type="button" @click="$dispatch('close-modal', 'upload-document-modal')"
                                class="bg-white/5 hover:bg-white/10 border border-white/10 text-white px-4 py-2 rounded-xl text-xs font-bold transition">
                            {{ __('app.cancel') }}
                        </button>
                        <button type="submit"
                                class="bg-[#06b6d4]/90 hover:bg-[#06b6d4] text-black px-4 py-2 rounded-xl text-xs font-bold transition">
                            {{ __('app.validate') }}
                        </button>
                    </div>
                </form>
            </x-modal>
        </div>
    </div>
</x-app-layout>
