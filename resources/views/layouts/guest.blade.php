<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Acesso') — {{ config('app.name') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: Arial, sans-serif;
            background: #F0F2F2;
            color: #333;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* HEADER */
        .ec-auth-header {
            background: #131921;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .ec-logo {
            color: #fff;
            font-weight: bold;
            font-size: 1.4rem;
            text-decoration: none;
        }

        /* BODY */
        .ec-auth-body {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 16px;
        }

        /* CARD */
        .ec-auth-card {
            background: #fff;
            border: 1px solid #ccc;
            padding: 32px 36px;
            width: 100%;
            max-width: 400px;
        }

        .ec-auth-title {
            font-size: 1.2rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 4px;
        }

        .ec-auth-subtitle {
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 24px;
        }

        /* FORM */
        .ec-field { margin-bottom: 16px; }

        .ec-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 5px;
            color: #333;
        }

        .ec-form-control {
            width: 100%;
            border: 1px solid #ccc;
            padding: 9px 12px;
            font-size: 0.875rem;
            color: #333;
            background: #fff;
            outline: none;
        }

        .ec-form-control:focus {
            border-color: #0066cc;
        }

        .ec-form-control.is-invalid {
            border-color: #cc0000;
        }

        .ec-field-error {
            font-size: 0.78rem;
            color: #cc0000;
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* CHECKBOX */
        .ec-check {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            font-size: 0.875rem;
            color: #333;
        }

        .ec-check input[type="checkbox"] {
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        /* BUTTON */
        .btn-ec-primary {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            width: 100%;
            background: #0066cc;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
        }

        /* DIVIDER */
        .ec-divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 20px 0;
            color: #888;
            font-size: 0.75rem;
        }

        .ec-divider::before,
        .ec-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #ddd;
        }

        /* LINK */
        .ec-auth-link {
            text-align: center;
            font-size: 0.82rem;
            color: #666;
        }

        .ec-auth-link a {
            color: #0066cc;
            font-weight: 600;
            text-decoration: none;
        }

        .ec-auth-link a:hover { text-decoration: underline; }

        /* FOOTER */
        .ec-auth-footer {
            text-align: center;
            font-size: 0.75rem;
            color: #888;
            padding: 20px 0 28px;
        }

        .ec-auth-footer a { color: #888; text-decoration: none; }
        .ec-auth-footer a:hover { text-decoration: underline; }
    </style>

    @stack('styles')
</head>
<body>

<header class="ec-auth-header">
    <a class="ec-logo" href="/">CompreJá</a>
</header>

<div class="ec-auth-body">
    <div class="ec-auth-card">
        @yield('content')
    </div>
</div>

<footer class="ec-auth-footer">
    © {{ date('Y') }} {{ config('app.name') }} &mdash;
    <a href="#">Privacidade</a> &middot; <a href="#">Termos</a>
</footer>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
@stack('scripts')
</body>
</html>
