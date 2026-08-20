@extends('layouts.app')

@section('title', app()->getLocale() == 'ar' ? 'تسجيل الدخول - أناقتي' : 'Admin Login - Elixir d\'Orient')

@section('styles')
<style>
    .login-container {
        max-width: 450px;
        margin: 4rem auto;
        padding: 3rem 2.5rem;
        background-color: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.6);
    }

    .login-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .login-header h2 {
        color: var(--gold-primary);
        font-size: 1.8rem;
        margin-bottom: 0.5rem;
        font-family: var(--font-arabic), serif;
    }

    .login-header p {
        color: var(--text-muted);
        font-size: 0.9rem;
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

    .auth-links {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 1.5rem;
        font-size: 0.88rem;
        gap: 1rem;
    }

    .auth-link {
        color: var(--gold-primary);
        text-decoration: none;
        transition: color 0.3s;
    }

    .auth-link:hover {
        color: var(--gold-hover);
        text-decoration: underline;
    }

    @media (max-width: 500px) {
        .login-container {
            margin: 2rem 1rem;
            padding: 1.75rem 1.2rem;
            max-width: 100%;
        }

        .login-header h2 {
            font-size: 1.4rem;
        }

        .auth-links {
            flex-direction: column;
            gap: 0.75rem;
            text-align: center;
        }
    }
</style>
@endsection

@section('content')

<div class="login-container">
    <div class="login-header">
        <h2>{{ app()->getLocale() == 'ar' ? 'تسجيل دخول المسؤول' : 'Connexion Administrateur' }}</h2>
        <p>{{ app()->getLocale() == 'ar' ? 'يرجى إدخال البريد الإلكتروني وكلمة المرور' : 'Veuillez saisir votre email et mot de passe' }}</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="background-color: rgba(46, 204, 113, 0.15); border: 1px solid #2ecc71; color: #2ecc71; padding: 0.75rem 1rem; border-radius: 6px; margin-bottom: 1.5rem; font-size: 0.9rem;">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger" style="background-color: rgba(231, 76, 60, 0.15); border: 1px solid #e74c3c; color: #e74c3c; padding: 0.75rem 1rem; border-radius: 6px; margin-bottom: 1.5rem; font-size: 0.9rem;">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form action="{{ route('admin.login.submit') }}" method="POST">
        @csrf
        
        <div class="form-group" style="margin-bottom: 1.25rem;">
            <label class="form-label" for="email">
                {{ app()->getLocale() == 'ar' ? 'البريد الإلكتروني' : 'Adresse Email' }}
            </label>
            <input type="email" name="email" id="email" class="form-input" value="{{ old('email') }}" placeholder="admin@exemple.com" required autofocus style="width: 100%; padding: 0.75rem 1rem; background: rgba(0,0,0,0.3); border: 1px solid var(--border-color); color: #fff; border-radius: 6px;">
        </div>

        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label class="form-label" for="password">
                {{ app()->getLocale() == 'ar' ? 'كلمة المرور' : 'Mot de passe' }}
            </label>
            <div class="password-wrapper">
                <input type="password" name="password" id="password" class="form-input" placeholder="••••••••" required>
                <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility('password', this)" title="Afficher/Masquer le mot de passe">
                    <!-- SVG Eye Open -->
                    <svg class="eye-icon-open" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                    <!-- SVG Eye Closed -->
                    <svg class="eye-icon-closed" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;">
                        <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                        <line x1="1" y1="1" x2="23" y2="23"></line>
                    </svg>
                </button>
            </div>
        </div>

        <button type="submit" class="btn" style="width: 100%; padding: 0.85rem; font-size: 1rem; font-weight: 600;">
            {{ app()->getLocale() == 'ar' ? 'تسجيل الدخول' : 'Se connecter' }}
        </button>

        <div class="auth-links">
            <a href="{{ route('admin.forgot.password') }}" class="auth-link">
                {{ app()->getLocale() == 'ar' ? 'نسيت كلمة المرور؟' : 'Mot de passe oublié ?' }}
            </a>
            <a href="{{ route('home') }}" class="auth-link" style="color: var(--text-muted);">
                &larr; {{ app()->getLocale() == 'ar' ? 'العودة للموقع' : 'Retour au site' }}
            </a>
        </div>
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
