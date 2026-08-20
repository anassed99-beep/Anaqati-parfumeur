@extends('layouts.app')

@section('title', app()->getLocale() == 'ar' ? 'إعادة تعيين كلمة المرور - أناقتي' : 'Réinitialisation de mot de passe - Elixir d\'Orient')

@section('styles')
<style>
    .auth-card {
        max-width: 480px;
        margin: 4rem auto;
        padding: 3rem 2.5rem;
        background-color: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.6);
    }

    .auth-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .auth-header h2 {
        color: var(--gold-primary);
        font-size: 1.8rem;
        margin-bottom: 0.5rem;
        font-family: var(--font-arabic), serif;
    }

    .auth-header p {
        color: var(--text-muted);
        font-size: 0.9rem;
        line-height: 1.5;
    }

    .info-banner {
        background: rgba(212, 175, 55, 0.1);
        border: 1px dashed var(--gold-primary);
        color: var(--gold-primary);
        padding: 0.85rem 1rem;
        border-radius: 6px;
        margin-bottom: 1.5rem;
        font-size: 0.85rem;
        line-height: 1.4;
    }

    .password-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .password-wrapper input {
        width: 100%;
        padding: 0.75rem 2.8rem 0.75rem 1rem;
        background: rgba(0,0,0,0.3);
        border: 1px solid var(--border-color);
        color: #fff;
        border-radius: 6px;
        font-size: 0.95rem;
    }

    .password-toggle-btn {
        position: absolute;
        right: 10px;
        background: none;
        border: none;
        color: var(--gold-primary);
        cursor: pointer;
        padding: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0.8;
        transition: opacity 0.2s;
    }

    .password-toggle-btn:hover {
        opacity: 1;
    }

    [dir="rtl"] .password-wrapper input {
        padding: 0.75rem 1rem 0.75rem 2.8rem;
    }

    [dir="rtl"] .password-toggle-btn {
        right: auto;
        left: 10px;
    }

    @media (max-width: 500px) {
        .auth-card {
            margin: 2rem 1rem;
            padding: 1.75rem 1.2rem;
            max-width: 100%;
        }

        .auth-header h2 {
            font-size: 1.4rem;
        }
    }
</style>
@endsection

@section('content')

<div class="auth-card">
    <div class="auth-header">
        <h2>{{ app()->getLocale() == 'ar' ? 'إعادة تعيين كلمة المرور' : 'Nouveau mot de passe' }}</h2>
        <p>
            {{ app()->getLocale() == 'ar' 
                ? 'أدخل الرمز المكون من 6 أرقام وكلمة المرور الجديدة' 
                : 'Entrez le code à 6 chiffres reçu et votre nouveau mot de passe' }}
        </p>
    </div>

    @if(session('info'))
        <div class="info-banner">
            <strong style="display: block; margin-bottom: 0.25rem;"><i class="fas fa-envelope" style="margin-inline-end: 0.3rem;"></i> Code envoyé :</strong>
            {{ session('info') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger" style="background-color: rgba(231, 76, 60, 0.15); border: 1px solid #e74c3c; color: #e74c3c; padding: 0.75rem 1rem; border-radius: 6px; margin-bottom: 1.5rem; font-size: 0.9rem;">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form action="{{ route('admin.reset.submit') }}" method="POST">
        @csrf
        
        <div class="form-group" style="margin-bottom: 1.25rem;">
            <label class="form-label" for="email">
                {{ app()->getLocale() == 'ar' ? 'البريد الإلكتروني' : 'Adresse Email' }}
            </label>
            <input type="email" name="email" id="email" class="form-input" value="{{ old('email', $email) }}" placeholder="admin@exemple.com" required style="width: 100%; padding: 0.75rem 1rem; background: rgba(0,0,0,0.3); border: 1px solid var(--border-color); color: #fff; border-radius: 6px;">
        </div>

        <div class="form-group" style="margin-bottom: 1.25rem;">
            <label class="form-label" for="code">
                {{ app()->getLocale() == 'ar' ? 'رمز التحقق (6 أرقام)' : 'Code de récupération (6 chiffres)' }}
            </label>
            <input type="text" name="code" id="code" maxlength="6" class="form-input" placeholder="123456" required style="width: 100%; padding: 0.75rem 1rem; background: rgba(0,0,0,0.3); border: 1px solid var(--gold-primary); color: var(--gold-primary); font-size: 1.2rem; letter-spacing: 4px; text-align: center; border-radius: 6px;">
        </div>

        <div class="form-group" style="margin-bottom: 1.25rem;">
            <label class="form-label" for="password">
                {{ app()->getLocale() == 'ar' ? 'كلمة المرور الجديدة' : 'Nouveau mot de passe' }}
            </label>
            <div class="password-wrapper">
                <input type="password" name="password" id="password" class="form-input" required minlength="6" placeholder="••••••••">
                <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility('password', this)">
                    <svg class="eye-icon-open" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                    <svg class="eye-icon-closed" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:none;">
                        <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                        <line x1="1" y1="1" x2="23" y2="23"></line>
                    </svg>
                </button>
            </div>
        </div>

        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label class="form-label" for="password_confirmation">
                {{ app()->getLocale() == 'ar' ? 'تأكيد كلمة المرور' : 'Confirmer le mot de passe' }}
            </label>
            <div class="password-wrapper">
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-input" required minlength="6" placeholder="••••••••">
                <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility('password_confirmation', this)">
                    <svg class="eye-icon-open" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                    <svg class="eye-icon-closed" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:none;">
                        <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                        <line x1="1" y1="1" x2="23" y2="23"></line>
                    </svg>
                </button>
            </div>
        </div>

        <button type="submit" class="btn" style="width: 100%; padding: 0.85rem; font-size: 1rem; font-weight: 600;">
            {{ app()->getLocale() == 'ar' ? 'تحديث كلمة المرور' : 'Réinitialiser le mot de passe' }}
        </button>
    </form>
</div>

<script>
    function togglePasswordVisibility(inputId, btn) {
        var input = document.getElementById(inputId);
        var openIcon = btn.querySelector('.eye-icon-open');
        var closedIcon = btn.querySelector('.eye-icon-closed');
        
        if (input.type === "password") {
            input.type = "text";
            openIcon.style.display = "none";
            closedIcon.style.display = "block";
        } else {
            input.type = "password";
            openIcon.style.display = "block";
            closedIcon.style.display = "none";
        }
    }
</script>

@endsection
