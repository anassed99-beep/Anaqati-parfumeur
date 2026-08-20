@extends('layouts.app')

@section('title', app()->getLocale() == 'ar' ? 'تعديل العطر - أناقتي' : 'Modifier Parfum - Elixir d\'Orient Admin')

@section('styles')
<style>
    .edit-container {
        max-width: 800px;
        margin: 2.5rem auto;
        padding: 2.25rem;
        background-color: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.6);
    }

    .edit-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--border-color);
    }

    .edit-header h2 {
        color: var(--gold-primary);
        font-size: 1.8rem;
        font-family: var(--font-arabic), serif;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.25rem;
    }

    .form-group-full {
        grid-column: span 2;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
    }

    .form-group label {
        color: var(--gold-light);
        font-size: 0.88rem;
        font-weight: 500;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 0.9rem;
        background: rgba(0, 0, 0, 0.3);
        border: 1px solid var(--border-color);
        border-radius: 6px;
        color: #fff;
        font-size: 0.92rem;
        transition: border-color 0.3s;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--gold-primary);
    }

    textarea.form-control {
        min-height: 100px;
        resize: vertical;
    }

    .image-preview {
        display: flex;
        align-items: center;
        gap: 1.25rem;
        background: rgba(255, 255, 255, 0.03);
        padding: 0.9rem;
        border-radius: 8px;
        border: 1px dashed var(--border-color);
        margin-top: 0.5rem;
    }

    .image-preview img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 6px;
        border: 1px solid var(--gold-primary);
    }

    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-top: 0.5rem;
        cursor: pointer;
    }

    .checkbox-group input {
        width: 18px;
        height: 18px;
        accent-color: var(--gold-primary);
    }

    .btn-submit {
        background: linear-gradient(135deg, var(--gold-primary), var(--gold-hover));
        color: #000;
        font-weight: 600;
        font-size: 0.95rem;
        padding: 0.8rem 1.8rem;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(212, 175, 55, 0.3);
    }

    .btn-cancel {
        background: transparent;
        border: 1px solid var(--border-color);
        color: var(--text-muted);
        padding: 0.8rem 1.25rem;
        border-radius: 6px;
        text-decoration: none;
        font-size: 0.9rem;
        transition: all 0.2s;
    }

    .btn-cancel:hover {
        border-color: #fff;
        color: #fff;
    }

    /* Smartphone Breakpoint (< 768px) */
    @media (max-width: 768px) {
        .edit-container {
            margin: 1.5rem 1rem;
            padding: 1.5rem 1rem;
        }

        .edit-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .edit-header h2 {
            font-size: 1.4rem;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .form-group-full {
            grid-column: span 1;
        }

        .image-preview {
            flex-direction: column;
            align-items: flex-start;
        }

        .action-buttons-wrapper {
            flex-direction: column-reverse;
            width: 100%;
        }

        .action-buttons-wrapper .btn-submit,
        .action-buttons-wrapper .btn-cancel {
            width: 100%;
            text-align: center;
        }
    }
</style>
@endsection

@section('content')

<div class="edit-container">
    <div class="edit-header">
        <h2>
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--gold-primary);">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
            </svg>
            {{ app()->getLocale() == 'ar' ? 'تعديل العطر' : 'Modifier le Parfum' }} : {{ app()->getLocale() == 'ar' ? $perfume->name_ar : $perfume->name_fr }}
        </h2>
        <a href="{{ route('admin.dashboard') }}" class="btn-cancel">
            &larr; {{ app()->getLocale() == 'ar' ? 'إلغاء والعودة' : 'Annuler et retour' }}
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger" style="background-color: rgba(231, 76, 60, 0.15); border: 1px solid #e74c3c; color: #e74c3c; padding: 0.75rem 1rem; border-radius: 6px; margin-bottom: 1.5rem; font-size: 0.9rem;">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form action="{{ route('admin.perfume.update', $perfume) }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-grid">
            <!-- Nom FR -->
            <div class="form-group">
                <label for="name_fr">{{ app()->getLocale() == 'ar' ? 'اسم العطر (بالفرنسية) *' : 'Nom du parfum (FR) *' }}</label>
                <input type="text" name="name_fr" id="name_fr" class="form-control" value="{{ old('name_fr', $perfume->name_fr) }}" required>
            </div>

            <!-- Nom AR -->
            <div class="form-group" dir="rtl">
                <label for="name_ar">{{ app()->getLocale() == 'ar' ? 'اسم العطر (بالعربية) *' : 'Nom du parfum (AR) *' }}</label>
                <input type="text" name="name_ar" id="name_ar" class="form-control" value="{{ old('name_ar', $perfume->name_ar) }}" required>
            </div>

            <!-- Prix -->
            <div class="form-group">
                <label for="price">{{ app()->getLocale() == 'ar' ? 'السعر (درهم) *' : 'Prix (DH) *' }}</label>
                <input type="number" step="0.01" name="price" id="price" class="form-control" value="{{ old('price', $perfume->price) }}" required>
            </div>

            <!-- Contenance ML -->
            <div class="form-group">
                <label for="volume_ml">{{ app()->getLocale() == 'ar' ? 'السعة (مل)' : 'Contenance (ML)' }}</label>
                <input type="number" name="volume_ml" id="volume_ml" class="form-control" value="{{ old('volume_ml', $perfume->volume_ml ?? 100) }}" placeholder="Ex: 100">
            </div>

            <!-- Description FR -->
            <div class="form-group form-group-full">
                <label for="description_fr">{{ app()->getLocale() == 'ar' ? 'الوصف (بالفرنسية)' : 'Description (FR)' }}</label>
                <textarea name="description_fr" id="description_fr" class="form-control">{{ old('description_fr', $perfume->description_fr) }}</textarea>
            </div>

            <!-- Description AR -->
            <div class="form-group form-group-full" dir="rtl">
                <label for="description_ar">{{ app()->getLocale() == 'ar' ? 'الوصف (بالعربية)' : 'Description (AR)' }}</label>
                <textarea name="description_ar" id="description_ar" class="form-control">{{ old('description_ar', $perfume->description_ar) }}</textarea>
            </div>

            <!-- Notes Olfactives FR -->
            <div class="form-group">
                <label for="notes_fr">{{ app()->getLocale() == 'ar' ? 'المكونات العطرية (بالفرنسية)' : 'Notes Olfactives (FR)' }}</label>
                <input type="text" name="notes_fr" id="notes_fr" class="form-control" value="{{ old('notes_fr', $perfume->notes_fr) }}" placeholder="Ex: Oud, Cuir, Vanille">
            </div>

            <!-- Notes Olfactives AR -->
            <div class="form-group" dir="rtl">
                <label for="notes_ar">{{ app()->getLocale() == 'ar' ? 'المكونات العطرية (بالعربية)' : 'Notes Olfactives (AR)' }}</label>
                <input type="text" name="notes_ar" id="notes_ar" class="form-control" value="{{ old('notes_ar', $perfume->notes_ar) }}" placeholder="مثال: عود، جلد، فانيليا">
            </div>

            <!-- Image File -->
            <div class="form-group form-group-full">
                <label>{{ app()->getLocale() == 'ar' ? 'صورة العطر' : 'Image du parfum' }}</label>
                <div class="image-preview">
                    @if($perfume->image_url)
                        <img src="{{ asset($perfume->image_url) }}" alt="{{ $perfume->name_fr }}">
                    @else
                        <div style="width: 80px; height: 80px; background: rgba(255,255,255,0.05); display: grid; place-content: center; color: var(--text-muted); border-radius: 6px;">Pas d'image</div>
                    @endif
                    <div style="flex: 1;">
                        <label for="image" style="cursor: pointer; color: var(--gold-primary); text-decoration: underline; margin-bottom: 0.5rem; display: inline-block;">
                            {{ app()->getLocale() == 'ar' ? 'تغيير صورة العطر' : 'Changer l\'image du parfum' }}
                        </label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/*">
                        <span style="font-size: 0.8rem; color: var(--text-muted); display: block; margin-top: 0.4rem;">Format: JPG, PNG, WEBP. Max: 4MB</span>
                    </div>
                </div>
            </div>

            <!-- Featured check -->
            <div class="form-group form-group-full">
                <label class="checkbox-group">
                    <input type="checkbox" name="is_featured" value="1" {{ $perfume->is_featured ? 'checked' : '' }}>
                    <span style="color: #fff; font-size: 0.95rem;">
                        {{ app()->getLocale() == 'ar' ? 'عرض العطر في الصفحة الرئيسية (عطر مميز)' : 'Afficher dans les coups de cœur de la page d\'accueil (En vedette)' }}
                    </span>
                </label>
            </div>
        </div>

        <div class="action-buttons-wrapper" style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border-color);">
            <a href="{{ route('admin.dashboard') }}" class="btn-cancel">{{ app()->getLocale() == 'ar' ? 'إلغاء' : 'Annuler' }}</a>
            <button type="submit" class="btn-submit">
                {{ app()->getLocale() == 'ar' ? '✓ حفظ التغييرات' : '✓ Enregistrer les modifications' }}
            </button>
        </div>
    </form>
</div>

@endsection
