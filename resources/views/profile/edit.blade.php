<x-app-layout>
    <x-slot name="header">
        <div class="topbar-title">{{ __('app.profile_settings') ?? 'الملف الشخصي والإعدادات' }}</div>
        <div class="topbar-subtitle">{{ __('app.profile_subtitle') ?? 'إدارة معلومات حسابك وكلمة المرور' }}</div>
    </x-slot>

    <style>
        .profile-container {
            display: flex;
            flex-direction: column;
            gap: 24px;
            max-width: 900px;
            margin: 0 auto;
            padding: 24px 0;
        }

        .profile-card {
            background: #ffffff !important;
            border-radius: 24px !important;
            border: 1px solid #e5e7eb !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03) !important;
            padding: 32px !important;
            position: relative;
        }

        /* Top titles in layout */
        .light-theme .topbar-title {
            color: #1e1b4b !important;
        }
        .light-theme .topbar-subtitle {
            color: #6366f1 !important;
        }

        /* Dot Indicators */
        .dot-indicator {
            position: absolute;
            top: 36px;
            right: 28px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }
        [dir="ltr"] .dot-indicator {
            right: auto;
            left: 28px;
        }

        .profile-card h2 {
            font-size: 1.35rem !important;
            font-weight: 800 !important;
            color: #1e1b4b !important;
            margin-bottom: 24px !important;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Style for form elements specifically inside profile cards */
        .profile-card label {
            display: block !important;
            font-size: 0.8rem !important;
            font-weight: 700 !important;
            color: #93c5fd !important; /* light blue labels like image */
            margin-bottom: 8px !important;
            text-transform: none !important;
            letter-spacing: normal !important;
        }

        .light-theme .profile-card label {
            color: #94a3b8 !important;
        }

        .profile-card input[type="text"],
        .profile-card input[type="email"],
        .profile-card input[type="password"] {
            background: #ffffff !important;
            border: 1.5px solid #e2e8f0 !important;
            color: #1e1b4b !important;
            border-radius: 16px !important;
            padding: 14px 20px !important;
            font-size: 0.95rem !important;
            font-weight: 500 !important;
            width: 100% !important;
            transition: all 0.3s ease !important;
            box-shadow: none !important;
        }

        .profile-card input[type="text"]:focus,
        .profile-card input[type="email"]:focus,
        .profile-card input[type="password"]:focus {
            border-color: #8b5cf6 !important;
            box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.1) !important;
        }

        /* Buttons matching the purple gradient */
        .profile-card button[type="submit"] {
            background: linear-gradient(135deg, #a855f7, #ec4899) !important;
            color: #ffffff !important;
            font-weight: 700 !important;
            padding: 12px 36px !important;
            border-radius: 14px !important;
            border: none !important;
            box-shadow: 0 8px 20px rgba(168, 85, 247, 0.25) !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
            font-size: 0.9rem !important;
        }

        .profile-card button[type="submit"]:hover {
            box-shadow: 0 12px 28px rgba(168, 85, 247, 0.4) !important;
            transform: translateY(-1px) !important;
        }

        /* Overrides to adapt specifically on Light Theme */
        .light-theme .profile-card {
            background: #ffffff !important;
            border-color: #f1f5f9 !important;
        }
        
        .light-theme .page-body-container {
            background: #f8fafc !important;
        }

        /* Alignment styles matching original direction */
        [dir="rtl"] .profile-card input {
            text-align: right !important;
        }
        [dir="ltr"] .profile-card input {
            text-align: left !important;
        }
        
        [dir="rtl"] .profile-card label {
            text-align: right !important;
        }
        [dir="ltr"] .profile-card label {
            text-align: left !important;
        }
    </style>

    <div class="py-6 animate-fade-in">
        <div class="profile-container">
            
            <!-- Information Personne -->
            <div class="profile-card">
                <span class="dot-indicator bg-[#8b5cf6]"></span>
                @include('profile.partials.update-profile-information-form')
            </div>

            <!-- Changement mot de passe -->
            <div class="profile-card">
                <span class="dot-indicator bg-[#06b6d4]"></span>
                @include('profile.partials.update-password-form')
            </div>

            <!-- Suppression de compte (Optionnelle/Sécurisée) -->
            <div class="profile-card">
                <span class="dot-indicator bg-[#ef4444]"></span>
                @include('profile.partials.delete-user-form')
            </div>
            
        </div>
    </div>
</x-app-layout>
