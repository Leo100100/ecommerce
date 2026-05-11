<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('error-title-tab', 'Erro') — {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #F0F2F2; color: #333; margin: 0; }
        .ec-header { background: #131921; height: 60px; display: flex; align-items: center; padding: 0 16px; }
        .ec-logo { color: #fff; font-weight: bold; font-size: 1.2rem; text-decoration: none; }
        .btn-ec-primary {
            background: #0066cc; color: #fff; border: none; padding: 8px 18px;
            font-weight: 600; font-size: 0.875rem; cursor: pointer;
            text-decoration: none; display: inline-flex; align-items: center; gap: 6px;
        }
        .btn-ec-ghost {
            background: transparent; color: #0066cc; border: 1px solid #0066cc;
            padding: 8px 18px; font-weight: 600; font-size: 0.875rem;
            text-decoration: none; display: inline-flex; align-items: center; gap: 6px;
        }
        .error-wrap {
            min-height: calc(100vh - 60px); display: flex;
            align-items: center; justify-content: center; padding: 24px 16px;
        }
        .error-box {
            background: #f0f4fa; border: 1px solid #c8d8f0;
            padding: 48px 40px; text-align: center; max-width: 480px; width: 100%;
        }
        .error-actions { display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; }
    </style>
</head>
<body>

<header class="ec-header">
    <a class="ec-logo" href="{{ route('home') }}">{{ config('app.name', 'CompreJá') }}</a>
</header>

<div class="error-wrap">
    <div class="error-box">
        <div style="font-size:4rem; color:#0066cc; margin-bottom:8px;">
            @yield('error-icon')
        </div>
<h2 style="font-size:1.2rem; font-weight:bold; color:#333; margin-bottom:8px;">
            @yield('error-heading')
        </h2>
        <p style="color:#666; font-size:0.875rem; margin-bottom:28px;">
            @yield('error-desc')
        </p>
        <div class="error-actions">
            <a href="{{ route('home') }}" class="btn-ec-primary">
                <i class="bi bi-house"></i> Voltar para o início
            </a>
            @yield('error-extra-action')
        </div>
    </div>
</div>

</body>
</html>
