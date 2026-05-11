@extends('layouts.guest')
@section('title', 'Criar conta')

@section('content')

<h2 class="ec-auth-title">Criar sua conta</h2>
<p class="ec-auth-subtitle">Preencha os dados abaixo para se cadastrar</p>

<form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="ec-field">
        <label for="name" class="ec-label">Nome completo</label>
        <input
            id="name"
            type="text"
            name="name"
            value="{{ old('name') }}"
            class="ec-form-control @error('name') is-invalid @enderror"
            required
            autofocus
            autocomplete="name"
            placeholder="Seu nome"
        >
        @error('name')
            <span class="ec-field-error">
                <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
            </span>
        @enderror
    </div>

    <div class="ec-field">
        <label for="email" class="ec-label">E-mail</label>
        <input
            id="email"
            type="email"
            name="email"
            value="{{ old('email') }}"
            class="ec-form-control @error('email') is-invalid @enderror"
            required
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
        <label for="password" class="ec-label">Senha</label>
        <input
            id="password"
            type="password"
            name="password"
            class="ec-form-control @error('password') is-invalid @enderror"
            required
            autocomplete="new-password"
            placeholder="Mínimo 8 caracteres"
        >
        @error('password')
            <span class="ec-field-error">
                <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
            </span>
        @enderror
    </div>

    <div class="ec-field" style="margin-bottom:24px;">
        <label for="password_confirmation" class="ec-label">Confirmar senha</label>
        <input
            id="password_confirmation"
            type="password"
            name="password_confirmation"
            class="ec-form-control"
            required
            autocomplete="new-password"
            placeholder="Repita a senha"
        >
    </div>

    <button type="submit" class="btn-ec-primary">
        <i class="bi bi-person-check"></i> Criar conta
    </button>
</form>

<div class="ec-divider">ou</div>

<div class="ec-auth-link" style="margin-bottom:10px;">
    Já tem conta? <a href="{{ route('login') }}">Entrar</a>
</div>
<div class="ec-auth-link">
    Quer vender? <a href="{{ route('vendedor.register') }}">Crie sua conta de vendedor</a>
</div>

@endsection
