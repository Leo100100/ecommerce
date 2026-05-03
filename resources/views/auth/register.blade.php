@extends('layouts.guest')
@section('title', 'Cadastro')

@section('content')
<h5 class="card-title mb-4">Criar conta</h5>

<form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="mb-3">
        <label for="name" class="form-label">Nome</label>
        <input id="name" type="text" name="name"
               class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name') }}" required autofocus autocomplete="name">
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">E-mail</label>
        <input id="email" type="email" name="email"
               class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email') }}" required autocomplete="username">
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Senha</label>
        <input id="password" type="password" name="password"
               class="form-control @error('password') is-invalid @enderror"
               required autocomplete="new-password">
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirmar senha</label>
        <input id="password_confirmation" type="password" name="password_confirmation"
               class="form-control" required autocomplete="new-password">
    </div>

    <div class="d-grid">
        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </div>

    <div class="text-center mt-3 small">
        Já tem conta? <a href="{{ route('login') }}">Entrar</a>
    </div>
</form>
@endsection
