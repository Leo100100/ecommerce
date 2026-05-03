@extends('layouts.guest')
@section('title', 'Entrar')

@section('content')
<h5 class="card-title mb-4">Entrar</h5>

<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="mb-3">
        <label for="email" class="form-label">E-mail</label>
        <input id="email" type="email" name="email"
               class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email') }}" required autofocus autocomplete="username">
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Senha</label>
        <input id="password" type="password" name="password"
               class="form-control @error('password') is-invalid @enderror"
               required autocomplete="current-password">
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3 form-check">
        <input id="remember_me" type="checkbox" name="remember" class="form-check-input">
        <label for="remember_me" class="form-check-label">Lembrar de mim</label>
    </div>

    <div class="d-grid">
        <button type="submit" class="btn btn-primary">Entrar</button>
    </div>

    <div class="text-center mt-3 small">
        Não tem conta? <a href="{{ route('register') }}">Cadastre-se</a>
    </div>
</form>
@endsection
