@extends('layouts.guest')
@section('title', 'Cadastro de Vendedor')

@section('content')

<h2 class="ec-auth-title">Cadastro de Vendedor</h2>
<p class="ec-auth-subtitle">Pessoa jurídica — preencha os dados da sua empresa</p>

<form method="POST" action="{{ route('vendedor.register.store') }}">
    @csrf

    <div class="ec-field">
        <label for="name" class="ec-label">Razão Social <span style="color:#cc0000;">*</span></label>
        <input
            id="name"
            type="text"
            name="name"
            value="{{ old('name') }}"
            class="ec-form-control @error('name') is-invalid @enderror"
            required
            autofocus
            autocomplete="organization"
            placeholder="Nome oficial da empresa"
        >
        @error('name')
            <span class="ec-field-error"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</span>
        @enderror
    </div>

    <div class="ec-field">
        <label for="cnpj" class="ec-label">CNPJ <span style="color:#cc0000;">*</span></label>
        <input
            id="cnpj"
            type="text"
            name="cnpj"
            value="{{ old('cnpj') }}"
            class="ec-form-control @error('cnpj') is-invalid @enderror"
            required
            inputmode="numeric"
            autocomplete="off"
            placeholder="00.000.000/0000-00"
            maxlength="18"
        >
        @error('cnpj')
            <span class="ec-field-error"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</span>
        @enderror
    </div>

    <div class="ec-field">
        <label for="email" class="ec-label">E-mail corporativo <span style="color:#cc0000;">*</span></label>
        <input
            id="email"
            type="email"
            name="email"
            value="{{ old('email') }}"
            class="ec-form-control @error('email') is-invalid @enderror"
            required
            autocomplete="username"
            placeholder="contato@empresa.com.br"
        >
        @error('email')
            <span class="ec-field-error"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</span>
        @enderror
    </div>

    <div class="ec-field">
        <label for="password" class="ec-label">Senha <span style="color:#cc0000;">*</span></label>
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
            <span class="ec-field-error"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</span>
        @enderror
    </div>

    <div class="ec-field" style="margin-bottom:20px;">
        <label for="password_confirmation" class="ec-label">Confirmar senha <span style="color:#cc0000;">*</span></label>
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
        <i class="bi bi-shop-window"></i> Criar conta de vendedor
    </button>
</form>

<div class="ec-divider">ou</div>

<div class="ec-auth-link">
    Já tem conta? <a href="{{ route('login') }}">Entrar</a>
    &nbsp;&middot;&nbsp;
    Quer comprar? <a href="{{ route('register') }}">Cadastre-se como comprador</a>
</div>

@endsection

@push('scripts')
<script>
(function () {
    const cnpjInput = document.getElementById('cnpj');
    if (!cnpjInput) return;

    cnpjInput.addEventListener('input', function () {
        let v = this.value.replace(/\D/g, '').slice(0, 14);
        if (v.length > 12) v = v.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{0,2})/, '$1.$2.$3/$4-$5');
        else if (v.length > 8) v = v.replace(/^(\d{2})(\d{3})(\d{3})(\d{0,4})/, '$1.$2.$3/$4');
        else if (v.length > 5) v = v.replace(/^(\d{2})(\d{3})(\d{0,3})/, '$1.$2.$3');
        else if (v.length > 2) v = v.replace(/^(\d{2})(\d{0,3})/, '$1.$2');
        this.value = v;
    });
})();
</script>
@endpush
