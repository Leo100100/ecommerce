@extends('layouts.guest')
@section('title', 'Entrar')

@section('content')

<h2 class="ec-auth-title">Bem-vindo de volta</h2>
<p class="ec-auth-subtitle">Entre com sua conta para continuar</p>

<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="ec-field">
        <label for="email" class="ec-label">E-mail</label>
        <input
            id="email"
            type="email"
            name="email"
            value="{{ old('email') }}"
            class="ec-form-control @error('email') is-invalid @enderror"
            required
            autofocus
            autocomplete="username"
            placeholder="seu@email.com"
        >
        @error('email')
            <span class="ec-field-error">
                <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
            </span>
        @enderror
    </div>

    <div class="ec-field">
        <div style="display:flex;justify-content:space-between;align-items:baseline;margin-bottom:6px;">
            <label for="password" class="ec-label" style="margin-bottom:0;">Senha</label>
            @if(Route::has('password.request'))
                <a href="{{ route('password.request') }}" style="font-size:.78rem;color:#0066cc;text-decoration:none;">
                    Esqueceu a senha?
                </a>
            @endif
        </div>
        <input
            id="password"
            type="password"
            name="password"
            class="ec-form-control @error('password') is-invalid @enderror"
            required
            autocomplete="current-password"
            placeholder="••••••••"
        >
        @error('password')
            <span class="ec-field-error">
                <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
            </span>
        @enderror
    </div>

    <div class="ec-field" style="margin-bottom:20px;">
        <label class="ec-check">
            <input type="checkbox" name="remember" id="remember_me" {{ old('remember') ? 'checked' : '' }}>
            Lembrar de mim
        </label>
    </div>

    <button type="submit" class="btn-ec-primary">
        <i class="bi bi-box-arrow-in-right"></i> Entrar
    </button>
</form>

<div class="ec-divider">ou</div>

<div class="ec-auth-link" style="margin-bottom:10px;">
    Não tem conta? <a href="{{ route('register') }}">Cadastre-se como comprador</a>
</div>
<div class="ec-auth-link">
    Quer vender? <a href="{{ route('vendedor.register') }}">Crie sua conta de vendedor</a>
</div>

@endsection
