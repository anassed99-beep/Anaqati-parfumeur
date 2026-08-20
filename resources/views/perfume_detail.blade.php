@extends('layouts.app')

@section('title', (app()->getLocale() == 'ar' ? $perfume->name_ar : $perfume->name_fr) . ' - Anaqati')

@section('styles')
<style>
    .detail-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 4rem 1.5rem;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3.5rem;
    }

    .detail-img-wrapper {
        border: 1px solid var(--border-color);
        border-radius: 8px;
        overflow: hidden;
        background-color: #000;
        height: 480px;
    }

    .detail-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .detail-info h1 {
        font-size: 2.8rem;
        color: var(--gold-primary);
        margin-bottom: 0.5rem;
        line-height: 1.2;
        font-family: var(--font-arabic), serif;
    }

    .detail-info .arabic-name {
        font-family: 'Amiri', serif;
        font-size: 2.2rem;
        color: var(--text-primary);
        margin-bottom: 1.5rem;
    }

    .detail-price {
        font-size: 2rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 1.5rem;
        display: inline-block;
        border-bottom: 2px solid var(--gold-primary);
        padding-bottom: 0.5rem;
    }

    .detail-notes {
        font-size: 0.95rem;
        color: var(--gold-primary);
        margin-bottom: 1.5rem;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        font-weight: 600;
    }

    .detail-desc {
        color: var(--text-secondary);
        font-size: 1.05rem;
        margin-bottom: 2rem;
        text-align: justify;
        line-height: 1.7;
    }

    /* Order Section Box */
    .order-box {
        background-color: var(--card-bg);
        border: 1px solid var(--border-color);
        padding: 2.5rem;
        border-radius: 12px;
        margin-top: 2rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.5);
    }

    .order-box h3 {
        color: var(--gold-primary);
        font-size: 1.4rem;
        margin-bottom: 1.5rem;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 0.75rem;
        font-family: var(--font-arabic), serif;
    }

    .or-separator {
        text-align: center;
        color: var(--text-secondary);
        margin: 1.5rem 0;
        position: relative;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .or-separator::before, .or-separator::after {
        content: '';
        position: absolute;
        width: 38%;
        height: 1px;
        background-color: var(--border-color);
        top: 50%;
    }

    .or-separator::before { left: 0; }
    .or-separator::after { right: 0; }

    /* Smartphone Breakpoints (< 850px & < 576px) */
    @media (max-width: 850px) {
        .detail-container {
            grid-template-columns: 1fr;
            gap: 2rem;
            padding: 2rem 1rem;
        }

        .detail-img-wrapper {
            height: 350px;
        }

        .detail-info h1 {
            font-size: 2rem;
        }

        .detail-info .arabic-name {
            font-size: 1.6rem;
        }

        .detail-price {
            font-size: 1.6rem;
        }

        .detail-desc {
            font-size: 0.95rem;
        }

        .order-box {
            padding: 1.5rem 1.25rem;
        }

        .or-separator::before, .or-separator::after {
            width: 25%;
        }
    }

    @media (max-width: 480px) {
        .detail-img-wrapper {
            height: 280px;
        }
    }
</style>
@endsection

@section('content')

<div class="detail-container">
    <div>
        <div class="detail-img-wrapper">
            <img src="/{{ $perfume->image_url ?? 'images/musc_imperial.png' }}" alt="{{ $perfume->name_fr }}" class="detail-img">
        </div>
    </div>
    
    <div class="detail-info">
        <h1>{{ app()->getLocale() == 'ar' ? $perfume->name_ar : $perfume->name_fr }}</h1>
        <div class="arabic-name">{{ $perfume->name_ar }}</div>
        
        <div class="detail-notes">
            <i class="fas fa-star" style="color: var(--gold-primary); margin-inline-end: 0.4rem;"></i> {{ app()->getLocale() == 'ar' ? 'المكونات الأساسية' : 'Notes Olfactives' }} : 
            {{ app()->getLocale() == 'ar' ? $perfume->notes_ar : $perfume->notes_fr }}
        </div>

        <span class="detail-price">{{ number_format($perfume->price, 2) }} DH</span>

        <p class="detail-desc">
            {{ app()->getLocale() == 'ar' ? $perfume->description_ar : $perfume->description_fr }}
        </p>

        @if(session('success'))
            <div class="alert alert-success">
                ✓ {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Order Placement Box -->
        <div class="order-box">
            <h3>{{ app()->getLocale() == 'ar' ? 'اطلب عطرك الآن' : 'Passer une Commande' }}</h3>

            <!-- 1. Form Order (FIRST) -->
            <form action="{{ route('order.store') }}" method="POST">
                @csrf
                <input type="hidden" name="perfume_id" value="{{ $perfume->id }}">
                
                <div class="form-group">
                    <label class="form-label" for="client_name">
                        {{ app()->getLocale() == 'ar' ? 'الاسم الكامل' : 'Nom Complet' }} *
                    </label>
                    <input type="text" name="client_name" id="client_name" class="form-input" required value="{{ old('client_name') }}">
                </div>

                <div class="form-group">
                    <label class="form-label" for="client_phone">
                        {{ app()->getLocale() == 'ar' ? 'رقم الهاتف' : 'Numéro de Téléphone' }} *
                    </label>
                    <input type="tel" name="client_phone" id="client_phone" class="form-input" required placeholder="ex: 0600000000" value="{{ old('client_phone') }}">
                </div>

                <div class="form-group">
                    <label class="form-label" for="quantity">
                        {{ app()->getLocale() == 'ar' ? 'الكمية' : 'Quantité' }} *
                    </label>
                    <input type="number" name="quantity" id="quantity" class="form-input" min="1" max="10" value="1" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="client_address">
                        {{ app()->getLocale() == 'ar' ? 'عنوان التسليم' : 'Adresse de Livraison' }}
                    </label>
                    <textarea name="client_address" id="client_address" class="form-input" rows="2">{{ old('client_address') }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label" for="notes">
                        {{ app()->getLocale() == 'ar' ? 'ملاحظات إضافية' : 'Notes ou instructions' }}
                    </label>
                    <textarea name="notes" id="notes" class="form-input" rows="2">{{ old('notes') }}</textarea>
                </div>

                <button type="submit" class="btn" style="width: 100%; padding: 0.85rem;">
                    {{ app()->getLocale() == 'ar' ? 'تأكيد الطلب عبر الموقع' : 'Valider la commande en ligne' }}
                </button>
            </form>

            <!-- 2. Separator -->
            <div class="or-separator">
                {{ app()->getLocale() == 'ar' ? 'أو اطلب المساعدة عبر الواتساب' : 'OU COMMANDER VIA WHATSAPP' }}
            </div>

            <!-- 3. Direct WhatsApp Order Link (AFTER FORM) -->
            @php
                $rawPhone = $settings['whatsapp_number'] ?? '212600000000';
                $whatsAppPhone = preg_replace('/[^0-9]/', '', $rawPhone);
                if(empty($whatsAppPhone)) {
                    $whatsAppPhone = '212600000000';
                }
                $messageFr = "Bonjour Anaqati, je souhaite commander le parfum " . $perfume->name_fr . " (Prix: " . number_format($perfume->price, 2) . " DH). Pouvez-vous me contacter ?";
                $messageAr = "السلام عليكم دار أناقتي، أود طلب عطر " . $perfume->name_ar . " (الثمن: " . number_format($perfume->price, 2) . " درهم). هل يمكنكم التواصل معي ؟";
                $whatsappUrl = "https://wa.me/" . $whatsAppPhone . "?text=" . urlencode(app()->getLocale() == 'ar' ? $messageAr : $messageFr);
            @endphp

            <a href="{{ $whatsappUrl }}" target="_blank" class="btn btn-whatsapp" style="width: 100%; justify-content: center; padding: 0.95rem; font-size: 1rem;">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.455L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.825 1.451 5.436.002 9.858-4.419 9.86-9.86.002-2.638-1.017-5.114-2.871-6.973-1.856-1.859-4.327-2.881-6.966-2.882-5.439 0-9.86 4.417-9.863 9.858-.001 1.768.479 3.498 1.39 5.041L1.13 21.03l4.63-1.213c.27.054.54.1.81.147z" />
                </svg>
                {{ app()->getLocale() == 'ar' ? 'طلب فوري عبر الواتساب' : 'Commander via WhatsApp' }}
            </a>
        </div>
    </div>
</div>

@endsection
