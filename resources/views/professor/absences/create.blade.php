<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <div>
                <div class="topbar-title">{{ __('app.attendance_button') }} : {{ $module->name }}</div>
                <div class="topbar-subtitle">{{ __('app.grade_entry_sub') }}</div>
            </div>
            <a href="{{ route('professor.absences.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 text-white text-xs font-bold rounded-xl transition">
                &larr; {{ __('app.back') }}
            </a>
        </div>
    </x-slot>

    <div class="py-6 animate-fade-in">
        <div class="dark-card rounded-3xl overflow-hidden border border-white/5">
            <div class="p-6 bg-[#17192a]/30 border-b border-white/5">
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <span class="w-2.5 h-2.5 bg-[#d946ef] rounded-full animate-pulse"></span>
                    {{ __('app.student_list') }} — {{ $module->name }}
                </h3>
            </div>
            <div class="p-6">
                <form action="{{ route('professor.absences.store', $module) }}" method="POST">
                    @csrf

                    <div class="mb-6 max-w-xs">
                        <label for="date" class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">{{ __('app.absence_date') }}</label>
                        <input id="date" type="date" name="date" value="{{ date('Y-m-d') }}" required
                               class="w-full bg-[#0d1220] border border-white/10 text-white rounded-xl px-4 py-2.5 focus:border-[#d946ef] focus:ring-1 focus:ring-[#d946ef]">
                        @error('date')
                            <p class="mt-1 text-xs text-[#d946ef]">{{ $message }}</p>
                        @enderror
                    </div>

                    <p class="text-sm text-gray-400 mb-4 flex items-center gap-2">
                        <span class="inline-block w-2 h-2 rounded-full bg-[#d946ef]"></span>
                        {{ __('app.absent') }} :
                    </p>

                    @if($students->isEmpty())
                        <p class="text-gray-400 italic text-center py-6">{{ __('app.no_student_absences') }}</p>
                    @else
                        <div class="border border-white/5 rounded-2xl overflow-hidden divide-y divide-white/5 bg-[#17192a]/10 mb-6">
                            @foreach($students as $student)
                                <label class="flex items-center gap-4 px-5 py-4 hover:bg-white/[0.02] cursor-pointer transition-colors">
                                    <input type="checkbox" name="absent_students[]" value="{{ $student->id }}"
                                           class="w-5 h-5 text-[#d946ef] bg-white/5 border border-white/10 rounded focus:ring-offset-0 focus:ring-[#d946ef] checked:bg-[#d946ef]">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-semibold text-white">{{ $student->user->name }}</span>
                                        <span class="text-xs text-gray-400">{{ $student->student_number ?? '—' }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>

                        <div class="flex justify-end pt-4 border-t border-white/5">
                            <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-[#d946ef] to-[#8b5cf6] hover:opacity-90 text-white text-xs font-bold rounded-xl shadow-md transition duration-200">
                                💾 {{ __('app.submit_absence') }}
                            </button>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
