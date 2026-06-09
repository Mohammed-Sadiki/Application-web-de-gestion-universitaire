<x-app-layout>
    <x-slot name="header">
        <div class="topbar-title">{{ __('app.profile_settings') }}</div>
        <div class="topbar-subtitle">{{ __('app.profile_subtitle') }}</div>
    </x-slot>

    <div class="py-12 animate-fade-in">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <div class="p-8 sm:p-10 dark-card rounded-3xl border border-white/5 shadow-2xl">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-8 sm:p-10 dark-card rounded-3xl border border-white/5 shadow-2xl">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-8 sm:p-10 dark-card rounded-3xl border border-white/5 shadow-2xl">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
