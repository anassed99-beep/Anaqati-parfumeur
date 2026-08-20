@extends('layouts.app')

@section('title', app()->getLocale() == 'ar' ? 'لوحة تحكم المسؤول - أناقتي' : 'Dashboard Admin - Elixir d\'Orient')

@section('styles')
<style>
    .dashboard-container {
        max-width: 1280px;
        margin: 2rem auto;
        padding: 0 1.5rem;
    }

    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 1.5rem;
        margin-bottom: 2rem;
    }

    .dashboard-header h1 {
        color: var(--gold-primary);
        font-size: 2rem;
        font-family: var(--font-arabic), serif;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .admin-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .admin-badge {
        font-size: 0.85rem;
        color: var(--gold-primary);
        background: rgba(212, 175, 55, 0.1);
        border: 1px solid var(--gold-primary);
        padding: 0.35rem 0.85rem;
        border-radius: 20px;
    }

    .tabs {
        display: flex;
        gap: 0.75rem;
        margin-bottom: 2rem;
        border-bottom: 1px solid var(--border-color);
        flex-wrap: wrap;
    }

    .tab-btn {
        background: none;
        border: none;
        color: var(--text-muted);
        font-size: 0.92rem;
        font-weight: 500;
        padding: 0.75rem 1.1rem;
        cursor: pointer;
        font-family: inherit;
        border-bottom: 3px solid transparent;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .tab-btn:hover, .tab-btn.active {
        color: var(--gold-primary);
        border-color: var(--gold-primary);
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    /* Orders Table */
    .table-card {
        background-color: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 700px; /* Ensures clean readable columns on mobile */
    }

    th, td {
        padding: 0.85rem 1rem;
        text-align: left;
        border-bottom: 1px solid var(--border-color);
        font-size: 0.88rem;
    }

    [dir="rtl"] th, [dir="rtl"] td {
        text-align: right;
    }

    th {
        background-color: rgba(255, 255, 255, 0.03);
        color: var(--gold-primary);
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.78rem;
        letter-spacing: 0.5px;
    }

    tr:hover {
        background-color: rgba(255, 255, 255, 0.02);
    }

    .badge {
        display: inline-block;
        padding: 0.28rem 0.6rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge-en_attente {
        background-color: rgba(243, 156, 18, 0.15);
        color: #f39c12;
        border: 1px solid rgba(243, 156, 18, 0.3);
    }

    .badge-valide {
        background-color: rgba(52, 152, 219, 0.15);
        color: #3498db;
        border: 1px solid rgba(52, 152, 219, 0.3);
    }

    .badge-livre {
        background-color: rgba(46, 204, 113, 0.15);
        color: #2ecc71;
        border: 1px solid rgba(46, 204, 113, 0.3);
    }

    .badge-annule {
        background-color: rgba(231, 76, 60, 0.15);
        color: #e74c3c;
        border: 1px solid rgba(231, 76, 60, 0.3);
    }

    .status-select {
        padding: 0.35rem 0.5rem;
        background-color: rgba(0, 0, 0, 0.4);
        color: var(--text-primary);
        border: 1px solid var(--border-color);
        border-radius: 6px;
        font-size: 0.82rem;
        outline: none;
        cursor: pointer;
    }

    /* Icon Action Buttons */
    .icon-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 6px;
        border: 1px solid var(--border-color);
        background: rgba(255, 255, 255, 0.03);
        color: var(--text-muted);
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .icon-btn-edit:hover {
        background: rgba(212, 175, 55, 0.15);
        color: var(--gold-primary);
        border-color: var(--gold-primary);
    }

    .icon-btn-delete:hover {
        background: rgba(231, 76, 60, 0.15);
        color: #e74c3c;
        border-color: #e74c3c;
    }

    /* Centered Forms */
    .centered-form-card {
        max-width: 900px;
        margin: 0 auto 2.5rem auto;
        background-color: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 14px;
        padding: 2.25rem;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.5);
    }

    .form-card-title {
        color: var(--gold-primary);
        font-size: 1.4rem;
        font-family: var(--font-arabic), serif;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--border-color);
    }

    .form-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.25rem;
    }

    .grid-full {
        grid-column: span 2;
    }

    .form-label {
        font-size: 0.85rem;
        color: var(--gold-light);
        margin-bottom: 0.35rem;
        display: block;
    }

    .form-input-custom {
        width: 100%;
        padding: 0.75rem 0.9rem;
        background: rgba(0, 0, 0, 0.35);
        border: 1px solid var(--border-color);
        border-radius: 6px;
        color: #fff;
        font-size: 0.92rem;
        transition: border-color 0.3s;
    }

    .form-input-custom:focus {
        outline: none;
        border-color: var(--gold-primary);
    }

    .password-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .password-wrapper input {
        padding-right: 2.8rem;
    }

    [dir="rtl"] .password-wrapper input {
        padding-right: 0.9rem;
        padding-left: 2.8rem;
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

    [dir="rtl"] .password-toggle-btn {
        right: auto;
        left: 10px;
    }

    .password-toggle-btn:hover {
        opacity: 1;
    }

    /* Compact Perfume Catalog Cards Grid */
    .compact-perfumes-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 1.25rem;
    }

    .compact-perfume-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 10px;
        padding: 0.9rem;
        display: flex;
        gap: 0.85rem;
        align-items: center;
        transition: transform 0.2s, border-color 0.2s;
    }

    .compact-perfume-card:hover {
        transform: translateY(-3px);
        border-color: var(--gold-primary);
    }

    .compact-perfume-img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 6px;
        border: 1px solid var(--border-color);
        flex-shrink: 0;
    }

    .compact-perfume-info {
        flex-grow: 1;
        min-width: 0;
    }

    .compact-perfume-info h4 {
        color: #fff;
        font-size: 0.92rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-bottom: 0.2rem;
    }

    .compact-perfume-info p {
        font-size: 0.78rem;
        color: var(--text-muted);
        margin-bottom: 0.2rem;
    }

    .compact-perfume-price {
        color: var(--gold-primary);
        font-weight: 700;
        font-size: 0.88rem;
    }

    .compact-perfume-actions {
        display: flex;
        flex-direction: column;
        gap: 0.35rem;
    }

    .bg-preview {
        display: flex;
        align-items: center;
        gap: 1.25rem;
        background: rgba(255, 255, 255, 0.03);
        padding: 0.9rem;
        border-radius: 8px;
        border: 1px dashed var(--border-color);
        margin-top: 0.5rem;
    }

    .bg-preview img {
        width: 100px;
        height: 60px;
        object-fit: cover;
        border-radius: 6px;
        border: 1px solid var(--gold-primary);
    }

    /* Smartphone Responsive Breakpoints (< 768px & < 480px) */
    @media (max-width: 768px) {
        .dashboard-container {
            padding: 0 1rem;
            margin: 1.5rem auto;
        }

        .dashboard-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
            padding-bottom: 1rem;
            margin-bottom: 1.5rem;
        }

        .dashboard-header h1 {
            font-size: 1.5rem;
        }

        .admin-info {
            width: 100%;
            justify-content: space-between;
        }

        .tabs {
            gap: 0.4rem;
        }

        .tab-btn {
            font-size: 0.82rem;
            padding: 0.6rem 0.85rem;
        }

        .centered-form-card {
            padding: 1.5rem 1rem;
            border-radius: 10px;
        }

        .form-card-title {
            font-size: 1.2rem;
        }

        .form-grid-2 {
            grid-template-columns: 1fr;
        }

        .grid-full {
            grid-column: span 1;
        }

        .bg-preview {
            flex-direction: column;
            align-items: flex-start;
        }
    }

    @media (max-width: 480px) {
        .compact-perfumes-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')

<div class="dashboard-container">
    <!-- Header -->
    <div class="dashboard-header">
        <div>
            <h1>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="7" height="7"></rect>
                    <rect x="14" y="3" width="7" height="7"></rect>
                    <rect x="14" y="14" width="7" height="7"></rect>
                    <rect x="3" y="14" width="7" height="7"></rect>
                </svg>
                {{ app()->getLocale() == 'ar' ? 'لوحة تحكم المسؤول' : 'Tableau de Bord Administrateur' }}
            </h1>
        </div>
        <div class="admin-info">
            <span class="admin-badge">
                <i class="fas fa-user-circle" style="margin-inline-end: 0.35rem;"></i> {{ session('admin_email', 'admin@elixirdorient.com') }}
            </span>
            <form action="{{ route('admin.logout') }}" method="POST" style="margin:0;">
                @csrf
                <button type="submit" class="btn btn-outline" style="padding: 0.4rem 0.9rem; font-size: 0.8rem;">
                    {{ app()->getLocale() == 'ar' ? 'تسجيل الخروج' : 'Déconnexion' }}
                </button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="background-color: rgba(46, 204, 113, 0.15); border: 1px solid #2ecc71; color: #2ecc71; padding: 0.85rem 1.25rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.95rem;">
            <i class="fas fa-check" style="margin-inline-end: 0.35rem;"></i> {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger" style="background-color: rgba(231, 76, 60, 0.15); border: 1px solid #e74c3c; color: #e74c3c; padding: 0.85rem 1.25rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.95rem;">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <!-- Tabs Navigation -->
    <div class="tabs">
        <button class="tab-btn active" onclick="switchTab(event, 'orders-tab')">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
            {{ app()->getLocale() == 'ar' ? 'طلبات الشراء' : 'Commandes' }} ({{ $orders->count() }})
        </button>
        <button class="tab-btn" onclick="switchTab(event, 'perfumes-tab')">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
            {{ app()->getLocale() == 'ar' ? 'كتالوج العطور' : 'Catalogue Parfums' }} ({{ $perfumes->count() }})
        </button>
        <button class="tab-btn" onclick="switchTab(event, 'settings-tab')">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
            {{ app()->getLocale() == 'ar' ? 'تخصيص الموقع والخلفية' : 'Personnalisation Site & Fond' }}
        </button>
        <button class="tab-btn" onclick="switchTab(event, 'profile-tab')">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
            {{ app()->getLocale() == 'ar' ? 'حساب مسؤول الأمان' : 'Compte & Sécurité Admin' }}
        </button>
    </div>

    <!-- ─── TAB 1: COMMANDES / TABLEAU ──────────────────────────────────── -->
    <div id="orders-tab" class="tab-content active">
        <div class="table-card">
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>{{ app()->getLocale() == 'ar' ? 'التاريخ' : 'Date' }}</th>
                            <th>{{ app()->getLocale() == 'ar' ? 'العميل' : 'Client' }}</th>
                            <th>{{ app()->getLocale() == 'ar' ? 'الهاتف' : 'Téléphone' }}</th>
                            <th>{{ app()->getLocale() == 'ar' ? 'العطر' : 'Parfum' }}</th>
                            <th>{{ app()->getLocale() == 'ar' ? 'الكمية' : 'Qté' }}</th>
                            <th>{{ app()->getLocale() == 'ar' ? 'قناة الطلب' : 'Canal' }}</th>
                            <th>{{ app()->getLocale() == 'ar' ? 'الحالة' : 'Statut' }}</th>
                            <th>{{ app()->getLocale() == 'ar' ? 'تغيير الحالة' : 'Changer Statut' }}</th>
                            <th>{{ app()->getLocale() == 'ar' ? 'إجراء' : 'Action' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <strong style="color: #fff;">{{ $order->client_name }}</strong>
                                    @if($order->client_address)
                                        <br><span style="font-size: 0.8rem; color: var(--text-muted);"><i class="fas fa-map-marker-alt" style="margin-inline-end: 0.2rem;"></i> {{ $order->client_address }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="tel:{{ $order->client_phone }}" style="color: var(--gold-primary); text-decoration: none;">
                                        <i class="fas fa-phone-alt" style="margin-inline-end: 0.2rem;"></i> {{ $order->client_phone }}
                                    </a>
                                </td>
                                <td>
                                    <strong>
                                        @if(app()->getLocale() == 'ar')
                                            {{ $order->perfume->name_ar ?? ($order->perfume->name_fr ?? 'عطر محذوف') }}
                                        @else
                                            {{ $order->perfume->name_fr ?? 'Parfum supprimé' }}
                                        @endif
                                    </strong>
                                </td>
                                <td><span style="font-weight: 600;">{{ $order->quantity }}</span></td>
                                <td>
                                    <span class="badge" style="background: rgba(255,255,255,0.06); color: var(--gold-primary);">
                                        @if($order->type == 'whatsapp')
                                            <i class="fab fa-whatsapp" style="margin-inline-end: 0.2rem;"></i> {{ app()->getLocale() == 'ar' ? 'واتساب' : 'WhatsApp' }}
                                        @else
                                            <i class="fas fa-globe" style="margin-inline-end: 0.2rem;"></i> {{ app()->getLocale() == 'ar' ? 'نموذج الموقع' : 'Formulaire' }}
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $order->status }}">
                                        @if($order->status == 'en_attente')
                                            {{ app()->getLocale() == 'ar' ? 'قيد الانتظار' : 'En attente' }}
                                        @elseif($order->status == 'valide')
                                            {{ app()->getLocale() == 'ar' ? 'تم التأكيد' : 'Validé' }}
                                        @elseif($order->status == 'livre')
                                            {{ app()->getLocale() == 'ar' ? 'تم التسليم' : 'Livré' }}
                                        @elseif($order->status == 'annule')
                                            {{ app()->getLocale() == 'ar' ? 'ملغي' : 'Annulé' }}
                                        @else
                                            {{ $order->status }}
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    <form action="{{ route('admin.order.status', $order->id) }}" method="POST" style="margin:0;">
                                        @csrf
                                        <select name="status" class="status-select" onchange="this.form.submit()">
                                            <option value="en_attente" {{ $order->status == 'en_attente' ? 'selected' : '' }}>
                                                ⧖ {{ app()->getLocale() == 'ar' ? 'قيد الانتظار' : 'En attente' }}
                                            </option>
                                            <option value="valide" {{ $order->status == 'valide' ? 'selected' : '' }}>
                                                ✓ {{ app()->getLocale() == 'ar' ? 'تم التأكيد' : 'Validé' }}
                                            </option>
                                            <option value="livre" {{ $order->status == 'livre' ? 'selected' : '' }}>
                                                → {{ app()->getLocale() == 'ar' ? 'تم التسليم' : 'Livré' }}
                                            </option>
                                            <option value="annule" {{ $order->status == 'annule' ? 'selected' : '' }}>
                                                ✕ {{ app()->getLocale() == 'ar' ? 'ملغي' : 'Annulé' }}
                                            </option>
                                        </select>
                                    </form>
                                </td>
                                <td>
                                    <form action="{{ route('admin.order.delete', $order->id) }}" method="POST" style="margin:0;" onsubmit="return confirm('{{ app()->getLocale() == 'ar' ? 'هل تريد حذف هذا الطلب نهائياً؟' : 'Supprimer définitivement cette commande ?' }}');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="icon-btn icon-btn-delete" title="{{ app()->getLocale() == 'ar' ? 'حذف الطلب' : 'Supprimer la commande' }}">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" style="text-align: center; padding: 3rem; color: var(--text-muted);">
                                    {{ app()->getLocale() == 'ar' ? 'لا يوجد أي طلب حتى الآن.' : 'Aucune commande reçue pour le moment.' }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- ─── TAB 2: CATALOGUE PERFUMES ────────────────────────────────────── -->
    <div id="perfumes-tab" class="tab-content">
        
        <!-- FORMULAIRE D'AJOUT GRAND & CENTRÉ -->
        <div class="centered-form-card">
            <h3 class="form-card-title">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="16"></line>
                    <line x1="8" y1="12" x2="16" y2="12"></line>
                </svg>
                {{ app()->getLocale() == 'ar' ? 'إضافة عطر جديد إلى الكتالوج' : 'Ajouter un nouveau parfum au catalogue' }}
            </h3>

            <form action="{{ route('admin.perfume.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-grid-2">
                    <div>
                        <label class="form-label" for="name_fr">{{ app()->getLocale() == 'ar' ? 'اسم العطر (بالفرنسية) *' : 'Nom du parfum (FR) *' }}</label>
                        <input type="text" name="name_fr" id="name_fr" class="form-input-custom" placeholder="Ex: Oud Imperial" required>
                    </div>

                    <div dir="rtl">
                        <label class="form-label" for="name_ar">{{ app()->getLocale() == 'ar' ? 'اسم العطر (بالعربية) *' : 'Nom du parfum (AR) *' }}</label>
                        <input type="text" name="name_ar" id="name_ar" class="form-input-custom" placeholder="مثال: عود إمبراطوري" required>
                    </div>

                    <div>
                        <label class="form-label" for="price">{{ app()->getLocale() == 'ar' ? 'السعر (درهم) *' : 'Prix (DH) *' }}</label>
                        <input type="number" step="0.01" name="price" id="price" class="form-input-custom" placeholder="Ex: 120.00" required>
                    </div>

                    <div>
                        <label class="form-label" for="volume_ml">{{ app()->getLocale() == 'ar' ? 'السعة (مل)' : 'Contenance (ML)' }}</label>
                        <input type="number" name="volume_ml" id="volume_ml" class="form-input-custom" value="100" placeholder="100">
                    </div>

                    <div>
                        <label class="form-label" for="notes_fr">{{ app()->getLocale() == 'ar' ? 'المكونات العطرية (بالفرنسية)' : 'Notes Olfactives (FR)' }}</label>
                        <input type="text" name="notes_fr" id="notes_fr" class="form-input-custom" placeholder="Ex: Oud, Cuir, Amber">
                    </div>

                    <div dir="rtl">
                        <label class="form-label" for="notes_ar">{{ app()->getLocale() == 'ar' ? 'المكونات العطرية (بالعربية)' : 'Notes Olfactives (AR)' }}</label>
                        <input type="text" name="notes_ar" id="notes_ar" class="form-input-custom" placeholder="مثال: عود، جلد، عنبر">
                    </div>

                    <div class="grid-full">
                        <label class="form-label" for="description_fr">{{ app()->getLocale() == 'ar' ? 'الوصف (بالفرنسية)' : 'Description (Français)' }}</label>
                        <textarea name="description_fr" id="description_fr" class="form-input-custom" rows="2" placeholder="Description détaillée..."></textarea>
                    </div>

                    <div class="grid-full" dir="rtl">
                        <label class="form-label" for="description_ar">{{ app()->getLocale() == 'ar' ? 'الوصف (بالعربية)' : 'Description (Arabe)' }}</label>
                        <textarea name="description_ar" id="description_ar" class="form-input-custom" rows="2" placeholder="وصف تفصيلي..."></textarea>
                    </div>

                    <div class="grid-full">
                        <label class="form-label" for="image">{{ app()->getLocale() == 'ar' ? 'صورة العطر' : 'Image du parfum' }}</label>
                        <input type="file" name="image" id="image" class="form-input-custom" accept="image/*">
                    </div>

                    <div class="grid-full">
                        <label style="display: flex; align-items: center; gap: 0.6rem; cursor: pointer;">
                            <input type="checkbox" name="is_featured" value="1" style="width: 18px; height: 18px; accent-color: var(--gold-primary);">
                            <span style="color: #fff; font-size: 0.9rem;">
                                {{ app()->getLocale() == 'ar' ? 'عرض العطر في الصفحة الرئيسية (عطر مميز)' : 'Mettre en vedette dans la page d\'accueil (Coup de cœur)' }}
                            </span>
                        </label>
                    </div>
                </div>

                <div style="margin-top: 2rem; text-align: right;">
                    <button type="submit" class="btn" style="padding: 0.85rem 2.5rem; font-size: 1rem; font-weight: 600;">
                        {{ app()->getLocale() == 'ar' ? '+ إضافة إلى الكتالوج' : '+ Ajouter au catalogue' }}
                    </button>
                </div>
            </form>
        </div>

        <h3 style="color: var(--gold-primary); font-size: 1.3rem; margin-bottom: 1.5rem;">
            {{ app()->getLocale() == 'ar' ? 'العطور المسجلة في الكتالوج' : 'Parfums dans le catalogue' }} ({{ $perfumes->count() }})
        </h3>

        <div class="compact-perfumes-grid">
            @forelse($perfumes as $perfume)
                <div class="compact-perfume-card">
                    <img src="{{ asset($perfume->image_url ?? 'images/musc_imperial.png') }}" alt="{{ $perfume->name_fr }}" class="compact-perfume-img">
                    
                    <div class="compact-perfume-info">
                        <h4>{{ app()->getLocale() == 'ar' ? $perfume->name_ar : $perfume->name_fr }}</h4>
                        <p>{{ app()->getLocale() == 'ar' ? $perfume->name_fr : $perfume->name_ar }}</p>
                        <div class="compact-perfume-price">{{ number_format($perfume->price, 2) }} DH</div>
                    </div>

                    <div class="compact-perfume-actions">
                        <a href="{{ route('admin.perfume.edit', $perfume) }}" class="icon-btn icon-btn-edit" title="{{ app()->getLocale() == 'ar' ? 'تعديل العطر' : 'Modifier le parfum' }}">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </a>

                        <form action="{{ route('admin.perfume.delete', $perfume) }}" method="POST" style="margin:0;" onsubmit="return confirm('{{ app()->getLocale() == 'ar' ? 'هل تريد حذف هذا العطر من الكتالوج؟' : 'Retirer ce parfum du catalogue ?' }}');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="icon-btn icon-btn-delete" title="{{ app()->getLocale() == 'ar' ? 'حذف العطر' : 'Supprimer le parfum' }}">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div style="grid-column: span 3; text-align: center; padding: 2rem; color: var(--text-muted);">
                    {{ app()->getLocale() == 'ar' ? 'لا يوجد أي عطر مسجل.' : 'Aucun parfum enregistré.' }}
                </div>
            @endforelse
        </div>
    </div>

    <!-- ─── TAB 3: PERSONNALISATION DU SITE ─────────────────────────────── -->
    <div id="settings-tab" class="tab-content">
        <div class="centered-form-card">
            <h3 class="form-card-title">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                    <polyline points="21 15 16 10 5 21"></polyline>
                </svg>
                {{ app()->getLocale() == 'ar' ? 'تخصيص محتوى الموقع وصورة الخلفية' : 'Personnalisation du Site (Image de Fond & Contenus)' }}
            </h3>

            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- IMAGE DE FOND ACCUEIL -->
                <div style="margin-bottom: 2rem; padding-bottom: 1.5rem; border-bottom: 1px solid var(--border-color);">
                    <label class="form-label" style="font-size: 1rem; font-weight: 600; color: var(--gold-primary);">
                        <i class="fas fa-image" style="margin-inline-end: 0.4rem;"></i> {{ app()->getLocale() == 'ar' ? 'صورة خلفية الصفحة الرئيسية (Section Hero)' : 'Image de Fond de la Page d\'Accueil (Section Hero)' }}
                    </label>
                    <div class="bg-preview">
                        <img src="{{ asset($settings['hero_bg_image'] ?? 'images/oud_majestic.png') }}" alt="Background Preview">
                        <div style="flex: 1;">
                            <label for="hero_bg_image" style="cursor: pointer; color: var(--gold-primary); text-decoration: underline; display: block; margin-bottom: 0.4rem;">
                                {{ app()->getLocale() == 'ar' ? 'اختر صورة خلفية جديدة...' : 'Choisir une nouvelle image de fond...' }}
                            </label>
                            <input type="file" name="hero_bg_image" id="hero_bg_image" class="form-input-custom" accept="image/*">
                            <span style="font-size: 0.8rem; color: var(--text-muted); display: block; margin-top: 0.3rem;">Format recommandé: HD 1920x1080px (JPG, PNG, WEBP)</span>
                        </div>
                    </div>
                </div>

                <!-- SECTION HERO TEXTES -->
                <div class="form-grid-2" style="margin-bottom: 2rem; padding-bottom: 1.5rem; border-bottom: 1px solid var(--border-color);">
                    <div class="grid-full">
                        <h4 style="color: var(--gold-light); font-size: 1.05rem;"><i class="fas fa-pen-nib" style="margin-inline-end: 0.4rem;"></i> {{ app()->getLocale() == 'ar' ? 'عنوان وشعار الواجهة الرئيسية' : 'Titre & Slogan de la Bannière Principale' }}</h4>
                    </div>

                    <div>
                        <label class="form-label">{{ app()->getLocale() == 'ar' ? 'العنوان الرئيسي (بالفرنسية)' : 'Titre Principal (FR)' }}</label>
                        <input type="text" name="hero_title_fr" class="form-input-custom" value="{{ $settings['hero_title_fr'] ?? 'Anaqati' }}">
                    </div>

                    <div dir="rtl">
                        <label class="form-label">{{ app()->getLocale() == 'ar' ? 'العنوان الرئيسي (بالعربية)' : 'Titre Principal (AR)' }}</label>
                        <input type="text" name="hero_title_ar" class="form-input-custom" value="{{ $settings['hero_title_ar'] ?? 'أناقتي' }}">
                    </div>

                    <div>
                        <label class="form-label">{{ app()->getLocale() == 'ar' ? 'الشعار (بالفرنسية)' : 'Slogan (FR)' }}</label>
                        <input type="text" name="hero_slogan_fr" class="form-input-custom" value="{{ $settings['hero_slogan_fr'] ?? 'L\'Élégance Impériale en Flacon' }}">
                    </div>

                    <div dir="rtl">
                        <label class="form-label">{{ app()->getLocale() == 'ar' ? 'الشعار (بالعربية)' : 'Slogan (AR)' }}</label>
                        <input type="text" name="hero_slogan_ar" class="form-input-custom" value="{{ $settings['hero_slogan_ar'] ?? 'الفخامة الإمبراطورية في زجاجة عطر' }}">
                    </div>

                    <div class="grid-full">
                        <label class="form-label">{{ app()->getLocale() == 'ar' ? 'الوصف التقديمي (بالفرنسية)' : 'Description d\'introduction (FR)' }}</label>
                        <textarea name="hero_desc_fr" class="form-input-custom" rows="2">{{ $settings['hero_desc_fr'] ?? '' }}</textarea>
                    </div>

                    <div class="grid-full" dir="rtl">
                        <label class="form-label">{{ app()->getLocale() == 'ar' ? 'الوصف التقديمي (بالعربية)' : 'Description d\'introduction (AR)' }}</label>
                        <textarea name="hero_desc_ar" class="form-input-custom" rows="2">{{ $settings['hero_desc_ar'] ?? '' }}</textarea>
                    </div>
                </div>

                <!-- SECTION À PROPOS DE LA SOCIÉTÉ -->
                <div class="form-grid-2" style="margin-bottom: 2rem;">
                    <div class="grid-full">
                        <h4 style="color: var(--gold-light); font-size: 1.05rem;"><i class="fas fa-building" style="margin-inline-end: 0.4rem;"></i> {{ app()->getLocale() == 'ar' ? 'قسم التعريف بالشركة' : 'Section Présentation de la Société' }}</h4>
                    </div>

                    <div>
                        <label class="form-label">{{ app()->getLocale() == 'ar' ? 'عنوان فقرة من نحن (بالفرنسية)' : 'Titre Section À propos (FR)' }}</label>
                        <input type="text" name="about_title_fr" class="form-input-custom" value="{{ $settings['about_title_fr'] ?? 'L\'Art du Parfum Rare' }}">
                    </div>

                    <div dir="rtl">
                        <label class="form-label">{{ app()->getLocale() == 'ar' ? 'عنوان فقرة من نحن (بالعربية)' : 'Titre Section À propos (AR)' }}</label>
                        <input type="text" name="about_title_ar" class="form-input-custom" value="{{ $settings['about_title_ar'] ?? 'شغفنا بالعطور النادرة' }}">
                    </div>

                    <div class="grid-full">
                        <label class="form-label">{{ app()->getLocale() == 'ar' ? 'الفقرة الأولى (بالفرنسية)' : 'Paragraphe 1 (FR)' }}</label>
                        <textarea name="about_p1_fr" class="form-input-custom" rows="2">{{ $settings['about_p1_fr'] ?? '' }}</textarea>
                    </div>

                    <div class="grid-full" dir="rtl">
                        <label class="form-label">{{ app()->getLocale() == 'ar' ? 'الفقرة الأولى (بالعربية)' : 'Paragraphe 1 (AR)' }}</label>
                        <textarea name="about_p1_ar" class="form-input-custom" rows="2">{{ $settings['about_p1_ar'] ?? '' }}</textarea>
                    </div>

                    <div class="grid-full">
                        <label class="form-label">{{ app()->getLocale() == 'ar' ? 'الفقرة الثانية (بالفرنسية)' : 'Paragraphe 2 (FR)' }}</label>
                        <textarea name="about_p2_fr" class="form-input-custom" rows="2">{{ $settings['about_p2_fr'] ?? '' }}</textarea>
                    </div>

                    <div class="grid-full" dir="rtl">
                        <label class="form-label">{{ app()->getLocale() == 'ar' ? 'الفقرة الثانية (بالعربية)' : 'Paragraphe 2 (AR)' }}</label>
                        <textarea name="about_p2_ar" class="form-input-custom" rows="2">{{ $settings['about_p2_ar'] ?? '' }}</textarea>
                    </div>

                    <div class="grid-full">
                        <label class="form-label">{{ app()->getLocale() == 'ar' ? 'رقم الواتساب الخاص بالشركة' : 'Numéro WhatsApp de la Société' }}</label>
                        <input type="text" name="whatsapp_number" class="form-input-custom" value="{{ $settings['whatsapp_number'] ?? '+212600000000' }}" placeholder="+212600000000">
                    </div>
                </div>

                <div style="text-align: right;">
                    <button type="submit" class="btn" style="padding: 0.85rem 2.5rem; font-size: 1rem; font-weight: 600;">
                        {{ app()->getLocale() == 'ar' ? '✓ حفظ التغييرات والتخصيصات' : '✓ Enregistrer les personnalisations du site' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ─── TAB 4: COMPTE ADMIN (EMAIL & MOT DE PASSE) ───────────────────── -->
    <div id="profile-tab" class="tab-content">
        <div class="centered-form-card" style="max-width: 600px;">
            <h3 class="form-card-title">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                {{ app()->getLocale() == 'ar' ? 'تعديل بيانات حساب المسؤول' : 'Modifier mes identifiants Administrateur' }}
            </h3>

            <form action="{{ route('admin.profile.update') }}" method="POST">
                @csrf

                <div style="margin-bottom: 1.25rem;">
                    <label class="form-label" for="profile_email">{{ app()->getLocale() == 'ar' ? 'البريد الإلكتروني للمسؤول *' : 'Adresse Email Administrateur *' }}</label>
                    <input type="email" name="email" id="profile_email" class="form-input-custom" value="{{ old('email', $adminUser->email ?? session('admin_email')) }}" required>
                </div>

                <div style="margin-bottom: 1.25rem;">
                    <label class="form-label" for="current_password">{{ app()->getLocale() == 'ar' ? 'كلمة المرور الحالية * (للتأكيد)' : 'Mot de passe actuel * (pour valider)' }}</label>
                    <div class="password-wrapper">
                        <input type="password" name="current_password" id="current_password" class="form-input-custom" placeholder="••••••••" required>
                        <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility('current_password', this)">
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

                <div style="margin-bottom: 1.25rem;">
                    <label class="form-label" for="new_password">{{ app()->getLocale() == 'ar' ? 'كلمة المرور الجديدة (اتركها فارغة إذا لم ترد التغيير)' : 'Nouveau mot de passe (laisser vide pour ne pas changer)' }}</label>
                    <div class="password-wrapper">
                        <input type="password" name="new_password" id="new_password" class="form-input-custom" placeholder="••••••••" minlength="6">
                        <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility('new_password', this)">
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

                <div style="margin-bottom: 1.75rem;">
                    <label class="form-label" for="new_password_confirmation">{{ app()->getLocale() == 'ar' ? 'تأكيد كلمة المرور الجديدة' : 'Confirmer le nouveau mot de passe' }}</label>
                    <div class="password-wrapper">
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-input-custom" placeholder="••••••••" minlength="6">
                        <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility('new_password_confirmation', this)">
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
                    {{ app()->getLocale() == 'ar' ? '✓ تحديث البريد الإلكتروني وكلمة المرور' : '✓ Mettre à jour l\'Email & Mot de Passe' }}
                </button>
            </form>
        </div>
    </div>

</div>

<script>
    function switchTab(evt, tabId) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tab-content");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tab-btn");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(tabId).style.display = "block";
        evt.currentTarget.className += " active";
    }

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
