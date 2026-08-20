@extends('layouts.app')

@section('title', app()->getLocale() == 'ar' ? ($settings['hero_title_ar'] ?? 'أناقتي') . ' - دار العطور الفاخرة' : ($settings['hero_title_fr'] ?? 'Anaqati') . ' - Maison de Haute Parfumerie')

@section('styles')
<style>
    /* Dynamic Hero Background */
    .hero {
        position: relative;
        padding: 6rem 1.5rem;
        background: linear-gradient(rgba(11, 11, 11, 0.68), rgba(11, 11, 11, 0.95)), 
                    url('/{{ $settings['hero_bg_image'] ?? 'images/oud_majestic.png' }}') no-repeat center center;
        background-size: cover;
        background-attachment: scroll; /* Smoother scrolling on mobile browsers */
        text-align: center;
        border-bottom: 1px solid var(--border-color);
        overflow: hidden;
        width: 100%;
    }

    .hero-content {
        max-width: 850px;
        margin: 0 auto;
        animation: fadeIn 1.5s ease-out;
    }

    .hero h1 {
        font-size: 3.5rem;
        color: var(--gold-primary);
        margin-bottom: 1rem;
        line-height: 1.2;
        text-shadow: 0 0 25px rgba(212, 175, 55, 0.35);
        font-family: var(--font-arabic), serif;
    }

    .hero .arabic-slogan {
        font-family: 'Amiri', serif;
        font-size: 2rem;
        color: var(--text-primary);
        margin-bottom: 1.5rem;
        letter-spacing: 0;
    }

    .hero p {
        font-size: 1.15rem;
        color: var(--text-secondary);
        margin-bottom: 2.2rem;
        font-weight: 300;
        line-height: 1.6;
    }

    /* About Section */
    .about-sec {
        max-width: 1200px;
        margin: 0 auto;
        padding: 4.5rem 1.5rem;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3.5rem;
        align-items: center;
    }

    .about-img {
        width: 100%;
        height: auto;
        border-radius: 8px;
        border: 1px solid var(--border-color);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
    }

    .about-text h2 {
        font-size: 2.2rem;
        color: var(--gold-primary);
        margin-bottom: 1.5rem;
        position: relative;
        padding-bottom: 0.5rem;
        font-family: var(--font-arabic), serif;
    }

    .about-text h2::after {
        content: '';
        position: absolute;
        width: 60px;
        height: 2px;
        background-color: var(--gold-primary);
        bottom: 0;
        left: 0;
    }

    [dir="rtl"] .about-text h2::after {
        left: auto;
        right: 0;
    }

    .about-text p {
        color: var(--text-secondary);
        font-size: 1.05rem;
        margin-bottom: 1.5rem;
        text-align: justify;
        line-height: 1.7;
    }

    /* Featured Products Section */
    .featured-sec {
        background-color: #0d0d0d;
        border-top: 1px solid var(--border-color);
        border-bottom: 1px solid var(--border-color);
        padding: 4rem 1.5rem;
    }

    .section-title {
        text-align: center;
        font-size: 2rem;
        color: var(--gold-primary);
        margin-bottom: 2.5rem;
        font-family: var(--font-arabic), serif;
    }

    .section-title span {
        display: block;
        font-family: 'Amiri', serif;
        font-size: 1.3rem;
        color: var(--text-secondary);
        margin-top: 0.5rem;
    }

    /* Compact Product Cards Grid */
    .products-grid {
        max-width: 1200px;
        margin: 0 auto;
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

    .arabic-pattern {
        height: 15px;
        background-image: radial-gradient(var(--border-color) 1px, transparent 0);
        background-size: 10px 10px;
        opacity: 0.3;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Smartphone Breakpoints (< 768px & < 480px) */
    @media (max-width: 850px) {
        .hero {
            padding: 4rem 1rem;
        }

        .hero h1 {
            font-size: 2.3rem;
        }

        .hero .arabic-slogan {
            font-size: 1.5rem;
        }

        .hero p {
            font-size: 0.98rem;
            margin-bottom: 1.75rem;
        }

        .about-sec {
            grid-template-columns: 1fr;
            gap: 2rem;
            padding: 3rem 1rem;
        }

        .about-text h2 {
            font-size: 1.8rem;
        }

        .about-text p {
            font-size: 0.95rem;
        }

        .featured-sec {
            padding: 3rem 1rem;
        }

        .section-title {
            font-size: 1.6rem;
            margin-bottom: 1.75rem;
        }

        .products-grid {
            grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
            gap: 1.25rem;
        }
    }

    @media (max-width: 480px) {
        .hero h1 {
            font-size: 1.9rem;
        }

        .hero .arabic-slogan {
            font-size: 1.3rem;
        }

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

<!-- Dynamic Hero Section -->
<div class="hero">
    <div class="hero-content">
        <h1>
            {{ app()->getLocale() == 'ar' ? ($settings['hero_title_ar'] ?? 'أناقتي') : ($settings['hero_title_fr'] ?? 'Anaqati') }}
        </h1>
        <div class="arabic-slogan">
            {{ app()->getLocale() == 'ar' ? ($settings['hero_slogan_ar'] ?? 'الفخامة الإمبراطورية في زجاجة عطر') : ($settings['hero_slogan_fr'] ?? 'L\'Élégance Impériale en Flacon') }}
        </div>
        <p>
            {{ app()->getLocale() == 'ar' ? ($settings['hero_desc_ar'] ?? 'نصنع من أجود أنواع العود والمسك والورد عطوراً تروي قصصاً من التراث العريق والفخامة العصرية.') : ($settings['hero_desc_fr'] ?? 'Nous sélectionnons les plus précieuses essences d\'Oud, de Musc et de Rose pour concevoir des parfums d\'exception.') }}
        </p>
        <a href="{{ route('catalog') }}" class="btn">{{ app()->getLocale() == 'ar' ? 'اكتشف مجموعتنا' : 'Découvrir la Collection' }}</a>
    </div>
</div>

<div class="arabic-pattern"></div>

<!-- About / Presentation Section -->
<div class="about-sec">
    <div>
        <img src="/{{ $settings['hero_bg_image'] ?? 'images/musc_imperial.png' }}" alt="Maison de Parfum" class="about-img">
    </div>
    <div class="about-text">
        <h2>
            {{ app()->getLocale() == 'ar' ? ($settings['about_title_ar'] ?? 'شغفنا بالعطور النادرة') : ($settings['about_title_fr'] ?? 'L\'Art du Parfum Rare') }}
        </h2>
        <p>
            {{ app()->getLocale() == 'ar' ? ($settings['about_p1_ar'] ?? 'تأسست دار إكسير الشرق في قلب التقاليد العطرية العربية لتصنع هوية عطرية لا تُنسى.') : ($settings['about_p1_fr'] ?? 'Fondée au cœur de la grande tradition de la parfumerie orientale, la maison Elixir d\'Orient élabore des créations intemporelles.') }}
        </p>
        <p>
            {{ app()->getLocale() == 'ar' ? ($settings['about_p2_ar'] ?? 'عطورنا ليست مجرد روائح، بل هي بصمة شخصية تعبر عن الفخامة والتميز.') : ($settings['about_p2_fr'] ?? 'Nos flacons incarnent un luxe discret et authentique, conçus pour ceux qui recherchent une signature olfactive remarquable.') }}
        </p>
        <a href="{{ route('catalog') }}" class="btn btn-outline" style="margin-top: 1rem;">
            {{ app()->getLocale() == 'ar' ? 'زيارة الكتالوج كامل' : 'Consulter le catalogue' }}
        </a>
    </div>
</div>

<div class="arabic-pattern"></div>

<!-- Featured Products Section -->
<div class="featured-sec">
    <h2 class="section-title">
        {{ app()->getLocale() == 'ar' ? 'العطور الأكثر تميزاً' : 'Nos Créations Signature' }}
        <span>{{ app()->getLocale() == 'ar' ? 'عطور مختارة بعناية لأجلك' : 'Une sélection de nos plus prestigieux flacons' }}</span>
    </h2>

    <div class="products-grid">
        @foreach($featured as $perfume)
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
                        <a href="{{ route('perfume.show', $perfume->id) }}" class="btn btn-outline" style="padding: 0.45rem 0.9rem; font-size: 0.82rem;">
                            {{ app()->getLocale() == 'ar' ? 'طلب الشراء' : 'Commander' }}
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection
