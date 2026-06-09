<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <div>
                <div class="topbar-title">{{ __('app.grades') ?? 'Gestion des Notes' }}</div>
                <div class="topbar-subtitle">{{ __('Saisie et modification des notes pour vos modules attribués') }}</div>
            </div>
        </div>
    </x-slot>

    <div class="py-6 animate-fade-in">
        <div class="profile-card">
            <span class="dot-indicator bg-[#8b5cf6]"></span>
            <div style="margin-bottom: 20px;">
                <h2 style="color: #1e1b4b !important; font-weight: 800 !important; font-size: 1.35rem !important; display: flex; align-items: center; gap: 8px; margin: 0;">
                    {{ __('app.my_modules') }}
                </h2>
            </div>
            <div>
                @if($modules->isEmpty())
                    <p class="text-gray-400 italic text-center py-6">{{ __('app.no_assigned_modules') }}</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($modules as $module)
                            <div class="profile-card" style="padding: 24px !important; border-radius: 18px !important; display: flex; flex-direction: column; justify-content: space-between; min-height: 180px; box-shadow: 0 4px 15px rgba(0,0,0,0.02) !important;">
                                <div>
                                    <h4 class="font-bold text-[#1e1b4b] text-lg mb-1">{{ $module->name }}</h4>
                                    <p class="text-sm text-gray-400 mb-4">{{ $module->department->name }}</p>
                                </div>
                                <div style="display: flex; justify-content: flex-start;">
                                    <a href="{{ route('professor.grades.edit', $module) }}" class="inline-flex justify-center items-center px-4 py-2.5 bg-gradient-to-r from-[#8b5cf6] to-[#d946ef] hover:opacity-90 text-white text-sm font-bold rounded-xl shadow-md transition duration-200" style="text-decoration: none !important; color: white !important; font-weight: 700 !important; background: linear-gradient(135deg, #a855f7, #ec4899) !important; border-radius: 12px !important; box-shadow: 0 4px 12px rgba(168,85,247,0.2) !important;">
                                        {{ __('app.enter_grades') }}
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>