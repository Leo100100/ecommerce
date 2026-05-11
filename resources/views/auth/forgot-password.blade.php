@extends('layouts.guest')
@section('title', 'Recuperar Senha')

@section('content')

<h2 class="ec-auth-title">Recuperar senha</h2>
<p class="ec-auth-subtitle">Informe seu e-mail e enviaremos um link para redefinição.</p>

@if(session('status'))
    <div style="background:#D1FAE5;color:#065F46;border:1px solid #6EE7B7;border-radius:6px;padding:12px 14px;font-size:.875rem;display:flex;align-items:center;gap:8px;margin-bottom:20px;">
        <i class="bi bi-check-circle-fill"></i> {{ session('status') }}
    </div>
@endif

<form method="POST" action="{{ route('password.email') }}">
    @csrf

    <div class="ec-field" style="margin-bottom:24px;">
        <label for="email" class="ec-label">E-mail</label>
        <input
            id="email"
            type="email"
            name="email"
            value="{{ old('email') }}"
            class="ec-form-control @error('email') is-invalid @enderror"
            required
            autofocus
            placeholder="seu@email.com"
        >
        @error('email')
            <span class="ec-field-error">
                <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
            </span>
        @enderror
    </div>

    <button type="submit" class="btn-ec-primary">
        <i class="bi bi-envelope"></i> Enviar link de recuperação
    </button>
</form>

<div class="ec-divider"></div>

<div class="ec-auth-link">
    <a href="{{ route('login') }}"><i class="bi bi-arrow-left"></i> Voltar ao login</a>
</div>

@endsection
