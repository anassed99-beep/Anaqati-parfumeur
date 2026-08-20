@extends('layouts.app')

@section('title', app()->getLocale() == 'ar' ? 'كتالوج العطور - أناقتي' : 'Catalogue des Parfums - Elixir d\'Orient')

@section('styles')
<style>
    .catalog-header {
        padding: 4rem 2rem 2rem;
        text-align: center;
        background-color: #080808;
        border-bottom: 1px solid var(--border-color);
    }

    .catalog-header h1 {
        font-size: 2.5rem;
        color: var(--gold-primary);
        margin-bottom: 1rem;
        font-family: var(--font-arabic), serif;
    }

    .catalog-header p {
        color: var(--text-secondary);
        max-width: 600px;
        margin: 0 auto;
        font-size: 1.05rem;
    }

    .catalog-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 3.5rem 1.5rem;
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1.75rem;
    }

    .product-card {
        background-color: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 10px;
        overflow: hidden;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    .product-card:hover {
        transform: translateY(-5px);
        border-color: var(--gold-primary);
        box-shadow: 0 10px 25px rgba(212, 175, 55, 0.15);
    }

    .product-img-wrapper {
        position: relative;
        height: 220px;
        overflow: hidden;
        background-color: #000;
    }

    .product-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .product-card:hover .product-img {
        transform: scale(1.06);
    }

    .product-info {
        padding: 1.25rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .product-title {
        font-size: 1.15rem;
        color: var(--text-primary);
        margin-bottom: 0.35rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .product-title span.arabic {
        font-family: 'Amiri', serif;
        font-size: 1.1rem;
        color: var(--gold-primary);
    }

    .product-notes {
        font-size: 0.8rem;
        color: var(--gold-primary);
        margin-bottom: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .product-desc {
        color: var(--text-secondary);
        font-size: 0.88rem;
        margin-bottom: 1.25rem;
        line-height: 1.4;
        flex-grow: 1;
    }

    .product-bottom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
        padding-top: 0.75rem;
        border-top: 1px solid rgba(255, 255, 255, 0.05);
    }

    .product-price {
        font-size: 1.15rem;
        font-weight: 700;
        color: #fff;
    }

    /* Smartphone Breakpoints (< 768px & < 480px) */
    @media (max-width: 850px) {
        .catalog-header {
            padding: 2.5rem 1rem 1.5rem;
        }

        .catalog-header h1 {
            font-size: 1.8rem;
        }

        .catalog-header p {
            font-size: 0.95rem;
        }

        .catalog-container {
            padding: 2rem 1rem;
        }

        .products-grid {
            grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
            gap: 1.25rem;
        }
    }

    @media (max-width: 480px) {
        .products-grid {
            grid-template-columns: 1fr;
        }

        .product-img-wrapper {
            height: 200px;
        }
    }
</style>
@endsection

@section('content')

<div class="catalog-header">
    <h1>
        {{ app()->getLocale() == 'ar' ? 'مجموعتنا الكاملة' : 'Notre Collection Exclusive' }}
    </h1>
    <p>
        {{ app()->getLocale() == 'ar' 
            ? 'تصفح تشكيلة عطورنا الفريدة المصنوعة يدوياً وبأعلى تركيز لتجربة تدوم طويلاً.' 
            : 'Parcourez notre gamme complète de fragrances uniques, élaborées artisanalement avec les concentrations les plus nobles.' }}
    </p>
</div>

<div class="catalog-container">
    <div class="products-grid">
        @foreach($perfumes as $perfume)
            <div class="product-card">
                <div class="product-img-wrapper">
                    <img src="/{{ $perfume->image_url ?? 'images/musc_imperial.png' }}" alt="{{ $perfume->name_fr }}" class="product-img">
                </div>
                <div class="product-info">
                    <div class="product-title">
                        <span>{{ app()->getLocale() == 'ar' ? $perfume->name_ar : $perfume->name_fr }}</span>
                        <span class="arabic">{{ $perfume->name_ar }}</span>
                    </div>
                    <div class="product-notes">
                        <i class="fas fa-star" style="color: var(--gold-primary); font-size: 0.75rem; margin-inline-end: 0.3rem;"></i> {{ app()->getLocale() == 'ar' ? $perfume->notes_ar : $perfume->notes_fr }}
                    </div>
                    <p class="product-desc">
                        {{ app()->getLocale() == 'ar' ? Str::limit($perfume->description_ar, 90) : Str::limit($perfume->description_fr, 90) }}
                    </p>
                    <div class="product-bottom">
                        <span class="product-price">{{ number_format($perfume->price, 2) }} DH</span>
                        <a href="{{ route('perfume.show', $perfume->id) }}" class="btn" style="padding: 0.5rem 1rem; font-size: 0.85rem;">
                            {{ app()->getLocale() == 'ar' ? 'طلب الآن' : 'Commander' }}
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection
