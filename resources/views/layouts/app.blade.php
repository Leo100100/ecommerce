<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'E-Commerce') — {{ config('app.name') }}</title>

    <!-- CoreUI CSS -->
    <link href="https://cdn.jsdelivr.net/npm/@coreui/coreui@5/dist/css/coreui.min.css" rel="stylesheet">
    <!-- CoreUI Icons -->
    <link href="https://cdn.jsdelivr.net/npm/@coreui/icons@3/css/all.min.css" rel="stylesheet">

    @stack('styles')
</head>
<body class="bg-body-tertiary">

<div class="wrapper d-flex flex-column min-vh-100">

    {{-- Navbar --}}
    <header class="header sticky-top">
        <nav class="container-fluid d-flex align-items-center p-0 px-3" style="height:56px; background:#3c4b64;">
            <button class="btn btn-link text-white p-0 me-3" id="sidebarToggle" type="button">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                </svg>
            </button>
            <a class="navbar-brand text-white fw-bold me-auto" href="{{ route('dashboard') }}">
                {{ config('app.name') }}
            </a>
            <div class="d-flex align-items-center gap-2">
                <span class="text-white small">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-light">Sair</button>
                </form>
            </div>
        </nav>
    </header>

    <div class="container-fluid flex-grow-1 d-flex p-0">

        {{-- Sidebar --}}
        <aside id="sidebar" class="sidebar" style="width:256px; min-width:256px; background:#2d3748; transition: width .3s ease;">
            <nav class="sidebar-nav pt-2">
                <ul class="list-unstyled m-0">
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 px-4 py-3 text-white @if(request()->routeIs('dashboard')) bg-primary rounded-0 @endif"
                           href="{{ route('dashboard') }}">
                            <i class="cil-speedometer" style="font-size:1.1rem;"></i>
                            <span class="sidebar-label">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 px-4 py-3 text-white @if(request()->routeIs('products.*')) bg-primary rounded-0 @endif"
                           href="{{ route('products.index') }}">
                            <i class="cil-tags" style="font-size:1.1rem;"></i>
                            <span class="sidebar-label">Produtos</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 px-4 py-3 text-white @if(request()->routeIs('orders.*')) bg-primary rounded-0 @endif"
                           href="{{ route('orders.index') }}">
                            <i class="cil-cart" style="font-size:1.1rem;"></i>
                            <span class="sidebar-label">Pedidos</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        {{-- Main content --}}
        <main class="flex-grow-1 p-4">

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-coreui-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-coreui-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <footer class="footer px-4 py-3 border-top small text-muted">
        © {{ date('Y') }} {{ config('app.name') }}
    </footer>
</div>

<!-- jQuery -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<!-- CoreUI JS -->
<script src="https://cdn.jsdelivr.net/npm/@coreui/coreui@5/dist/js/coreui.bundle.min.js"></script>

<script>
    $('#sidebarToggle').on('click', function () {
        const $sidebar = $('#sidebar');
        if ($sidebar.width() > 60) {
            $sidebar.css('width', '0').css('min-width', '0');
            $sidebar.find('.sidebar-label').hide();
        } else {
            $sidebar.css('width', '256px').css('min-width', '256px');
            $sidebar.find('.sidebar-label').show();
        }
    });
</script>

@stack('scripts')
</body>
</html>
