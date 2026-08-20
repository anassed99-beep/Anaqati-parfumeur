<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Elixir d\'Orient')</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400;1,700&family=Cinzel:wght@400;600;700&family=Cairo:wght@300;400;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- Font Awesome 6 Free -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <style>
        :root {
            --bg-color: #0b0b0b;
            --card-bg: #141414;
            --gold-primary: #d4af37;
            --gold-hover: #f3e5ab;
            --text-primary: #f5f5f5;
            --text-secondary: #a0a0a0;
            --border-color: #2a2a2a;
            --danger: #cf6679;
            --success: #03dac6;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-primary);
            font-family: 'Inter', 'Cairo', sans-serif;
            line-height: 1.6;
            overflow-x: hidden;
            width: 100%;
        }

        h1, h2, h3, h4, .brand-logo {
            font-family: 'Cinzel', 'Amiri', serif;
            font-weight: 600;
            letter-spacing: 1px;
        }

        a {
            color: inherit;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        /* Layout Structure */
        header {
            border-bottom: 1px solid var(--border-color);
            background-color: rgba(11, 11, 11, 0.96);
            position: sticky;
            top: 0;
            z-index: 1000;
            backdrop-filter: blur(10px);
            width: 100%;
        }

        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 1.5rem;
        }

        .brand-logo {
            font-size: 1.6rem;
            color: var(--gold-primary);
            text-shadow: 0 0 10px rgba(212, 175, 55, 0.2);
            display: flex;
            flex-direction: column;
            line-height: 1.1;
        }
        
        .brand-logo span {
            font-size: 0.85rem;
            font-family: 'Amiri', serif;
            color: var(--text-secondary);
            letter-spacing: 2px;
        }

        nav {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .nav-link {
            font-size: 0.95rem;
            font-weight: 500;
            color: var(--text-secondary);
            position: relative;
            padding: 0.2rem 0;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--gold-primary);
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 1px;
            bottom: 0;
            left: 0;
            background-color: var(--gold-primary);
            transition: width 0.3s ease;
        }

        .nav-link:hover::after, .nav-link.active::after {
            width: 100%;
        }

        /* Language Dropdown Selector */
        .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .custom-lang-selector-wrapper {
            position: relative;
            display: inline-flex;
            align-items: center;
        }

        .custom-lang-select {
            appearance: none;
            -webkit-appearance: none;
            background-color: rgba(20, 20, 20, 0.9);
            border: 1px solid var(--gold-primary);
            color: var(--gold-primary);
            padding: 0.4rem 2rem 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.82rem;
            font-weight: 600;
            cursor: pointer;
            outline: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%23d4af37' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.6rem center;
        }

        [dir="rtl"] .custom-lang-select {
            padding: 0.4rem 0.8rem 0.4rem 2rem;
            background-position: left 0.6rem center;
        }

        .custom-lang-select:hover {
            background-color: rgba(212, 175, 55, 0.15);
        }

        .custom-lang-select option {
            background-color: #141414;
            color: #fff;
            padding: 0.5rem;
        }

        .admin-btn {
            background-color: var(--gold-primary);
            color: #000;
            padding: 0.45rem 1.1rem;
            border-radius: 4px;
            font-size: 0.82rem;
            font-weight: 600;
            white-space: nowrap;
        }

        .admin-btn:hover {
            background-color: var(--gold-hover);
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.4);
        }

        /* Main Content */
        main {
            min-height: calc(100vh - 180px);
            width: 100%;
        }

        /* Footer */
        footer {
            border-top: 1px solid var(--border-color);
            padding: 3rem 1.5rem;
            background-color: #060606;
            margin-top: 3.5rem;
            width: 100%;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 2rem;
        }

        .footer-sec h3 {
            color: var(--gold-primary);
            margin-bottom: 1rem;
            font-size: 1.15rem;
        }

        .footer-sec p, .footer-sec li {
            color: var(--text-secondary);
            font-size: 0.88rem;
            margin-bottom: 0.5rem;
            list-style: none;
        }

        .footer-sec a:hover {
            color: var(--gold-primary);
        }

        .copyright {
            max-width: 1200px;
            margin: 2rem auto 0;
            padding-top: 1.25rem;
            border-top: 1px solid var(--border-color);
            text-align: center;
            color: var(--text-secondary);
            font-size: 0.82rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        /* Form Controls */
        .form-group {
            margin-bottom: 1.2rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.4rem;
            font-size: 0.88rem;
            color: var(--text-secondary);
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 0.9rem;
            background-color: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            border-radius: 6px;
            font-family: inherit;
            outline: none;
            transition: border-color 0.3s;
            font-size: 0.95rem;
        }

        .form-input:focus {
            border-color: var(--gold-primary);
        }

        /* Buttons */
        .btn {
            display: inline-block;
            background-color: var(--gold-primary);
            color: #000;
            padding: 0.8rem 1.6rem;
            border-radius: 6px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            text-align: center;
            font-family: inherit;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background-color: var(--gold-hover);
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.3);
        }

        .btn-outline {
            background-color: transparent;
            color: var(--gold-primary);
            border: 1px solid var(--gold-primary);
        }

        .btn-outline:hover {
            background-color: var(--gold-primary);
            color: #000;
        }

        .btn-whatsapp {
            background-color: #25d366;
            color: white;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
        }

        .btn-whatsapp:hover {
            background-color: #20ba5a;
            box-shadow: 0 0 15px rgba(37, 211, 102, 0.3);
        }

        /* Arabic/RTL Adjustments */
        [dir="rtl"] .nav-link::after {
            left: auto;
            right: 0;
        }

        /* Alert / Messages */
        .alert {
            padding: 0.9rem;
            border-radius: 6px;
            margin-bottom: 1.25rem;
            border-left: 4px solid transparent;
            font-size: 0.9rem;
        }

        .alert-success {
            background-color: rgba(3, 218, 198, 0.1);
            color: var(--success);
            border-color: var(--success);
        }

        .alert-danger {
            background-color: rgba(207, 102, 121, 0.1);
            color: var(--danger);
            border-color: var(--danger);
        }

        /* Hamburger Menu for Mobile */
        .menu-toggle {
            display: none;
            flex-direction: column;
            gap: 5px;
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
        }
        
        .menu-toggle span {
            display: block;
            width: 24px;
            height: 2px;
            background-color: var(--text-primary);
            transition: all 0.3s;
        }

        /* Responsive Breakpoints for Smartphones */
        @media (max-width: 850px) {
            .header-container {
                padding: 0.8rem 1rem;
            }

            .brand-logo {
                font-size: 1.35rem;
            }

            .brand-logo span {
                font-size: 0.75rem;
            }

            .menu-toggle {
                display: flex;
            }

            nav {
                display: none;
                flex-direction: column;
                position: absolute;
                top: 100%;
                left: 0;
                width: 100%;
                background-color: #0b0b0be6;
                border-bottom: 1px solid var(--border-color);
                padding: 1.5rem;
                gap: 1.2rem;
                backdrop-filter: blur(15px);
            }

            nav.active {
                display: flex;
            }

            .header-actions {
                gap: 0.6rem;
            }

            .custom-lang-select {
                padding: 0.35rem 1.8rem 0.35rem 0.6rem;
                font-size: 0.78rem;
            }

            [dir="rtl"] .custom-lang-select {
                padding: 0.35rem 0.6rem 0.35rem 1.8rem;
            }

            .admin-btn {
                padding: 0.4rem 0.75rem;
                font-size: 0.75rem;
            }

            footer {
                padding: 2rem 1rem;
            }

            .footer-container {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .copyright {
                flex-direction: column;
                text-align: center;
                gap: 0.5rem;
            }
        }
    </style>
    @yield('styles')
</head>
<body>
    <header>
        <div class="header-container">
            <a href="{{ route('home') }}" class="brand-logo">
                Anaqati
                <span>أناقتي</span>
            </a>
            
            <button class="menu-toggle" onclick="toggleMenu()" aria-label="Menu">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <nav id="navbar">
                <a href="{{ route('home') }}" class="nav-link {{ Route::is('home') ? 'active' : '' }}">
                    {{ app()->getLocale() == 'ar' ? 'الرئيسية' : 'Présentation' }}
                </a>
                <a href="{{ route('catalog') }}" class="nav-link {{ Route::is('catalog') || Route::is('perfume.show') ? 'active' : '' }}">
                    {{ app()->getLocale() == 'ar' ? 'كتالوج العطور' : 'Catalogue' }}
                </a>
            </nav>

            <div class="header-actions">
                <!-- Premium Language Selector (Français / العربية Only) -->
                <div class="custom-lang-selector-wrapper">
                    <select class="custom-lang-select" onchange="window.location.href='/lang/' + this.value">
                        <option value="fr" {{ app()->getLocale() == 'fr' ? 'selected' : '' }}>Français</option>
                        <option value="ar" {{ app()->getLocale() == 'ar' ? 'selected' : '' }}>العربية</option>
                    </select>
                </div>

                @if(session('is_admin'))
                    <a href="{{ route('admin.dashboard') }}" class="admin-btn">Dashboard</a>
                    <form action="{{ route('admin.logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="admin-btn" style="background-color: transparent; border: 1px solid var(--danger); color: var(--danger); padding: 0.4rem 0.6rem;">
                            {{ app()->getLocale() == 'ar' ? 'خروج' : 'X' }}
                        </button>
                    </form>
                @else
                    <a href="{{ route('admin.login') }}" class="admin-btn">{{ app()->getLocale() == 'ar' ? 'لوحة التحكم' : 'Espace Admin' }}</a>
                @endif
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <div class="footer-container">
            <div class="footer-sec">
                <h3>Anaqati / أناقتي</h3>
                <p style="margin-top: 0.75rem;">
                    {{ app()->getLocale() == 'ar' 
                        ? 'نسج من أرق المكونات الشرقية والغربية ليجسد الفخامة والأصالة في كل زجاجة.' 
                        : 'Une fusion mystique d\'essences orientales et occidentales incarnant le luxe et l\'authenticité.' }}
                </p>
            </div>
            <div class="footer-sec">
                <h3>{{ app()->getLocale() == 'ar' ? 'روابط سريعة' : 'Navigation' }}</h3>
                <ul>
                    <li><a href="{{ route('home') }}">{{ app()->getLocale() == 'ar' ? 'الرئيسية' : 'Présentation' }}</a></li>
                    <li><a href="{{ route('catalog') }}">{{ app()->getLocale() == 'ar' ? 'الكتالوج' : 'Catalogue' }}</a></li>
                </ul>
            </div>
            <div class="footer-sec">
                <h3>{{ app()->getLocale() == 'ar' ? 'اتصل بنا' : 'Contact' }}</h3>
                <p><i class="fas fa-map-marker-alt" style="color: var(--gold-primary); margin-inline-end: 0.4rem;"></i> {{ app()->getLocale() == 'ar' ? 'حي النخيل، الدار البيضاء، المغرب' : 'Avenue Al-Nakhil, Casablanca, Maroc' }}</p>
                <p>
                    <i class="fas fa-phone-alt" style="color: var(--gold-primary); margin-inline-end: 0.4rem;"></i> <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['whatsapp_number'] ?? '212600000000') }}" target="_blank" style="color: var(--gold-primary); text-decoration: none;">
                        {{ $settings['whatsapp_number'] ?? '+212 6 00 00 00 00' }}
                    </a>
                </p>
                <p><i class="fas fa-envelope" style="color: var(--gold-primary); margin-inline-end: 0.4rem;"></i> contact@anaqati.com</p>
            </div>
        </div>
        <div class="copyright">
            <span>&copy; {{ date('Y') }} Anaqati. {{ app()->getLocale() == 'ar' ? 'جميع الحقوق محفوظة' : 'Tous droits réservés.' }}</span>
        </div>
    </footer>

    <script>
        function toggleMenu() {
            var nav = document.getElementById('navbar');
            nav.classList.toggle('active');
        }
    </script>
</body>
</html>
