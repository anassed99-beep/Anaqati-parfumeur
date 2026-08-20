@extends('layouts.app')

@section('title', app()->getLocale() == 'ar' ? 'استعادة كلمة المرور - أناقتي' : 'Mot de passe oublié - Elixir d\'Orient')

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
        .auth-card {
            margin: 2rem 1rem;
            padding: 1.75rem 1.2rem;
            max-width: 100%;
        }

        .auth-header h2 {
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

<div class="auth-card">
    <div class="auth-header">
        <h2>{{ app()->getLocale() == 'ar' ? 'استعادة كلمة المرور' : 'Récupération de mot de passe' }}</h2>
        <p>
            {{ app()->getLocale() == 'ar' 
                ? 'أدخل بريدك الإلكتروني ليصلك رمز التحقق لإعادة تعيين كلمة المرور' 
                : 'Saisissez votre email administrateur pour recevoir un code de récupération' }}
        </p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger" style="background-color: rgba(231, 76, 60, 0.15); border: 1px solid #e74c3c; color: #e74c3c; padding: 0.75rem 1rem; border-radius: 6px; margin-bottom: 1.5rem; font-size: 0.9rem;">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form action="{{ route('admin.forgot.send') }}" method="POST">
        @csrf
        
        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label class="form-label" for="email">
                {{ app()->getLocale() == 'ar' ? 'البريد الإلكتروني للمسؤول' : 'Email Administrateur' }}
            </label>
            <input type="email" name="email" id="email" class="form-input" value="{{ old('email') }}" placeholder="admin@exemple.com" required autofocus style="width: 100%; padding: 0.75rem 1rem; background: rgba(0,0,0,0.3); border: 1px solid var(--border-color); color: #fff; border-radius: 6px;">
        </div>

        <button type="submit" class="btn" style="width: 100%; padding: 0.85rem; font-size: 1rem; font-weight: 600;">
            {{ app()->getLocale() == 'ar' ? 'إرسال رمز التحقق' : 'Envoyer le code de récupération' }}
        </button>

        <div class="auth-links">
            <a href="{{ route('admin.login') }}" class="auth-link">
                &larr; {{ app()->getLocale() == 'ar' ? 'العودة لتسجيل الدخول' : 'Retour à la connexion' }}
            </a>
            <a href="{{ route('admin.reset.password') }}" class="auth-link" style="color: var(--text-muted);">
                {{ app()->getLocale() == 'ar' ? 'لدي رمز بالفعل' : 'J\'ai déjà un code' }} &rarr;
            </a>
        </div>
    </form>
</div>

@endsection
