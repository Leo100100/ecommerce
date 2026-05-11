<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'E-Commerce') — {{ config('app.name') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@coreui/coreui@5/dist/css/coreui.min.css" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #F0F2F2;
            color: #333;
            margin: 0;
        }

        /* HEADER */
        .ec-header {
            background: #131921;
            height: 60px;
            display: flex;
            align-items: center;
            padding: 0 16px;
            gap: 12px;
        }

        .ec-logo {
            color: #fff;
            font-weight: bold;
            font-size: 1.2rem;
            text-decoration: none;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .ec-search-wrap {
            position: relative;
            flex: 1;
            max-width: 600px;
        }

        .ec-search {
            display: flex;
            border: 1px solid #ccc;
            width: 100%;
        }

        .ec-search input {
            flex: 1;
            border: none;
            outline: none;
            padding: 0 12px;
            font-size: 0.875rem;
            height: 36px;
            background: #fff;
        }

        .ec-search button {
            background: #0066cc;
            border: none;
            padding: 0 14px;
            cursor: pointer;
            color: #fff;
            font-size: 1rem;
        }

        /* SEARCH DROPDOWN */
        .ec-search-drop {
            position: absolute;
            top: calc(100% + 4px);
            left: 0;
            right: 0;
            background: #fff;
            border: 1px solid #ccc;
            z-index: 1100;
        }

        .ec-drop-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            text-decoration: none;
            color: #333;
            border-bottom: 1px solid #eee;
            font-size: 0.875rem;
        }

        .ec-drop-item:last-child { border-bottom: none; }

        .ec-drop-thumb {
            width: 36px;
            height: 36px;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #999;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .ec-drop-name  { flex: 1; font-weight: 500; }
        .ec-drop-price { font-weight: bold; font-size: 0.85rem; flex-shrink: 0; }

        .ec-drop-msg {
            padding: 16px;
            text-align: center;
            color: #666;
            font-size: 0.875rem;
        }

        .ec-drop-footer {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 10px 14px;
            background: #f5f5f5;
            border-top: 1px solid #eee;
            color: #0066cc;
            font-size: 0.8rem;
            font-weight: 600;
            text-decoration: none;
        }

        @keyframes ec-spin { to { transform: rotate(360deg); } }

        .ec-header-actions {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-left: auto;
            flex-shrink: 0;
        }

        .ec-header-btn {
            color: #fff;
            background: transparent;
            border: 1px solid #666;
            padding: 6px 10px;
            font-size: 0.8rem;
            cursor: pointer;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
        }

        .ec-header-btn .label-top  { font-size: 0.7rem; color: #ccc; display: block; }
        .ec-header-btn .label-main { font-weight: 600; display: block; }

        .ec-cart-btn {
            position: relative;
            font-size: 1.4rem;
            color: #fff;
            text-decoration: none;
            padding: 4px 8px;
        }

        .ec-cart-badge {
            position: absolute;
            top: -2px;
            right: -4px;
            background: #0066cc;
            color: #fff;
            font-size: 0.65rem;
            font-weight: bold;
            border-radius: 50%;
            min-width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 3px;
        }

        .ec-sidebar-toggle {
            background: transparent;
            border: none;
            color: #fff;
            font-size: 1.3rem;
            cursor: pointer;
            padding: 6px;
            flex-shrink: 0;
        }

        /* SUB-NAV */
        .ec-subnav {
            background: #232F3E;
            padding: 0 16px;
            display: flex;
            align-items: center;
            gap: 2px;
            overflow-x: auto;
        }

        .ec-subnav a {
            color: #ddd;
            text-decoration: none;
            font-size: 0.8rem;
            padding: 8px 12px;
            white-space: nowrap;
        }

        .ec-subnav a.active {
            color: #fff;
            font-weight: bold;
            text-decoration: underline;
        }

        /* SIDEBAR */
        .ec-sidebar {
            background: #37475A;
            width: 200px;
            min-width: 200px;
            flex-shrink: 0;
            overflow: hidden;
        }

        .ec-sidebar.collapsed {
            width: 0;
            min-width: 0;
        }

        .ec-sidebar-inner { padding: 8px 0; }

        .ec-nav-section {
            color: #aaa;
            font-size: 0.75rem;
            font-weight: bold;
            padding: 12px 16px 4px;
        }

        .ec-nav-item a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 16px;
            color: #ddd;
            text-decoration: none;
            font-size: 0.875rem;
            white-space: nowrap;
        }

        .ec-nav-item a .nav-icon {
            font-size: 1rem;
            flex-shrink: 0;
            width: 20px;
            text-align: center;
        }

        .ec-nav-item a.active {
            color: #fff;
            font-weight: bold;
        }

        /* MAIN */
        .ec-body-wrap {
            display: flex;
            flex: 1;
            min-height: calc(100vh - 60px - 38px);
        }

        .ec-main {
            flex: 1;
            padding: 24px;
            min-width: 0;
        }

        .ec-content {
            max-width: 70%;
            margin: 0 auto;
        }

        .ec-page-title {
            font-size: 1.3rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 0;
        }

        /* CARD */
        .ec-card {
            background: #fff;
            border: 1px solid #ddd;
        }

        /* ALERTS */
        .ec-alert {
            padding: 12px 16px;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
        }

        .ec-alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .ec-alert-danger  { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

        /* BUTTONS */
        .btn-ec-primary {
            background: #0066cc;
            color: #fff;
            border: none;
            padding: 8px 18px;
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-ec-outline {
            background: transparent;
            color: #0066cc;
            border: 1px solid #0066cc;
            padding: 7px 16px;
            font-size: 0.875rem;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-ec-ghost {
            background: transparent;
            color: #555;
            border: 1px solid #ccc;
            padding: 7px 12px;
            font-size: 0.8rem;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-ec-danger {
            background: #cc0000;
            color: #fff;
            border: none;
            padding: 7px 12px;
            font-size: 0.8rem;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        /* BADGE */
        .ec-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 2px 8px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .ec-badge-success { background: #d4edda; color: #155724; }
        .ec-badge-warning { background: #fff3cd; color: #856404; }
        .ec-badge-danger  { background: #f8d7da; color: #721c24; }
        .ec-badge-info    { background: #d1ecf1; color: #0c5460; }
        .ec-badge-muted   { background: #e9ecef; color: #555; }

        /* TABLE */
        .ec-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.875rem;
        }

        .ec-table thead th {
            background: #f5f5f5;
            color: #555;
            font-weight: bold;
            padding: 10px 14px;
            border-bottom: 2px solid #ddd;
            text-align: left;
        }

        .ec-table tbody td {
            padding: 12px 14px;
            border-bottom: 1px solid #eee;
            color: #333;
            vertical-align: middle;
        }

        .ec-table tbody tr:last-child td { border-bottom: none; }

        /* FOOTER */
        .ec-footer {
            background: #131921;
            color: #aaa;
            font-size: 0.8rem;
            padding: 14px 24px;
            text-align: center;
        }

        .ec-footer a { color: #ccc; text-decoration: none; }

        /* FORM CONTROLS */
        .ec-form-control {
            width: 100%;
            border: 1px solid #ccc;
            padding: 8px 12px;
            font-size: 0.875rem;
            color: #333;
            background: #fff;
            outline: none;
        }

        .ec-form-control:focus {
            border-color: #0066cc;
        }

        @media (max-width: 768px) {
            .ec-search-wrap { display: none; }
            .ec-sidebar { width: 0; min-width: 0; }
        }
    </style>

    @stack('styles')
</head>
<body>

{{-- TOP HEADER --}}
<header class="ec-header">
    <button class="ec-sidebar-toggle" id="sidebarToggle" title="Menu">
        <i class="bi bi-list"></i>
    </button>

    <a class="ec-logo" href="{{ route('home') }}">CompreJá</a>

    <div class="ec-search-wrap">
        <form class="ec-search" action="{{ route('search.index') }}" method="GET">
            <input
                type="text"
                id="ecSearchInput"
                name="q"
                value="{{ request('q') }}"
                placeholder="Buscar produtos..."
                autocomplete="off"
            >
            <button type="submit" title="Buscar"><i class="bi bi-search"></i></button>
        </form>
        <div id="ecSearchDropdown" class="ec-search-drop" style="display:none;"></div>
    </div>

    <div class="ec-header-actions">
        @auth
            <a class="ec-header-btn" href="{{ route('profile.index') }}">
                <span class="label-top">Olá, {{ Auth::user()->name }}</span>
                <span class="label-main"><i class="bi bi-person-circle"></i> Meu Perfil</span>
            </a>

            <button class="ec-cart-btn" id="cartSidebarToggle" title="Carrinho" style="background:none;border:none;cursor:pointer;">
                <i class="bi bi-cart3"></i>
                <span class="ec-cart-badge" id="cartBadge">0</span>
            </button>

            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="ec-header-btn" title="Sair">
                    <i class="bi bi-box-arrow-right" style="font-size:1.1rem;"></i>
                </button>
            </form>
        @else
            <a href="{{ route('cart.index') }}" class="ec-cart-btn" title="Carrinho">
                <i class="bi bi-cart3"></i>
            </a>
            <a href="{{ route('login') }}" class="ec-header-btn">
                <span class="label-main"><i class="bi bi-person-circle"></i> Entrar</span>
            </a>
            <a href="{{ route('register') }}" class="ec-header-btn" style="background:#0066cc; border-color:#0066cc;">
                <span class="label-main">Cadastrar</span>
            </a>
        @endauth
    </div>
</header>

{{-- SUB-NAV --}}
<nav class="ec-subnav">
    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
        <i class="bi bi-house"></i> Página inicial
    </a>
    @auth
        @if(Auth::user()->vendedor)
        <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.index') ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i> Produtos
        </a>
        @else
        <a href="{{ route('search.index') }}" class="{{ request()->routeIs('search.*') ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i> Produtos
        </a>
        @endif
    @endauth
    @guest
    <a href="{{ route('search.index') }}" class="{{ request()->routeIs('search.*') ? 'active' : '' }}">
        <i class="bi bi-box-seam"></i> Produtos
    </a>
    @endguest
    <a href="{{ route('orders.index') }}" class="{{ request()->routeIs('orders.*') ? 'active' : '' }}">
        <i class="bi bi-receipt"></i> Pedidos
    </a>

    {{-- {{dd(Auth::user())}} --}}

    @if (Auth::guest() || (!Auth::user()->vendedor))

         <a href="{{ route('cart.index') }}" class="{{ request()->routeIs('cart.*') ? 'active' : '' }}">
            <i class="bi bi-cart3"></i> Carrinho
        </a>
    @endif
</nav>

<div class="ec-body-wrap">

    {{-- SIDEBAR --}}
    <aside class="ec-sidebar collapsed" id="sidebar">
        <div class="ec-sidebar-inner">
            <div class="ec-nav-section">Navegação</div>

            <div class="ec-nav-item">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                    <i class="bi bi-house nav-icon"></i>
                    <span class="nav-label">Página inicial</span>
                </a>
            </div>
            @auth
                @if(Auth::user()->vendedor)
                <div class="ec-nav-item">
                    <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">
                        <i class="bi bi-box-seam nav-icon"></i>
                        <span class="nav-label">Produtos</span>
                    </a>
                </div>
                <div class="ec-nav-item">
                    <a href="{{ route('products.create') }}" class="{{ request()->routeIs('products.create') ? 'active' : '' }}">
                        <i class="bi bi-plus-circle nav-icon"></i>
                        <span class="nav-label">Novo Produto</span>
                    </a>
                </div>
                @endif
            @endauth

            <div class="ec-nav-section">Vendas</div>

            <div class="ec-nav-item">
                <a href="{{ route('orders.index') }}" class="{{ request()->routeIs('orders.*') ? 'active' : '' }}">
                    <i class="bi bi-receipt nav-icon"></i>
                    <span class="nav-label">Pedidos</span>
                </a>
            </div>
            <div class="ec-nav-item">
                <a href="{{ route('cart.index') }}" class="{{ request()->routeIs('cart.*') ? 'active' : '' }}">
                    <i class="bi bi-cart3 nav-icon"></i>
                    <span class="nav-label">Carrinho</span>
                </a>
            </div>

            <div class="ec-nav-section">Conta</div>

            <div class="ec-nav-item">
                <a href="{{ route('profile.index') }}" class="{{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <i class="bi bi-person-circle nav-icon"></i>
                    <span class="nav-label">Meu Perfil</span>
                </a>
            </div>
        </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <main class="ec-main">

        <div class="ec-content">

            @if(session('success'))
                <div class="ec-alert ec-alert-success">
                    <i class="bi bi-check-circle-fill"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="ec-alert ec-alert-danger">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')

        </div>
    </main>
</div>

<footer class="ec-footer">
    © {{ date('Y') }} {{ config('app.name') }} &mdash;
    <a href="{{ route('home') }}">Início</a>
    @auth
        @if(Auth::user()->vendedor)
        &middot; <a href="{{ route('products.index') }}">Produtos</a>
        @endif
    @endauth
    &middot; <a href="{{ route('orders.index') }}">Pedidos</a>
</footer>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script>
    (function () {
        const $sidebar = $('#sidebar');
        let collapsed = true;

        $('#sidebarToggle').on('click', function () {
            collapsed = !collapsed;
            $sidebar.toggleClass('collapsed', collapsed);
        });
    })();
</script>

<script>
(function () {
    const input = document.getElementById('ecSearchInput');
    const drop  = document.getElementById('ecSearchDropdown');

    if (!input) return;

    let timer, ctrl;

    function esc(str) {
        return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }

    function fmtPrice(v) {
        return parseFloat(v).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    function show(html) { drop.innerHTML = html; drop.style.display = 'block'; }
    function hide()     { drop.style.display = 'none'; }

    function render(data, q) {
        if (!data.length) {
            show(`<div class="ec-drop-msg">Nenhum resultado para <strong>"${esc(q)}"</strong></div>`);
            return;
        }

        const items = data.map(p => `
            <a href="/products/${p.id}" class="ec-drop-item">
                <div class="ec-drop-thumb"><i class="bi bi-box-seam"></i></div>
                <span class="ec-drop-name">${esc(p.nome)}</span>
                <span class="ec-drop-price">R$ ${fmtPrice(p.preco)}</span>
            </a>`).join('');

        const footer = `<a href="/search?q=${encodeURIComponent(q)}" class="ec-drop-footer">
            Ver todos os resultados para "${esc(q)}"
        </a>`;

        show(items + footer);
    }

    input.addEventListener('input', function () {
        const q = this.value.trim();
        clearTimeout(timer);

        if (q.length < 3) { hide(); return; }

        show(`<div class="ec-drop-msg">Buscando...</div>`);

        timer = setTimeout(function () {
            if (ctrl) ctrl.abort();
            ctrl = new AbortController();

            fetch('/search/live?q=' + encodeURIComponent(q), { signal: ctrl.signal })
                .then(r => r.json())
                .then(data => render(data, q))
                .catch(e => { if (e.name !== 'AbortError') hide(); });
        }, 320);
    });

    document.addEventListener('click', function (e) {
        if (!input.closest('.ec-search-wrap').contains(e.target)) hide();
    });

    input.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') hide();
    });

    input.addEventListener('focus', function () {
        if (this.value.trim().length >= 3 && drop.innerHTML !== '') {
            drop.style.display = 'block';
        }
    });
})();
</script>

@auth
{{-- CART SIDEBAR --}}
<style>
    .cart-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.4);
        z-index: 1200;
    }
    .cart-overlay.open { display: block; }

    .cart-drawer {
        position: fixed;
        top: 0;
        right: -360px;
        width: 360px;
        height: 100%;
        background: #fff;
        z-index: 1300;
        display: flex;
        flex-direction: column;
        border-left: 1px solid #ddd;
        transition: right 0.3s ease;
    }
    .cart-drawer.open { right: 0; }

    .cart-drawer-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 16px;
        background: #131921;
        color: #fff;
        font-weight: bold;
        font-size: 0.95rem;
        flex-shrink: 0;
    }

    .cart-drawer-close {
        background: none;
        border: none;
        color: #fff;
        font-size: 1.2rem;
        cursor: pointer;
        padding: 0;
    }

    .cart-drawer-body {
        flex: 1;
        overflow-y: auto;
        padding: 0;
    }

    .cart-drawer-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        border-bottom: 1px solid #eee;
        font-size: 0.85rem;
    }

    .cart-drawer-thumb {
        width: 44px;
        height: 44px;
        background: #f3f4f6;
        border: 1px solid #ddd;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #aaa;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .cart-drawer-name {
        flex: 1;
        font-weight: 600;
        color: #333;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .cart-drawer-qty  { font-size: 0.78rem; color: #888; }
    .cart-drawer-price { font-weight: bold; color: #333; flex-shrink: 0; align-self: flex-start; padding-top: 2px; }

    .drawer-qty-btn {
        background: #f0f0f0;
        border: 1px solid #ccc;
        width: 24px;
        height: 24px;
        font-size: 0.9rem;
        font-weight: bold;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        flex-shrink: 0;
    }

    .drawer-remove-btn {
        background: none;
        border: none;
        color: #cc0000;
        cursor: pointer;
        font-size: 0.85rem;
        padding: 0 4px;
        margin-left: 4px;
    }

    .cart-drawer-empty {
        padding: 48px 16px;
        text-align: center;
        color: #888;
        font-size: 0.875rem;
    }

    .cart-drawer-footer {
        padding: 16px;
        border-top: 2px solid #ddd;
        flex-shrink: 0;
        background: #fafafa;
    }

    .cart-drawer-total {
        display: flex;
        justify-content: space-between;
        font-weight: bold;
        font-size: 1rem;
        margin-bottom: 12px;
    }

    .cart-drawer-footer a,
    .cart-drawer-footer button {
        display: block;
        width: 100%;
        text-align: center;
        padding: 9px;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        box-sizing: border-box;
        margin-bottom: 8px;
    }

    .cart-drawer-footer a:last-child,
    .cart-drawer-footer button:last-child { margin-bottom: 0; }
</style>

<div class="cart-overlay" id="cartOverlay"></div>

<div class="cart-drawer" id="cartDrawer">
    <div class="cart-drawer-header">
        <span><i class="bi bi-cart3"></i> Meu Carrinho</span>
        <button class="cart-drawer-close" id="cartDrawerClose"><i class="bi bi-x-lg"></i></button>
    </div>
    <div class="cart-drawer-body" id="cartDrawerBody">
        <div class="cart-drawer-empty">Carregando...</div>
    </div>
    <div class="cart-drawer-footer" id="cartDrawerFooter" style="display:none;">
        <div class="cart-drawer-total">
            <span>Total</span>
            <span id="cartDrawerTotal">R$ 0,00</span>
        </div>
        <a href="{{ route('cart.index') }}" class="btn-ec-ghost">
            <i class="bi bi-cart3"></i> Ver carrinho completo
        </a>
        <a href="{{ route('checkout.index') }}" class="btn-ec-primary" style="display:block;text-align:center;">
            <i class="bi bi-lock-fill"></i> Finalizar compra
        </a>
    </div>
</div>

<script>
(function () {
    const toggle   = document.getElementById('cartSidebarToggle');
    const overlay  = document.getElementById('cartOverlay');
    const drawer   = document.getElementById('cartDrawer');
    const closeBtn = document.getElementById('cartDrawerClose');
    const body     = document.getElementById('cartDrawerBody');
    const footer   = document.getElementById('cartDrawerFooter');
    const badge    = document.getElementById('cartBadge');
    const totalEl  = document.getElementById('cartDrawerTotal');

    function fmt(v) {
        return 'R$ ' + parseFloat(v).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    function open() {
        overlay.classList.add('open');
        drawer.classList.add('open');
        loadCart();
    }

    function close() {
        overlay.classList.remove('open');
        drawer.classList.remove('open');
    }

    function csrfToken() {
        const m = document.querySelector('meta[name="csrf-token"]');
        return m ? m.content : '';
    }

    function cartRequest(url, qty) {
        const body = qty !== undefined
            ? new URLSearchParams({ _token: csrfToken(), quantidade: qty })
            : new URLSearchParams({ _token: csrfToken() });

        return fetch(url, {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
            body: body,
        }).then(r => r.json());
    }

    function renderCart(data) {
        badge.textContent = data.count || 0;

        if (!data.items || data.items.length === 0) {
            body.innerHTML = '<div class="cart-drawer-empty"><i class="bi bi-cart-x" style="font-size:2rem;display:block;margin-bottom:10px;"></i>Seu carrinho está vazio.</div>';
            footer.style.display = 'none';
            return;
        }

        body.innerHTML = data.items.map(function (item) {
            return '<div class="cart-drawer-item">' +
                '<div class="cart-drawer-thumb"><i class="bi bi-box-seam"></i></div>' +
                '<div style="flex:1;min-width:0;">' +
                    '<div class="cart-drawer-name">' + item.nome + '</div>' +
                    '<div style="display:flex;align-items:center;gap:8px;margin-top:6px;">' +
                        '<button class="drawer-qty-btn" data-action="remove" data-id="' + item.id + '">−</button>' +
                        '<span style="font-size:.85rem;font-weight:600;min-width:20px;text-align:center;">' + item.quantidade + '</span>' +
                        '<button class="drawer-qty-btn" data-action="add" data-id="' + item.id + '" data-qty="' + (item.quantidade + 1) + '">+</button>' +
                        '<button class="drawer-remove-btn" data-action="destroy" data-id="' + item.id + '" title="Remover"><i class="bi bi-trash3"></i></button>' +
                    '</div>' +
                '</div>' +
                '<div class="cart-drawer-price">' + fmt(item.subtotal) + '</div>' +
            '</div>';
        }).join('');

        totalEl.textContent = fmt(data.total);
        footer.style.display = 'block';
    }

    function loadCart() {
        body.innerHTML = '<div class="cart-drawer-empty">Carregando...</div>';
        footer.style.display = 'none';

        fetch('{{ route("cart.data") }}', {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
            .then(r => r.json())
            .then(renderCart)
            .catch(function () {
                body.innerHTML = '<div class="cart-drawer-empty">Erro ao carregar o carrinho.</div>';
            });
    }

    // Delegação de eventos nos botões da sidebar
    body.addEventListener('click', function (e) {
        const btn = e.target.closest('[data-action]');
        if (!btn) return;

        const action = btn.dataset.action;
        const id     = btn.dataset.id;
        let url;

        if (action === 'remove') {
            url = '/cart/remove/' + id;
            cartRequest(url).then(renderCart);
        } else if (action === 'add') {
            url = '/cart/update/' + id;
            cartRequest(url, btn.dataset.qty).then(renderCart);
        } else if (action === 'destroy') {
            url = '/cart/destroy/' + id;
            cartRequest(url).then(renderCart);
        }
    });

    if (toggle)   toggle.addEventListener('click', open);
    if (closeBtn) closeBtn.addEventListener('click', close);
    if (overlay)  overlay.addEventListener('click', close);

    // Intercepta todos os formulários de adicionar ao carrinho
    document.addEventListener('submit', function (e) {
        const form = e.target;
        if (form.action.indexOf('add-product') === -1) return;

        e.preventDefault();

        const data = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
            body: data,
        })
        .then(r => r.json())
        .then(function (res) {
            if (res.success) {
                badge.textContent = res.count || 0;
                open();
            }
        })
        .catch(function () { form.submit(); });
    });
})();
</script>
@endauth

@stack('scripts')
</body>
</html>
